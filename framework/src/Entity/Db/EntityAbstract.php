<?php

namespace Ufo\Entity\Db;

use \Ufo\Db\Manager as DbManager;
use \Ufo\Log\Trace as Trace;
use \Ufo\Entity\Db\Exception\EmptyValueException as EmptyValueException;
use \Ufo\Entity\Db\Exception\EntityException as EntityException;
use \Ufo\Security\Sanitizer as Sanitizer;
use \Ufo\Entity\Db\Link\ColumnLink as ColumnLink;
use \Ufo\Entity\Db\Link\ForeignLink as ForeignLink;

use Ufo\Error;


/**
 * Tout les objets persistants dans la base de donnees, heritent 
 * de cette classe.
 */
abstract class EntityAbstract
{   	
    public static $___invokable = array(
        'getByID'=>array('id'),
        'read'=>array('$start','$length'),
    );
    
    protected $___loaded = false;
    
    
    final public function __clone()
    {
        $this->id = null;
    }
    
    protected static function getDatabaseProfile()
    {
        if(\Ufo\User\UserManager::isOpen()){
            $dbProfile = \Ufo\User\UserManager::getDBProfile();
        }
        else{
            $dbProfile = _UFO_APP_DEFAULT_PROFILE_;
        }
        
        return $dbProfile;
    }

    public static function directHttpInvok($methodname_str, $httpmethod = 'POST')
    {
        switch($httpmethod)
        {
        	case 'POST':
        	    $inputs = $_POST;
        	    break;
        	case 'GET':
        	    $inputs = $_GET;
        	    break;
        	default:
        	    throw new \Exception('Invalid HTTP method');
        	    break;
        }
        
        if(!isset(self::$___invokable[$methodname_str])) throw new \Exception('Method is not invokable');
            
        $params = array(); 
        for($i=0;$i<count(self::$___invokable[$methodname_str]);$i++)
        {
            
            if($inputs[self::$___invokable[$methodname_str][$i]]->is_submit()){
                $inputs[self::$___invokable[$methodname_str][$i]]->decontaminate();
                $params[$i] = $inputs[self::$___invokable[$methodname_str][$i]];
            }
        }
        
        return call_user_func_array(get_called_class().'::'.$methodname_str,$params);
    }
    
    public static function invokeFromPOST($methodname_str)
    {
        if(!isset(self::$___invokable[$methodname_str])) throw new \Exception('Method is not invokable');
    
        $params = array();
        for($i=0;$i<count(self::$___invokable[$methodname_str]);$i++)
        {
        
            if($_POST[self::$___invokable[$methodname_str][$i]]->is_submit()){
                $_POST[self::$___invokable[$methodname_str][$i]]->decontaminate();
                $params[$i] = $_POST[self::$___invokable[$methodname_str][$i]];
            }
        }
    
        return call_user_func_array(get_called_class().'::'.$methodname_str,$params);
    }
    
    public static function invokeFromGET($methodname_str)
    {
        if(!isset(self::$___invokable[$methodname_str])) throw new \Exception('Method is not invokable');
    
        $cls = get_called_class();
        $pts = $cls::getProperties();
        
        $ppts = array_combine($pts, $pts);
        
        $params = array();
        for($i=0;$i<count(self::$___invokable[$methodname_str]);$i++)
        {
            $arg = self::$___invokable[$methodname_str][$i];
            
            if(isset($ppts[$arg])){
                if($_GET[$arg]->is_submit()){
                
                    $p = $_GET->get($arg)->sanitizeAsObjectProperty($cls.'::checkAs',$arg);
                    $params[$i] = $p;
                }
            }
            elseif($arg[0] == '$'){
                $arg = substr($arg,1);
                if(($_GET[$arg]->is_submit())&&($_GET[$arg]->taintedInputs instanceof \Ufo\HTTP\TaintedString)){
                    $p = $_GET[$arg]->taintedInputs->getData();
                    $params[$i] = $p;
                }
            }
        }
    
        return call_user_func_array(get_called_class().'::'.$methodname_str,$params);
    }
    
	/**
	 *
	 * @param unknown $sqlrequest_str
	 * @return Ambigous <number, NULL, string>
	 * @version 2.0
	 * @since 06/01/2014
	 */
	protected static function execStaticRequest( $sqlrequest_str)
	{
	    $db = DbManager::getConnexion(self::getDatabaseProfile());
	
	    return $db->SQL($sqlrequest_str);
	}
	
	/**
	 * To parse an entity path and return stack of columnLink
	 * 
	 * Translate the path into a stack of columnLinks as :
	 * 
	 * "school.student.name" => Stack :
	 * 
	 * TOP
	 * --------------------------------------------
	 * | SCHOOL - ForeignLink from current entity |
	 * --------------------------------------------
	 * | STUDENT - ForeignLink from School entity |
	 * --------------------------------------------
	 * |  NAME - ColumnLink from Student entity   |
	 * --------------------------------------------
	 * BOTTOM
	 * 
	 * @method array parseEntityPath( string $path_str ) 
	 * @param string $path_str Entity path like : "car.color" or "town.school.student.name" 
	 * @return array Translation of path as a stack of columnLinks
	 * @since 20/05/2014
	 * @version 2.1 
	 */
	protected static function parseEntityPath($path_str)
	{
	    $e = explode('.',$path_str);
	    $list = array();
	    $localAdapter = self::getAdapter();
	
	    $n = count($e);
	    $i = 0;
	     
	    for($i=0;$i<$n;$i++){
	        if(isset($list[$i-1])){
	            // s'il y a un antecedent c'est forcement un ForeignLink
	            $lastLink = $list[$i-1];
	            $lastForeignAdapter = $lastLink->getForeignAdapter();
	             
	            $link = $lastForeignAdapter->getColumnLinks($e[$i]);
	             
	            array_push($list,$link);
	             
	            if($link instanceof ColumnLink) $i=$n ;
	        }
	        else{
                $link = $localAdapter->getColumnLinks($e[$i]);
                
                array_push($list, $link);
                
                if (($n == 1) || ($link instanceof ColumnLink))
                    $i = $n;
            }
        }
        unset($e);
        
        return $list;
    }

    
    /**
     * To make FROM/WHERE clause from simplified WHERE clause
     * 
     * Make from a simplified WHERE clause using EntityPath and paramters
     * as "(student.firstname LIKE :name) AND (student.grade = :grade)"
     * the FROM with appropriate JOIN and WHERE clause, and prepare 
     * the ColumnLinks for each params. 
     * 
     * @method array clauseConstructor( string $clause_str)
     * @param string $clause_str
     * @return array Associtative array as : array{ ['clause'] => string clause, ['tokens'] => associative array which associate to each param name the corresponding columnlink }
     * @since 20/05/2014
     * @version 2.1
     */
    protected static function clauseConstructor($clause_str)
    {
        $matches = array();
        $joined = array();
        $inClause = array();
        
        preg_match_all('/\(?\s*(?P<col>[a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*)\s*(?P<ope>=|<|>|LIKE|IN)\s*(?P<val>:?([a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*))\s*\)?/u', $clause_str, $matches);
        $tokens = array(
            'col' => $matches['col'],
            'ope' => $matches['ope'],
            'val' => $matches['val']
        );
        
        $adapter = self::getAdapter();
        $localTable = $adapter->getTableLink();
        $localCols = $adapter->getColumnLinks();
        $db = DbManager::getConnexion(self::getDatabaseProfile());
        
        // construction de la clause
        $from = ' FROM `' . _UFO_APP_SCHEMA_ . '`.' . $db->manageCase($localTable->getName()) . ' ' . $localTable->getPrefix() . ' ';
        
        foreach ($matches[0] as $i => $match) {
            $colPath = $tokens['col'][$i];
            
            if (strpos($colPath, '.') == false) {
                $inClause[] = array(
                    'prefix' => $localTable->getPrefix(),
                    'link' => $adapter->getColumnLinks($tokens['col'][$i]),
                    'colname' => $tokens['col'][$i],
                    'token' => $tokens['val'][$i]
                );
            } else {
                $path = self::parseEntityPath($tokens['col'][$i]);
                $j = 0;
                
                for ($j = 0; $j < count($path); $j ++) {
                    if ($path[$j] instanceof ForeignLink) {
                        
                        if (! isset($joined[$path[$j]->getTableName()])) {
                            
                            $link = $path[$j];
                            if ($j > 0) {
                                $localPrefix = $path[$j - 1]->getTablePrefix();
                                $localName = ($link->hasLocalName()) ? $link->getName() : $link->getColumn()->getName();
                            } else {
                                $localPrefix = $localTable->getPrefix();
                                $localName = ($link->hasLocalName()) ? $link->getName() : $link->getColumn()->getName();
                            }
                            
                            $tmpJoin = ($link->isFacultative()) ? 'LEFT JOIN ' : 'INNER JOIN ';
                            $tmpJoin .= '`' . _UFO_APP_SCHEMA_ . '`.' . $db->manageCase($link->getTableName()) . ' ' . $link->getTablePrefix() . ' ON ' . $localPrefix . '.' . $localName . '=' . $link->getTablePrefix() . '.' . $link->getName() . ' ';
                            $from .= $tmpJoin;
                            $joined[$link->getTableName()] = true;
                        } elseif ($j == (count($path) - 1)) {
                            $inClause[] = array(
                                'prefix' => $path[$j]->getTablePrefix(),
                                'link' => $path[$j],
                                'colname' => $tokens['col'][$i],
                                'token' => $tokens['val'][$i]
                            );
                        }
                    } else {
                        
                        $link = $path[$j];
                        
                        if ($j > 0)
                            $prefix = $path[$j - 1]->getTablePrefix();
                        else
                            $prefix = $localTable->getPrefix();
                        
                        $inClause[] = array(
                            'prefix' => $prefix,
                            'link' => $link,
                            'colname' => $tokens['col'][$i],
                            'token' => $tokens['val'][$i]
                        );
                        // bout de la jointure, colonne locale de la table jointe precedemment
                    }
                }
            }
        }
        
        $result = array(
            'clause' => '',
            'tokens' => array()
        );
        
        $where = ' WHERE ';
        $where .= $clause_str;
        
        $rep = 0;
        foreach ($inClause as $clause) {
            $where = preg_replace('/'.str_replace('.', '\.', $clause['colname']).'/',$clause['prefix'].'.'.$clause['link']->getName(),$where,1);
            $result['tokens'][$clause['token']] = $clause['link'];
        }
	                 
        $result['clause'] = $from.$where;

        return $result;
	}
	
	/**
	 * 
	 * @return NULL
	 * @version 2.0
	 * @since 06/01/2014
	 */
	final static public function getAdapter()
	{
	    $cls = get_called_class().'Adapter';
	    
	    if( class_exists($cls,true)){
	        return $cls::get();
	    }
	    else{
	        return null;
	    }
	} 
	
	/**
	 * To get the name of all properties as Reflection of the entity
	 * 
	 * @return multitype:|NULL
	 */
	final static public function getProperties()
	{
	   try{
	       return array_keys(self::getAdapter()->getColumnLinks());
	   }    
	   catch(\Exception $e){
	       return null;
	   }
	} 
	
	/**
	 * 
	 * @param unknown $property_str
	 * @param unknown $value_mixed
	 * @throws EntityException
	 * @return boolean
	 */
	public function checkAsProperty( $property_str, $value_mixed)
	{
	    $adapter = self::getAdapter();
		if( $adapter !== null){
			
			$col = $adapter->getColumnLinks($property_str);
			if( $col !== null){
			    // c'est un column link ??
			    if($col instanceof ColumnLink){
			        return $col->check($value_mixed);
			    }
			    // sinon c'est un foreign link
			    else{
			         if($col->isSameEntity($value_mixed)){
			             return $col->check($value_mixed->getID());
			         }   
			         else{
			             return $col->check($value_mixed);
			         }
			    }
			}
			else{
				throw new EntityException(EntityException::INVALID_COLUMN_LINK);
				return false;
			}			
		}
		else{
			throw new EntityException(EntityException::INVALID_ENTITY_ADAPTER);
			return false;
		}
	}
	
	/**
	 *
	 * @param unknown $property_str
	 * @param unknown $value_mixed
	 * @throws EntityException
	 * @return boolean
	 */
	static public function checkAs( $property_str, $value_mixed)
	{
	    $adapter = self::getAdapter();
	    if( $adapter !== null){
	        	
	        $col = $adapter->getColumnLinks($property_str);
	        if( $col !== null){
	            // c'est un column link ??
	            if($col instanceof ColumnLink){
	                return $col->check($value_mixed);
	            }
	            // sinon c'est un foreign link
	            else{
	                if($col->isSameEntity($value_mixed)){
	                    return $col->check($value_mixed->getID());
	                }
	                else{
	                    return $col->check($value_mixed);
	                }
	            }
	        }
	        else{
	            throw new EntityException(EntityException::INVALID_COLUMN_LINK);
	            return false;
	        }
	    }
	    else{
	        throw new EntityException(EntityException::INVALID_ENTITY_ADAPTER);
	        return false;
	    }
	}
	 
	
	/**
	 * update 06/01/2014
	 * 
	 * @access public
	 * @method boolean Valide les propriete d'un objet selon les donnee de la propriete _template
	 * @param array $param_propertylist_array Tableau des noms des proprietes a tester, si il est vide, toutes les prop seront teste
	 * @return boolean Resultat de la validation des proprietes
	 * @author GB Michel
	 * @version 2.0
	 */
	public function checkData( $param_propertylist_array = array())
	{
		$adapter = self::getAdapter();
		if( $adapter == null){
			return false;
		}
		$columns = $adapter->getColumnLinks();
		
		$final = true ;
		foreach( $param_propertylist_array as $ppt=>$value){
			
			// if a property not exists, check is stopped 
		    if( !property_exists(get_class($this), $ppt)){
		    	return false;
		    	break;
		    }
		    
		    if( $this->$ppt == null){
		        if($columns[$ppt]->isFacultative()){
		            // if property is empty but is optional, check pass
		            $v1 = true;
		        }
		        else{
		            // if property is empty but is needed, check fail
		            throw new EmptyValueException('Check data failed : empty value',$ppt,EntityException::FIELD_EMPTY);
		            $v1 = false;
		        }
		    }
		    else{
		        $f = $columns[$ppt]->check($this->$ppt);
		        $v1 = ($f === false)? false : true ;
		    }
			
			
			if( _UFO_VERBOSE_MODE_ === true){				
				if( $final === false){
				    Trace::addDebugData( 'checkData()', array(
    				    'Property_Name'=>$ppt,
    				    'Property_Value'=>$this->$ppt,
    				    'Check_TemplateCommand'=>$v1
				    ));
				}
			}
			
			$final = $final && $v1 ;		
		}
		
		return $final ;
	}
	
	
	
	/**
	 * update 06/0/2014
	 * 
	 * Permet de tester un jeu de donnees avant de les assigner aux proprietes de l'objet
	 * @access public
	 * @method boolean Valide un tableau associatif qui decrit les propriete d'un objet et leur valeur
	 * @param array $array_check Tableau des noms des proprietes et des valeurs a tester
	 * @return boolean Resultat de la validation des proprietes
	 * @author GB Michel
	 * @version 2.0
	 */
	public function checkDataFromArray( $array_check)
	{
		if( is_array($array_check)){

		    $adapter = self::getAdapter();
		    if( $adapter == null){
		    	return false;
		    }
		    $columns = $adapter->getColumnLinks();
		    
		    
		    $f = true;
			foreach( $array_check as $k=>$val)
			{
			    if( isset($columns[$k])){
			        if( $columns[$k] instanceof ForeignLink){
			            $f &= ($columns[$k]->checkAsProperty($val) === false)? false : true ;
			        }
			        elseif( $columns[$k] instanceof ColumnLink){
			            $f &= ($columns[$k]->check($val) === false)? false : true ;
			        }

			        if((_UFO_VERBOSE_MODE_===true)&&($f==false)){
			            echo "col : $k => val : $val<br>";
			        }
			    }
			    
			    
			}
			
			//  with the &= assignation's shortcut $f become an integer and need to be test with ==
			return ($f == false)? false : true ;
		}
		else{
			return null ;
		}
	}
	
	/**
	 * exemple :
	 * $param_fieldsearch_array = array('CAT_ID'=>array('int',1),'CRI_TITRE'=>array('str','telecom')) ;
	 * $returned_column_array = array('CRI_ID')
	 * $tablename_string = 'T_CRITERE_CRI'
	 *
	 * Rewrited the 06/01/2014
	 *
	 *
	 * @access public
	 * @method Array Retourne les colonnes de $returned_column_array en fonction de  $param_fieldsearch_array
	 * @param Array $param_fieldsearch_array Tableau associatif des colonne teste dans la close, de la forme colonne=>valeur
	 * @param String $tablename_str Nom de la table dans laquelle on cherche
	 * @param String $returned_column_str Chaine de caractere contenant la liste des colonnes retournee separee par une virgule
	 * @return Array Liste des occurences de la recherche
	 * 
	 * @version 2.0
	 */
	protected static function search( $param_fieldsearch_array, $returned_property_array = array(), $sizelimit_int = null, $startlimit_int = 0)
	{
	    /*
	    UserManager::getCurrentUser()->getRole()->checkAuthorizationOnEntity(get_called_class(),'Search');
	    */
	    
	    // adapter data : get Adapter of entity, table link and column links
	    $adapter = self::getAdapter();
	    if( $adapter == null){
	        throw new EntityException('Failed to get entity\'s adapter');
	        return false;
	    }
	    $tablename = $adapter->getTableLink()->getName();
	    $columns = $adapter->getColumnLinks();
	    $table_prefix = $adapter->getTableLink()->getPrefix();
	    
	    // Bind params array with counter
	    $c = 0;
	    $bindIndex = 1;
	    $bindParams = array();
	    
	    $db = DbManager::getConnexion(self::getDatabaseProfile());
	    $dbh = $db->getHandler();
	
	    // Make SELECT
	    $sql = 'SELECT ';
	    if( count($returned_property_array) == 0){
	        foreach($columns as $ppt=>$lnk)
	        {
	            // $sql .= '`'.$lnk->getName().'`,';
	            $return_keys['ppt_'.$ppt] = $ppt;
	            $sql .= ' '.$table_prefix.'.`'.$lnk->getName().'` AS ppt_'.$ppt.',';
	            $c++;
	        }
	        $sql = substr($sql,0,-1);
	    }
	    else{
	        foreach($returned_property_array as $ppt)
	        {
	            if( isset($columns[$ppt])){
	                //$sql .= '`'.$columns[$ppt]->getName().'`,';
	                $return_keys['ppt_'.$ppt] = $ppt;
	                $sql .= ' '.$table_prefix.'.`'.$columns[$ppt]->getName().'` AS ppt_'.$ppt.',';
	                $c++;
	            }
	        }
	        $sql = substr($sql,0,-1);
	    }
	    
	    // if c==0 , there aren't columns in request
	    if( $c == 0){
	    	
	    	return false;
	    }

	 
	    // Make FROM
	    $sql .= ' FROM `'._UFO_APP_SCHEMA_.'`.'.$db->manageCase($tablename).' '.$table_prefix.' ' ;
	
	    // Make WHERE clause
	    $where = ' WHERE ';
	    $join = '';    
	    foreach( $param_fieldsearch_array as $col=>$param)
	    {
	        if(isset($columns[$col])&&($columns[$col] instanceof ColumnLink)){
	            
	            $cleaned_param = isset($columns[$col])? $columns[$col]->check($param) : false ;
	            if( $cleaned_param !== false){
	            
	                switch($columns[$col]->getType())
	                {
	                	case ColumnLink::T_INT:
	                	    $where .= ' ('.$table_prefix.'.`'.$columns[$col]->getName().'` = ?) OR';
	                	    $bindParams[$bindIndex] = array('val'=>$cleaned_param,'col'=>$columns[$col]);
	                	    $bindIndex++;
	                	    break;
	                	case ColumnLink::T_STR:
	                	    $where .= ' ('.$table_prefix.'.`'.$columns[$col]->getName().'` LIKE ?) OR';
	                	    $bindParams[$bindIndex] = array('val'=>'%'.$cleaned_param.'%','col'=>$columns[$col]);
	                	    $bindIndex++;
	                	    break;
	                }
	            }
	            else{
	                return false;
	            }
	        }
	        elseif(strpos($col,'.')!==false){
	            
	            $t = explode('.',$col);
	            if(isset($columns[$t[0]])){
	                
	                $foreign_link = $columns[$t[0]];
	                $foreign_adapter = $foreign_link->getForeignAdapter();
	                $foreign_col = $foreign_adapter->getColumnLinks($t[1]);
	                   
	                if($foreign_link !== false){

	                    $cleaned_param = $foreign_col->check($param);
	                    if($cleaned_param !== false){
	                        
	                        $tmp_prefix = $foreign_link->getTablePrefix();
	                        $tmp_join = $foreign_link->isFacultative()? 'LEFT JOIN ' : 'INNER JOIN ';
	                        $tmp_join .= '`'._UFO_APP_SCHEMA_.'`.'.$db->manageCase($foreign_link->getTableName()).' '.$tmp_prefix.' ON '.$table_prefix.'.'.$foreign_link->getName().'='.$tmp_prefix.'.'.$foreign_link->getName().' ';
	                         
	                        switch($foreign_col->getType())
	                        {
	                        	case ColumnLink::T_INT:
	                        	    $where .= ' ('.$tmp_prefix.'.`'.$foreign_col->getName().'` = ?) OR';
	                        	    $bindParams[$bindIndex] = array('val'=>$cleaned_param,'col'=>$foreign_col);
	                        	    $bindIndex++;
	                        	    break;
	                        	case ColumnLink::T_STR:
	                        	    $where .= ' ('.$tmp_prefix.'.`'.$foreign_col->getName().'` LIKE ?) OR';
	                        	    $bindParams[$bindIndex] = array('val'=>'%'.$cleaned_param.'%','col'=>$foreign_col);
	                        	    $bindIndex++;
	                        	    break;
	                        }
	                        
	                        $join .= $tmp_join;
	                    }
	                    else{
	                        throw new EntityException();
	                    }
	                }
	                else{
	                    throw new EntityException();
	                }
	            } 
	        }
 
	    }
	    
	    $sql .= $join;
	    if( $where !== ' WHERE '){
	        $sql .= substr( $where, 0, -2);
	    }	    
	    
	    // Make LIMIT
	    if( $sizelimit_int !== null){
	        $sql .= 'LIMIT '.(int)$sizelimit_int.' OFFSET '.(int)$startlimit_int;
	    }
	    
	    try{
	        $sth = $dbh->prepare( $sql, array( \PDO::ATTR_CURSOR => \PDO::CURSOR_SCROLL));
	        // set values of bind params
	        for($i=1 ; $i<=($bindIndex-1) ; $i++)
	        {
	           $sth->bindParam($i, $bindParams[$i]['val'], $bindParams[$i]['col']->getType());    
	        }
	        $res = $sth->execute();
	        	
	        if( $res !== false){
	
	            $tmp = array();
	            while( $data = $sth->fetch( \PDO::FETCH_ASSOC, \PDO::FETCH_ORI_NEXT)){
	                
	                $cleaned_data = array();
	                foreach( $data as $col=>$val)
	                {
	                    if( $columns[$return_keys[$col]]->check($val)){
	                        $cleaned_data[$return_keys[$col]] = $val; 
	                    }
	                }
	                $tmp[] = $cleaned_data;
	            }
	
	            $res = $tmp;
	        }
	        else{
	            $res = false ;
	        }
	    }
	    catch( \PDOException $e){
	        	
	        throw new EntityException('Search() failed');
	        $res = false ;
	    }
	
	    return $res ;
	}
	
	public static function searchBy($property_str,$value_mixed,$start_int=null,$limit_int=null,$rawdata_bool=false)
	{
	    if(is_int($value_mixed)){       
	        $data = self::search(array($property_str=>$value_mixed),array(),$limit_int,$start_int);
	    }
	    elseif(is_string($value_mixed)){
	        $data = self::search(array($property_str=>$value_mixed),array(),$limit_int,$start_int);	        
	    }
	    else{
	        return false;
	    }
	    
	    if($data==false) return false;
	    
	    if($rawdata_bool == false){
	        
	        $current_class = get_called_class();
            $collection = new EntityCollection();
            ;
            foreach($data as $row){	  
                             
                $o = new $current_class();
                $o->setData($row);  
                $collection->add($o);
            }

            return $collection;
	    }
	    else{
	        return $data;
	    }
	    /*
	    elseif(is_array($value_mixed)){
	        
	        $adapter = self::getAdapter();
    	    if( $adapter == null){
    	        throw new EntityException('Failed to get entity\'s adapter');
    	        return false;
    	    }
    	    $tablename = $adapter->getTableLink()->getName();
    	    $columns = $adapter->getColumnLinks();
    	    
	        return self::read($start_int,$limit_int,'( '.$columns[$property_str]->getName().' IN ())')   
	    }*/
	    
	}
	
	
	/**
	 * @method String Retourne les valeurs des proprietes selectionnes de l'objet au format JSON
	 * @param Array $param_propertyname_array description Liste des propriete retourne, par defaut toutes les propriete sont retournees
	 * @param Array $customvalue_array Liste de paire "clef" : "valeur" a ajouter a la fin de la chaine
	 * @return String Representation JSON de l'objet, en fonction des parametres
	 **/
	public function JSONencode( $htmlencode_bool = true, $param_propertyname_array = array(), $customvalue_array = array())
	{
	    
	    
		// preparation de la liste des proprietes selectionnees
		if( count($param_propertyname_array) == 0){
		    $adapter = call_user_func(get_called_class().'::getAdapter');
		    $ppties = array_keys($adapter->getColumnLinks());
			//$ppties = array_keys( $this->_template); 	
		}
		else{
			
			$ppties = array();
			foreach( $param_propertyname_array as $ppt){
					
				$ppties[] = $ppt ; 
			}
		}
		
		// creation du tableau des valeurs
		$tmp = array();
		foreach( $ppties as $ppt)
		{
			if( property_exists( $this, $ppt)){
				
				( $htmlencode_bool == true)? $tmp[$ppt] = htmlentities( $this->$ppt) : $tmp[$ppt] = $this->$ppt ;
			}			
		}
		
		// Ajout des eventuelle paire supplementaire
		if( count($customvalue_array) > 0){
			
			$keys = array_keys( $tmp);
			foreach( $customvalue_array as $k=>$v){
				
				if( !in_array( $k, $keys)){
					$tmp[$k] = $v ;
				}
			}
		}
		
		
		return json_encode( $tmp);
	}
	
	/**
	 * @method Boolean Remplit les propriete de l'objet en utilisant des donnees JSON
	 * @param String $jsonnotation_str Representation JSON des propriete et de leur valeur
	 * @return Boolean TRUE en cas de succes d'enregistrement, FALSE sinon
	 * @author GB Michel
	 * @version 1.0
	 */
	public function JSONdecode( $jsonsnotation_str)
	{
		$ctn = json_decode( $jsonsnotation_str, true);
		
		return $this->setData($ctn);
	}
	
	 
	/**
	 * 
	 * @param unknown $param_id_int
	 */
	public static function IDexists( $param_id_int)
	{
	    if( !is_null($param_id_int)){
	        	
	        $adapter = self::getAdapter();
	        if( $adapter == null){
	        	throw new EntityException('Failed to get entity\'s adapter');
	        	return false;
	        }	        
	        $col_ID = $adapter->getColumnLinks('id');
	        	        
	        $checked_ID = $col_ID->check($param_id_int);
	        if( $checked_ID === false){
	        	return false;
	        }
	        
	    	$db = DbManager::getConnexion(self::getDatabaseProfile());
	    	$dbh = $db->getHandler();
	        
	        $sql = 'SELECT `'.$col_ID->getName().'` 
	        		FROM `'._UFO_APP_SCHEMA_.'`.'.$db->manageCase($adapter->getTableLink()->getName()).' 
	        		WHERE `'.$col_ID->getName().'` = ?';
	        	 	
	        try{
	            $sth = $dbh->prepare( $sql);
	            $sth->bindParam( 1, $checked_ID, $col_ID->getType(), $col_ID->getMaxLength());
	            $sth->execute();
	    
	            if( count($sth->fetchAll()) > 0){
	                return true ;
	            }
	            else{
	                return false ;
	            }
	    
	        }
	        catch( \PDOException $e){

	        	throw new EntityException('ID exist() failed');
	            return false ;
	        }
	    }
	    else{
	        return false ;
	    }
	} 
	
	
	/**
	 * update 06/01/2014
	 * 
	 * @param unknown $data_array
	 * @param string $check_bool
	 * @return boolean
	 */
	public function setData( $data_array, $check_bool = true)
	{
	    
	    if( $check_bool === true){
	        $f = $this->checkDataFromArray( $data_array);
	    }
	    else{
	        $f = true;
	    }
	     
	    if( $f == true ){	
	        foreach( $data_array as $k=>$v){
	            
	        	if( property_exists( get_called_class(), $k)){
	        		$this->$k = $v ;
	        	}
	        	else{
	        		throw new EntityException(get_called_class(),'setData',func_get_args(),
	        		EntityException::ASSIGNATION_FAILED);
	        	}
	        }
	        return true ;
	    }
	    else{
	        throw new EntityException(get_called_class(),'setData',func_get_args(),
	        		EntityException::CHECK_DATA_FAILED);
	        return false ;
	    }
	}

	
	/**
	 *
	 * @param unknown $listID_array
	 * @return DbObjectAbstract|Collection|boolean
	 */
	public static function getByID( $ID_mixed)
	{
	    // PREPARE ADAPTER
	    // -------------------------------------------------------
	    $adapter = call_user_func(get_called_class().'::getAdapter');
	    $tableLink = $adapter->getTablelInk();
	    $columnLinks = $adapter->getColumnLinks();
	    $return_keys = array();
	    
	    // PREPARE LIST OF ID
	    // -------------------------------------------------------
	    $listID = array();
	    if( is_array($ID_mixed)){
	        foreach( $ID_mixed as $tmpd_id){
	            $listID[] = $columnLinks['id']->check($tmpd_id);
	        }
	    }
	    elseif( ($tmpd_id = $columnLinks['id']->check($ID_mixed)) !== false){
	        $listID[] = $tmpd_id;
	    }	    
	    else{
	        return false;
	    }
	    
	    // PREPARE REQUEST
	    // ------------------------------------------------------
	    $db = DbManager::getConnexion(self::getDatabaseProfile());
	    $dbh = $db->getHandler();
	    
	    // Make request
	    $bindTable = array();
	    $sql = 'SELECT ';
	    
	    foreach( $columnLinks as $ppt=>$lnk)
	    {
	        $return_keys['ppt_'.$ppt] = $ppt;
	        $sql .= '`'.$lnk->getName().'` AS ppt_'.$ppt.',';
	    }

	    $sql = substr($sql,0,-1).' FROM `'._UFO_APP_SCHEMA_.'`.`'.$db->manageCase($tableLink->getName()).'` ';
	    $sql .= ' WHERE `'.$columnLinks['id']->getName().'` IN ('.str_repeat('?,', count($listID));
	    $sql = substr( $sql, 0, -1).')';
	    

	    // EXEC REQUEST
	    // --------------------------------------------------------
	    try{
	        $sth = $dbh->prepare( $sql);
	        
	        foreach( $listID as $i=>$cleanID){
	            $sth->bindParam( $i+1, $cleanID, $columnLinks['id']->getType(), $columnLinks['id']->getMaxLength());
	        }
	        $f = $sth->execute();

	        if( $f !== false){
	            
	            $current_class = get_called_class();
	
	            // If multiple ID :return collection of instance
	            if( count($listID) > 1){
	                $collection = new EntityCollection();
	                while( $data = $sth->fetchAll(\PDO::FETCH_ASSOC)){
	                    $o = new $current_class();
	                    $o->setID($data['ppt_id']);
	                    foreach( $data as $k=>$n){
	                        if( $k !== 'ppt_id'){
	                            $t[$return_keys[$k]] = $n;
	                        }
	                    }
	                    $o->setData($t);
	                    
	                    $collection->add($o);
	                }
	                
	                return $collection;
	            }
	            // If only one ID : return and instance 
	            else{
	                $data = $sth->fetchAll(\PDO::FETCH_ASSOC);
	                $t = array();
	                
	                
	                $o = new $current_class();
	                $o->setID($data[0]['ppt_id']);
	                foreach( $data[0] as $k=>$n){
	                    if( $k !== 'ppt_id'){
	                        
	                        $t[$return_keys[$k]] = $n;
	                    }
	                }
	                $o->setData($t);
	                
	                return $o;
	            }
	        }
	        else{
	            return null;
	        }
	    }
	    catch(\PDOException $pdoException){
	        
	        throw new EntityException(get_called_class(),'getByID',func_get_args(),EntityException::DB_QUERY_SEARCH_FAILED,$pdoException);
	        
	        return false ;
	    }
	}
	
	
	/**
	 * @method boolean Insert object's data as record into database 
	 * @return boolean Return TRUE if insert successful, else FALSE
	 * @since 09/09/2013
	 * @version 2.0
	 * @author GB Michel
	 */
	public function create( $autoIncrement_bool = true)
	{
		if( $this->checkData() == true ){
			
			$adapter = self::getAdapter();
			
			$db = DbManager::getConnexion(self::getDatabaseProfile());
			$dbh = $db->getHandler();
			
		    // Make request
			$bindParams = array();
			$bindIndex = 1;
			
			
			$sql = 'INSERT INTO `'._UFO_APP_SCHEMA_.'`.'.$db->manageCase($adapter->getTableLink()->getName()).' (';
			foreach( $adapter->getColumnLinks() as $ppt=>$coll){
			    
			    if( $ppt !== 'id'){
			    	  
			        if( $coll instanceof ForeignLink){
			            $f_adapter = $coll->getForeignAdapter();
			            $f_pptname = $coll->getPropertyName();
			            $f_coll = $f_adapter->getColumnLinks($f_pptname);
			            
			            $unclean_data = $this->$ppt->get($f_pptname);
			            $clean_data = $f_coll->check($unclean_data, $coll->getPropertyName());
			            
			            $parameter = array('val'=>$clean_data,'col'=>$f_coll);
			        }
			        else{
			            $parameter = array('val'=>$this->$ppt,'col'=>$coll);
			        }
			        
			        //if(!$coll->isFacultative()||($this->$ppt !== null)){
			            $bindParams[] = $parameter;
			            $bindIndex++;
			            $sql .= '`'.$coll->getName().'`,';
			        //}    
			    }	
			    elseif( $autoIncrement_bool === false){
			        
			        $bindParams[] = array('val'=>$this->$ppt,'col'=>$coll);
			        $bindIndex++;
			         
			        $sql .= '`'.$coll->getName().'`,';
			    }		    
			}
			$sql = substr( $sql, 0, -1).') VALUES (';
			$sql .= str_repeat( '?,', count($bindParams));
			$sql = substr( $sql, 0, -1).')';

			//var_dump($sql);
			try{
				$sth = $dbh->prepare( $sql);
				foreach( $bindParams as $i=>$desc){
				    $sth->bindParam( $i+1, $desc['val'], $desc['col']->getType(), $desc['col']->getMaxLength());
				}
				$res = $sth->execute();
				
				if( $res == true ){					
					return (int)$dbh->lastInsertId();
				}
				else{
				    return false;
				}
			}
			catch( \PDOException $pdoException ){
				
				throw new EntityException(
						get_called_class(),'getByID',func_get_args(),
						EntityException::DB_QUERY_CREATE_FAILED,$pdoException);
				
				return false ;
			}
		}
		else{
			return 'err' ;
		}
	}
	
	
	/**
	 * @method boolean Update database record 
	 * @return boolean Return TRUE if update successful, else FALSE
	 * @since 09/09/2013
	 * @version 2.0
	 * @author GB Michel
	 */
	public function update()
	{
	    if( call_user_func(get_class($this).'::IDexists',$this->id) && ($this->checkData() == true)){
	        	
	    	$adapter = call_user_func(get_class($this).'::getAdapter');
	    	if( $adapter == null){
	    		throw new EntityException('Failed to get entity\'s adapter');
	    		return false;
	    	}
	    	$tablename = $adapter->getTableLink()->getName();
	    	$column = $adapter->getColumnLinks();
	    		    	
	    	$db = DbManager::getConnexion(self::getDatabaseProfile());
	    	$dbh = $db->getHandler();
	    	
	        // Make request
	        $bindTable = array();
	        
	        $sql = 'UPDATE `'._UFO_APP_SCHEMA_.'`.`'.$db->manageCase($tablename).'` SET ';
	        $bindIndex = 0;
	        foreach( $column as $ppt=>$link)
	        {
	           if( $ppt !== 'id'){			    	  
			        if( $link instanceof ForeignLink){
			            $f_adapter = $link->getForeignAdapter();
			            $f_pptname = $link->getPropertyName();
			            $f_link = $f_adapter->getColumnLinks($f_pptname);
			            $f_entity = $link->getEntity();
			            
			            
			            // if(!($link->isFacultative() && (is_null($this->$ppt)||$this->$ppt==''))){
			            if(!($link->isFacultative() && is_null($this->$ppt))){
			                if( $this->$ppt instanceof $f_entity){
			                    $unclean_data = $this->$ppt->get($f_pptname);
			                    $clean_data = $link->checkAsProperty($unclean_data, $link->getPropertyName());
			                }
			                else{
			                    $clean_data = $link->checkAsProperty($this->$ppt, $link->getPropertyName());
			                }
			                 
			                $sql .= '`'.$link->getName().'` = ?,';
			                //$sql .= '`'.$link->getName().'` = '.$this->$ppt.',';
			                $bindParams[] = array('val'=>$clean_data,'col'=>$f_link);
			                $bindIndex++;
			            }	            
			        }
			        else{
			            //if(!($link->isFacultative() && (is_null($this->$ppt)||$this->$ppt==''))){
			            if(!($link->isFacultative() && is_null($this->$ppt))){
			        	     $sql .= '`'.$link->getName().'` = ?,';
			        	     //$sql .= '`'.$link->getName().'` = '.$this->$ppt.',';
			                 $bindParams[] = array('val'=>$this->$ppt,'col'=>$link);
			                 $bindIndex++;
			            }
			        }     
			    }	
	        }
	        $sql = substr( $sql, 0, -1).' WHERE `'.$column['id']->getName().'` = ?';
	        
	        $id = $column['id']->check($this->id);
	        
	        try{
	            $sth = $dbh->prepare( $sql);
	            
	            foreach( $bindParams as $i=>$desc){
	                $sth->bindParam( $i+1, $desc['val'], $desc['col']->getType(), $desc['col']->getMaxLength());
	            }
	            $sth->bindParam( $i+2, $id, $column['id']->getType(), $column['id']->getMaxLength()); 

	            return $sth->execute();
	        }
	        catch( \PDOException $pdoException){
	    
	            throw new EntityException(
						get_called_class(),'update',func_get_args(),
						EntityException::DB_QUERY_UPDATE_FAILED,$pdoException);
				
				return false ;
	        }
	    }
	    else{
	        return false ;
	    }
	}
	
	
	/**
	 * update 07/01/2014
	 * 
	 * @method boolean Delete a record from database
	 * @return boolean Return TRUE if update successful, else FALSE
	 * @since 09/09/2013
	 * @version 2.0
	 * @author GB Michel
	 */
	public function delete()
	{	
		$adapter = self::getAdapter();
		if( $adapter == null){
			throw new EntityException('Failed to get entity\'s adapter');
			return false;
		}
		$tablename = $adapter->getTableLink()->getName();
		$column = $adapter->getColumnLinks('id');
		
		$clean_id = $column->check($this->id);
	    if( $clean_id == true){
	    	
	    	$db = DbManager::getConnexion(self::getDatabaseProfile());
	    	$dbh = $db->getHandler();
	    	
	    	$dbh->beginTransaction();
	    		    	
	        $sql = 'DELETE FROM `'._UFO_APP_SCHEMA_.'`.'.$this->manageCase($tablename).' WHERE `'.$column->getName().'` = ?';	        
	        	
	        try{
	            $sth = $dbh->prepare( $sql);
	            $sth->bindParam(1, $column->check($this->id), $column->getType(), $column->getMaxLength());
	            $res = $sth->execute();
	            
	            if( $res == false){
	            	$dbh->rollback();

	            	throw new EntityException(
	            			get_called_class(),'delete',func_get_args(),
	            			EntityException::DELETE_FAILED);
	            	
	            	return false;
	            }
	            else{
	            	return true;
	            }
	        }
	        catch( \PDOException $pdoException){

	            throw new EntityException(
	            		get_called_class(),'delete',func_get_args(),
	            		EntityException::DB_QUERY_DELETE_FAILED,$pdoException);
	            
	            return false ;
	        }
	    }
	    else{
	        return false ;
	    }
	}
	
	
	/**
	 * To count the number of entity in database
	 * 
	 * Static method
	 * The count can be specialized when passing simplified clause in params
	 * 
	 * @method integer count( [ string $clause_str = null [, array $params_arr = null ]])
	 * @param string $clause_str [Optionnal] Simplified clause to specialize count
	 * @param array $params_arr [Optionnal] Array of params used into clause
	 * @return integer Return the count of entity in the database, FALSE if error occur
	 * @since 20/05/2014
	 * @version 2.1
	 */
	public static function count($clause_str = null,$params_arr = null)
	{
	    $db = DbManager::getInstance()->getConnexion(self::getDatabaseProfile());
	    $dbh = $db->getHandler();
	     
	    try{
	        if($clause_str !== null){
	            // parametre non liee a des param, futur => rectif de la clause
	            $clause = self::clauseConstructor($clause_str);
	            $sql = 'SELECT COUNT(*) AS NBROW '.$clause['clause'];
	             
	            $sth = $dbh->prepare($sql);
	            
	            if($params_arr !== null){
    	            foreach($params_arr as $token=>$val){
    	                if(isset($clause['tokens'][$token])){
    	                    $cleaned_val = $clause['tokens'][$token]->check($val);
    	                    if($cleaned_val !== false){
    	                        $sth->bindParam($token,$clause['tokens'][$token]->check($val),$clause['tokens'][$token]->getType(),$clause['tokens'][$token]->getMaxLength());
    	                    }
    	                    else{
    	                        // error
    	                    }
    	                }
    	                else{
    	                    // ignore
    	                }
    	            }
	            }
	        }
	        else{
	            $adapter = self::getAdapter();
	            $sql = 'SELECT COUNT(*) AS NBROW FROM `'._UFO_APP_SCHEMA_.'`.'.$db->manageCase($adapter->getTableLink()->getName());
	             
	            $sth = $dbh->prepare($sql);
	        }
	        	
	        $res = $sth->execute();
	        if($res == true){
	            $data = $sth->fetch();
	            $nb = $data['NBROW'];
	            unset($data);
	        }
	        else{
	            $nb = 0;
	        }
	        	
	        unset($clause,$sql,$sth);
	        return (int)$nb;
	    }
	    catch( \PDOException $e){
	        return false;
	    }
	}
	
	
	/**
	 * read();
	 * read(0,30);
	 * read(null,null,'( id = :id:) AND ( nom = :nom:)', array('id'=>1,'nom'=>'jojo'));
	 * 
	 * 
	 * @param unknown $whereproperty_array
	 * @param number $start_int
	 * @param number $nb_int
	 * @throws EntityException
	 * @return boolean
	 */
	public static function read( $start_int=0, $nb_int=10, $where_str = '', $whereproperty_array = array())
	{	    
		// Prepare adapter
		$adapter = call_user_func(get_called_class().'::getAdapter');
		if( $adapter == null){
			throw new EntityException('Failed to get entity\'s adapter');
			return false;
		} 
		$tablename = $adapter->getTableLink()->getName();
		$columns = $adapter->getColumnLinks();
		 
		// Bind params array with counter
		$bindIndex = 1;
		$bindParams = array();
		 
		$db = DbManager::getInstance()->getConnexion(self::getDatabaseProfile());
		$dbh = $db->getHandler();
		
		// Make SELECT
		$sql = 'SELECT ';
		foreach($columns as $ppt=>$link)
		{
			$sql .= '`'.$columns[$ppt]->getName().'` AS ppt_'.$ppt.',';
		}
		$sql = substr($sql,0,-1);
	 
		// Make FROM
		$sql .= ' FROM `'._UFO_APP_SCHEMA_.'`.'.$db->manageCase($tablename).' ' ;
		
		// Make WHERE clause
		if( $where_str !== ''){
			$ident = array();
			preg_match_all('/:([a-z0-9A-Z_]+):/',$where_str,$idents);
				
			
			foreach( $idents[1] as $k=>$param){
		
				if( isset($whereproperty_array[$param])){
					
					$cleaned_param = isset($columns[$param])? $columns[$param]->check($whereproperty_array[$param]) : false ;
					
					if( $cleaned_param !== false){
					
					    
						$where_str = str_replace($idents[0][$k],'?',$where_str);
						$bindParams[$bindIndex] = array('val'=>$cleaned_param,'col'=>$columns[$param]);
						$bindIndex++;
					}
					else{
						return false;
					}
				}
				else{
					return false;	
				}
			}
			$sql .= ' WHERE '.$where_str;
		}
		 
		if($start_int !== null){
		    $sql .= ' LIMIT '.(int)$start_int ;
		    // Standard SQL, ne marche pas sous MySQL
		    // if($nb_int !== null) $sql .= ' OFFSET '.(int)$nb_int;
		    if($nb_int !== null) $sql .= ','.(int)$nb_int;
		}
	    

		try{
			$sth = $dbh->prepare( $sql, array( \PDO::ATTR_CURSOR => \PDO::CURSOR_SCROLL));
			for($i=1 ; $i<=($bindIndex-1) ; $i++)
			{
			// set values of bind params
				$sth->bindParam($i, $bindParams[$i]['val'], $bindParams[$i]['col']->getType(), $bindParams[$i]['col']->getMaxLength());
			}
			
			$res = $sth->execute();
		
			if( $res !== false){
		
				//$tmp = array();
				$tmp = new EntityCollection();
				$class = get_called_class();
				
				
				while( $data = $sth->fetch( \PDO::FETCH_ASSOC, \PDO::FETCH_ORI_NEXT))
				{
					$o = new $class;
					$id_obj = null;
					
					$properties = array();
					//$properties = new EntityCollection();
					
					foreach( $data as $col=>$val)
					{
						if( $col == 'ppt_id'){
						    if($adapter->getColumnLinks('id')->getType() == ColumnLink::T_INT){
						        $id_obj = (int)$val;
						    }
						    else{
						        $id_obj = (string)$val;
						    }
						}
						else{
							$ppt_name = substr($col,4,strlen($col)-4);
							$properties[$ppt_name] = $val;
						}
					}
					
					
					if( $id_obj !== null){
						$o->setID($id_obj);
						$o->setData($properties, true);
					}
					
					$tmp[] = $o;
					//$tmp->add($o);
				}
		
				return $tmp;
			}
			else{
				return false;
			}
		}
		catch( \PDOException $e){

			throw new EntityException('Read() failed');
			$res = false ;
		}

		return $res ;
	}
	
	
	
	/**
	 * update 
	 * 
	 * V1.1 : Ajout de $changekey, permet le renommage des proprietes pour l'export 
	 * @method Array Retourne les propriete de l'objet sous forme de tableau associatif: ppt => valeur
	 * @param Array $propertynames_array Liste des propriete retourne, si vide, renvoie toutes les proprietes publique
	 * @return Array Tableau de "nom_de_la_propriete"
	 * @author GB Michel
	 * @version 1.1
	 */
	public function toArray( $propertynames_array = array(), $changekeys = false, $usealias_bool = false)
	{
		// GET ADAPTER
		$adapter = self::getAdapter();
		if( $adapter == null){
			throw new EntityException('Failed to get entity\'s adapter');
			return false;
		}
		$columns = $adapter->getColumnLinks();
		
		
		$tmp = array();
		if( count($propertynames_array) == 0){
			$pptlist = array_keys($columns) ;
		}
		else{
			$pptlist = $propertynames_array ;
		}
		/*
		if( $usealias_bool == true){
		
		    $new = array();
		    foreach( $pptlist as $ptie){
		        $new[$this->_alias[$ptie]] = $ptie;
		    }
		
		    $pptlist = $new;
		    unset($new);
		}*/
		
		foreach( $pptlist as $key=>$ppt)
		{
			if( property_exists( $this, $ppt)){
				
				if( $changekeys === true){
					$tmp[$key] = $this->$ppt ;
				}
				else{
					$tmp[$ppt] = $this->$ppt ;
				}
			}
		}
		
		return $tmp ;
	}
	
	
	/**
	 * new
	 * 
	 * @param unknown $request_str
	 * @param string $delimiter_str
	 * @throws EntityException
	 * @return boolean|multitype:
	 */
	public function executeQuery( $request_str, $delimiter_str = ':')
	{
		// PREPARE 
		// ---------------------------------------------
		$raw_request = $request_str;
		$final_request = $request_str;
		$bindParam = array();
		$bindIndex = 0;
		
		$adapter = self::getAdapter();
		if( $adapter == null){
			throw new EntityException('Failed to get entity\'s adapter');
			return false;
		}
		$tablename = $adapter->getTableLink()->getName();
		$columns = $adapter->getColumnLinks();
		
		// MAKE REQUEST
		// ----------------------------------------------
		$matches = array();
		preg_match_all('/'.$delimiter_str.'([a-zA-Z0-9_]+)'.$delimiter_str.'/',$request_str,$matches);

		if(count($matches)>0){
		    foreach( $matches[1] as $offset=>$token)
		    {
		        if( isset($columns[$token])){
		            if($columns[$token] instanceof ColumnLink){
		                $bindParam[$offset] = array('val'=>$columns[$token]->check($this->$token),'col'=>$columns[$token]);
		            }
		            else{
		                if($columns[$token]->isSameEntity($this->$token)){
		                    $bindParam[$offset] = array('val'=>$columns[$token]->check($this->$token->getID()),'col'=>$columns[$token]);
		                }
		                else{
		                    $bindParam[$offset] = array('val'=>$columns[$token]->check($this->$token),'col'=>$columns[$token]);
		                }		                
		            }
		            $final_request = str_replace($matches[0][$offset], '?', $final_request);
		        }
		    }
		}

		if(\Ufo\User\UserManager::isOpen()){
		    $dbProfile = \Ufo\User\UserManager::getDBProfile();
		}
		else{
		    $dbProfile = _UFO_APP_DEFAULT_PROFILE_;    
		}
		
		
		$db = DbManager::getConnexion(self::getDatabaseProfile());
		$dbh = $db->getHandler();
		
		try{
			$sth = $dbh->prepare($final_request);
			
			foreach( $bindParam as $i=>$data)
			{
				$sth->bindParam($i+1, $data['val'], $data['col']->getType(), $data['col']->getMaxLength());
			}
			$f = $sth->execute();
			
		    if( $f !== false){
			    
			    if(substr($final_request,0,5) == 'SELEC'){
			        return $sth->fetchAll();
			    }
				elseif(substr($final_request,0,5) == 'INSER'){
				    return !is_null($this->id)? $this->id : $dbh->lastInsertId();
				}
				else{
				    return true;
				}
			}
			else{
				return false;
			}
		}
		catch( \PDOException $pdoException){
			
			throw new EntityException(
					get_called_class(),'executeQuery',func_get_args(),
					EntityException::DB_QUERY_CUSTOM_FAILED,$pdoException);
			 
			return false ;
		}
	}
	
	
	/**
	 * @static
	 * @access public
	 * @method Collection|boolean Cree une collection de tous les referentiels sur la plage choisie.
	 * @param int $start Numero de la premiere ligne a extraire
	 * @param int $nb_int Nombre de ligne a extraire
	 * @return Collection|boolean Collection de tous les referentiels, FALSE en cas d'erreur
	 * @since 19/03/2013
	 * @author GB Michel
	 * @version 1.0
	 */
	public static function getAll( $start_int=0, $nb_int=10)
	{
		$coll = new EntityCollection();
		$f = $coll->addObjectsFromDb( get_called_class(), $start_int, $nb_int);
		 
		return ($f==true)? $coll : false ;
	}
	
	
	/**
	 * @method bool Verifie avec le template si l'objet s'est charge correctement
	 * @return bool Retourn TRUE si l'obje est bien charge, sinon FALSE
	 * @since 30/04/2013
	 * @version 1.0
	 * @author GB Michel
	 */
	public function isLoaded()
	{
	   if($this->___loaded == false){
	        if($this->checkData()){
	            $this->___loaded = true;
	            return true;
	        }
	        else{
	            return false;
	        }
	    }
	    else{
	        return true;
	    }
	}
	
	
	/**
	 * @method boolean Set object ID 
	 * @param int ID to add to object
	 * @return boolean Return TRUE if operation succesfull, else FALSE 
	 * @version 1.0
	 * @since 2013/09/08
	 * @author GB Michel
	 */
	final public function setID( $id_int)
	{	    
		$id = $this->checkAsProperty('id',$id_int);

		if( $id !== false){
			$this->id = $id;
			return true;
		}
		else{
			return false;
		}
	}
	
	
	/**
	 * @method boolean Get object ID 
	 * @return boolean Return ID value if operation succesfull, else FALSE 
	 * @version 1.0
	 * @since 2013/09/08
	 * @author GB Michel
	 */
	final public function getID()
	{
		if( is_null( $this->id)){
			return false;
		}
		else{
			return $id = $this->checkAsProperty('id',$this->id);
		}
	}
	
	/**
	 * Return alias property if exists
	 * @return boolean
	 */
	public function getAlias()
	{
	    if( property_exists( $this, '_alias')){
	        return $this->_alias;
	    }
	    else{
	        return false;
	    }
	}
	
	/** 
	 * Alias de $this->$pptname_str
	 * Est utile dans certain cas ou l'alias n'est pas dispo
	 * @since 05/05/2013 
	 */
	final public function get( $pptname_str)
	{
		return $this->$pptname_str ;		
	}
	
	
	/**
	 * To get property of an object, and property of agregate object
	 * 
	 * Pour un objet Entreprise contenant dans la propriete "contact" un object Personne
	 * on peut recuperer la propriete "prenom" du contact de la maniere suivant
	 * 
	 * Le chemin suit les ForeignLink
	 * 
	 * $entreprise->getProperty('contact.prenom');   
	 * 
	 * Que la propriete "contact" de Entreprise contienent une instance Personne ou un ID
	 *
	 * $entreprise->getProperty('contact'); Retourne un objet Personne contenant les données du contact  
	 * 
	 * Si la propriete "siret" de Entreprise est une chaine de caractere
	 * 
	 * $entreprise->getProperty('siret'); Retourne la chaine de caractere
	 * 
	 * Si une propriete n'existe pas ou n'est pas accessible, la methode retourne FALSE
	 * 
	 * @method mixed getProperty( string $path2property_str)
	 * @param string $path2property_str Relative path to the property from current objet
	 * @return Ambigous <\Ufo\Entity\Db\EntityAbstract, boolean>|boolean|mixed
	 */
	final public function getProperty( $path2property_str)
	{
	    if(strpos($path2property_str,'.') !== false){
	         
	        if($this->isLoaded()){
	            $node = explode('.',$path2property_str);
	            $val = null;
	            $e = $this;
	             
	            for($i=0;$i<count($node);$i++){
	                 
	                $adpt = $e::getAdapter();
	                if($adpt instanceof EntityAdapter){
	
	                    $link = $adpt->getColumnLinks($node[$i]);
	                     
	                    if($link instanceof ForeignLink){
	                        $entity = $link->getEntity();
	                        if($e->get($node[$i]) instanceof $entity){
	                            $e = $e->get($node[$i]);
	                        }
	                        else{
	                            $e = call_user_func($entity.'::getByID',$e->get($node[$i]));
	                        }
	                    }
	                    elseif($link instanceof ColumnLink){
	                        $e = $e->get($node[$i]);
	                    }
	                }
	                else{
	                    $e = false;
	                    $i = count($node)+1;
	                }
	            }
	
	            return $e;
	        }
	        else{
	            return false;
	        }
	    }
	    else{
	
	        $col = self::getAdapter()->getColumnLinks($path2property_str);
	         
	        if($col instanceof ForeignLink){
	            $entity = $col->getEntity();
	            if($this->$path2property_str instanceof $entity){
	                return $this->$path2property_str;
	            }
	            else{
	                return  call_user_func($entity.'::getByID',$this->$path2property_str);
	            }
	        }
	        elseif($col instanceof ColumnLink){
	            return $this->$path2property_str;
	        }
	        else{
	            return false;
	        }
	    }
	}
	
	/**
	 * Alias de $this->$pptname_str = $val_mixed ;
	 * Est utile dans certain cas ou l'alias n'est pas dispo 
	 * @since 05/05/2013
	 **/
	final public function set( $pptname_str, $val_mixed)
	{
	    if($val_mixed !== '')
		  $val = $this->checkAsProperty($pptname_str, $val_mixed);
		else 
		  $val = '';
		
		if( $val !== false){
			$this->$pptname_str = $val;
			return true;
		}
		else{
			return false;
		}
	}
	
	/**
	 * @method void En cas d'erreur d'un Mutator
	 */
	final public function __set( $name_str, $value_mixed)
	{
		throw new \Ufo\Error\MutatorException(
		    get_called_class(),
		    Sanitizer::on($name_str)->asString('Corrupted property')->remakeAsPureText(),
		    __FILE__,__LINE__
	    );
	}
	
	/**
	 * 
	 * @param unknown $name_str
	 * @throws Error\AccessorException
	 */
	final public function __get( $name_str)
	{
		throw new Error\AccessorException(
		    get_called_class(),
		    Sanitizer::on($name_str)->asString('Corrupted property')->remakeAsPureText(),
		    __FILE__,__LINE__
	    );
	}
	
	
	/**
	 * 
	 * @param unknown $name_str
	 * @throws Error\IssetException
	 */
	final public function __isset( $name_str)
	{
		throw new Error\IssetException(
		    get_called_class(),
		    Sanitizer::on($name_str)->asString('Corrupted property')->remakeAsPureText(),
		    __FILE__,__LINE__
		);
	}
	
	
	/**
	 * 
	 * @param unknown $name_str
	 * @throws Error\UnsetException
	 */
	final public function __unset( $name_str)
	{
		throw new Error\UnsetException(
		    get_called_class(),
		    Sanitizer::on($name_str)->asString('Corrupted property')->remakeAsPureText(),
		    __FILE__,__LINE__
		);
	}
	
	/**
	 * 
	 * @param unknown $name_str
	 * @param unknown $args_array
	 * @throws Error\CallException
	 */
	final public function __call( $name_str, $args_array)
	{
		throw new Error\CallException(
		    get_called_class(),
		    Sanitizer::on($name_str)->asString('Corrupted property')->remakeAsPureText(),
		    __FILE__,__LINE__
		);
	}
	
}
?>
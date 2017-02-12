<?php
namespace Ufo\Entity\Db;


use Ufo\Entity\Db\Link\ForeignLink;

class RequestException extends \Exception {}

/**
 * Request helper, allow the developper to write request like it :
 * 
 * @todo
 * 
 * Request::on($entity)
 *  ->select('nom','prenom',array('Adresse','adr1'))
 *  ->where('(id = $id1) OR (id = $id2)')
 *  ->with('id1',1)
 *  ->with('id2',"toto");
 *  
 * @author gb-michel
 *        
 */
class Request
{
    private $_adapter = null;
    private $_adapter_foreign_cols = array();
    
    
    private $_request = '';
    
    private $_select_foreign = array();
     
    
    /**
     * 
     * @param unknown $entityAdapter_obj
     */
    public function __construct( $entityAdapter_obj)
    {
        $this->_adapter = $entityAdapter_obj;
        
        // import foreign link
        foreach( $this->_adapter->getColumnLinks() as $ppt=>$cols)
        {
            if( $cols instanceof ForeignLink){
                
                $this->_adapter_foreign_cols[$ppt] = $cols;
            }
        }
        
    }
    
    /**
     * 
     */
    public function select()
    {
        $sql = '';
        if( func_num_args() == 0){
            $sql .= '*';
        }
        else{
            $args = func_get_args();
            foreach($args as $ppt)
            {
                if( is_array($ppt)){
                    // If its a column from foreign table
                    if( class_exists($ppt[0],true)){
                        $adapter = call_user_func($ppt[0].'::getAdapter');
                        if( $adapter !== null){
                            $col = $adapter->getColumnLinks($ppt[1]);
                            if( $col !== false){
                                $table = $adapter->getTableLink()->getName();
                                
                                $sql .= '`'.$table.'`.`'.$col->getName().'`,';
                                $this->_select_foreign[$table][$ppt[1]] = $col;
                            }
                        }
                    }
                    else{
                        throw new RequestException();
                        return false;
                    }
                }
                else{
                    // If column depends of local adapter
                    $col = $this->_adapter->getColumnLinks($ppt);
                    if( $col !== false){
                        $sql .= '`'.$col->getName().'`,';
                    }
                }
            }
            $sql = substr($sql,0,strlen($sql)-1);
        }
        
        $this->_request .= $sql;
        
        return $this;
    }
    
    
    /**
     *
     */
    public function update()
    {      
        if( func_num_args() == 0){
            return false;
        }
        else{
            $args = func_get_args();
            
            $sql = 'UPDATE `'.$this->_adapter->getTableLink()->getName().'` SET ';
            foreach($args as $ppt)
            {
                if( is_array($ppt)){
                    // If its a column from foreign table
                    if( class_exists($ppt[0],true)){
                        $adapter = call_user_func($ppt[0].'::getAdapter');
                        if( $adapter !== null){
                            $col = $adapter->getColumnLinks($ppt[1]);
                            if( $col !== false){
                                $table = $adapter->getTableLink()->getName();
    
                                $sql .= '`'.$table.'`.`'.$col->getName().'`,';
                                $this->_select_foreign[$table][$ppt[1]] = $col;
                            }
                        }
                    }
                    else{
                        throw new RequestException();
                        return false;
                    }
                }
                else{
                    // If column depends of local adapter
                    $col = $this->_adapter->getColumnLinks($ppt);
                    if( $col !== false){
                        $sql .= '`'.$col->getName().'`,';
                    }
                }
            }
            $sql = substr($sql,0,strlen($sql)-1);
            $this->_request .= $sql;
        }
            
        return $this;
    }
    
    /**
     * @todo
     */
    public function from()
    {
        $table_lnk = $this->_adapter->getTableLink();
        
        $sql = ' FROM `'.$table_lnk->getName().'` AS '.$table_lnk->getAlias().'';
        foreach( $this->_select_foreign as $tname=>$tcols)
        {
            //foreach( )
        } 
        
        
    }
    
    public function get()
    {
        if( $this->error == true){
            
        }
    }
    
    
}

?>
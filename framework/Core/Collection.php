<?php

namespace Ufo\Core;

class Collection implements \Iterator
{
	const SORTASC = 'asc' ;
	const SORTDESC = 'desc' ;
	
	public $ids ;
	public $objects ;
	public $index ;
	
	public function __construct()
	{
		$this->ids = array();
		$this->objects = array();
	}	
	
	public function current() 
	{
		return $this->objects[$this->index];
	}
	
	public function next()
	{
		$this->index += 1;
	}
	
	public function rewind() 
	{
		$this->index = 0;
	}
	
	public function key()
	{
		return $this->ids[$this->index];
	}
	
	public function valid()
	{
		return (($this->index +1) <= (count($this->objects)));
	}
	
	/**
	 * 
	 * @param int $param_id ID de l'objet ajoute
	 * @param object $param_obj Object a ajouter a la collection
	 */
	public function addSingleObject( $param_id, $param_object)
	{
		if( (!is_int($param_id) && !is_string($param_id)) 
			|| !is_object( $param_object)){
			return false ;
		}
		
		if( in_array( $param_id, $this->ids)){
			return false ;
		}
		
		$this->ids[] = $param_id;
		$this->objects[] = $param_object;
		return true ;
	}
	
	/**
	 * @access public
	 * @method boolean Extrait de la base de donnees, un certain nombre d'objets a partir d'une position, puis les ajoute a la collection
	 * @param string $classname_str Type d'objet a extraire de la base
	 * @param int $startrow_int Position de la premiere ligne de l'extrait
	 * @param int $limit_int Longueur de l'extrait en nombre d'objet
	 * @return boolean Retourne FALSE si le type d'objet n'existe pas, TRUE si ok
	 * @author GB Michel
	 * @version 1.0
	 */
	public function addObjectsFromDb( $classname_str, $startrow_int = 0, $limit_int = 100)
	{
		if( !class_exists( $classname_str, true)){
			return false ;
		}	
		
		$o = new $classname_str();
		$listID = $o->getAllID( $startrow_int, $limit_int);
		
		if( $listID === false){
			return false ;
		}
		
		foreach( $listID as $id){
			$this->addSingleObject( $id, new $classname_str($id));
		}
		
		$o = null ;
		unset( $listID) ;
		
		return true ;
	}
	
	/**
	 * sortByValue() et sortByID()
	 * Attention !! Le tri ecrase l'ID
	 * La propriete utilisee comme index de tri doit etre la meme quelque soit la nature des objets 
	 * @method void Tri la collectio en rangeant les objets suivant l'ordre d'une de leur propriete commune
	 * @param String $param_dataname_str Nom de la propriete utilise pour le tri
	 * @author GB Michel
	 * @version 1.0
	 */
	public function sortBy( $param_dataname_str, $sensdutri_const = self::SORTASC)
	{
		if( count($this->ids)>0){
			$tVAL = array();
			$tIds = $this->ids ;
			$tObjects = $this->objects ;
			$tt = array();
			$j = 0 ;
			
			// creation du tableau avec les ID et les valeurs a trier
			foreach( $this->objects as $i=>$o)
			{
				$tVAL[$i] = $o->$param_dataname_str  ;
			}
			
			// trie du tableau
			if( $sensdutri_const == self::SORTASC){
				asort( $tVAL, SORT_REGULAR);
			}
			else{
				arsort( $tVAL, SORT_REGULAR);
			}
			
			
			// reconstruction de la collection
			$this->ids = null ;
			$this->objects = null ;
			foreach( $tVAL as $id=>$val)
			{
				$this->ids[$j] = $j ;
				$this->objects[$j] = $tObjects[$id] ;
				$j++ ;
			}
		}	
	}
	
	/**
	 * Si la collection contient des objets de type different, 
	 * la representation sera quand meme retourne.
	 * La representation JSON de la collection, contient la representation
	 * JSON de tout les objets de la collection.
	 * @method String Retourne la representation JSON d'une collection d'objet
	 * @param array $fieldsname_array Liste des nom des proprietes a retourner
	 * @param array $extrafields_array Liste des valeurs a ajoute : clef => valeur, pour utiliser une propriete de l'objet dans valeur l'encadrer de $$, exemple $$idORG$$
	 * @param bool $changekeys_bool Si TRUE, dans la chaine retourne le nom des proprietes de l'objet sont remplacees, voir l'exemple, vaut FALSE par defaut 
	 * @return String Representation JSON de la collection
	 * @author GB Michel
	 * @version 1.0
	 */
	public function getJSONencode( $fieldsname_array = array(), $extrafields_array = array(), $changekeys = false )
	{
		$tabJSON = array();
		
		foreach( $this->ids as $i=>$id)
		{
			if( (get_class($this->objects[$i]) !== 'Collection') 
				&& (method_exists( $this->objects[$i], 'toArray')) ){
				
				$tmp = $this->objects[$i]->toArray( $fieldsname_array, $changekeys);
				
				foreach( $extrafields_array as $kx=>$vx){
					
					if( isset($vx['static'])){
						$tmp[$kx] = $vx['static'];
					}
					if( isset($vx['v']) && isset($vx['f'])){
						
						if( isset( $vx['vArg'])){
							if( is_array( $vx['vArg'])){
								$arg = $vx['vArg'];
							}
							else{
								$arg = array();
								$arg[] = $vx['vArg'];
							}	
						}
						else{
							$arg = array();
						}
												
						$o = call_user_func_array( array($this->objects[$i],$vx['v']), $arg);
						$tmp[$kx] =  $vx['f']( $o);
					}
				}
				
				$tabJSON[] = $tmp ;
			}
			
		}
		
		return json_encode( $tabJSON);
	}
	
	/**
	 * @access public
	 * @method void Detruit la collection et tous les objets qui la compose
	 * @author GB Michel
	 * @version 1.0
	 */
	public function removeContent()
	{
		if( count($this->ids) > 0){
			foreach( $this->ids as $i=>$id)
			{
				if( isset( $this->objects[$i])){
					$this->objects[$i] = null ;
				}
			}
			
			$this->ids = array();
			$this->objects = array();
		}

	}
	
	/**
	 * @method int Retourn le nombre d'objets de la collection
	 * @return int Nombre d'objets cotenu dans la Collection
	 * @author GB Michel
	 * @version 1.0
	 */
	public function getCount()
	{
		return count( $this->objects);
	}
	
	public function getObjectByID( $idobjet_mixed)
	{
		if( !in_array( $idobjet_mixed, $this->ids)) {
			return false ;
		}
		
		$i = array_search( $idobjet_mixed, $this->ids);
		return $this->objects[$i] ;
	}
	
}

?>
<?php

namespace Ufo\Entity\Db;

use \Ufo\Error\CollectionException as CollectionException;

class EntityCollectionException extends CollectionException 
{
	
    
}

class EntityCollection implements \Iterator, \ArrayAccess
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
	
	/* ****************** Iterator interface ********************** */
	
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
	
	
	/* ********** Array interface ************** */
	
	public function offsetSet($offset, $value)
	{
	    $this->add($value);
	}
	
	public function offsetExists($offset)
	{
	    return in_array($offset,$this->ids);
	}
	
	public function offsetUnset($offset)
	{
	    if(in_array($offset,$this->ids)){
	        
	       $off7 = array_search($offset,$this->ids); 
	       unset($this->objects[$off7]);
	       unset($this->ids[$off7]);    
	    }
	}
	
	public function offsetGet($offset)
	{
	    if(in_array($offset,$this->ids)){
	       return $this->objects[array_search($offset,$this->ids)];    
	    }
	    else{
	       return null;
	    }
	}
	
	
	/**
	 * 
	 * @param unknown $param_obj
	 * @return boolean
	 */
	public function add( $param_obj)
	{
	      if( is_object($param_obj) && (get_parent_class($param_obj) == 'Ufo\Entity\Db\EntityAbstract')){
	          $id = $param_obj->getID();
	          
	          if( $id === false){
	              $this->objects[] = $param_obj;
	              $this->ids[] = key($this->objects);
	              return true;
	          }
	          else{
	              if(!in_array( $id, $this->ids)){
	                  $this->ids[] = $id;
	                  $this->objects[] = $param_obj;
	                  return true;
	              }
	              else{
	                  throw new EntityCollectionException($this,'',CollectionException::ADD_OVERWRITE);
	                  return false;
	              }
	          }
	      }
	      else{
	          return false;
	      }
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
	public function JSONencode( $fieldsname_array = array(), $extrafields_array = array(), $changekeys = false )
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
	 * 
	 * @param unknown $key_mixed
	 * @return boolean
	 */
	public function removeByID( $key_mixed)
	{
	    $k = array_search($key_mixed,$this->ids);
	    if( $k !== false){
	        $this->objects[$k] = null;
            $this->ids[$k] = null;
            return true;
	    }
	    else{
	        return false;
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
	
	
	/**
	 * 
	 * @param unknown $idobjet_mixed
	 * @return boolean
	 */
	public function getObjectByID( $idobjet_mixed)
	{
		if( !in_array( $idobjet_mixed, $this->ids)) {
			return false ;
		}
		
		$i = array_search( $idobjet_mixed, $this->ids);
		return $this->objects[$i] ;
	}
	
	/**
	 * To get an element by index value
	 *
	 * @param integer $index_int
	 * @return boolean
	 */
	public function getAt($index_int)
	{
	    return isset($this->objects[$index_int])? $this->objects[$index_int] : false ;
	}
}

?>
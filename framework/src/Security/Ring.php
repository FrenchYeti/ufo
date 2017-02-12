<?php

namespace Ufo\Security;

use Ufo\Session\Session as Session;
use Ufo\Util\Util as Util;
use Ufo\Db\Manager as DbManager;
use Ufo\Security\Exception\RingException as RingException;

/**
 * protection CSRF :
 * Certaine donnees utilisees dans une cadre critique ne devrait 
 * jamais pouvoir etre appele sans passer par certaine etape.
 * 
 * Par exemple pour la suppression d'une categorie, et pour eviter 
 * toute attaques CSRF, l'ID de la categorie que l'on veut supprimer,
 * avant la demande de confirmation est ajoute a l'ensemble des valeur
 * possible lors de la demande de suppression.
 * 
 * Il s'agit de restreindre les actions en utilisant leur "contexte"
 */

class Ring
{
    public $_id= null;
    public $_token = null;
    public $_data = null;
    public $_expire = null;
    public $_create = null;
    
    
	//private $_data = null;
	private $_name = '';
	

	public function __construct( $ringname_str = null)
	{
		if( !is_null( $ringname_str)){
			$this->_name = $ringname_str;
		}
	}
	
	/**
	 * 
	 * @param unknown $token_str
	 * @return boolean
	 */
	public static function existingToken($token_str)   
	{
	    $db = DbManager::getConnexion('internals/users_manager');
	    $data = $db->SQL('SELECT RNG_ID FROM `'._UFO_RBAC_SCHEMA_.'`.`T_RING_RNG` WHERE RNG_TOKEN = ?',array($token_str));
	
	    if(($data!==false) && (count($data)>0)){
	        return true;
	    }
	    else{
	        return false;
	    }
	}
	
	/**
	 * 
	 * @param unknown $token_str
	 * @throws RingException
	 */
	public static function expiredToken($token_str)
	{
	    $db = DbManager::getConnexion('internals/users_manager');
	    $data = $db->SQL('SELECT RNG_EXPIRE FROM `'._UFO_RBAC_SCHEMA_.'`.`T_RING_RNG` WHERE RNG_TOKEN = ?',array($token_str));
	
	    if(($data!==false) && (count($data)>0)){	        
	        if(intval($data[0]['RNG_EXPIRE']) == 0){
	            throw new RingException(RingException::EXPIRED,__FILE__,__LINE__);
	        }
	    }
	    else{
	        throw new RingException(RingException::INVALID_TOKEN,__FILE__,__LINE__);
	    }
	}
	
	
	/**
	 * 
	 * @param unknown $data_mixed
	 * @param number $maxread_int
	 * @throws RingException
	 * @return \Ufo\Security\Ring|boolean
	 */
	public function newRing($data_mixed,$maxread_int=1)
	{   
	    try{
    	    do{
    	        $token = \Ufo\Util\Util::randomString(128);
    	    }
    	    while(self::existingToken($token)==true);
    	    
    	    $db = DbManager::getConnexion('internals/users_manager');
    	    $data = $db->SQL('INSERT INTO `'._UFO_RBAC_SCHEMA_.'`.`T_RING_RNG`(RNG_TOKEN,RNG_DATA,RNG_EXPIRE,RNG_CREATE) 
    	                      VALUES (?,?,?,CURRENT_TIMESTAMP)',array($token,serialize($data_mixed),$maxread_int));
    	    
    	    if($data!==false){
    	        $this->_data['value'] = $data_mixed;
    	        $this->_expire = $maxread_int;
    	        $this->_token = $token;
    	        $this->_id = $data;
    	        return $this;
    	    }
    	    else{
    	        throw new RingException(RingException::DB_QUERY_INSERT_FAILED,__FILE__,__LINE__);
    	        return false;
    	    }
	    }
	    catch(\PDOException $e){
	        throw new RingException(RingException::DB_QUERY_INSERT_FAILED,__FILE__,__LINE__,$e);
	        return false;
	    }
	}
	
	public function getToken()
	{
	    return $this->_token;
	}
	
	public function remove()
	{
	    if($this->_token !== null){
	        try{
	            $db = DbManager::getConnexion('internals/users_manager');
	            $data = $db->SQL('DELETE FROM `'._UFO_RBAC_SCHEMA_.'`.`T_RING_RNG` WHERE RNG_TOKEN = ?',array($this->_token));
	            
	            if($data==false){
	                throw new RingException(RingException::DB_QUERY_DELETE_FAILED,__FILE__,__LINE__);
	                return false;
	            }
	            else{
	                return true;
	            }
	        }
	        catch(\PDOEXception $e){
	            throw new RingException(RingException::DB_QUERY_DELETE_FAILED,__FILE__,__LINE__,$e);
	            return false;
	        }
	    }
	    else{
	        return false;
	    }
	}
	   
	public function setData( $value_mixed)
	{		
		if( $this->_name !== ''){
			$this->_data = array();
			$this->_data['value'] = $value_mixed;
			$this->_data['keyRing'] = substr( hash( 'sha256', time()), 0, 12);
			$this->_data['time'] = time();
			$this->_data['salt'] = Util::randomString(12);
			$this->_data['field'] = Util::randomString(12);
			$this->_data['keyRingFieldname'] = Util::randomString(8);
			$this->_data['keyCSRF'] = hash( 'sha256', $this->_data['salt'].$this->_data['keyRing']);			
			
			
			$sess = Session::getInstance();
			$sess->setData( 'ring_'.$this->_name, $this->_data);
			return true;
		}
		else{
			return false;
		}
	}
	
	/**
	 * 
	 * @param unknown $token_str
	 * @throws RingException
	 * @return NULL|\Ufo\Security\Ring
	 */
	public static function loadRing($token_str)
	{
	    try{
	        if(!self::existingToken($token_str)){
	            throw new RingException(RingException::INVALID_TOKEN,__FILE__,__LINE__);
	            return null;
	        }
	        
	        self::expiredToken($token_str);
	        
	        
    	    $db = DbManager::getConnexion('internals/users_manager');
    	    $data = $db->SQL('SELECT RNG_ID, RNG_TOKEN, RNG_DATA, RNG_EXPIRE, RNG_CREATE 
    	             FROM `'._UFO_RBAC_SCHEMA_.'`.`T_RING_RNG` WHERE RNG_TOKEN = ?',array($token_str));
    	    
    	    if(($data!==false) && (count($data)>0)){	        
    	        if(intval($data[0]['RNG_EXPIRE']) == 0){
    	            throw new RingException(RingException::EXPIRED,__FILE__,__LINE__);
    	        }
    	        else{ 	            
    	            $ring = new Ring();
    	           
    	            $ring->_id = $data[0]['RNG_ID'];
    	            $ring->_token = $data[0]['RNG_TOKEN'];
    	            $ring->_data = unserialize($data[0]['RNG_DATA']);
    	            
    	            $ring->_expire = (int)$data[0]['RNG_EXPIRE'];
    	            $ring->_create = $data[0]['RNG_CREATE'];

    	            $exp = $ring->_expire -1;
    	            
    	            if($exp > 0){
    	                $data = $db->SQL('UPDATE `'._UFO_RBAC_SCHEMA_.'`.`T_RING_RNG` SET RNG_EXPIRE = ? WHERE RNG_TOKEN = ?',array($exp,$this->$token_str));
    	            }
    	            else{
    	                $ring->remove();
    	            }
    	            
    	            return $ring;
    	        }
    	    }
    	    else{
    	        throw new RingException(RingException::INVALID_TOKEN,__FILE__,__LINE__);
    	    }
	    }
	    catch(\PDOException $e){
	        throw new RingException(RingException::DB_QUERY_EXISTS_FAILED,__FILE__,__LINE__,$e);
	    }
	}
	
	
	public function old_loadRing( $ringname)
	{
		$sess = Session::getInstance();
		
		$rdata = $sess->getData( 'ring_'.$ringname);
		if( $rdata === false){
			return false;
		}
		else{
			$this->_data = $rdata;
			$this->_name = $ringname;
			return true;
		}		
	}
	
	public function getData()
	{
	    return $this->_data;
	}
	
	/**
	 * @method mixed
	 * @param string $pkCSRF_str
	 * @param string $fieldname_str Nom du cha
	 */
	public function old_getData( $keyRing_str, $fieldname_str = null)
	{
		if( is_null($this->_data)) return false;
		
		// Verif des clef
		$guestKeyCSRF = hash( 'sha256', $this->_data['salt'].$keyRing_str);	
		if( $guestKeyCSRF !== $this->_data['keyCSRF']){
			return false;
		}
		
		// Verif du nom du champ
		if( !is_null( $fieldname_str)){
			if( $this->_data['field'] !== $fieldname_str) return false;
		}
		
		// Verif de l'expiration ( non implemente )
		
		return $this->_data['value'];
	}
	
	/**
	 * @method string Retourne le nom du champ qui contient la donnee critique
	 * @return string Retourne le nom du champ, FALSE en cas d'erreur
	 * @author GB Michel
	 * @version 1.0
	 * @since 01/04/2013
	 */
	public function getFieldname()
	{
		if( is_null($this->_data) or ($this->_name == '')) return false;
		
		return $this->_data['field'];
	}
	
	/**
	 * @method string Retourne la valeur du keyRing
	 * @return string Retourne la valeur, FALSE en acs d'erreur
	 * @author GB Michel
	 * @version 1.0
	 * @since 01/04/2013
	 */
	public function getKeyRing()
	{
		if( is_null($this->_data) or ($this->_name == '')) return false;
		
		return $this->_data['keyRing'];
	}
	
	/**
	 * @method string Retourne le nom du champ contenant le keyRing
	 * @return string Retourne le nom du champ, FALSE en cas d'erreur
	 * @author GB Michel
	 * @version 1.0
	 * @since 01/04/2013
	 */
	public function getKeyRingFieldname()
	{
		if( is_null($this->_data) or ($this->_name == '')) return false;
		
		return $this->_data['keyRingFieldname'];
	}
	
	/**
	 * @method bool Detruit un anneau stocke en session
	 * @return boolean Retourne TRUE en cas de reussite, FALSE sinon
	 * @author GB Michel
	 * @version 1.0
	 * @since 01/07/2013
	 */
	public function destroy()
	{
		if( ($this->_name !== '') && (is_null($this->_data))){
			
			$sess = Session::getInstance();
			return $sess->removeData( 'ring_'.$this->_name);
		}
		else{
			return false;
		}
	}
	
	
	/**
	 * @method bool Valide le format du keyRing
	 * @param string $value_str Valeur du KeyRing
	 * @return bool Retourne TRUE si ok, FALSE sinon
	 * @author GB Michel
	 * @since 18/07/2013
	 * @version 1.0 
	 */
	public function checkKeyRingFormat( $value_str)
	{
		$f1 = Check::pureText( $value_str, true, false);
		$f2 = (strlen($value_str)==12)? true : false;
		
		return $f1 && $f2;
	}
	
	
	/**
	 * @method string|bool Check keyring format
	 * @param unknown_type $keyring_str
	 */
	public static function sanitizeKeyRing( $keyring_str)
	{
		if( Check::hexadecimalText( $keyring_str, 12)){
			return $keyring_str;
		}
		else{
			return false;
		}
	}
	
	public static function sanitizeKeyFieldname( $name_str)
	{
		if( Check::hexadecimalText( $name_str, 8)){
			return $name_str;
		}
		else{
			return false;
		}
	}
}

?>
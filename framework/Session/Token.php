<?php

namespace Ufo\Session;

use Ufo\Security\Check;


class InvalidTokenException extends \Exception {};

/**
 * 
 * @author gbmichel
 *
 */
class Token
{
	/**
	 * @var string Token value
	 */
	private $_token;
	private $_tokenname;
	
	private $_valid = false;
	
	
	/**
	 * Create a new Token object and generate value,
	 * if _USE_DOUBLE_TOKEN_ is TRUE in config, name of token is 
	 * randomized.
	 * 
	 * Token is serialized and stored in session, SHA checksum of serial 
	 * is stored in session.
	 * 
	 * @method void Cree ou modifie le token
	 * @author GB Michel
	 * @version 1.0
	 * @since 12/04/2013
	 */
	public function newToken( Session $session_obj)
	{	
		// Creation des donnees du token
		if( $this->_profile->get('USE_DOUBLE_TOKEN') == true ){			
			$this->_tokenname = md5(\Ufo\Core\Init\rand(20,100)).'#'.sha1(\Ufo\Core\Init\time());
		}
		else{
			$this->_tokenname = $this->_profile->get('TOKEN_NAME') ;
		}		
		$this->_token = sha1(time().rand(0,100).$this->_profile->get('TOKEN_GDS')) ;

		$session_obj->setDataObject('token', $this);
			
		// Envoie du token
		\setcookie( $this->_tokenname, $this->_token, 
		  time()+intval($this->_profile->get('SESSION_EXPIRE')), 
		  $this->_profile->get('SESSION_PATH'),TRUE,TRUE
        );
	}

	/**
	 * To refresh the session ID of the current session. 
	 * This will update the last time that the user was active and the session creation date to the current time. 
	 * The essence is to make the session ID look like it was just created now.
	 * 
	 * @return string			Returns the new/current sessionID and update the browser's cookies
	 * @throws SessionNotFoundException	Thrown when trying to refresh session when no session ID is set
	 * @throws SessionExpired		Thrown when the session has expired
	 */
	public function refreshToken()
	{
	    if( $this->_valid !== true){
	        throw new InvalidTokenException("ERROR: Try to use token but token is not valid");
	    }
	
	      
	}
	
	
	
	/**
	 * Teste si la valeur du token et celle enregistre dans la session
	 * sont identique. Si les valeurs sont differentes, la session
	 * est detruite.
	 * @access private
	 * @method boolean Verifie la concordance entre la session et le token
	 * @return boolean TRUE si la session et token vont ensemble, FALSE sinon
	 * @author GB Michel
	 * @version 1.0
	 * @since 12/04/2013
	 */
	private static function checkValidity( Session $session_obj, $replace_token = true)
	{
	    $token = $session_obj->getData('token');
	    
		if( !isset($_SESSION['ss_tokenname'])
		|| !isset($_SESSION['ss_token']) ){
			return false;
		}
	
		// verifie que le token existe
		if( !isset($_COOKIE[$_SESSION['ss_tokenname']])){
			return false;
		}
	
	
		// verifie le format du token
		if( Check::hexadecimalText( $_COOKIE[$_SESSION['ss_tokenname']], 40) == false ){
			return false ;
		}
	
	
		/* Comparaison de valeurs hachees pour se premunir des
		 octets null qui aurait pu etre introduit dans le
		de cookie de session */
		if( sha1($_SESSION['ss_token']) !== sha1($_COOKIE[$_SESSION['ss_tokenname']]) ){
			return false ;
		}
	
	
		// maj du cookie token
		if( (self::$_tokenChecked === false) && ($replace_token === true)){
				
			if( self::$_instance->_profile->get('TOKEN_REGEN') === true){
	
				// suppression de l'ancien token
				setcookie( $_SESSION['ss_tokenname'], '', time()-3600, self::$_instance->_profile->get('SESSION_PATH'));
	
				// creation du nouveau token
				self::$_instance->createToken();
				self::$_tokenChecked = true;
			}
		}
	
		$this->_valid = true;
		
		return true ;
	}
	
	
}

?>
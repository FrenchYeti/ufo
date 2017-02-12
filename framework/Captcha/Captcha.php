<?php

namespace Ufo\Captcha;

use Ufo\Security\Check as Check;


/**
 * Classe de gestion du captcha
 * @since 08/04/2013
 * @author GB Michel
 */
class Captcha
{
    private $_backgrounddir;
    private $_fontsdir;
    
    public $clearValue = '';
	public $value ;
	public $path ;
	public $error = false;
	
	/**
	 * @access private
	 * @method array Genere le captcha
	 * @return array Tableau associatif contenant la valeur et le chemine de l'image'
	 * @since 08/04/2013
	 */
	private function generate()
	{
		$length = 5; 	
		$alphabet = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789'; 
		
		$nb_characters = strlen($alphabet); 
		
		$code = '';
		for($i = 0; $i < $length; ++$i)
		{
			$code .= $alphabet[mt_rand(0, $nb_characters-1)];		
		}
		$str_length = strlen($code);
		
		try{
    		$image = imagecreatefrompng( $this->_backgrounddir.'background.png');
    		
    		$black = imagecolorallocate($image, 0, 0, 0);
    		
    		for($i = 0; $i < $str_length; ++$i)
    		{
    			$size = mt_rand(30, 35);
    			$angle = mt_rand(-5, 5);
    			$x = 13 + (25 * $i);
    			$y = mt_rand(40, imagesy($image) - 15);
    			$font =  $this->_fontsdir._UFO_CAPTCHA_FONTS_;
    			imagettftext($image, $size, $angle, $x, $y, $black, $font, $code[$i] );
    			imagecolordeallocate($image, $black);	
    		}
    		
    		$chemin_image = _UFO_TMP_DIR_.sha1(time().rand(0,100)).'.png';	
    		
    		imagepng($image, $chemin_image);		
    		imagedestroy($image);
		}
		catch( \ErrorException $e){
		    $this->error = true;
		}
		
		return array('path'=>$chemin_image,'val'=>$code);
	}
	
	/**
	 * @method void Constructeur, generation du captcha et stockage des valeurs
	 * @since 08/04/2013 
	 */
	public function __construct()
	{
	    // fix background dir
	    if( is_null(_UFO_CAPTCHA_IMG_DIR_)){
	        $this->_backgrounddir = __DIR__.'/Background/';
	    }
	    else{
	        $this->_backgrounddir = _UFO_CAPTCHA_IMG_DIR_;
	    }
	    
	    // fix fonts dir
	    if( is_null(_UFO_CAPTCHA_FONTS_DIR_)){
	        $this->_fontsdir = __DIR__.'/Fonts/';
	    }
	    else{
	        $this->_fontsdir = _UFO_CAPTCHA_FONTS_DIR_;
	    }
	    
		$captcha = $this->generate() ;
		if( $this->error === false){
		    $this->clearValue = $captcha['val'];
		    $this->value = sha1($captcha['val']);
		    $this->path = $captcha['path'] ;
		}
		else{
		    if( is_null(_UFO_ERROR_HANDLER_)){
		        header('Location: '._UFO_DEFAULT_DOCUMENT_ERROR_);
		    }
		}	
	}
	
	
	public function getValue()
	{
		return $this->value ;
	}
	
	public function getClearValue()
	{
	   return $this->clearValue;    
	}
	
	
	/**
	 * @method string|boolean Retourne l'url de l'image du captcha
	 * @return string|boolean URL de l'image si elle existe, FALSE en cas d'erreur
	 * @since 08/04/2013 
	 */
	public function getImagePath()
	{
		if( file_exists( $this->path)){
			return $this->path ;
		}
		else{
			return false ;
		}
	}
	
	/**
	 * @method boolean Verifie si le captcha sousmis est bon
	 * @param string $login_str Chaine de caractere sousmise du captcha
	 * @return boolean TRUE si la valeur est correcte, FALSE sinon
	 * @since 08/04/2013
	 */
	public function check( $captcha_submitted_str)
	{
	    $input = sha1($captcha_submitted_str);
	    
	    return ( $input == $this->value);
	    /*
		if( Check::puretext( $captcha_submitted_str, true, false, 5)){
			return ( $input == $this->value)? true : false ;
		}
		else{
			return false ;
		}*/
	}
	
	/**
	 * @method boolean Supprime l'image du captcha et sa valeur
	 * @since 08/04/2013
	 */
	public function destroy()
	{
		$this->value = null;
		
		if( file_exists( $this->path)){
			return unlink( $this->path);
		}else{
			return true;
		}
	}
	
	/**
	 * @method void En cas de destruction de l'objet, l'image sera supprimee
	 * @since 03/04/2013 
	 */
	public function __destruct()
	{
		//$this->destroy();
	}
}

?>
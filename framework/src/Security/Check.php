<?php

namespace Ufo\Security;

use Ufo\Util\Util;

/**
 * 
 * @package core
 * @author GB Michel
 * @version 1.0
 * @since 18/11/2012
 */
class Check {

	//const TIMESTAMP_EN = 'Y-m-d h:i:s';
	//const TIMESTAMP_FR = 'd-m-Y h:i:s';
	
	public static $accent_fr = 'àâäçéèêëïîôöûù';
	public static $utf8_fr_low = array(
			"\x{00E0}","\x{00E2}","\x{00E4}",
			"\x{00E7}","\x{00E8}","\x{00E9}","\x{00EA}",
			"\x{00EB}","\x{00EE}","\x{00EF}","\x{00F4}",
			"\x{00F6}","\x{00FB}","\x{00FC}"
	);
	public static $utf8_fr_up = array(
			"\x{00C0}","\x{00C2}","\x{00C4}",
			"\x{00C7}","\x{00C8}","\x{00C9}","\x{00CA}",
			"\x{00CB}","\x{00CE}","\x{00CF}","\x{00D4}",
			"\x{00D6}","\x{00DB}","\x{00DC}"
	);
	
	
	private static function makePCREClass( $name_str, $quantifier_str)
	{
		$class = '';
		foreach( self::${$name_str} as $c){
			$class .= $c.$quantifier_str;
		}
		
		return $class;
	}
	
	/**
	 * @static
	 * @access private
	 * @method boolean Valide le texte de  avec $testing_str avec l'expression reguliere $pattern_str
	 * @param string $pattern_str Motif de l'expression reguliere
	 * @param string $testing_str Chaine de caractere a tester
	 * @return boolean Resultat du test : TRUE si ok, FALSE sinon
	 * @author GB Michel
	 * @version 1.0
	 */
	private static function regexpCheck( $pattern_str, $testing_str)
	{
		$matches = array();
		preg_match( $pattern_str, $testing_str, $matches);
		
		if( (count($matches)>0) and ($matches[0]==$testing_str) ){
			return true ;
		}
		else{
			return false ;
		}
	}
	
	/**
	 * Teste si un chaine de caracteres est uniquement constituee de lettre, et
	 * facultativement de chiffre, d'espace et tabulation et 
	 * teste facultativement la longueur
	 * 
	 * Text is full compatible with ASCII
	 * 
	 * @static
	 * @access public
	 * @method boolean Teste si la chaine contient que des lettre, facultativement des espaces et des chiffres, et teste la taille max
	 * @param string $param_text_str Chaine de caractere a tester
	 * @param boolean $number_authorized Authoriser ou non les chiffres, TRUE pour oui, sinon FALSE
	 * @param boolean $space_authorized Authoriser ou non les espace, TRUE pour oui, sinon FALSE
	 * @param int $length_max Taille max de la chaine, 0 pour desactiver
	 * @return boolean Resultat du test : TRUE si ok, FALSE sinon
	 * @author GB Michel
	 * @version 1.0
	 */
	public static function pureText( $param_text_str, $number_authorized = false, $space_authorized = false, $length_max = 0 )
	{
		( strpos( $param_text_str, chr(0)) === false )? $c = true : $c = false ;
		( (int)$length_max > 0 )? ( mb_strlen($param_text_str) <= (int)$length_max )? $v = true : $v = false : $v = true ;
		( $number_authorized == true )? $n = '0-9' : $n = '' ;
		( $space_authorized == true )? $p = '/\A[a-zA-Z\s'.$n.']+\Z/' : $p = '/\A[a-zA-Z{L}'.$n.']+\Z/u' ;
		
		return ( self::regexpCheck( $p, $param_text_str) && $v && $c );
	} 

	
	/**
	 * Can check pureText with additionnal special chars existing in ASCII 
	 * 
	 * @param unknown $param_text_str
	 * @param string $number_authorized
	 * @param string $space_authorized
	 * @param number $length_max
	 */
	public static function specificPureText($param_text_str, $specialchar_str, $number_authorized = false, $space_authorized = false, $length_max = 0)
	{
		if( $specialchar_str == ''){
			// add exception NOTICE strange callback 
			return self::pureText($param_text_str, $number_authorized, $space_authorized, $length_max);
		}

		$chars = Util::make_UTF8_RegexpPatternFrom($specialchar_str);
		
		( strpos( $param_text_str, chr(0)) === false )? $c = true : $c = false ;
		( (int)$length_max > 0 )? ( mb_strlen($param_text_str) <= (int)$length_max )? $v = true : $v = false : $v = true ;
		( $number_authorized == true )? $n = '\p{N}' : $n = '' ;
		( $space_authorized == true )? $p = '/\A[a-zA-Z\s'.$n.''.$chars.']+\Z/u' : $p = '/\A[a-zA-Z'.$n.''.$chars.']+\Z/u' ;
		
		return ( self::regexpCheck( $p, $param_text_str) && $v && $c );
	}

	/**
	 * 
	 * @param unknown $param_text_str
	 * @param number $length_max
	 * @param string $specific_char
	 * @return boolean
	 */
	public static function litteralI18nText( $param_text_str, $length_max = 0, $specific_char = '', $carrierreturn_bool = false)
	{
	    ( strpos( $param_text_str, chr(0)) === false )? $c = true : $c = false ;
	    ( (int)$length_max > 0 )? ( mb_strlen($param_text_str) <= (int)$length_max )? $v = true : $v = false : $v = true ;
	    
	    $chars = Util::make_UTF8_RegexpPatternFrom($specific_char);
	    
	    ($carrierreturn_bool == true)? $rn = '\r\n\t' : $rn = '';
	    
	    return ( self::regexpCheck( '/\A['.$rn.'\p{L}\p{N}\p{Zs}'.$chars.']+\Z/u', $param_text_str) && $v && $c);
	}
	
	
	/**
	 * Teste si un chaine est un texte ponctue
	 * @static
	 * @access public
	 * @method boolean Teste si la chaine contient que des nombres, facultativement les espace, et teste la taille max
	 * @param string $param_text_str Chaine de caractere a tester
	 * @param boolean $space_authorized Authoriser ou non les espace, TRUE pour oui, sinon FALSE
	 * @param int $length_max Taille max de la chaine, 0 pour desactiver
	 * @return boolean Resultat du test : TRUE si ok, FALSE sinon
	 * @author GB Michel
	 * @version 1.0
	 */
	public static function punctuatedText( $param_text_str, $length_max = 0)
	{
		( strpos( $param_text_str, chr(0)) === false )? $c = true : $c = false ;
		( (int)$length_max > 0 )? ( mb_strlen($param_text_str) <= (int)$length_max )? $v = true : $v = false : $v = true ;
		
		$accent = self::makePCREClass( 'utf8_fr_low', '').self::makePCREClass( 'utf8_fr_up', '');
		
		return ( self::regexpCheck( '/\A[\p{Latin}\p{N}\p{Zs}'.$accent.'\x{2E}\x{B3}\x{c2}\x{21}\x{3f}\x{3a}\x{27}\x{22}]+\Z/u', $param_text_str) && $v && $c);
	}
	
	/**
	 * Teste si un chaine de caracteres est uniquement constituee de chiffres.
	 * Vous pouvez utilisez $space_authorized pour autoriser ou non les espace et les tabulations
	 * Vou
	 * @static
	 * @access public
	 * @method boolean Teste si la chaine contient que des nombres, facultativement les espace, et teste la taille max
	 * @param string $param_text_str Chaine de caractere a tester
	 * @param boolean $space_authorized Authoriser ou non les espace, TRUE pour oui, sinon FALSE
	 * @param int $length_max Taille max de la chaine, 0 pour desactiver
	 * @return boolean Resultat du test : TRUE si ok, FALSE sinon
	 * @author GB Michel
	 * @version 1.0
	 */
	public static function specificPunctuatedText( $param_text_str, $length_max = 0, $additivespecialchar_str = '-')
	{
		( strpos( $param_text_str, chr(0)) === false )? $c = true : $c = false ;
		( (int)$length_max > 0 )? ( mb_strlen($param_text_str) <= (int)$length_max )? $v = true : $v = false : $v = true ;
	
		$accent = self::makePCREClass( 'utf8_fr_low', '').self::makePCREClass( 'utf8_fr_up', '');
		
		$specRegexp = '';
		for( $i=0 ; $i < strlen($additivespecialchar_str) ; $i++){
			$c = ord($additivespecialchar_str[$i]);
			if( $c <= 127){
				$specRegexp .= '\x{00'.dechex($c).'}';
			}
		}
		
		return ( self::regexpCheck( '/\A[\p{L}\p{N}\p{Z}'.$accent.$specRegexp.']+\Z/u', $param_text_str) && $v && $c);
	}
	
	/**
	 * @static
	 * @access public
	 * @method boolean Teste si la chaine contient que des nombres, facultativement les espaces, et teste la taille max
	 * @param string $param_text_str Chaine de caractere a tester
	 * @param int $length_max Taille max de la chaine, 0 pour desactiver
	 * @return boolean Resultat du test : TRUE si ok, FALSE sinon
	 * @author GB Michel
	 * @version 1.0
	 */
	public static function htmlText( $param_text_str, $length_max = 0)
	{
		( strpos( $param_text_str, chr(0)) === false )? $c = true : $c = false ;
		( (int)$length_max > 0 )? ( mb_strlen($param_text_str) <= (int)$length_max )? $v = true : $v = false : $v = true ;
		
		return ( self::regexpCheck( '/^[a-zA-Z0-9\s]+$/', $param_text_str) && $v && $c);
	}
	
	/**
	 * 
	 * Update : new Regexp + FILTER
	 * 
	 * @static
	 * @access public
	 * @method boolean Teste si la chaine contient que des nombres, facultativement les espaces, et teste la taille max
	 * @param string $param_text_str Chaine de caractere a tester
	 * @param int $length_max Taille max de la chaine, 0 pour desactiver
	 * @return boolean Resultat du test : TRUE si ok, FALSE sinon
	 * @author GB Michel
	 * @version 1.1
	 * 
	 * 
	 */
    public static function mailText( $param_text_str, $length_max = 0)
	{
		( strpos( $param_text_str, chr(0)) === false )? $c = true : $c = false ;
		( (int)$length_max > 0 )? ( mb_strlen($param_text_str) <= (int)$length_max )? $v = true : $v = false : $v = true ;
	
		
        if(filter_var($param_text_str,FILTER_VALIDATE_EMAIL)){
            return true && $v && $c ;
        }
        else{
            return ( self::regexpCheck( '/\A[\p{L}\p{N}_+-]+(\.[\p{L}\p{N}_+-]+)*@[\p{L}\p{N}_+-]+\.[\p{L}\p{N}_+-]+(\.[\p{L}\p{N}_+-]+)*\z/u', $param_text_str) && $v && $c);
        }
	}
	
	/**
	 * 
	 * @param unknown $param_text_str
	 * @param number $length_max
	 * @param string $protocols
	 * @return boolean
	 */
	public static function wwwText( $param_text_str, $length_max = 0, $protocols = 'https|http')
	{
		( strpos( $param_text_str, chr(0)) === false )? $c = true : $c = false ;
		( (int)$length_max > 0 )? ( mb_strlen($param_text_str) <= (int)$length_max )? $v = true : $v = false : $v = true ;
		
		$url = parse_url($param_text_str);
		
		if(!isset($url['scheme'])&&isset($url['path'])){
		    
		    isset($url['host'])? $p = $url['host'] : $p = '';
		    
		    return (filter_var('http://'.$p.$url['path'],FILTER_VALIDATE_URL)&&$v&&$c); 
		}
		elseif(isset($url['scheme'])&&isset($url['host'])){
		    
		    isset($url['path'])? $p = $url['path'] : $p = '';
		    
		    return (filter_var($url['scheme'].'://'.$url['host'].$p,FILTER_VALIDATE_URL)&&$v&&$c);
		}
		else{
		    return false;
		}
	}	
	
	/**
	 * @static
	 * @access public
	 * @method boolean Teste si la chaine contient que des nombres, facultativement les espaces, et teste la taille max
	 * @param string $param_text_str Chaine de caractere a tester
	 * @param int $length_max Taille max de la chaine, 0 pour desactiver
	 * @return boolean Resultat du test : TRUE si ok, FALSE sinon
	 * @author GB Michel
	 * @version 1.0
	 */
	public static function dateText( $param_text_str)
	{
		( strpos( $param_text_str, chr(0)) === false )? $c = true : $c = false ;

		return ( self::regexpCheck( '/\A\d{4}-\d{2}-\d{2}\s\d{2}:\d{2}:\d{2}\z/u', $param_text_str) && $c);
	}
	
	/**
	 * @static
	 * @access public
	 * @method boolean Teste si la chaine contient que des nombres, facultativement les espaces, et teste la taille max
	 * @param string $param_text_str Chaine de caractere a tester
	 * @param int $length_max Taille max de la chaine, 0 pour desactiver
	 * @return boolean Resultat du test : TRUE si ok, FALSE sinon
	 * @author GB Michel
	 * @version 1.0
	 */
	public static function dateFormatText( $param_text_str, $format_str = 'FR')
	{
	    ( strpos( $param_text_str, chr(0)) === false )? $c = true : $c = false ;
	
	    switch($format_str)
	    {
	    	case 'FR':
	    	    /*
	    	     $check = ( self::regexpCheck( '/\A\d{2}\/\d{2}\/\d{4}\z/u', $param_text_str) && $v && $c)
	    	     */
	    	    $pattern = '/\A(\d{1,2}[-\/]\d{1,2}[-\/]\d{2,4})\z/u';
	    	    break;
	    	case 'EN':
	    	    /*
	    	     
	    	    $m = array();
	    	    preg_match('/\A(\d{4})-(\d{2})-(\d{2})\z/u',$param_text_str,$m);
                if( isset($m[1]) && isset($m[2]) && isset($m[3])){
                    $check = check_date( intval($m[3]), intval($m[2]), intval($m[1]));
                }
                else{
                    $check = false;
                }
                unset($m);
	    	    */
	    	    $pattern = '/\A\d{4}-\d{2}-\d{2}\z/u';
	    	    break;
    	    case 'TIMESTAMP':
    	        $pattern = '/\A\d{4}-\d{2}-\d{2}\s\d{2}:\d{2}:\d{2}\z/u';
    	        break;
	    	default :
	    	    // $check = ( self::regexpCheck( '/\A\d{2}/\d{2}/\d{4}\z/u', $param_text_str) && $v && $c)
	    	    $pattern = '/\A\d{2}/\d{2}/\d{4}\z/u';
	    	    break;
	    }
	    
	    // return $check;
	    return ( self::regexpCheck( $pattern, $param_text_str) && $c);
	}
	
	/**
	 * Teste si un chaine de caracteres est uniquement constituee de chiffres, 
	 * facultativement les espaces et tabulations, et teste facultativement
	 * la longueur. 
	 * @static
	 * @access public
	 * @method boolean Teste si la chaine contient que des nombres, facultativement les espace, et teste la taille max
	 * @param string $param_text_str Chaine de caractere a tester
	 * @param boolean $space_authorized Authoriser ou non les espace, TRUE pour oui, sinon FALSE
	 * @param int $length_max Taille max de la chaine, 0 pour desactiver
	 * @return boolean Resultat du test : TRUE si ok, FALSE sinon
	 * @author GB Michel
	 * @version 1.0
	 */
	public static function numberText( $param_text_str, $space_authorized = false, $length_max = 0 )
	{
		( strpos( $param_text_str, chr(0)) === false )? $c = true : $c = false ;
		( (int)$length_max > 0 )? ( mb_strlen($param_text_str) <= (int)$length_max )? $v = true : $v = false : $v = true ;
		( $space_authorized == true )? $p = '/\A[\p{N}\s]+\z/u' : $p = '/\A[\p{N}]+\z/u' ;
		
		return ( self::regexpCheck( $p, $param_text_str) && $v && $c );
	} 
	
	
	public static function specificNumberText( $param_text_str, $specialchars_str, $space_authorized = false, $length_max = 0 )
	{
		( strpos( $param_text_str, chr(0)) === false )? $c = true : $c = false ;
		( (int)$length_max > 0 )? ( mb_strlen($param_text_str) <= (int)$length_max )? $v = true : $v = false : $v = true ;
		
		$chars = Util::make_UTF8_RegexpPatternFrom($specialchars_str);
		
		( $space_authorized == true )? $p = '/\A[\p{N}\s'.$chars.']+\z/u' : $p = '/\A[\p{N}'.$chars.']+\z/u' ;
	
		return ( self::regexpCheck( $p, $param_text_str) && $v && $c );
	}
	
	
	/**
	 * @static
	 * @access public
	 * @method boolean Teste si une valeur est un entier
	 * @param int $param_nb_int Valeur a tester
	 * @param int $nb_max Valeur maximale
	 * @return boolean Resultat du test : TRUE si ok, FALSE sinon
	 * @author GB Michel
	 * @version 1.0
	 */
	public static function shortInt( $param_nb_int, $nb_max = 0, $unsigned_bool = true )
	{
		( $unsigned_bool == true )? ( (int)$param_nb_int < 0  )? $c = false : $c = true : $c = true ;
		( (int)$nb_max > 0 )? ( (int) $param_nb_int <= (int)$nb_max )? $v = true : $v = false : $v = true ;
		
		return ( is_int($param_nb_int) && $v && $c );
	} 
	
	/**
	 * @static
	 * @access public
	 * @method boolean Teste si une chaine de caractere est hexadecimale, et teste la taille max
	 * @param string $param_text_str Chaine a tester
	 * @param int $lengthmax_int Longueur max de la chaine
	 * @return boolean Resultat de du test, TRUE si OK, FALSE sinon
	 * @author GB Michel
	 * @version 1.0
	 */
	public static function hexadecimalText( $param_text_str, $lengthmax_int = 0)
	{
		( strpos( $param_text_str, chr(0)) === false )? $c = true : $c = false ;
		( (int)$lengthmax_int > 0 )? ( mb_strlen($param_text_str) <= (int)$lengthmax_int )? $v = true : $v = false : $v = true ;
		
		return ( self::regexpCheck( '/\A[0123456789abcdefABCDEF]+\z/u', $param_text_str) && $v && $c );
	}
	
	/**
	 * @static
	 * @access public
	 * @method boolean Test une valeur en utilisant une fonction de PHP avec ses arguments
	 * @param unknown_type $value_mixed Valeur a tester
	 * @param unknown_type $phpfuncname_str Nom de la fonction PHP
	 * @param unknown_type $phpfuncargs_array Tableau des parametres passes a la fonction, la valeur a tester sera la premiere
	 * @return boolean Retourne sous forme de booleen le resultat de la fonction appelee
	 * @author GB Michel
	 * @version 1.0
	 */
	public static function phptestCallback( $value_mixed, $phpfuncname_str, $phpfuncargs_array = array())
	{
		if( $phpfuncname_str !== ''){
			$args = $phpfuncargs_array ;
			array_unshift( $args, $value_mixed);
			$v = true ;
		}
		else{
			$v = false ;
		}
		
		
		return ( call_user_func_array( $phpfuncname_str, $args) && $v );	
	}
	
	/**
	 * @static
	 * @access public
	 * @method boolean Teste si une valeur fait parti d'une autre liste de valeurs
	 * @param string $value_str Valeur a tester
	 * @param string $valuelist_str Liste des valeurs autorisees, separees par $separator_str
	 * @param string $separator_str Motif de separation des valeurs dans  $valuelist_str
	 * @return boolean Retourne TRUE si la valeur teste est autorisee, FALSE sinon
	 * @author GB Michel
	 * @version 1.0
	 */
	public static function arrayText( $value_str, $valuelist_str, $separator_str = ",")
	{
		$t = explode( $separator_str, $valuelist_str);
		
		return in_array( $value_str, $t);
	}
	
	/**
	 * @static
	 * @access public
	 * @method boolean Teste un value en tant qu'une propriete specifique d'un objet specifique
	 * @param mixed $value_mixed Valeur a tester
	 * @param string $objectname_str Type d'objet emule
	 * @param string $propertyname_str Nom de la propriete emule
	 * @return boolean Resultat du test
	 * @author GB Michel
	 * @version 1.0
	 */
	public static function asObjectProperty( $value_mixed, $objectname_str, $propertyname_str)
	{
		if( class_exists( $objectname_str, true) == true){
			$o = new $objectname_str ;
			$f = $o->checkDataFromArray( array($propertyname_str=>$value_mixed));
			$o = null ;
			
			return $f ;
		}
		else{
			return false ;
		}	
	}
	

	/**
	 *
	 * @param unknown $value_mixed
	 * @param unknown $size_int
	 * @param unknown $nbrdecimale_int
	 * @return boolean
	 */
	/* public static function decimal( $value_mixed, $size_int, $nbrdecimale_int, $signs = '')
	{
	    $signs = str_replace('+','\+',$signs);
	    
	    if( preg_match('/^'.$signs.'[0-9]+\.[0-9]+$/',$value_mixed) > 0){
	        $value_mixed = floatval($value_mixed);
	    }
	    
	    
	    if( is_float( $value_mixed)){
	        ((strlen( (string) $value_mixed)-1) <= $size_int)? $c = true : $c = false;
	
	        
	        $dec = $value_mixed-((int) $value_mixed);
	        
	        if( $dec > 0 )
	           (strlen( (string) ($dec * pow( 10, $nbrdecimale_int))) == $nbrdecimale_int) ? $v = true : $v = false;
	        else
	            $v = true;
	        
	        return $c && $v;
	    }
	    else{
	        return false;
	    }
	}*/
	
    public static function decimal($value_mixed, $size_int, $nbrdecimale_int, $signed_bool = false, $separator = '\.')
    {
        $t = array();
        
        ($signed_bool===true)? $signs = '[\+-]*' : $signs = '';
        
        if( preg_match_all('#^'.$signs.'(?P<int>[0-9]+)'.$separator.'(?P<dec>[0-9]+)$#',$value_mixed,$t) > 0){

            $f = true;
            $f &= (isset($t['dec'][0][0]) && (strlen($t['dec'][0])<=$nbrdecimale_int));
            $f &= (isset($t['int'][0][0]) && (strlen($t['int'][0])<=($size_int-strlen($t['dec'][0]))));
            
            return (bool)$f;
        }
        else{
            return false;
        }
    }
}


?>
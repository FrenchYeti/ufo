<?php

namespace Ufo\Util;

/**
 * 
 * @author gb-michel
 *
 */
class Util
{

    /**
     * 
     * @param unknown $size_int
     * @return string
     */
	public static function randomString( $size_int)
	{
		$c = str_shuffle( '0123456abcdefghijklmnopqrstuvwxyz');
		$l = strlen($c);
		
		$i = 0 ;
		$rstring = '';
		while( $i < $size_int)
		{
			$r = rand( 3, 35200);
			$rstring .= $c[$r%$l];
			$i++;
		}
		
		return $rstring ;
	}
	
	
	/**
	 * 
	 * @param unknown $obj_mixed
	 * @param unknown $data_arr
	 * @return boolean
	 */
	public static function ArrayToObject( $obj_mixed, $data_arr)
	{
		if( is_object($obj_mixed)){
			
			$obj = &$obj_mixed;
		}
		elseif( is_string($obj_mixed) 
			&& class_exists($obj_mixed,true)){
			
			$obj = new $obj_mixed;
		}
		else{
			$obj = null ;
		}
		
		if( !is_null($obj)){
			
			foreach( $data_arr as $ppt=>$val)
			{
				if( property_exists($obj, $ppt))
				{
					$obj->$ppt = $val ;
				}
			}
			
			return true;
		}
		else{
			return false;
		}
	}
	
	
	/**
	 * 
	 * @param unknown $json_str
	 */
	public static function outputJSON( $json_str)
	{
		header('Cache-Control: no-cache, must-revalidate');
		header('Content-type: application/json');
		
		echo $json_str ;
		exit;
	}

	/**
	 * Use only to make quickly regexp with special chars existing in ASCII charset
	 * 
	 * Util::make_UTF8_RegexpPatternFrom( "-|,!%");
	 * // return : "\x{0012}\x{0000}\x{0000}\x{0000}\x{0000}"
	 * 
	 * @param unknown $char_str
	 */
	public static function make_UTF8_RegexpPatternFrom( $char_str)
	{
		$specRegexp = '';
		for( $i=0 ; $i < strlen($char_str) ; $i++){
			$c = ord($char_str[$i]);
			if( $c <= 127){
				$specRegexp .= '\x{00'.dechex($c).'}';
			}
		}
		
		return $specRegexp;
	}
	
    /*************************************************************************
    *	Fonction dateFrToEn
    *	V1.0, MFM, 31/05/07, Création
    *	Converti une date jj/mm/aa en une date Y-m-d (MySQL)
    *
    **************************************************************************/	
    
    public static function dateFrToEn($mydate, 	//date au format jj/mm/aaaa
    					$defaut) 	//valeur par defaut (souvent '')
    {	if ( (!isset($mydate)) 
    		or (!is_string($mydate)))
    	{	$mydate = $defaut;
    	}
    	if ($mydate == '')
    	{	return '';
    	}
    	else
    	{	@list($jour,$mois,$annee)=explode('/',$mydate);
    		return @date('Y-m-d',mktime(0,0,0,$mois,$jour,$annee));
    	}
    }
    
    /*************************************************************************
    *	Fonction dateEnToFr
    *	V1.0, MFM, 31/05/07, Création
    *	V1.0.1, MFM, 31/03/09, Modification
    *	Converti une date Y-m-d (MySQL) en une date jj/mm/aa
    *
    **************************************************************************/		
    public static function dateEnToFr($mydate, 	//date au format annee-mm-jj
    					$defaut) 	//valeur par defaut
    {	if ( (!isset($mydate)) 
    		or (!is_string($mydate))
    		or ($mydate == '0000-00-00'))
    	{	return $defaut;
    	}
    	if ($mydate == '')
    	{	return '';
    	}
    	else
    	{	return date('d/m/Y',strtotime($mydate));
    	}
    }
    
    
    /*************************************************************************
    *	Fonction dateMmToMois
    **************************************************************************/		
    
    public static function dateMmToMois($paramMois,$paramLangue) 	//valeur du mois(01->12)
    {	
    	if( (!isset($paramMois)) || (!isset($paramLangue)) )
    	{	return false;
    	}else{
    		if( $paramLangue == "fr" ){
    			switch($paramMois)
    			{
    				case "01": $mois = "Janvier" ; break; 
    				case "02": $mois = "Février" ; break; 
    				case "03": $mois = "Mars" ; break; 
    				case "04": $mois = "Avril" ; break; 
    				case "05": $mois = "Mai" ; break; 
    				case "06": $mois = "Juin" ; break; 
    				case "07": $mois = "Juillet" ; break; 
    				case "08": $mois = "Août" ; break; 
    				case "09": $mois = "Septembre" ; break; 
    				case "10": $mois = "Octobre" ; break; 
    				case "11": $mois = "Novembre" ; break; 
    				case "12": $mois = "Decembre" ; break; 
    				default: $mois = "default" ; break; 
    			}
    			return $mois;
    		}
    		elseif( $paramLangue == "en" ){
    			switch($paramMois)
    			{
    				case "01": $mois = "January" ; break; 
    				case "02": $mois = "Febuary" ; break; 
    				case "03": $mois = "March" ; break; 
    				case "04": $mois = "April" ; break; 
    				case "05": $mois = "May" ; break; 
    				case "06": $mois = "June" ; break; 
    				case "07": $mois = "July" ; break; 
    				case "08": $mois = "August" ; break; 
    				case "09": $mois = "September" ; break; 
    				case "10": $mois = "October" ; break; 
    				case "11": $mois = "November" ; break; 
    				case "12": $mois = "December" ; break; 
    				default: $mois = "default" ; break; 
    			}
    			return $mois;
    		}
    	}	
    }
}
?>

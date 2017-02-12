<?php

namespace Ufo\Util;

/**
 * Classe de reflection utilise dans les test unitaire
 * pour valider des objet complexe avec des propriete 
 * protegee ou privee
 * 
 * Pour recuperer ou definir une propriete, il est plus 
 * simple d'utiliser les methodes statiques.
 * 
 * @author GB Michel
 * @version 1.0
 * @since 2012-12-08
 */
class UnitReflection 
{
	private $classRefelection = null ;
	
	/**
	 * @access public
	 * @param string $class_str Nom de la classe
	 * @return boolean Retourne la reussite ou nom de l'instanciation de la reflection
	 * @author GB Michel
	 * @version 1.0
	 */
	public function __construct( $class_str)
	{
		try{
			$o = new \ReflectionClass( $class_str);
			
			if( $o !== false){
				$this->classReflection = $o ;
				return true ;
			}
			else{
				return false ;
			}
		}
		catch( \ReflectionException $e){
			return false ;
		}
	}
	
	public function getProperty( $property_str)
	{
		if( is_null( $this->classReflection)){
			return false ;
		}	
		
		return $this->classReflection->getProperty( $property_str);
	}

	
	/** 
	 * @static
	 * @access public
	 * @method mixed Retourne la valeur d'une propriete d'un classe, independement de sa visibilite
	 * @param string $class_str Nom de la classe
	 * @param string $property_str Nom de la propriete
	 * @return mixed Valeur de la propriete
	 * @author GB Michel
	 * @version 1.0
	 */
	public static function getPropertyValue( $class_str, $property_str)
	{
		if( !isset( $class_str, $property_str)){
			return false ;
		}
		
		try{
			$classRef = new \ReflectionClass( $class_str);
			$pptRef = $classRef->getProperty( $property_str);
			
			if( $pptRef->isPrivate() || $pptRef->isProtected()){
				$pptRef->setAccessible( true);
			}
			
			return $pptRef->getValue() ;
		}
		catch( \ReflectionException $e){
			echo 'Erreur de recuperation d\'une valeur';
		}
		
	}
	
	/** 
	 * @static
	 * @access public
	 * @method mixed Definit la valeur d'une propriete d'un objet, independement de sa visibilite
	 * @param string $class_str Nom de la classe
	 * @param string $property_str Nom de la propriete
	 * @param mixed $value_mixed Valeur de la propriete
	 * @return bool Retourn TRUE si la valeur a bien ete definie, FALSE sinon 
	 * @author GB Michel
	 * @version 1.0
	 */
	public static function setPropertyValue($class_str, $property_str, $value_mixed)
	{
		if( !isset( $class_str, $property_str, $value_mixed)){
			return false ;
		}
		
		try{
			$classRef = new \ReflectionClass( $class_str);
			$pptRef = $classRef->getProperty( $property_str);
			
			if( $pptRef->isPrivate() || $pptRef->isProtected()){
				$pptRef->setAccessible( true);
			}
			
			$pptRef->setValue( $value_mixed);
			
			return $pptRef->getValue() ;
		}
		catch( \ReflectionException $e){
			echo 'Erreur de definition d\'une valeur';
		}
	}
}
?>

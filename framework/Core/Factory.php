<?php

namespace Ufo\Core;
 
/**
 * Design Pattern FACTORY
 * @author GB MICHEL
 * @since 25/11/2012 
 */
final class Factory
{
	/**
	 * Instance de la fabrique
	 * @static
	 * @access private
	 */
	private static $_instance = null ;
	
	/**
	 * Espace de noms utilise par la fabrique
	 * pour instancier la classe
	 * @access private
	 */
	private $_namespace ;
	
	/**
	 * @access protected
	 * @method void Contructeur
	 * @version 1.0
	 * @author GB Michel
	 */
	protected function __construct()
	{}
	
	/**
	 * @access private
	 * @method Object Retourne une instance de l'objet invoque
	 * @param string $namespace_str Espace de nommage de la classe a fabriquer
	 * @param array $args_array Tableau des arguments pour la methode
	 * @return Object Objet de la classe fabrique
	 * @author GB Michel
	 */
	private function getCustomInstance( $classname_str, $args_array)
	{
		/*
		if( substr( $this->_namespace, strlen($this->_namespace)-1, 1) == '_'){
			$classname_str = $this->_namespace.ucwords($classname_str) ;
			$this->_namespace = str_replace( '_', '/', $this->_namespace);
		}
		*/
		
		$class = $this->_namespace.ucwords($classname_str);
		
		//var_dump( $class, class_exists( $class, true));
		
		if( class_exists( $class, true)){
			
			$refClass = new \ReflectionClass( $class);
			if( $refClass->isInstantiable() && 
				$refClass->hasMethod('__construct')){
				
				return $refClass->newInstanceArgs( $args_array);	
			}
			else{
				$c = str_replace( ';', '*', $classname_str );
				throw new \Ufo\Core\Exception\Factory( '[FACTORY] Fichier:'.$_SERVER['PHP_SELF'].', Class:'.$c.', Msg:La classe n\'est pas instanciable');
			}			
		}
		else{
			$c = str_replace( ';', '*', $classname_str );
			throw new \Ufo\Core\Exception\Factory( '[FACTORY] Fichier:'.$_SERVER['PHP_SELF'].', Class:'.$c.', Msg:La classe que l\'on tente de fabriquer n\'existe pas');
		}
	}
	
	/**
	 * @static
	 * @access public 
	 * @method Object Retourne une instance de l'objet fabrique
	 * @param string $namespace_str Espace de nommage de la classe a fabriquer
	 * @return Object Objet fabrique
	 * @author GB Michel
	 */
	public static function getInstance( $namespace_str = null)
	{
		if( is_null(self::$_instance)){
			self::$_instance = new self ;
		}
		
		self::$_instance->_namespace = $namespace_str ;
		return self::$_instance ;
	}
	
	
	/**
	 * Cette methode se differencie de Callback(), par la maniere
	 * dont elle est appelee. Cette methode cree l'objet de maniere 
	 * implicite.
	 * Exemple :
	 * Factory::getInstance('Exception_')->Organisation( $msg);
	 * @access public
	 * @method Object Retourne une instance de l'objet invoque
	 * @param string $classname_str Nom de la classe a fabriquer
	 * @param array $args_array Tableau des arguments pour la methode
	 * @return Object Objet de la classe
	 * @author GB Michel
	 */
	public function __call( $classname_str, $args_array)
	{
		return $this->getCustomInstance( $classname_str, $args_array);
	}
	
	/**
	 * Callback() est appelee explicitement
	 * et permet de fabriquer un objet dont le nom de la classe
	 * est genere dynamiquement, par exemple avec get_class($this).
	 * Exemple:
	 * // get_class($this) = 'Organisation';
	 * Factory::getInstance('Exception_')->callback( get_class($this), $msg);
	 * @access public
	 * @method Object Retourne une instance de l'objet invoque
	 * @param string $classname_str Nom de la classe a fabriquer
	 * @param array $args_array Tableau des arguments pour la methode
	 * @return Object Objet de la classe
	 * @author GB Michel
	 */
	public function callback( $classname_str, $args_array)
	{
		return $this->getCustomInstance( $classname_str, $args_array);
	}
} 

?>

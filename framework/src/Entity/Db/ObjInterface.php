<?php

namespace Ufo\Entity\Db;

/**
 * Interface utiliser par tous les objets associe a une 
 * entite dans la base des donnees. Force l'implementation
 * des methodes CRUD pour chaque objet.
 * @author GB Michel
 * @version 1.0 
 * @since 17/11/2012
 */
interface ObjInterface
{
	/* *
	 * Description des proprietes de l'objet utilise
	 * par la BDD
	 * @access public
	 */
    private $_db_profile;
    private $_tpl_table;
	private $_tpl_columns;
	private $_id;
	
	
	/**
	 * Verifie que l'ID en parametre, renvoie bien a un objet
	 * existent dans la BDD 
	 * @abstract
	 * @method boolean Assigne au proprietes de l'objet, leur valeur dans la base
	 * @return boolean Retourn TRUE en cas de succes, FALSE sinon
	 */
	public static function checkID( $param_id_int);
	
	/**
	 * Utilise l'ID de l'objet pour recupere les donnees dans la base
	 * et renseigner les proprietes de l'objet. 
	 * @abstract
	 * @method boolean Assigne au proprietes de l'objet, leur valeur dans la base
	 * @return boolean Retourn TRUE en cas de succes, FALSE sinon
	 */
	public function getData();
		
	/**
	 * Utilise l'ID de l'objet pour recupere les donnees dans la base
	 * et renseigner les proprietes de l'objet. 
	 * @abstract
	 * @method boolean Assigne au proprietes de l'objet, leur valeur dans la base
	 * @return boolean Retourn TRUE en cas de succes, FALSE sinon
	 */
	public function setData( $param_data_array);	
	
	/**
	 * Enregistre l'objet dans la BDD en utilisant ses proprietes. 
	 * @abstract
	 * @method boolean Assigne au proprietes de l'objet, leur valeur dans la base
	 * @return boolean Retourn TRUE en cas de succes, FALSE sinon
	 */
	public function create();	
	
	/**
	 * Utilise l'ID et les proprietes de l'objet pour mettre
	 * a jour l'enregistrement associe dans la BDD.
	 * @abstract
	 * @method boolean Assigne au proprietes de l'objet, leur valeur dans la base
	 * @return boolean Retourn TRUE en cas de succes, FALSE sinon
	 */
	public function update();	
	
	/**
	 * Utilise l'ID de l'objet pour supprimer l'enregistrement 
	 * qui lui est associe dans la BDD. 
	 * @abstract
	 * @method boolean Supprime dans la BDD, l'enregistrement correspondant a l'ID de l'objet
	 * @return boolean Retourn TRUE en cas de succes, FALSE sinon
	 */
	public function delete(); 	
	
}

?>
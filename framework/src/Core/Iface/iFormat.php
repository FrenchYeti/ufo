<?php

namespace Ufo\Core\Iface ;

interface iFormat
{
	/**
	 * Teste si un chaine de caracteres est uniquement constituee de lettre, et
	 * facultativement de chiffre, d'espace et tabulation et 
	 * teste facultativement la longueur
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
	public static function pureText( $param_text_str, $number_authorized = false, $space_authorized = false, $length_max = 0 );
	
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
	public static function punctuatedText( $param_text_str, $length_max = 0);
	
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
	public static function specificPunctuatedText( $param_text_str, $length_max = 0, $additivespecialchar_str = '-');
}

?>
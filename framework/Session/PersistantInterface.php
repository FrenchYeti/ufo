<?php

namespace Ufo\Session;

/**
 * Interface pour les objets persitant en session
 * ---------------------------------------------------
 * stock() = serialise l'objet et le stocke en session
 * destroy() = detruit l'objet en session et l'objet courant
 * restore() = recupere s'il existe l'objet stocke en session
 * 
 * @since 08/04/2013
 * @author GB Michel
 * @version 1.0
 */
interface PersistantInterface
{
	public function destroy();
	
	public static function restore();
	
	public function stock();
}

?>

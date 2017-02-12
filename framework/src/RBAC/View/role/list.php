<table id="role-list">
<tr>
	<td>ID</td>
	<td>Nom du r&ocric;le</td>
	<?php 
	
	if( UserSession::isAuthorized("Supprimer un role")){
		echo '<td>Supprimer</td>';
	}
	if( UserSession::isAuthorized("Modifer un role")){
		echo '<td>Modifier</td>';
	}
	if( UserSession::isAuthorized("Modifier les autorisations")){
		echo '<td>Modifier les autorisations</td>';
	}
	
	?>
</tr>
<?php 

if( UserSession::isAuthorized("Lister les roles")){
	
	foreach( Role::getAll() as $role){

		echo '<tr>
				<td>'.$role->getID().'</td>
				<td>'.$role->getName().'</td>';
		
		if( UserSession::isAuthorized("Supprimer un role")){
			echo '<td><a href="">Supprimer</a></td>';
		}
		if( UserSession::isAuthorized("Modifer un role")){
			echo '<td><a href="">Supprimer</a></td>';
		}
		if( UserSession::isAuthorized("Modifier les autorisations")){
			echo '<td><a href="">G&eacute;rer</a>/td>';
		}
		
		echo '</tr>';
	}
}

?>
</table> 
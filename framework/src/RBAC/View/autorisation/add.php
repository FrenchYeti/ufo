<form method="POST" action="">
<fieldset>
<legend>Ajouter une autorisation</legend>

<!-- Selct role -->
<label for="aarole"></label>
<select size="1" name="aarole">
<?php 

$list = RBAC\Role::getAll();
foreach( $list as $role){
	echo '<option value="'.$role->getID().'">'.$role->getName().'</option>';
}

?>
</select>

<!-- Select operation -->
<label for="aaope"></label>
<select size="1" name="aaope">
<?php 


$list_cat = RBAC\OperationCategorie::getAll();
foreach( $list_cat as $cat){
	
	$list_ope = RBAC\Operation::getFromCategorie($cat);
	echo '<optgroup label="'.$cat->getName().'">';
	foreach( $list_ope as $ope){
		echo '<option value="'.$ope->getID().'">'.$ope->getTitle().'</option>';
	}
	echo '</optgroup>';
}

?>
</select>

</fieldset>
</form>
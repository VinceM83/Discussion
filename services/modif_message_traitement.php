<?php

	require_once("../config/connect.php");

	$id= $_POST['id'];
	$contenu= $_POST['contenu'];

	$modif= $pdo->prepare('UPDATE message SET contenu= :contenu WHERE id= :id');
	$modif->bindValue(':id', $id, PDO::PARAM_INT);
	$modif->bindValue(':contenu', $contenu, PDO::PARAM_STR);
	$modif->execute();


?>
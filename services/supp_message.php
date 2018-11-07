<?php
	try { $bdd = new PDO('mysql:host=localhost;dbname=channel', 'root', ''); }
	catch(Exception $e) { echo $e->getMessage(); }

	$supp = $bdd->prepare('DELETE FROM message WHERE id = :id');
	$supp->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
	$supp->execute();
	echo 'message effacé';
?>
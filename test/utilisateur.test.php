<?php

	require_once('../classes/utilisateur.class.php');

	$paul = new Utilisateur('Paul');
	$ringo = new Utilisateur('Ringo');
	$john = new Utilisateur('John');
	$george = new Utilisateur('George');

	echo $john->getPseudo();
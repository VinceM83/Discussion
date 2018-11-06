<?php
	require_once('../config/protect.php');
	if (!$identifie) {
		echo "2"; // non identifié
		exit;
	}

	$format = ['contenu' => '', 'channel' => ''];
	$p = array_intersect_key($_POST, $format);

	if (count($p) < count($format)) {
		echo "3"; // paramètre manquant
		exit;
	}

	require_once('../config/connect.php');
	// deux choix s'offrent à nous ici :
	// - utiliser la POO, pas très utile car ça fait charger des classes et instancier des objets qui ne seront pas utilisés, mais ça peut être intéressant si le fonctionnement interne de l'objet implique des traitements sur les données (formatage de la date, transformation du contenu etc.)
	// - passer simplement les paramètres POST au connecteur PDO, sans passer par la POO, ce qu'on fait ici pour l'instant car la classe Message n'a aucun intérêt et elle nécessite de plus la création d'un objet Utilisateur

	$stmt = $pdo->prepare('INSERT INTO message (contenu, idutilisateur, idchannel) VALUES (:contenu, :utilisateur, :channel)');
	
	if ($stmt->execute($p + ['utilisateur' => $_SESSION['id']])) echo "0"; // ok
	else echo "1"; // not ok
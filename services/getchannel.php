<?php
	require_once('../config/protect.php');
	if (!$identifie) {
		echo json_encode(['erreur' => 2]); // non identifié
		exit;
	}

	$format = ['id' => ''];
	$p = array_intersect_key($_GET, $format);

	if (count($p) < count($format)) {
		echo json_encode(['erreur' => 3]); // paramètre manquant
		exit;
	}

	require_once('../config/connect.php');
	// deux choix s'offrent à nous ici :
	// - utiliser la POO, pas très utile car ça fait charger des classes et instancier des objets qui ne seront pas utilisés, mais ça peut être intéressant si le fonctionnement interne de l'objet implique des traitements sur les données (formatage de la date, transformation du contenu etc.)
	// - passer simplement les paramètres POST au connecteur PDO, sans passer par la POO, ce qu'on fait ici pour l'instant car la classe Message n'a aucun intérêt et elle nécessite de plus la création d'un objet Utilisateur

	$stmt = $pdo->prepare('SELECT nom, utilisateur.pseudo nomauteur, utilisateur.id idauteur FROM channel JOIN utilisateur ON utilisateur.id = channel.idutilisateur AND channel.id = :id;');
	
	if ($stmt->execute($p)) {
		$chan = $stmt->fetch(PDO::FETCH_ASSOC);
		echo json_encode(['nom' => $chan['nom'], 'auteur' => [
			'pseudo' => $chan['nomauteur'],
			'id' => $chan['idauteur']
		]]); // ok
	} else echo json_encode(['erreur' => 1]); // not ok
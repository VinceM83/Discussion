<?php
	require_once('../config/protect.php');
	if (!$identifie) {
		echo json_encode(['erreur' => 'utilisateur non identifié', 'url' => 'login.php']); // non identifié
		exit;
	}

	require_once('../config/connect.php');
	require_once('../classes/message.class.php');
	require_once('../classes/utilisateur.class.php');

	$stmt = $pdo->prepare('SELECT message.*, utilisateur.id idauteur, utilisateur.pseudo nomauteur FROM message JOIN utilisateur ON utilisateur.id = message.idutilisateur AND message.idchannel = :id ORDER BY message.envoi ASC');
	$stmt->execute($_GET);

	$msg = $stmt->fetchAll(PDO::FETCH_ASSOC);

	$messages = [];
	foreach ($msg as $m) {
		$messages[] = new Message($m['id'], new Utilisateur($m['idauteur'], $m['nomauteur']), $m['contenu'], new DateTime($m['envoi']));
	}

	echo json_encode(array_map(function($mes) {
		return $mes->toJSON();
	}, $messages));
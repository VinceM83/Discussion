<?php
	require_once('../config/connect.php');
	require_once('../classes/channel.class.php');
	require_once('../classes/utilisateur.class.php');

	$cnl = $pdo->query('SELECT channel.*, utilisateur.id idauteur, utilisateur.pseudo nomauteur FROM channel JOIN utilisateur ON utilisateur.id = channel.idutilisateur;')->fetchAll(PDO::FETCH_ASSOC);

	$channels = [];
	foreach ($cnl as $c) {
		$channels[] = new Channel($c['id'], $c['nom'], new Utilisateur($c['idauteur'], $c['nomauteur']));
	}

	echo json_encode(array_map(function($chan) {
		return $chan->toJSON();
	}, $channels));
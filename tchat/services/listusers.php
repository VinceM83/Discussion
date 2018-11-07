<?php
	require_once('../config/connect.php');
	require_once('../classes/channel.class.php');
	require_once('../classes/utilisateur.class.php');

	$usr = $pdo->query('SELECT * from utilisateur')->fetchAll(PDO::FETCH_ASSOC);

	$user = [];
	foreach ($usr as $c) {
		$user[] = new Utilisateur($c['id'], $c['pseudo']);
	};

	echo json_encode(array_map(function($usrs) {
		return $usrs->toJSON();
	}, $user));
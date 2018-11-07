<?php
session_start();
	require_once('../config/connect.php');

	require_once('../classes/messageprive.class.php');

	$pvm = $pdo->prepare('SELECT contenu, idenvoie, idrecois FROM messageprive WHERE idenvoie = :idenvoie AND idrecois = :idrecois OR idenvoie= :idrecois AND idrecois = :idenvoie');
	$pvm -> bindValue(':idenvoie', $_SESSION['id']);
	$pvm -> bindValue(':idrecois', $_GET['id']);
	$pvm->execute();
	$priv = $pvm->fetchAll(PDO::FETCH_ASSOC);

	$privates = [];
	foreach ($priv as $c) {
		$privates[] = new Messageprive($c['idenvoie'], $c['idrecois'], $c['contenu'] );
	};

	echo json_encode(array_map(function($privmes) {
		return $privmes->toJSON();
	}, $privates));


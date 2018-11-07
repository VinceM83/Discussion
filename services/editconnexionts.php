<?php
	$ts = $_POST['ts'];
	$id = $_POST['id'];

	require_once('../config/connect.php');
	$insertion = $pdo->prepare('UPDATE utilisateur SET connexion_ts ='.$_POST['ts'] .' WHERE id='.intval($_POST['id']));
	$insertion->execute();
	echo json_encode(array($ts,$id));

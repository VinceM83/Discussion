<?php
	require_once('../config/connect.php');

	$utilisateurs = $pdo->query('SELECT id, pseudo, connexion_ts FROM utilisateur;');

	echo json_encode($utilisateurs->fetchAll(PDO::FETCH_ASSOC));
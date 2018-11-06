<?php
	session_start();
	// pour les tests
	//if (!isset($_SESSION['id'])) $_SESSION = ['id' => 1, 'pseudo' => 'Testeur'];
	// à commenter avant le passage en prod !!!
	$identifie = isset($_SESSION['id']);
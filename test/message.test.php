<?php

	require_once('../classes/utilisateur.class.php');
	require_once('../classes/channel.class.php');
	require_once('../classes/message.class.php');

	$bilbo = new Utilisateur(42, 'Bilbon Sacquet');

	$hbt = new Channel(32, 'Le Hobbit', $bilbo);

	$balrog = new Message(4, new Utilisateur(20, 'Gandalf'), 'Vous ne passerez pas !', new DateTime('2018-09-18 10:34:17'));
	$precieux = new Message(6, new Utilisateur(19, 'Gollum'), 'Mon précieux !', new DateTime('2018-09-18 10:34:23'));

	$hbt->addMessage($balrog);
	$hbt->addMessage($precieux);

	echo $balrog;
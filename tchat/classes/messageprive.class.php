<?php

require_once('channel.class.php');
require_once('utilisateur.class.php');

class Messageprive {


	private $idenvoie;
	private $idrecois;
	private $contenu;


	public function __construct($idenvoie, $idrecois, $contenu) {
		$this->idenvoie = $idenvoie;
		$this->idrecois = $idrecois;
		$this->contenu = $contenu;
	}

	public function getId() {
		return $this->id;
	}

	public function getContenu() {
		return $this->contenu;
	}

	public function getEnvoie() {
		return $this->idenvoie;
	}

	public function getRecois() {
		return $this->idrecois;
	}




	public function toJSON() {
		return [
			"contenu" => $this->getContenu(),
			"idenvoie" => $this->getEnvoie(),
			"idrecois" => $this->getRecois()
		];
	}
}
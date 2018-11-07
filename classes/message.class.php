<?php

require_once('channel.class.php');
require_once('utilisateur.class.php');

class Message {

	private $id;
	private $auteur;
	private $contenu;
	private $date;
	private $channel;

	public function __construct($id, Utilisateur $auteur, $contenu, DateTime $date) {
		$this->id = $id;
		$this->auteur = $auteur;
		$this->contenu = $contenu;
		$this->date = $date;
	}

	public function getId() {
		return $this->id;
	}

	public function getContenu() {
		return $this->contenu;
	}

	public function getAuteur() {
		return $this->auteur;
	}

	public function getDate() {
		return $this->date;
	}

	public function setChannel(Channel $channel) {
		if (is_null($this->channel)) $this->channel = $channel;
		else throw new Exception('Un channel ne peut être défini qu\'une seule fois');
	}

	public function getChannel() {
		return $this->channel;
	}

	public function __toString() {
		return $this->getAuteur()->getPseudo()." dit ".$this->getContenu();
	}

	public function toJSON() {
		return [
			"id" => $this->getId(),
			"contenu" => $this->getContenu(),
			"auteur" => [
				"id" => $this->auteur->getId(),
				"pseudo" => $this->auteur->getPseudo()
			],
			"envoi" => $this->getDate()->getTimestamp()
		];
	}
}
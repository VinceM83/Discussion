<?php

require_once('message.class.php');
require_once('utilisateur.class.php');

class Channel {

	private $id;
	private $nom;
	private $messages;
	private $auteur;
	
	public function __construct($id, $nom, Utilisateur $auteur) {
		$this->id = $id;
		$this->nom = $nom;
		$this->auteur = $auteur;
	}

	public function getId() {
		return $this->id;
	}

	public function getNom() {
		return $this->nom;
	}

	public function setMessages(array $messages) {
		$this->messages = $messages;
	}

	public function getMessages() {
		return $this->messages;
	}

	public function addMessage(Message $message) {
		$message->setChannel($this);
		$this->messages[] = $message;
	}

	public function getAuteur():Utilisateur {
		return $this->auteur;
	}

	public function toJSON() {
		return [
			"id" => $this->getId(),
			"nom" => $this->getNom(),
			"auteur" => [
				"id" => $this->auteur->getId(),
				"pseudo" => $this->auteur->getPseudo()
			]
		];
	}
}
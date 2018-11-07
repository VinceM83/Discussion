<?php

class Utilisateur {

	private $id;
	private $pseudo;
	private $password;

	public function __construct($id, $pseudo) {
		$this->id = $id;
		$this->pseudo = $pseudo;
	}

	public function getId() {
		return $this->id;
	}

	public function getPseudo() {
		return $this->pseudo;
	}

	public function setPassword($password) {
		$this->password = $password;
	}

	public function getPassword() {
		return $this->password;
	}
}
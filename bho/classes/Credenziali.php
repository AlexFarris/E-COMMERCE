<?php

class Credenziali {
    private $idCredenziale;
    private $nomeUtente;
    private $password;
    private $privilegi;
    private $idUtente;

    public function __construct($idCredenziale, $nomeUtente, $password, $privilegi, $idUtente) {
        $this->idCredenziale = $idCredenziale;
        $this->nomeUtente = $nomeUtente;
        $this->password = $password;
        $this->privilegi = $privilegi;
        $this->idUtente = $idUtente;
    }

    public function getIdCredenziale() {
        return $this->idCredenziale;
    }

    public function getNomeUtente() {
        return $this->nomeUtente;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getPrivilegi() {
        return $this->privilegi;
    }

    public function getIdUtente() {
        return $this->idUtente;
    }

    public function setIdCredenziale($idCredenziale) {
        $this->idCredenziale = $idCredenziale;
    }

    public function setNomeUtente($nomeUtente) {
        $this->nomeUtente = $nomeUtente;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function setPrivilegi($privilegi) {
        $this->privilegi = $privilegi;
    }

    public function setIdUtente($idUtente) {
        $this->idUtente = $idUtente;
    }
}

?>

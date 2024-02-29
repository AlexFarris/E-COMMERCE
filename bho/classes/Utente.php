<?php

class Utente {
    private $idUtente;
    private $nome;
    private $cognome;
    private $sesso;
    private $metodoPagamento;
    private $mail;
    private $numeroTelefono;

    public function __construct($idUtente, $nome, $cognome, $sesso, $metodoPagamento, $mail, $numeroTelefono) {
        $this->idUtente = $idUtente;
        $this->nome = $nome;
        $this->cognome = $cognome;
        $this->sesso = $sesso;
        $this->metodoPagamento = $metodoPagamento;
        $this->mail = $mail;
        $this->numeroTelefono = $numeroTelefono;
    }

    public function getIdUtente() {
        return $this->idUtente;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getCognome() {
        return $this->cognome;
    }

    public function getSesso() {
        return $this->sesso;
    }

    public function getMetodoPagamento() {
        return $this->metodoPagamento;
    }

    public function getMail() {
        return $this->mail;
    }

    public function getNumeroTelefono() {
        return $this->numeroTelefono;
    }

    public function setIdUtente($idUtente) {
        $this->idUtente = $idUtente;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function setCognome($cognome) {
        $this->cognome = $cognome;
    }

    public function setSesso($sesso) {
        $this->sesso = $sesso;
    }

    public function setMetodoPagamento($metodoPagamento) {
        $this->metodoPagamento = $metodoPagamento;
    }

    public function setMail($mail) {
        $this->mail = $mail;
    }

    public function setNumeroTelefono($numeroTelefono) {
        $this->numeroTelefono = $numeroTelefono;
    }
}

?>

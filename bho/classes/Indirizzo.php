<?php

class Indirizzo {
    private $idIndirizzo;
    private $via;
    private $stato;
    private $citta;
    private $CAP;
    private $idUtente;

    public function __construct($idIndirizzo, $via, $stato, $citta, $CAP, $idUtente) {
        $this->idIndirizzo = $idIndirizzo;
        $this->via = $via;
        $this->stato = $stato;
        $this->citta = $citta;
        $this->CAP = $CAP;
        $this->idUtente = $idUtente;
    }

    public function getIdIndirizzo() {
        return $this->idIndirizzo;
    }

    public function getVia() {
        return $this->via;
    }

    public function getStato() {
        return $this->stato;
    }

    public function getCitta() {
        return $this->citta;
    }

    public function getCAP() {
        return $this->CAP;
    }

    public function getIdUtente() {
        return $this->idUtente;
    }

    public function setIdIndirizzo($idIndirizzo) {
        $this->idIndirizzo = $idIndirizzo;
    }

    public function setVia($via) {
        $this->via = $via;
    }

    public function setStato($stato) {
        $this->stato = $stato;
    }

    public function setCitta($citta) {
        $this->citta = $citta;
    }

    public function setCAP($CAP) {
        $this->CAP = $CAP;
    }

    public function setIdUtente($idUtente) {
        $this->idUtente = $idUtente;
    }
}

?>

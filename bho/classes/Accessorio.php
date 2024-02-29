<?php

class Accessorio {
    private $idAccessorio;
    private $descrizione;
    private $prezzo;
    private $idProdotto;

    public function __construct($idAccessorio, $descrizione, $prezzo, $idProdotto) {
        $this->idAccessorio = $idAccessorio;
        $this->descrizione = $descrizione;
        $this->prezzo = $prezzo;
        $this->idProdotto = $idProdotto;
    }

    public function getIdAccessorio() {
        return $this->idAccessorio;
    }

    public function getDescrizione() {
        return $this->descrizione;
    }

    public function getPrezzo() {
        return $this->prezzo;
    }

    public function getIdProdotto() {
        return $this->idProdotto;
    }

    public function setIdAccessorio($idAccessorio) {
        $this->idAccessorio = $idAccessorio;
    }

    public function setDescrizione($descrizione) {
        $this->descrizione = $descrizione;
    }

    public function setPrezzo($prezzo) {
        $this->prezzo = $prezzo;
    }

    public function setIdProdotto($idProdotto) {
        $this->idProdotto = $idProdotto;
    }
}

?>

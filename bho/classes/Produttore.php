<?php

class Produttore {
    // Proprietà della classe corrispondenti alle colonne della tabella
    public $idProduttore;
    public $nome;
    public $descrizione;
    public $statoResidenza;
    public $tipologiaProdotti;

    // Costruttore della classe
    public function __construct($idProduttore, $nome, $descrizione, $statoResidenza, $tipologiaProdotti) {
        $this->idProduttore = $idProduttore;
        $this->nome = $nome;
        $this->descrizione = $descrizione;
        $this->statoResidenza = $statoResidenza;
        $this->tipologiaProdotti = $tipologiaProdotti;
    }

    // Metodo per ottenere l'ID del produttore
    public function getIdProduttore() {
        return $this->idProduttore;
    }

    // Metodo per ottenere il nome del produttore
    public function getNome() {
        return $this->nome;
    }

    // Metodo per ottenere la descrizione del produttore
    public function getDescrizione() {
        return $this->descrizione;
    }

    // Metodo per ottenere lo stato di residenza del produttore
    public function getStatoResidenza() {
        return $this->statoResidenza;
    }

    // Metodo per ottenere la tipologia dei prodotti del produttore
    public function getTipologiaProdotti() {
        return $this->tipologiaProdotti;
    }
}

?>

<?php

class Categoria {
    // Proprietà della classe corrispondenti alle colonne della tabella
    public $idCategoria;
    public $nome;
    public $descrizione;

    // Costruttore della classe
    public function __construct($idCategoria, $nome, $descrizione) {
        $this->idCategoria = $idCategoria;
        $this->nome = $nome;
        $this->descrizione = $descrizione;
    }

    // Metodo per ottenere l'ID della categoria
    public function getIdCategoria() {
        return $this->idCategoria;
    }

    // Metodo per ottenere il nome della categoria
    public function getNome() {
        return $this->nome;
    }

    // Metodo per ottenere la descrizione della categoria
    public function getDescrizione() {
        return $this->descrizione;
    }
}

?>

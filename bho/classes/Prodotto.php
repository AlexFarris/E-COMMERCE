<?php

class Prodotto {
    // Proprietà della classe corrispondenti alle colonne della tabella
    public $idProdotto;
    public $nome;
    public $descrizione;
    public $numeroProdotti;
    public $prezzo;
    public $idProduttore;

    // Costruttore della classe
    public function __construct($idProdotto, $nome, $descrizione, $numeroProdotti, $prezzo, $idProduttore) {
        $this->idProdotto = $idProdotto;
        $this->nome = $nome;
        $this->descrizione = $descrizione;
        $this->numeroProdotti = $numeroProdotti;
        $this->prezzo = $prezzo;
        $this->idProduttore = $idProduttore;
    }

    // Metodo per ottenere l'ID del prodotto
    public function getIdProdotto() {
        return $this->idProdotto;
    }

    // Metodo per ottenere il nome del prodotto
    public function getNome() {
        return $this->nome;
    }

    // Metodo per ottenere la descrizione del prodotto
    public function getDescrizione() {
        return $this->descrizione;
    }

    // Metodo per ottenere il numero di prodotti disponibili
    public function getNumeroProdotti() {
        return $this->numeroProdotti;
    }

    // Metodo per ottenere il prezzo del prodotto
    public function getPrezzo() {
        return $this->prezzo;
    }

    // Metodo per ottenere l'ID del produttore associato al prodotto
    public function getIdProduttore() {
        return $this->idProduttore;
    }
}

?>

<?php

class Recensione {
    // Proprietà della classe corrispondenti alle colonne della tabella
    public $idRecensione;
    public $titolo;
    public $contenuto;
    public $stelle;
    public $idUtente;
    public $idProdotto;

    // Costruttore della classe
    public function __construct($idRecensione, $titolo, $contenuto, $stelle, $idUtente, $idProdotto) {
        $this->idRecensione = $idRecensione;
        $this->titolo = $titolo;
        $this->contenuto = $contenuto;
        $this->stelle = $stelle;
        $this->idUtente = $idUtente;
        $this->idProdotto = $idProdotto;
    }

    // Metodo per ottenere l'ID della recensione
    public function getIdRecensione() {
        return $this->idRecensione;
    }

    // Metodo per ottenere il titolo della recensione
    public function getTitolo() {
        return $this->titolo;
    }

    // Metodo per ottenere il contenuto della recensione
    public function getContenuto() {
        return $this->contenuto;
    }

    // Metodo per ottenere il numero di stelle della recensione
    public function getStelle() {
        return $this->stelle;
    }

    // Metodo per ottenere l'ID dell'utente associato alla recensione
    public function getIdUtente() {
        return $this->idUtente;
    }

    // Metodo per ottenere l'ID del prodotto associato alla recensione
    public function getIdProdotto() {
        return $this->idProdotto;
    }
}

?>

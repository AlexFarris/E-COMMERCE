<?php

class Carrello {
    // Proprietà della classe corrispondenti alle colonne della tabella
    public $idCarrello;
    public $costoAttuale;
    public $idUtente;
    public $idOrdine;

    // Costruttore della classe
    public function __construct($idCarrello, $costoAttuale, $idUtente, $idOrdine) {
        $this->idCarrello = $idCarrello;
        $this->costoAttuale = $costoAttuale;
        $this->idUtente = $idUtente;
        $this->idOrdine = $idOrdine;
    }

    // Metodo per ottenere l'ID del carrello
    public function getIdCarrello() {
        return $this->idCarrello;
    }

    // Metodo per ottenere il costo attuale del carrello
    public function getCostoAttuale() {
        return $this->costoAttuale;
    }

    // Metodo per ottenere l'ID dell'utente associato al carrello
    public function getIdUtente() {
        return $this->idUtente;
    }

    // Metodo per ottenere l'ID dell'ordine associato al carrello
    public function getIdOrdine() {
        return $this->idOrdine;
    }
}

?>

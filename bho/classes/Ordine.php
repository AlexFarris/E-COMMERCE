<?php

class Ordine {
    // Proprietà della classe corrispondenti alle colonne della tabella
    public $idOrdine;
    public $dataOrdine;
    public $costoTotale;
    public $idUtente;

    // Costruttore della classe
    public function __construct($idOrdine, $dataOrdine, $costoTotale, $idUtente) {
        $this->idOrdine = $idOrdine;
        $this->dataOrdine = $dataOrdine;
        $this->costoTotale = $costoTotale;
        $this->idUtente = $idUtente;
    }

    // Metodo per ottenere l'ID dell'ordine
    public function getIdOrdine() {
        return $this->idOrdine;
    }

    // Metodo per ottenere la data dell'ordine
    public function getDataOrdine() {
        return $this->dataOrdine;
    }

    // Metodo per ottenere il costo totale dell'ordine
    public function getCostoTotale() {
        return $this->costoTotale;
    }

    // Metodo per ottenere l'ID dell'utente associato all'ordine
    public function getIdUtente() {
        return $this->idUtente;
    }
}

?>

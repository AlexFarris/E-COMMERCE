<?php
session_start();
include '../config.php';

if (isset($_POST['idOrdine'])) {
    $idOrdine = $_POST['idOrdine'];

    // Query per ottenere i dettagli dell'ordine
    $sql_ordine_dettagli = "SELECT * FROM ORDINE WHERE idOrdine = $idOrdine";
    $result_ordine_dettagli = $conn->query($sql_ordine_dettagli);

    if ($result_ordine_dettagli->num_rows > 0) {
        $row_ordine_dettagli = $result_ordine_dettagli->fetch_assoc();
        $dataOrdine = $row_ordine_dettagli["data"];
        $costoTotaleOrdine = $row_ordine_dettagli["costoTotale"];

        echo "<h2>Dettagli dell'Ordine</h2>";
        echo "Data: $dataOrdine<br>";
        echo "Costo Totale: $$costoTotaleOrdine<br>";
        echo $idOrdine;
        // Ottieni l'elenco dei prodotti nell'ordine
        $sql_prodotti_ordine = "SELECT P.nome AS nomeProdotto, OP.idAccessorio, A.descrizione AS descrAccessorio
                                FROM ORDINE_PRODOTTI OP
                                LEFT JOIN PRODOTTO P ON OP.idProdotto = P.idProdotto
                                LEFT JOIN ACCESSORIO A ON OP.idAccessorio = A.idAccessorio
                                WHERE OP.idOrdine = $idOrdine";
        $result_prodotti_ordine = $conn->query($sql_prodotti_ordine);

        if ($result_prodotti_ordine->num_rows > 0) {
            echo "<h3>Prodotti nell'Ordine</h3>";
            echo "<ul>";
            while ($row_prodotto_ordine = $result_prodotti_ordine->fetch_assoc()) {
                $nomeProdotto = $row_prodotto_ordine["nomeProdotto"];
                $descrizAccessorio = $row_prodotto_ordine["descrAccessorio"];

                echo "<li>$nomeProdotto";
                if ($descrizAccessorio) {
                    echo " (Accessorio: $descrizAccessorio)";
                }
                echo "</li>";
            }
            echo "</ul>";
        } else {
            echo "Nessun prodotto trovato per questo ordine.";
        }
    } else {
        echo "Ordine non trovato.";
    }
} else {
    echo "ID Ordine non specificato.";
}

// Chiudi la connessione al database
$conn->close();
?>

<?php
session_start();
include '../config.php';

// Funzione per ottenere i dettagli dell'ordine
function getDettagliOrdine($idUtente)
{
    global $conn;

    $sql = "SELECT * FROM CARRELLO WHERE idUtente = $idUtente";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            
            $idCarrello = $row["idCarrello"];
            $costoAttuale = $row["costoAttuale"];
        
            echo "<div class='mb-4 custom-border-bottom'>
                    <br>
                    <p><strong>Costo Totale:</strong> $$costoAttuale</p>";
        
            // Ottenere i prodotti nel carrello
            echo "<h3>Prodotti nell'Ordine:</h3>";
            echo "<div class='row'>";
            getProdottiCarrello($idCarrello, null, 0);
            echo "</div>";
        
            // Aggiungi pulsante per effettuare l'ordine
            echo "<form method='post' class='mt-3'>";
            echo "<input type='submit' name='effettuaOrdine' value='Effettua Ordine' class='btn btn-primary'>";
            echo "</form>";
        
            // Ottenere gli indirizzi dell'utente
            echo "<div class='dettagli'>";
            echo "<h3 class='mt-4'>Dettagli Utente:</h3>";
            getDettagliUtente($idUtente);
            echo "</div>";
            // Gestione dell'effettuazione dell'ordine
            if (isset($_POST['effettuaOrdine'])) {
                effettuaOrdine($idUtente, $idCarrello, $costoAttuale);
            }
        
            echo "</div>"; // Chiudi il container dell'ordine
        }
    } else {
        echo "Nessun ordine trovato.";
    }
}
// Funzione per ottenere i prodotti nel carrello
// Funzione per ottenere i prodotti e accessori nel carrello
function getProdottiCarrello($idCarrello,$idOrdine,$x)
{
    global $conn;

    $sql = "SELECT PRODOTTO.idProdotto, PRODOTTO.nome AS nomeProdotto, PRODOTTO.descrizione AS descrizioneProdotto, PRODOTTO.prezzo AS prezzoProdotto,
            ACCESSORIO.idAccessorio, ACCESSORIO.descrizione AS descrizioneAccessorio, ACCESSORIO.prezzo AS prezzoAccessorio
            FROM CARRELLO_PRODOTTI
            JOIN PRODOTTO ON CARRELLO_PRODOTTI.idProdotto = PRODOTTO.idProdotto
            LEFT JOIN ACCESSORIO ON CARRELLO_PRODOTTI.idAccessorio = ACCESSORIO.idAccessorio
            WHERE CARRELLO_PRODOTTI.idCarrello = $idCarrello";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<ul>";
        while ($row = $result->fetch_assoc()) {
            $idProdotto = $row["idProdotto"];
            $nomeProdotto = $row["nomeProdotto"];
            $descrizioneProdotto = $row["descrizioneProdotto"];
            $prezzoProdotto = $row["prezzoProdotto"];
            $idAccessorio = $row["idAccessorio"];
            $descrizioneAccessorio = $row["descrizioneAccessorio"];
            $prezzoAccessorio = $row["prezzoAccessorio"];

            echo "<li>";
            echo "<strong>$nomeProdotto</strong> - Descrizione: $descrizioneProdotto - Prezzo: $$prezzoProdotto";

            // Visualizza gli accessori solo se presenti
            if (!empty($idAccessorio)) {
                echo " - Accessorio: $descrizioneAccessorio - Prezzo Accessorio: $$prezzoAccessorio";
            }

            echo "</li>";

            // Aggiungi dettagli prodotto all'ordine
            if($x===1){
                echo "bho non so piu:".$idOrdine;
                aggiungiDettagliProdottoAllOrdine($idOrdine,$idProdotto, $idAccessorio);
            }
        }
        echo "</ul>";
    } else {
        echo "Nessun prodotto nel carrello.";
    }
}

// Funzione per aggiungere dettagli del prodotto e accessori all'ordine
function aggiungiDettagliProdottoAllOrdine($idOrdine,$idProdotto, $idAccessorio)
{
    global $conn;
        // Aggiungi l'accessorio all'ordine
        $query_aggiungi_accessorio = "INSERT INTO ORDINE_PRODOTTI (idOrdine, idProdotto, idAccessorio) VALUES (?, ?, ?)";
        $stmt_aggiungi_accessorio = $conn->prepare($query_aggiungi_accessorio);
        $stmt_aggiungi_accessorio->bind_param("iii", $idOrdine, $idProdotto, $idAccessorio);
        if (!$stmt_aggiungi_accessorio->execute()) {
            echo "Errore nell'aggiunta dell'accessorio all'ordine: " . $stmt_aggiungi_accessorio->error;
        }

        $stmt_aggiungi_accessorio->close();
}


// Funzione per ottenere gli indirizzi e il metodo di pagamento dell'utente
function getDettagliUtente($idUtente)
{
    global $conn;

    $sql = "SELECT * FROM INDIRIZZO WHERE idUtente = $idUtente";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {

        // Verifica se ci sono più indirizzi e crea un form di selezione
        if ($result->num_rows > 1) {
            echo "<form action='pagina_indirizzo.php' method='post'>";
            echo "<label for='indirizzo'>Scegli un Indirizzo:</label>";
            echo "<select name='indirizzo' id='indirizzo'>";
            while ($row = $result->fetch_assoc()) {
                $via = $row["via"];
                $citta = $row["citta"];
                $stato = $row["stato"];
                $cap = $row["CAP"];
                $idIndirizzo = $row["idIndirizzo"];

                echo "<option value='$idIndirizzo'>$via, $citta, $stato, CAP: $cap</option>";
            }
            echo "</select>";
            echo "<input type='submit' value='Modifica Indirizzo'>";
            echo "</form>";
        } else {
            // Se c'è un solo indirizzo, mostra direttamente i dettagli
            $row = $result->fetch_assoc();
            $via = $row["via"];
            $citta = $row["citta"];
            $stato = $row["stato"];
            $cap = $row["CAP"];
            echo "Indirizzo: $via, $citta, $stato, CAP: $cap";
            
            // Aggiungi un pulsante per visualizzare la pagina degli indirizzi
            echo "<form action='pagina_indirizzo.php' method='post'>";
            echo "<input type='hidden' name='idIndirizzo' value='{$row['idIndirizzo']}'>";
            echo "<input type='submit' value='Cambia Indirizzo' class='btn btn-primary'>";
            echo "</form>";
        }
    } else {
        echo "Nessun indirizzo trovato.";
    }

    // Ottenere il metodo di pagamento dell'utente
    $sql_metodo_pagamento = "SELECT metodoPagamento FROM UTENTE WHERE idUtente = $idUtente";
    $result_metodo_pagamento = $conn->query($sql_metodo_pagamento);

    if ($result_metodo_pagamento->num_rows > 0) {
        while ($row_metodo_pagamento = $result_metodo_pagamento->fetch_assoc()) {
            $metodoPagamento = $row_metodo_pagamento["metodoPagamento"];
            echo "Metodo di Pagamento: $metodoPagamento<br>";
        }
    } else {
        echo "Metodo di pagamento non disponibile.";
    }
}

// Funzione per effettuare l'ordine e azzerare il carrello
function effettuaOrdine($idUtente, $idCarrello,$costoAttuale)
{
    global $conn;
    // Inserimento dell'ordine
    $query_ordine = "INSERT INTO ORDINE (idUtente, data, costoTotale) VALUES (?, NOW(), ?)";
    $stmt_ordine = $conn->prepare($query_ordine);
    $stmt_ordine->bind_param("id", $idUtente, $costoAttuale);

    if ($stmt_ordine->execute()) {
        // Ottieni l'ID dell'ordine appena inserito
        $idOrdine = $conn->insert_id;
        getProdottiCarrello($idCarrello,$idOrdine,1);
            // Azzerare il carrello
            $query_azzera_carrello = "DELETE FROM CARRELLO_PRODOTTI WHERE idCarrello = ?";
            $stmt_azzera_carrello = $conn->prepare($query_azzera_carrello);
            $stmt_azzera_carrello->bind_param("i", $idCarrello);

            if ($stmt_azzera_carrello->execute()) {
                /* header("Location: ../index.php");
                exit(); */    
            } else {
                echo "Errore nell'azzeramento del carrello: " . $stmt_azzera_carrello->error;
            }

            $stmt_azzera_carrello->close();
    } else {
        echo "Errore nell'effettuazione dell'ordine: " . $stmt_ordine->error;
    }

    $stmt_ordine->close();
}

// Esempio di utilizzo
$idUtente = $_SESSION['user_id']; // Sostituisci con l'ID dell'utente attuale
echo "<h2 class='mt-5'>Dettagli Ordine</h2>";
getDettagliOrdine($idUtente);
// Chiudi la connessione al database
$conn->close();

?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .dettagli{
            float: right;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
        <a class="navbar-brand" href="../index.php">HOME</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="pagina_carrello.php">Vai al Carrello</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="pagina_utente.php"><?= (isset($_SESSION['user_id']) ? 'account' : 'login') ?></a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
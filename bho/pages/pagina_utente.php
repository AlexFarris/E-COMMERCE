<?php
session_start();
include '../config.php';

// Funzione per ottenere i dettagli dell'utente
function getDettagliUtente($idUtente)
{
    global $conn;

    // Dettagli utente
    $sql_utente = "SELECT * FROM UTENTE WHERE idUtente = $idUtente";
    $result_utente = $conn->query($sql_utente);

    if ($result_utente->num_rows > 0) {
        while ($row_utente = $result_utente->fetch_assoc()) {
            $nome = $row_utente["nome"];
            $cognome = $row_utente["cognome"];
            $sesso = $row_utente["sesso"];
            $metodoPagamento = $row_utente["metodoPagamento"];
            $mail = $row_utente["mail"];
            $numeroTelefono = $row_utente["numeroTelefono"];

            echo "<h2>Dettagli Utente</h2>";
            echo "Nome: $nome<br>";
            echo "Cognome: $cognome<br>";
            echo "Sesso: $sesso<br>";
            echo "Metodo di Pagamento: $metodoPagamento<br>";
            echo "Email: $mail<br>";
            echo "Numero di Telefono: $numeroTelefono<br>";
        }
    } else {
        header("Location: login.php");
        exit();
    }

    // Indirizzi dell'utente
    $sql_indirizzi = "SELECT * FROM INDIRIZZO WHERE idUtente = $idUtente";
    $result_indirizzi = $conn->query($sql_indirizzi);

    if ($result_indirizzi->num_rows > 0) {
        echo "<h2>Indirizzi</h2>";
        while ($row_indirizzo = $result_indirizzi->fetch_assoc()) {
            $via = $row_indirizzo["via"];
            $stato = $row_indirizzo["stato"];
            $citta = $row_indirizzo["citta"];
            $cap = $row_indirizzo["CAP"];

            echo "Indirizzo: $via, $citta, $stato, CAP: $cap<br>";
        }
    } else {
        echo "Nessun indirizzo trovato.";
    }

    // Ordini effettuati dall'utente
    $sql_ordini = "SELECT * FROM ORDINE WHERE idUtente = $idUtente";
    $result_ordini = $conn->query($sql_ordini);

    if ($result_ordini->num_rows > 0) {
        echo "<h2>Ordini Effettuati</h2>";
        while ($row_ordine = $result_ordini->fetch_assoc()) {
            $idOrdine = $row_ordine["idOrdine"];
            $data = $row_ordine["data"];
            $costoTotale = $row_ordine["costoTotale"];

            echo "Data: $data - Costo Totale: $$costoTotale";
            
            // Aggiungi un pulsante per visualizzare i dettagli dell'ordine
            echo "<form action='pagina_dettagli_ordine.php' method='post'>";
            echo "<input type='hidden' name='idOrdine' value='$idOrdine'>";
            echo "<input type='submit' name='dettagliOrdine' value='Dettagli Ordine'>";
            echo "</form>";
        }
    } else {
        echo "Nessun ordine effettuato.";
    }

    echo "<br><form action='' method='post'>";
    echo "<input type='submit' name='logout' value='Logout'>";
    echo "</form>";
    
    // Verifica se il pulsante di logout è stato premuto
    if(isset($_POST['logout'])) {
        // Resetta la sessione
        session_unset();
        session_destroy();
        header("Location: ../index.php");
        exit();
    }

}

// Esempio di utilizzo
if(isset($_SESSION['user_id'])){
    $idUtente = $_SESSION['user_id']; // Sostituisci con l'ID dell'utente attuale
    getDettagliUtente($idUtente);
}else{
    header("Location: login.php");
    exit(); 
}


// Chiudi la connessione al database
$conn->close();
?>

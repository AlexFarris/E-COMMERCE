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
        // Ottieni l'elenco dei prodotti nell'ordine
        $sql_prodotti_ordine = "SELECT P.nome AS nomeProdotto, P.descrizione AS descrizioneP, A.prezzo AS prezzoAcc ,P.prezzo AS prezzoP ,OP.idAccessorio, A.descrizione AS descrAccessorio
                                FROM ORDINE_PRODOTTI OP
                                LEFT JOIN PRODOTTO P ON OP.idProdotto = P.idProdotto
                                LEFT JOIN ACCESSORIO A ON OP.idAccessorio = A.idAccessorio
                                WHERE OP.idOrdine = $idOrdine";
        $result_prodotti_ordine = $conn->query($sql_prodotti_ordine);

        if ($result_prodotti_ordine->num_rows > 0) {
            echo "<br><br><br><h3>Ordine n. ".$idOrdine."</h3>";
            echo "<ul>   <div class='col'>
                            <div class='card mb-4 rounded-1 shadow-sm'>
                            <div class='card-header py-3'>
                                <h4 class='my-0 fw-normal'>$dataOrdine</h4>
                            </div>
                            <div class='card-body'>
                                <h1 class='card-title pricing-card-title'>$$costoTotaleOrdine</h1>
                                <ul class='list-unstyled mt-3 mb-4'>";
            while ($row_prodotto_ordine = $result_prodotti_ordine->fetch_assoc()) {
                $nomeProdotto = $row_prodotto_ordine["nomeProdotto"];
                $descrizAccessorio = $row_prodotto_ordine["descrAccessorio"];
                $prezzoProdotto = $row_prodotto_ordine["prezzoP"];
                $descrizProd = $row_prodotto_ordine["descrizioneP"];
                $prezzoAcc = $row_prodotto_ordine["prezzoAcc"];

                echo "<li>- $nomeProdotto - $descrizProd - $$prezzoProdotto</li>";
                                if ($descrizAccessorio) {
                                    echo "- $descrizAccessorio - $$prezzoAcc</li>";
                                }
                echo "<hr>";
            }
            echo "</div></div></div></ul>";
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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>DEttagli</title>
    <style>
        body{
            width: 33%;
            width: 33%;
            width: 33%;
            margin-top: 10%;
            margin-left: 35%;
        }
        h3 {
            text-align: center;
            background-color: #3b71ca;
            color: white;
            border-radius: 5px;
            margin-left: 30px;
        }

    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="../index.php">HOME</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="pagina_carrello.php">Vai al Carrello</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="pagina_utente.php"><?php echo isset($_SESSION['user_id']) ? 'account' : 'login'; ?></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

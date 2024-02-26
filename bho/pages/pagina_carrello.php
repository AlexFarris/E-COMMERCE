<?php
session_start();
include '../config.php';

// Verifica se l'ID dell'utente è presente e valido
if(isset( $result_carrello)){
    $carrelloEsistente=$result_carrello->num_rows > 0;
}else{
    $carrelloEsistente=0;
}
if (!isset($_SESSION["user_id"]) || empty($_SESSION["user_id"]) || $carrelloEsistente > 0) {
    header("Location: login.php");
    exit();
}

$utente_id = $_SESSION["user_id"]; 
// Verifica se l'ID dell'utente esiste nel database
$query_verifica_utente = "SELECT idUtente FROM UTENTE WHERE idUtente = $utente_id";
$result_verifica_utente = $conn->query($query_verifica_utente);

if ($result_verifica_utente->num_rows === 0) {
    // Resetta la sessione
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit();
}
$totale = 0; // Inizializza la variabile totale

// Query per ottenere i dettagli del carrello dell'utente
$query_carrello = "SELECT c.idCarrello, c.costoAttuale, p.nome AS nomeProdotto, p.prezzo AS prezzoProdotto, a.descrizione AS accessorioDescrizione, a.prezzo AS accessorioPrezzo, p.idProdotto AS id
                    FROM CARRELLO c
                    INNER JOIN CARRELLO_PRODOTTI cp ON c.idCarrello = cp.idCarrello
                    INNER JOIN PRODOTTO p ON cp.idProdotto = p.idProdotto
                    LEFT JOIN ACCESSORIO a ON cp.idAccessorio = a.idAccessorio
                    WHERE c.idUtente = $utente_id";

$result_carrello = $conn->query($query_carrello);

// Visualizzazione dei risultati
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrello</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            padding-top: 60px;
        }
        .custom-border-bottom {
            border-bottom: 4px solid black; 
            padding-bottom: 10px; 
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
<h1>Carrello dell'utente</h1>

    <?php
    // Verifica se ci sono prodotti nel carrello
    if ($result_carrello->num_rows > 0) {

        // Output dei dati del carrello
        mysqli_data_seek($result_carrello, 0);
        while($row = $result_carrello->fetch_assoc()) {
            $sql_immagine = "SELECT nome FROM IMMAGINE_PRODOTTO WHERE idProdotto = " . $row["id"];
            $result_immagine = $conn->query($sql_immagine);
            $path_immagine = ($result_immagine->num_rows > 0) ? $result_immagine->fetch_assoc()["nome"] : "default.jpg";
            $static_path_immagini = '../resources/image/' . $path_immagine;

            echo "<div class='row mb-4 border-bottom pb-3'>
                    <div class='col-md-2'>
                        <img src='$static_path_immagini' class='img-thumbnail' alt='{$row["nome"]}' style='max-width: 100px;'>
                    </div>
                    <div class='col-md-4'>
                        <p><strong>{$row["nomeProdotto"]}</strong></p>
                        <p>$ {$row["prezzoProdotto"]}</p>";

            if ($row["accessorioDescrizione"] !== null) {
                echo "<p>{$row["accessorioDescrizione"]}:$ {$row["accessorioPrezzo"]}</p>";
            }

            echo "</div>
                </div>";
            $totale += $row["prezzoProdotto"] + $row["accessorioPrezzo"];
        }

        echo "</tbody>
            </table>";
        echo "<p class='lead'><strong>TOTALE: $</strong>".$totale."<br><br>";

        echo "<form action='pagina_ordine.php' method='post'>";
        echo "<button type='submit' name='procediOrdine' class='btn btn-primary'>Procedi all'Ordine</button>";
        echo "</form>";
    } else {
        echo "<p class='lead'>Il carrello è vuoto.</p>";
    }

    $conn->close();
    ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

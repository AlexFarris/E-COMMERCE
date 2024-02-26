<?php
session_start();
include '../config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica se il form è stato inviato
    if (isset($_POST['submit'])) {
        // Ottieni i dati dal form
        $via = $_POST['via'];
        $stato = $_POST['stato'];
        $citta = $_POST['citta'];
        $cap = $_POST['cap'];

        // Ottieni l'ID dell'utente
        $idUtente = $_SESSION['user_id'];

        // Query per inserire il nuovo indirizzo nel database
        $query_inserimento_indirizzo = "INSERT INTO INDIRIZZO (via, stato, citta, CAP, idUtente) 
                                        VALUES (?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($query_inserimento_indirizzo);
        $stmt->bind_param("ssssi", $via, $stato, $citta, $cap, $idUtente);

        if ($stmt->execute()) {
            header("Location: pagina_ordine.php");
            exit();
        } else {
            echo "Errore durante l'inserimento dell'indirizzo: " . $stmt->error;
        }

        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inserisci Indirizzo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
    <div class="container mt-5">
        <h2 class="text-center">Inserisci un nuovo indirizzo</h2>
        <br>
        <div class="d-flex justify-content-center mt-5 border p-3">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <label for="via">Via:</label>
                <input type="text" name="via" required><br>

                <label for="stato">Stato:</label>
                <input type="text" name="stato" required><br>

                <label for="citta">Città:</label>
                <input type="text" name="citta" required><br>

                <label for="cap">CAP:</label>
                <input type="text" name="cap" required><br><br>

                <input type="submit" name="submit" value="Inserisci Indirizzo" class="btn btn-primary">
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

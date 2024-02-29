<?php
session_start();
include '../config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica se il form è stato inviato
    if (isset($_POST['submit'])) {
        echo "<script>console.log('aaaa')</script>";
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
    <div class="border p-3">
            <div class="container-form">
                <div class="row g-5">
                    <div class="col-md-7 col-lg-8">
                        <h4 class="mb-3">Inserisci un nuovo indirizzo</h4>
                        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                <div class="col-12">
                                <label for="via" class="form-label">Indirizzo</label>
                                <input type="text" class="form-control" name="via" placeholder="Via Garibaldi 15" required>
                                <div class="invalid-feedback">
                                    Indirizzo non valido.
                                </div>
                                </div>

                                <div class="col-sm-4">
                                    <label for="stato" class="form-label">Stato</label>
                                    <input type="text" class="form-control" name="stato" placeholder="Italia" required>
                                    <div class="invalid-feedback">
                                        Stato non valido!
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <label for="citta" class="form-label">Città</label>
                                    <input type="text" class="form-control" name="citta" placeholder="Roma" required>
                                    <div class="invalid-feedback">
                                        Città non valida!
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <label for="cap" class="form-label">CAP</label>
                                    <input type="number" class="form-control" name="cap" placeholder="43121" required>
                                    <div class="invalid-feedback">
                                        CAP necessario!
                                    </div>
                                </div>
                            <input type="submit" name="submit" value="Inserisci Indirizzi" class="btn btn-primary">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
include '../config.php';
mb_internal_encoding('UTF-8');

// Dati ricevuti dal modulo di registrazione
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $nome = $_POST['nome'];
    $cognome = $_POST['cognome'];
    $sesso = $_POST['sesso'];
    $metodoPagamento = $_POST['metodoPagamento'];
    $mail = $_POST['mail'];
    $numeroTelefono = $_POST['numeroTelefono'];
    $via = $_POST['via'];
    $stato = $_POST['stato'];
    $citta = $_POST['citta'];
    $CAP = $_POST['CAP'];
    $nomeUtente = $_POST['nomeUtente'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hash della password

    // Inserimento dati nella tabella UTENTE
    $sqlUtente = "INSERT INTO UTENTE (nome, cognome, sesso, metodoPagamento, mail, numeroTelefono) 
                VALUES ('$nome', '$cognome', '$sesso', '$metodoPagamento', '$mail', '$numeroTelefono')";
    if ($conn->query($sqlUtente) === TRUE) {
        $idUtente = $conn->insert_id;

        // Inserimento dati nella tabella INDIRIZZO
        $sqlIndirizzo = "INSERT INTO INDIRIZZO (via, stato, citta, CAP, idUtente) 
                        VALUES ('$via', '$stato', '$citta', '$CAP', $idUtente)";
        if ($conn->query($sqlIndirizzo) === TRUE) {
            $idIndirizzo = $conn->insert_id;

            $sqlCarrello = "INSERT INTO CARRELLO (costoAttuale, idUtente, idOrdine)
                            VALUES (0, '$idUtente', null)";
            if ($conn->query($sqlCarrello) === TRUE) {
                $idCarello = $conn->insert_id;

                // Inserimento dati nella tabella CREDENZIALI
                $sqlCredenziali = "INSERT INTO CREDENZIALI (nomeUtente, password, privilegi, idUtente) 
                                VALUES ('$nomeUtente', '$password', 1, $idUtente)";
                if ($conn->query($sqlCredenziali) === TRUE) {
                    header("Location: login.php");
                } else {
                    echo "Errore nell'inserimento delle credenziali: " . $conn->error;
                }
            } else {
                echo "Errore nella creazione del carrello: " . $conn->error;
            }
        } else {
            echo "Errore nell'inserimento dell'indirizzo: " . $conn->error;
        }
    } else {
        echo "Errore nell'inserimento dell'utente: " . $conn->error;
    }

    // Chiudi la connessione al database
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrazione Utente</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">Il Tuo Sito</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="offcanvas" data-bs-target="#filterSidebar">Filtri</button>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="pages/pagina_carrello.php">Vai al Carrello</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="pages/pagina_utente.php"><?php echo isset($_SESSION['user_id']) ? 'account' : 'login'; ?></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container mt-5">
        <div class="d-flex justify-content-center">
            <form action="registration.php" method="post" class="border p-3">
                <h2 class="text-center">Registrazione Utente</h2>

                <form action="registration.php" method="post">
                    <label for="nome">Nome:</label>
                    <input type="text" name="nome" required><br>

                    <label for="cognome">Cognome:</label>
                    <input type="text" name="cognome" required><br>

                    <label for="sesso">Sesso:</label>
                    <select name="sesso" required>
                        <option value="M">Maschio</option>
                        <option value="F">Femmina</option>
                    </select><br>

                    <label for="metodoPagamento">Metodo di Pagamento:</label>
                    <input type="text" name="metodoPagamento" required><br>

                    <label for="mail">E-mail:</label>
                    <input type="email" name="mail" required><br>

                    <label for="numeroTelefono">Numero di Telefono:</label>
                    <input type="tel" name="numeroTelefono" required><br>

                    <label for="via">Via:</label>
                    <input type="text" name="via" required><br>

                    <label for="stato">Stato:</label>
                    <input type="text" name="stato" required><br>

                    <label for="citta">Città:</label>
                    <input type="text" name="citta" required><br>

                    <label for="CAP">CAP:</label>
                    <input type="text" name="CAP" required><br>

                    <label for="nomeUtente">Nome Utente:</label>
                    <input type="text" name="nomeUtente" required><br>

                    <label for="password">Password:</label>
                    <input type="password" name="password" required><br>

                    <input type="submit" value="Registrati" class="btn btn-primary">
            </form>
        </div>
    </div>


</body>
</html>

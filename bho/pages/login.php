<?php
// Includi il file di configurazione del database
include '../config.php';
mb_internal_encoding('UTF-8');

// Funzione per sanificare i dati di input
function sanitize_input($data) {
    global $conn;
    return mysqli_real_escape_string($conn, htmlspecialchars(trim($data)));
}

// Inizializza le variabili
$username = $password = "";
$usernameErr = $passwordErr = "";
$login_err = "";

// Verifica se l'utente è già autenticato
session_start();
if (isset($_SESSION["user_id"])) {
    // Utente già autenticato, reindirizzalo alla tua pagina desiderata
    header("Location: ../index.php");
    exit();
}  

// Verifica se il modulo è stato inviato
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validazione del nome utente
    if (empty($_POST["username"])) {
        $usernameErr = "Il nome utente è obbligatorio";
    } else {
        $username = sanitize_input($_POST["username"]);
    }

    // Validazione della password
    if (empty($_POST["password"])) {
        $passwordErr = "La password è obbligatoria";
    } else {
        $password = sanitize_input($_POST["password"]);
    }

    // Se sia il nome utente che la password sono forniti
    if (empty($usernameErr) && empty($passwordErr)) {
        // Query al database per l'utente
        $sql = "SELECT idUtente, nomeUtente, password, privilegi FROM CREDENZIALI WHERE nomeUtente = '$username'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            // Verifica della password
            if (password_verify($password, $row["password"])) {
                // La password è corretta, verifica i privilegi
                session_start();
                $_SESSION["user_id"] = $row["idUtente"];

                if ($row["privilegi"] == 1) {
                    // Utente cliente, reindirizzalo alla pagina cliente
                    header("Location: ../index.php");
                    exit();
                } elseif ($row["privilegi"] == 2) {
                    // Utente admin, reindirizzalo alla pagina admin
                    header("Location: pagina_utente.php");
                    exit();
                }
            } else {
                $login_err = "Nome utente o password non validi";
            }
        } else {
            $login_err = "Nome utente o password non validi";
        }
    }
}

// Chiudi la connessione al database
$conn->close();
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagina di Login</title>
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
    <br><br>

    <div class="container mt-5">
    <div class="d-flex justify-content-center">
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="border p-3">
            <h2 class="text-center">Login</h2>

            <label for="username">Nome utente:</label>
            <input type="text" name="username" id="username" value="<?php echo $username; ?>" class="form-control">
            <span style="color: red;"><?php echo $usernameErr; ?></span><br>

            <label for="password">Password:</label>
            <input type="password" name="password" id="password" class="form-control">
            <span style="color: red;"><?php echo $passwordErr; ?></span><br>

            <input type="submit" value="Login" class="btn btn-primary">
            <a href="registration.php" class="btn btn-primary ml-2">Registrati</a>
        </form>
    </div>
</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
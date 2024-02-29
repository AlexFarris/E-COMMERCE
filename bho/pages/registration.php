<?php
include '../config.php';
mb_internal_encoding('UTF-8');
// Dati ricevuti dal modulo di registrazione
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $nome = $_POST['nome'];
    $cognome = $_POST['cognome'];
    $sesso =$_POST['sesso'];
    $metodoPagamento = $_POST['metodoPagamento'];
    $mail = $_POST['mail'];
    $numeroTelefono = $_POST['numeroTelefono'];
    $via = $_POST['via'];
    $stato = $_POST['stato'];
    $citta = $_POST['citta'];
    $CAP = $_POST['CAP'];
    $nomeUtente = $_POST['nomeUtente'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); 

    // Inserimento dati nella tabella UTENTE
    $sqlUtente = "INSERT INTO UTENTE (nome, cognome, sesso, metodoPagamento, mail, numeroTelefono) 
                VALUES ('$nome', '$cognome', '$sesso', '$metodoPagamento', '$mail', '$numeroTelefono')";
    if ($conn->query($sqlUtente) === TRUE) {
        $idUtente = $conn->insert_id;
        echo "<script>console.log('".$idUtente."')';</script>";

        // Inserimento dati nella tabella INDIRIZZO
        $sqlIndirizzo = "INSERT INTO INDIRIZZO (via, stato, citta, CAP, idUtente) 
                        VALUES ('$via', '$stato', '$citta', '$CAP', $idUtente)";
        if ($conn->query($sqlIndirizzo) === TRUE) {
            $idIndirizzo = $conn->insert_id;

            $sqlCarrello = "INSERT INTO CARRELLO (costoAttuale, idUtente)
                            VALUES (0, '$idUtente')";
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
    <style>
        .container {
  max-width: 960px;
}
body {
  padding-bottom: 20px;
}

.navbar {
  margin-bottom: 20px;
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
                        <a class="nav-link" href="pages/pagina_carrello.php">Vai al Carrello</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="pagina_utente.php"><?php echo isset($_SESSION['user_id']) ? 'account' : 'login'; ?></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container mt-5 d-flex justify-content-center align-items-center">
    <div class="border p-3">
        <h2 class="text-center">Registrazione Utente</h2>
            <div class="container-form">
                <div class="row g-5">
                    <div class="col-md-7 col-lg-8">
                        <h4 class="mb-3">Compila I Campi</h4>
                        <form class="needs-validation custom-form" novalidate action="registration.php" method="post">
                            <div class="row g-3">
                                <div class="col-sm-6">
                                <label for="nome" class="form-label">Nome</label>
                                <input type="text" class="form-control" name="nome" placeholder="" value="" required>
                                <div class="invalid-feedback">
                                    Nome non valido!
                                </div>
                                </div>

                                <div class="col-sm-6">
                                <label for="cognome" class="form-label">Cognome</label>
                                <input type="text" class="form-control" name="cognome" placeholder="" value="" required>
                                <div class="invalid-feedback">
                                    Cognome non valido!
                                </div>
                                </div>

                                <div class="col-sm-6">
                                    <label for="numeroTelefono" class="form-label">Numero Di Telefono</label>
                                    <input type="number" class="form-control" name="numeroTelefono" placeholder="333 3333333" required>
                                    <div class="invalid-feedback">
                                        Il tuo numero di cellulare è necessario!
                                    </div>
                                </div>

                                <div class="col-md-5">
                                <label for="sesso" class="form-label">Sesso</label>
                                <select class="form-select" name="sesso" required>
                                    <option value="">scegli</option>
                                    <option value="M" >Maschio</option>
                                    <option value="F">Femmina</option>
                                    <option value="E">Elicottero</option>
                                    <option value="#">Altro</option>
                                </select>
                                <div class="invalid-feedback">
                                    Scegli un opzione.
                                </div>
                                </div>
                                
                                <div class="col-12">
                                <label for="Telefono" class="form-label">E-mail</label>
                                <div class="input-group has-validation">
                                    <span class="input-group-text">@</span>
                                    <input type="text" class="form-control" name="mail" placeholder="you@example.com" required>
                                <div class="invalid-feedback">
                                    La tua E-mail non è valida!
                                    </div>
                                </div>
                                </div>

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
                                    <label for="CAP" class="form-label">CAP</label>
                                    <input type="number" class="form-control" name="CAP" placeholder="43121" required>
                                    <div class="invalid-feedback">
                                        CAP necessario!
                                    </div>
                                </div>

                                <div class="col-md-7">
                                <label for="metodoPagamento" class="form-label">Metodo di Pagamento</label>
                                <select class="form-select" name="metodoPagamento" required>
                                    <option value="">scegli</option>
                                    <option value="debito">Carta di Debito</option>
                                    <option value="credito">Carta di Credito</option>
                                    <option value="paypal">PAYPAL</option>
                                    <option>Altro</option>
                                </select>
                                <div class="invalid-feedback">
                                    Scegli un opzione.
                                </div>
                                </div>

                                <div class="col-sm-6">
                                <label for="nomeUtente" class="form-label">User</label>
                                <input type="text" class="form-control" name="nomeUtente" placeholder="zucchina93"  required>
                                <div class="invalid-feedback">
                                    User non valido!
                                </div>
                                </div>

                                <div class="col-sm-6">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" name="password" placeholder="" value="" required>
                                <div class="invalid-feedback">
                                    Password richiesta!
                                </div>
                                </div>

                            <input type="submit" value="Registrati" class="btn btn-primary">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        (() => {
  'use strict'

  // Fetch all the forms we want to apply custom Bootstrap validation styles to
  const forms = document.querySelectorAll('.needs-validation')

  // Loop over them and prevent submission
  Array.from(forms).forEach(form => {
    form.addEventListener('submit', event => {
      if (!form.checkValidity()) {
        event.preventDefault()
        event.stopPropagation()
      }

      form.classList.add('was-validated')
    }, false)
  })
})()
    </script>
</body>
</html>

<?php
session_start();
include '../config.php';

function getDettagliUtente($idUtente)
{
    global $conn;
    $sql_c = "SELECT * FROM CREDENZIALI WHERE idUtente = $idUtente";
    $result_c = $conn->query($sql_c);

    if ($result_c->num_rows > 0) {
        while ($row_c = $result_c->fetch_assoc()) {
            $_SESSION['nUtente'] = $row_c["nomeUtente"];
        }

    }
    // Dettagli utente
    $sql_utente = "SELECT * FROM UTENTE WHERE idUtente = $idUtente";
    $result_utente = $conn->query($sql_utente);

    if ($result_utente->num_rows > 0) {
        while ($row_utente = $result_utente->fetch_assoc()) {
            $nome = $row_utente["nome"];
            $cognome = $row_utente["cognome"];
            $sesso = $row_utente["sesso"];
            $pagamento = $row_utente["metodoPagamento"];
            $mail = $row_utente["mail"];
            $numeroTelefono = $row_utente["numeroTelefono"];

            $_SESSION['nome']=$nome;
            $_SESSION['cognome']=$cognome;
            if($sesso=='M'){$_SESSION['sesso']='Maschio';}elseif($sesso=='F'){$_SESSION['sesso']='Femmina';}elseif($sesso=='E'){$_SESSION['sesso']='<a href="https://youtu.be/SOpzYqRwqfg" target="_blank">:-O</a>';}else{$_SESSION['sesso']='na\'cifra';}
            $_SESSION['pagamento']=$pagamento;
            $_SESSION['mail']=$mail;
            $_SESSION['telefono']=$numeroTelefono;
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

            $_SESSION['stato']=$stato;
            $_SESSION['citta']=$citta;
            $_SESSION['indirizzo']=$via.", ". $cap.", ". $citta .", ". $stato ;
        }
    } else {
        echo "Nessun indirizzo trovato.";
    }

    
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

function getOrdiniUtente($idUtente){
  
  global $conn;
  // Ordini effettuati dall'utente
  $sql_ordini = "SELECT * FROM ORDINE WHERE idUtente = $idUtente";
  $result_ordini = $conn->query($sql_ordini);
  
  if ($result_ordini->num_rows > 0) {
      echo "<h2>Ordini Effettuati</h2>";
      while ($row_ordine = $result_ordini->fetch_assoc()) {
          $idOrdine = $row_ordine["idOrdine"];
          $data = $row_ordine["data"];
          $costoTotale = $row_ordine["costoTotale"];

          /* echo "Data: $data - ";
          
          // Aggiungi un pulsante per visualizzare i dettagli dell'ordine
          echo "<form action='pagina_dettagli_ordine.php' method='post'>";
          echo "<input type='hidden' name='idOrdine' value='$idOrdine'>";
          echo "<input type='submit' name='dettagliOrdine' value='Dettagli Ordine'>";
          echo "</form>"; */

          echo "<li class='list-group-item d-flex justify-content-between align-items-center p-3'>
                  <i class='fas fa-globe fa-lg text-warning'></i>
                  <p class='mb-0'>$data <form action='pagina_dettagli_ordine.php' method='post'><input type='hidden' name='idOrdine' value='$idOrdine'><input type='submit' class='btn btn-primary' name='dettagliOrdine' value='Dettagli Ordine'></form></p>
              </li>"; 
      }
  } else {
      echo "Nessun ordine effettuato.";
  }
}

?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>SIUM</title>
    <style>
      input {
        margin-top: 10px;
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
    <br>
    <h3>Dettagli Utente</h3>
    <section style="background-color: #eee;">
    <div class="row">
      <div class="col-lg-4">
        <div class="card mb-4">
          <div class="card-body text-center">
            <h5 class="my-3"><?php echo $_SESSION['nUtente'];?></h5>
            <p class="text-muted mb-4"><?php echo $_SESSION['stato'].", ".$_SESSION['citta'];?></p>
            <div class="d-flex justify-content-center mb-2">
              <form action="" method='post' >
                <input type="submit" class="btn btn-secondary" name="logout" value='LOGOUT'>
              </form>
            </div>
          </div>
        </div>
        <div class="card mb-4 mb-lg-0">
            <div class="card-body p-0">
                <ul class="list-group list-group-flush rounded-3">                
                <?php if(isset($idUtente)){ getOrdiniUtente($idUtente);}?>
                </ul>
            </div>
            </div>
        </div>
      <div class="col-lg-8">
        <div class="card mb-4">
          <div class="card-body">
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Nome</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0"><?php echo $_SESSION['nome']." ".$_SESSION['cognome'];?></p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Sesso</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0"><?php echo $_SESSION['sesso'];?></p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Email</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0"><?php echo $_SESSION['mail'];?></p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Telefono</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0"><?php echo $_SESSION['telefono'];?></p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Indirizzo Completo</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0"><?php echo $_SESSION['indirizzo'];?></p>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</section>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php 
  $conn->close();
?>


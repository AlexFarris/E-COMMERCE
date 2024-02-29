<?php
session_start();
include '../config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dettagli Prodotto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            padding-top: 60px;
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

<div class="container mt-5">
    <?php
    if (isset($_GET['id'])) {
        $idProdotto = $_GET['id'];

        $sql = "SELECT * FROM PRODOTTO WHERE idProdotto = $idProdotto";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            ?>

            <h2><?php echo $row["nome"];?></h2>

            <div class="row">
                <div class="col-md-6">
                    <!-- Immagine a sinistra -->
                    <?php
                    $sql_immagine = "SELECT nome FROM IMMAGINE_PRODOTTO WHERE idProdotto = " . $row["idProdotto"];
                    $result_immagine = $conn->query($sql_immagine);
                    $path_immagine = ($result_immagine->num_rows > 0) ? $result_immagine->fetch_assoc()["nome"] : "default.jpg";
                    $static_path_immagini = '../resources/image/' . $path_immagine;
                    ?>
                    <img src="<?= $static_path_immagini ?>" class="img-fluid img-thumbnail" alt="Immagine del prodotto">
                </div>
                <div class="col-md-6">
                    <p> <?= $row["descrizione"] ?>
                    <p  >Prezzo: $<?= $row["prezzo"] ?></p>

                    <form method="post">
                        <input type="hidden" name="idProdotto" value="<?= $row['idProdotto'] ?>">

                        <label for="accessorio">Seleziona Accessorio:</label>
                        <select name="accessorio" id="accessorio" class="form-select">
                            <option value="0">Nessun Accessorio</option>

                            <?php
                            $query_accessori = "SELECT * FROM ACCESSORIO WHERE idProdotto = $idProdotto";
                            $result_accessori = $conn->query($query_accessori);

                            while ($row_accessorio = $result_accessori->fetch_assoc()) {
                                ?>
                                <option value="<?= $row_accessorio['idAccessorio'] ?>">
                                    <?= $row_accessorio['descrizione'] ?> - Prezzo: <?= $row_accessorio['prezzo'] ?>
                                </option>
                                <?php
                            }
                            ?>
                        </select>
                        <br>
                        <button type="submit" name="aggiungiCarrello" class="btn btn-primary">Aggiungi al Carrello</button>
                    </form>
                </div>
            </div>

            <?php
            if (isset($_POST['aggiungiCarrello'])) {
                $user_id = $_SESSION["user_id"];
            $idAccessorio = isset($_POST['accessorio']) ? $_POST['accessorio'] : null;

            if(isset($_SESSION['user_id'])){
                $query_inserimento_carrello = "INSERT INTO CARRELLO_PRODOTTI (idCarrello, idProdotto, idAccessorio) 
                    VALUES ((SELECT idCarrello FROM CARRELLO WHERE idUtente = ?), ?, ?)";
                
                $stmt = $conn->prepare($query_inserimento_carrello);
                $stmt->bind_param("iii", $user_id, $idProdotto, $idAccessorio);
                
                if ($stmt->execute()) {
                    $update_carrello_query = "UPDATE CARRELLO 
                        SET costoAttuale = (
                            SELECT SUM(PRODOTTO.PREZZO) + COALESCE(SUM(ACCESSORIO.PREZZO), 0)
                            FROM CARRELLO_PRODOTTI
                            JOIN PRODOTTO ON CARRELLO_PRODOTTI.idProdotto = PRODOTTO.idProdotto
                            LEFT JOIN ACCESSORIO ON CARRELLO_PRODOTTI.idAccessorio = ACCESSORIO.idAccessorio
                            WHERE CARRELLO_PRODOTTI.idCarrello = (SELECT idCarrello FROM CARRELLO WHERE idUtente = ?)
                        )
                        WHERE idCarrello = (SELECT idCarrello FROM CARRELLO WHERE idUtente = ?)";
                    
                    $stmt_update_carrello = $conn->prepare($update_carrello_query);
                    $stmt_update_carrello->bind_param("ii", $user_id, $user_id);
                    
                    if ($stmt_update_carrello->execute()) {
    
                    } else {
                        echo "Errore durante l'aggiornamento del costo del carrello: " . $conn->error;
                    }

                    $stmt_update_carrello->close();
                }
            } else {
                header("Location: login.php");
                exit(); 
            }

            $stmt->close();
        }
            }

        } else {
            echo "Prodotto non trovato.";
        }
        $conn->close();
    ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

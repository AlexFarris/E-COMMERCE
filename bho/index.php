<?php
session_start();
include 'config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            padding-top: 60px; /* Per adattarsi al fixed navbar */
        }
        .product-container {
            text-align: center;
            margin-bottom: 80px;
        }
        h1{
            text-align: center;
            animation: changeColor 7s infinite; 

        }
        @keyframes changeColor {
            0% {
                color: blue;
            }
            50% {
                color: #50ff50;
            }
            100% {
                color: blue;
            }
        }

    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
        <a class="navbar-brand" href="#">Abdul.com</a>
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
<!-- Offcanvas Filter Sidebar -->
<div class="offcanvas offcanvas-start" tabindex="-1" id="filterSidebar" aria-labelledby="filterSidebarLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="filterSidebarLabel">Filtri</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <?php 
            $query_categorie = "SELECT * FROM CATEGORIA";
            $result_categorie = $conn->query($query_categorie);
        ?>
        <form action='' method='get'>
            <label for='categoria'>Seleziona Categoria:</label>
            <select name='categoria' id='categoria'>
                <option value='0' <?php echo (isset($_GET['categoria']) && $_GET['categoria'] == 0) ? 'selected' : ''; ?>>Tutte le Categorie</option>
                <?php 
                    while ($row_categoria = $result_categorie->fetch_assoc()) {
                        $selected = (isset($_GET['categoria']) && $_GET['categoria'] == $row_categoria['idCategoria']) ? 'selected' : '';
                        echo "<option value='" . $row_categoria['idCategoria'] . "' $selected>" . $row_categoria['nome'] . "</option>";
                    }
                ?>
            </select>

                <label for='prezzoMin'>Prezzo Minimo:</label>
                <input type='number' name='prezzoMin' id='prezzoMin' placeholder='Min' value='<?php echo isset($_GET["prezzoMin"]) ? $_GET["prezzoMin"] : ""; ?>'>

                <label for='prezzoMax'>Prezzo Massimo:</label>
                <input type='number' name='prezzoMax' id='prezzoMax' placeholder='Max' value='<?php echo isset($_GET["prezzoMax"]) ? $_GET["prezzoMax"] : ""; ?>'>

                <button type='submit' class='btn btn-primary mt-2'>Applica Filtri</button>
        </form>
        <?php 
             $prezzoMin = $_GET['prezzoMin']!="" ? $_GET['prezzoMin'] : 0;
            $prezzoMax = $_GET['prezzoMax']!="" ? $_GET['prezzoMax'] : 10000; 
                $prezzoFilter = "";
                $prezzoFilter = "AND CAST(PRODOTTO.prezzo AS DECIMAL(10, 2)) BETWEEN $prezzoMin AND $prezzoMax";

            
            
        ?>
    </div>
    
</div>
<h1>L'E-COMMERCE DEL FUTURO</h1>
<div class="album py-5 bg-body-tertiary">
    <div class="container">
    <?php
    // Query per ottenere tutte le categorie
    $query_categorie = "SELECT * FROM CATEGORIA";
    $result_categorie = $conn->query($query_categorie);
        if ($result_categorie->num_rows > 0) {
            $categoria_selezionata = isset($_GET['categoria']) ? $_GET['categoria'] : 0;

            if ($categoria_selezionata != 0) {
                // Query per ottenere i prodotti solo per la categoria selezionata
                $sql = "SELECT PRODOTTO.idProdotto, PRODOTTO.nome, PRODOTTO.prezzo, PRODOTTO.numeroProdotti
                        FROM PRODOTTO
                        INNER JOIN CATEGORIA_PRODOTTI ON PRODOTTO.idProdotto = CATEGORIA_PRODOTTI.idProdotto
                        WHERE CATEGORIA_PRODOTTI.idCategoria = $categoria_selezionata $prezzoFilter ";
                        
            } else {
                // Se l'utente non seleziona una categoria, mostra tutti i prodotti
                $sql = "SELECT * FROM PRODOTTO WHERE 1=1 $prezzoFilter";
            }

            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Output dei risultati in una tabella
                echo "<div class='row'>";
                ?>
                <?php 
                while ($row = $result->fetch_assoc()) {
                    // Aggiungi JOIN con la tabella IMMAGINE_PRODOTTO
                    $sql_immagine = "SELECT nome FROM IMMAGINE_PRODOTTO WHERE idProdotto = " . $row["idProdotto"];
                    $result_immagine = $conn->query($sql_immagine);
                    $path_immagine = ($result_immagine->num_rows > 0) ? $result_immagine->fetch_assoc()["nome"] : "default.jpg";
                    $static_path_immagini = 'resources/image/' . $path_immagine;
        
                    // Visualizzazione del singolo prodotto
                    echo "<div class='col-4'>
                            <div class='card shadow-sm'>
                                <img src='$static_path_immagini' class='bd-placeholder-img card-img-top' width='100%' height='225' xmlns='http://www.w3.org/2000/svg' role='img' aria-label='Placeholder: Thumbnail' preserveAspectRatio='xMidYMid slice' focusable='false'>
                                <div class='card-body'>
                                    <p class='card-text'>" . $row["nome"] . "</p>
                                    <div class='d-flex justify-content-between align-items-center'>
                                        <div class='btn-group'>
                                            <button type='button' class='btn btn-sm btn-outline-secondary' onclick=\"window.location='pages/pagina_articolo.php?id=" . $row["idProdotto"] . "'\">Visualizza</button>
                                        </div>
                                        <small class='text-body-secondary'>" . $row["numeroProdotti"] . " Rimanenti</small>
                                    </div>
                                </div>
                            </div>
                        </div>";
                
                }
                
                echo "</div>"; // Chiudi la riga Bootstrap
            }
        }
    $conn->close();
    ?>


<!-- Includi Bootstrap JS e Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


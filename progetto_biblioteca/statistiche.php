
<?php
require_once("strumenti/connect.php"); // Connessione al DB
include("strumenti/navbar.php");       // Navbar

$anno = "";
$totale_libri = null;

// conteggio libri per anno scelto dall'utente
if (isset($_GET['anno']) && is_numeric($_GET['anno'])) {
    $anno =  $_GET['anno'];
    $queryAnno = "SELECT COUNT(*) AS totale_libri FROM Libro WHERE anno_pubblicazione = $anno";
    $resultAnno = mysqli_query($link, $queryAnno);

    //$resultAnno non contiene direttamente il numero, è un oggetto di tipo mysqli_result
    if ($resultAnno && mysqli_num_rows($resultAnno) > 0) {
        //prendo il conteggio dei libri per l'anno selezionato, estraggo la colonna 'totale_libri'
        //row è un array associativo, devo estrarre il valore della chiave 'totale_libri'
        $row = mysqli_fetch_assoc($resultAnno);
        $totale_libri = $row['totale_libri'];
    }
}

// conteggio libri per autore
$queryAutori = "
    SELECT A.nome, A.cognome, COUNT(*) AS numero_libri
    FROM Autore A
    JOIN AutoreLibro AL ON A.id_autore = AL.id_autore
    GROUP BY A.id_autore
";
$resultAutori = mysqli_query($link, $queryAutori);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Statistiche Libri</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

<h2>Statistiche sulla Biblioteca</h2>


<a href="statistiche_succursale.php">
    <button class="button">Statistiche per Succursale</button>
</a>


<form method="GET" action="" style="margin-top: 20px;">
    <label for="anno">Inserisci un anno di pubblicazione:</label>
    <input type="number" name="anno" id="anno" value="<?php echo htmlspecialchars($anno); ?>" required>
    <button type="submit">Cerca</button>
</form>


<?php
if ($anno !== "") {
    echo "<h3>Numero di libri pubblicati nel $anno</h3>";
    echo "<table>";
    echo "<tr><th>Anno</th><th>Totale Libri</th></tr>";
    if ($totale_libri !== null) {
        echo "<tr><td>$anno</td><td>$totale_libri</td></tr>";
    } else {
        echo "<tr><td>$anno</td><td>0</td></tr>";
    }
    echo "</table>";
}
?>


<h3>Numero di libri per Autore</h3>
<?php
if ($resultAutori && mysqli_num_rows($resultAutori) > 0) {
    echo "<table>";
    echo "<tr><th>Nome</th><th>Cognome</th><th>Numero di Libri</th></tr>";
    while ($row = mysqli_fetch_assoc($resultAutori)) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row["nome"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["cognome"]) . "</td>";
        echo "<td>" . $row["numero_libri"] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p class='message'>Nessun autore trovato.</p>";
}
?>

</body>
</html>


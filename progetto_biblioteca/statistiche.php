
<?php
require_once("strumenti/connect.php"); // Connessione al DB
include("strumenti/navbar.php");       // Navbar

$anno = "";
$totale_libri = null;

// Primo blocco: conteggio libri per anno scelto dall'utente
if (isset($_GET['anno']) && is_numeric($_GET['anno'])) {
    $anno = mysqli_real_escape_string($link, $_GET['anno']);
    $queryAnno = "SELECT COUNT(*) AS totale_libri FROM Libro WHERE anno_pubblicazione = $anno";
    $resultAnno = mysqli_query($link, $queryAnno);

    if ($resultAnno && mysqli_num_rows($resultAnno) > 0) {
        $row = mysqli_fetch_assoc($resultAnno);
        $totale_libri = $row['totale_libri'];
    }
}

// Secondo blocco: conteggio libri per autore
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
    <style>
        body { font-family: Arial; padding: 20px; }
        input[type="number"] {
            padding: 8px;
            margin-bottom: 10px;
            width: 120px;
        }
        button {
            padding: 8px 16px;
            margin-right: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        h3 {
            margin-top: 40px;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 15px;
        }
        th, td {
            border: 1px solid #aaa;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #ddd;
        }
        .message {
            margin-top: 15px;
            padding: 10px;
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
            width: fit-content;
        }
    </style>
</head>
<body>

<h2>Statistiche sulla Biblioteca</h2>

<!--Bottone per andare a statistiche_succursale.php -->
<a href="statistiche_succursale.php">
    <button class="button">Statistiche per Succursale</button>
</a>

<!-- Form per selezionare un anno -->
<form method="GET" action="" style="margin-top: 20px;">
    <label for="anno">Inserisci un anno di pubblicazione:</label>
    <input type="number" name="anno" id="anno" value="<?php echo htmlspecialchars($anno); ?>" required>
    <button type="submit">Cerca</button>
</form>

<!-- Tabella 1: Conteggio libri per anno -->
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

<!-- Tabella 2: Conteggio libri per autore -->
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


<?php
require_once("strumenti/connect.php"); // Connessione al DB
include("strumenti/navbar.php");       // Navbar

$nome = "";
$cognome = "";
$result = null;

// veririco sia se sono stati inviati dal form tramite get sia se i campi non sono vuoti
if (isset($_GET["nome"]) && isset($_GET["cognome"]) &&
    !empty(trim($_GET["nome"])) && !empty(trim($_GET["cognome"]))) {

    $nome =  $_GET["nome"];
    $cognome = $_GET["cognome"];

    $query = "
        SELECT A.nome, A.cognome, L.titolo, L.anno_pubblicazione
        FROM Autore A
        JOIN AutoreLibro AL ON A.id_autore = AL.id_autore
        JOIN Libro L ON AL.id_libro = L.id_libro
        WHERE A.cognome = '$cognome' AND A.nome = '$nome'
        ORDER BY L.anno_pubblicazione
    ";

    $result = mysqli_query($link, $query);

    if (!$result) {
        echo "Errore nella query: " . mysqli_error($link);
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Libri per Autore</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h2>Ricerca Libri per Autore</h2>

<form method="GET" action="">
    <label>Nome:</label>
    <input type="text" name="nome" placeholder="Es. Umberto" value="<?php echo htmlspecialchars($nome); ?>">

    <label>Cognome:</label>
    <input type="text" name="cognome" placeholder="Es. Eco" value="<?php echo htmlspecialchars($cognome); ?>">

    <button type="submit">Cerca</button>
    <a href="libri_autore.php"><button type="button" class="exit-btn">Reset</button></a>
</form>

<?php
if ($result !== null) {
    if (mysqli_num_rows($result) > 0) {
        echo "<table>";
        echo "<tr><th>Autore</th><th>Titolo</th><th>Anno di Pubblicazione</th></tr>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row["nome"]) . " " . htmlspecialchars($row["cognome"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["titolo"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["anno_pubblicazione"]) . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p class='message'>Nessun libro trovato per questo autore.</p>";
    }
}
?>

</body>
</html>

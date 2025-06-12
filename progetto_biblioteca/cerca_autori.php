<?php
require_once("strumenti/connect.php"); // Connessione al DB
include("strumenti/navbar.php");       // Navbar

$autore = "";
$query = "SELECT * FROM Autore"; 


if (isset($_GET["autore"]) && !empty(trim($_GET["autore"]))) {
    $autore = $_GET["autore"];
    $query = "SELECT * FROM Autore WHERE nome LIKE '%$autore%' OR cognome LIKE '%$autore%'";
}

$result = mysqli_query($link, $query);

if (!$result) {
    echo "Errore nella query: " . mysqli_error($link);
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Ricerca Autore</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

<h2>Ricerca Autori per Nome o Cognome</h2>

<form method="GET" action="">
    <input type="text" name="autore" placeholder="Inserisci nome o cognome (anche parziale)" value="<?php echo htmlspecialchars($autore); ?>">
    <button type="submit">Cerca</button>
    <button type="button" class="exit-btn" onclick="window.location.href='autori.php'">Esci</button>
</form>

<?php
if (mysqli_num_rows($result) > 0) {
    echo "<table>";
    echo "<tr><th>Nome</th><th>Cognome</th></tr>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row["nome"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["cognome"]) . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p class='message'>Nessun autore trovato.</p>";
}
?>

</body>
</html>

<?php
require_once("strumenti/connect.php"); // Connessione al DB
include("strumenti/navbar.php");         // Navbar
?>

<!DOCTYPE html>
<html>
<head>
    <title>Elenco Autori</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

<h2>Elenco degli Autori</h2>

<a href="cerca_autori.php">
    <button>Ricerca</button>
</a>

<a href="inserisci_autore.php">
    <button>Inserisci Nuovo Autore</button>
</a>

<?php
// Query per ottenere tutti gli autori
$query = "SELECT id_autore, nome, cognome, data_nascita, luogo_nascita FROM Biblioteca.Autore";

$result = mysqli_query($link, $query);

// Verifica se ci sono risultati
if (mysqli_num_rows($result) > 0) {
    echo "<table>";
    echo "<tr><th>ID Autore</th><th>Nome</th><th>Cognome</th><th>Data di Nascita</th><th>Luogo di Nascita</th></tr>";

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row["id_autore"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["nome"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["cognome"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["data_nascita"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["luogo_nascita"]) . "</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "<p class='message'>Nessun autore trovato.</p>";
}
?>

</body>
</html>

<?php
require_once("strumenti/connect.php"); // Connessione al DB
include("strumenti/navbar.php");         // Navbar
?>


<!DOCTYPE html>
<html>
<head>
    <title>Elenco Utenti</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

<h2>Elenco degli Utenti Registrati</h2>

<a href="nuovo_utente.php">
    <button>Aggiungi Nuovo Utente</button>
</a>

<a href="storico_utente.php">
    <button>Ricerca</button>
</a>


<?php
// Query per ottenere tutti gli utenti
$query = "SELECT matricola, nome, cognome, indirizzo, telefono FROM Biblioteca.Utente";

$result = mysqli_query($link, $query);

// Verifica se ci sono risultati
if (mysqli_num_rows($result) > 0) {
    echo "<table>";
    echo "<tr><th>Matricola</th><th>Nome</th><th>Cognome</th><th>Indirizzo</th><th>Telefono</th></tr>";

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row["matricola"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["nome"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["cognome"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["indirizzo"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["telefono"]) . "</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "<p class='message'>Nessun utente trovato.</p>";
}
?>

</body>
</html>

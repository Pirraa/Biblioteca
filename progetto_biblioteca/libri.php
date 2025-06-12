<?php
require_once("strumenti/connect.php"); // Connessione al DB
include("strumenti/navbar.php");       // Navbar
?>

<!DOCTYPE html>
<html>
<head>
    <title>Elenco Libri</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h2>Elenco dei Libri in Biblioteca</h2>

<a href="nuovo_libro.php">
    <button>Aggiungi Nuovo Libro</button>
</a>

<a href="cerca_libro.php">
    <button>Ricerca Libro</button>
</a>

<a href="libri_autore.php">
    <button>Ricerca Libro Autore</button>
</a>

<?php

$query = "SELECT 
              l.titolo,
              l.ISBN,
              l.anno_pubblicazione,
              l.lingua, 
              GROUP_CONCAT(DISTINCT CONCAT(a.nome, ' ', a.cognome) SEPARATOR ', ') AS autori,
              COUNT(c.id_copia) AS numero_copie
          FROM Biblioteca.Libro l
          LEFT JOIN Biblioteca.AutoreLibro al ON l.ISBN = al.ISBN
          LEFT JOIN Biblioteca.Autore a ON al.id_autore = a.id_autore
          LEFT JOIN Biblioteca.CopiaLibro c ON l.ISBN = c.ISBN
          GROUP BY l.ISBN";

$result = mysqli_query($link, $query);

// Verifica se ci sono risultati
if (mysqli_num_rows($result) > 0) {
    echo "<table>";
    echo "<tr><th>Titolo</th><th>ISBN</th><th>Anno Pubblicazione</th><th>Lingua</th><th>Autori</th><th>Numero Copie</th></tr>";

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row["titolo"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["ISBN"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["anno_pubblicazione"]) . "</td>";
        // echo "<td>" . htmlspecialchars($row["succursale"]) . "</td>"; 
        echo "<td>" . htmlspecialchars($row["lingua"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["autori"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["numero_copie"]) . "</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "<p class='message'>Nessun libro trovato.</p>";
}
?>

</body>
</html>


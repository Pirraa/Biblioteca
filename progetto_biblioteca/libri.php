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
// Query per ottenere tutti i libri
//$query = "SELECT titolo, ISBN, anno_pubblicazione, succursale, lingua FROM Biblioteca.Libro";



// Query per ottenere tutti i libri con i nomi degli autori
//per avere una unica riga devo usare concat, altrimenti la posso togliere ma metto una colonna per nome e una per cognome e una riga per ogni autore
$query = "SELECT l.titolo, l.ISBN, l.anno_pubblicazione, l.succursale, l.lingua, 
                 GROUP_CONCAT(CONCAT(a.nome, ' ', a.cognome) SEPARATOR ', ') AS autori
          FROM Biblioteca.Libro l
          LEFT JOIN Biblioteca.AutoreLibro al ON l.id_libro = al.id_libro
          LEFT JOIN Biblioteca.Autore a ON al.id_autore = a.id_autore
          GROUP BY l.id_libro";

$result = mysqli_query($link, $query);

// Verifica se ci sono risultati
if (mysqli_num_rows($result) > 0) {
    echo "<table>";
    echo "<tr><th>Titolo</th><th>ISBN</th><th>Anno Pubblicazione</th><th>Succursale</th><th>Lingua</th><th>Autori</th></tr>";

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row["titolo"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["ISBN"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["anno_pubblicazione"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["succursale"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["lingua"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["autori"]) . "</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "<p class='message'>Nessun libro trovato.</p>";
}
?>

</body>
</html>

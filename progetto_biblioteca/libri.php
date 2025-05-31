<?php
require_once("strumenti/connect.php"); // Connessione al DB
include("strumenti/navbar.php");         // Navbar
?>

<!DOCTYPE html>
<html>
<head>
    <title>Elenco Libri</title>
    <style>
        body { font-family: Arial; padding: 20px; }
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #aaa;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #ddd;
        }
        button {
            background-color: #28a745;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

<h2>Elenco dei libri</h2>

<a href="nuovo_libro.php">
    <button>Aggiungi Nuovo Libro</button>
</a>

<a href="cerca_libro.php">
    <button>Ricerca Libro</button>
</a>


<?php
// Query per ottenere tutti i libri con i nuovi campi
$query = "SELECT id_libro, ISBN, titolo, anno_pubblicazione, succursale, lingua FROM Biblioteca.Libro";

$result = mysqli_query($link, $query);

// Verifica se ci sono risultati
if (mysqli_num_rows($result) > 0) {
    echo "<table>";
    echo "<tr>
            <th>ID Libro</th>
            <th>ISBN</th>
            <th>Titolo</th>
            <th>Anno Pubblicazione</th>
            <th>Succursale</th>
            <th>Lingua</th>
          </tr>";

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row["id_libro"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["ISBN"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["titolo"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["anno_pubblicazione"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["succursale"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["lingua"]) . "</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "<p>Nessun libro trovato.</p>";
}
?>

</body>
</html>

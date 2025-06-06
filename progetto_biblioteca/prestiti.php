<?php
require_once("strumenti/connect.php"); // Connessione al DB
include("strumenti/navbar.php");         // Navbar
?>


<!DOCTYPE html>
<html>
<head>
    <title>Elenco Prestiti</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

<h2>Elenco dei Prestiti</h2>

<a href="inserisci_prestito.php">
    <button>Aggiungi Nuovo Prestito</button>
</a>

<a href="cancella_prestito.php">
    <button>Cancella Prestito</button>
</a>

<a href="prestiti_per_data.php">
    <button>Informazioni Prestiti</button>
</a>

<?php
// Query per ottenere tutti i dati della tabella Prestito con il titolo del libro
$query = "
    SELECT 
        Prestito.matricola,
        Prestito.succursale,
        Prestito.data_uscita,
        Prestito.data_restituzione_prevista,
        Libro.titolo AS nome_libro
    FROM 
        Biblioteca.Prestito
    JOIN 
        Biblioteca.Libro ON Prestito.id_libro = Libro.id_libro
";

$result = mysqli_query($link, $query);

// Verifica se ci sono risultati
if (mysqli_num_rows($result) > 0) {
    echo "<table>";
    echo "<tr>
            <th>Nome Libro</th>
            <th>Matricola Utente</th>
            <th>Succursale</th>
            <th>Data Uscita</th>
            <th>Data Restituzione Prevista</th>
          </tr>";

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row["nome_libro"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["matricola"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["succursale"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["data_uscita"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["data_restituzione_prevista"]) . "</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "<p class='message'>Nessun prestito trovato.</p>";
}
?>

</body>
</html>

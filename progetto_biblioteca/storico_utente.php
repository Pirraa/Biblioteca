<?php
require_once("strumenti/connect.php"); // Connessione al DB
include("strumenti/navbar.php");         // Navbar
?>

<!DOCTYPE html>
<html>
<head>
    <title>Storico Utente</title>
    <style>
        body { font-family: Arial; padding: 20px; }
        form input { margin-right: 10px; }
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
            background-color: #eee;
        }
    </style>
</head>
<body>

<h2>Ricerca Storico Prestiti per Matricola</h2>

<a href="index.php">
    <button style="padding: 8px 16px; font-size: 14px; background-color: #dc3545; color: white; border: none; cursor: pointer;">
        Esci
    </button>
</a>

<form method="POST" action="">
    <label for="matricola">Matricola:</label>
    <input type="text" name="matricola" id="matricola" required>
    <button type="submit">Cerca</button>
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $matricola = $_POST['matricola'];

    // Query per ottenere lo storico dei prestiti
    $sql = "SELECT U.nome, U.cognome, P.data_uscita, P.data_restituzione_prevista, L.titolo, P.succursale
            FROM Utente U
            JOIN Prestito P ON U.matricola = P.matricola
            JOIN Libro L ON P.id_libro = L.id_libro
            WHERE U.matricola = '$matricola'
            ORDER BY P.data_uscita DESC";

    $query = mysqli_query($link, $sql);

    if (!$query) {
        echo "<p>Si è verificato un errore: " . mysqli_error($link) . "</p>";
        exit;
    }

    if (mysqli_num_rows($query) > 0) {
        echo "<h3>Storico prestiti per matricola <strong>$matricola</strong>:</h3>";
        echo "<table>";
        echo "<tr><th>Nome</th><th>Cognome</th><th>Data Uscita</th><th>Data Restituzione</th><th>Titolo Libro</th><th>Succursale</th></tr>";

        while ($row = mysqli_fetch_assoc($query)) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row["nome"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["cognome"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["data_uscita"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["data_restituzione_prevista"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["titolo"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["succursale"]) . "</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "<p>Nessun prestito trovato per questa matricola.</p>";
    }

    mysqli_close($link);
}
?>

</body>
</html>


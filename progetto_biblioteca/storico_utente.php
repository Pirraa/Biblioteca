<?php
require_once("strumenti/connect.php"); // Connessione al DB
include("strumenti/navbar.php");         // Navbar
?>

<!DOCTYPE html>
<html>
<head>
    <title>Storico Utente</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

<h2>Ricerca Storico Prestiti per Matricola</h2>

<form method="POST" action="">
    <label for="matricola">Matricola:</label>
    <input type="text" name="matricola" id="matricola" required>
    <button type="submit">Cerca</button>
    <button type="button" class="exit-btn" onclick="window.location.href='utenti.php'">
        Esci
    </button>
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['matricola'])) {
    $matricola = mysqli_real_escape_string($link, $_POST['matricola']);


    $sql = "
        SELECT U.nome, U.cognome, P.data_uscita, P.data_restituzione_prevista, L.titolo, C.succursale
        FROM Biblioteca.Utente U
        JOIN Biblioteca.Prestito P ON U.matricola = P.matricola
        JOIN Biblioteca.CopiaLibro C ON P.id_copia = C.id_copia
        JOIN Biblioteca.Libro L ON C.ISBN = L.ISBN
        WHERE U.matricola = '$matricola'
        ORDER BY P.data_uscita DESC
    ";

    $query = mysqli_query($link, $sql);

    if (!$query) {
        echo "<p class='message'>Si è verificato un errore: " . htmlspecialchars(mysqli_error($link)) . "</p>";
        exit;
    }

    if (mysqli_num_rows($query) > 0) {
        echo "<h3>Storico prestiti per matricola <strong>" . htmlspecialchars($matricola) . "</strong>:</h3>";
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
        echo '<p class="message">Nessun prestito trovato per questa matricola.</p>';
    }

    mysqli_close($link);
}
?>

</body>
</html>

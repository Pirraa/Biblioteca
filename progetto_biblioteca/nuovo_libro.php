<?php
require_once("strumenti/connect.php"); // Connessione al DB
include("strumenti/navbar.php");       // Navbar

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Leggo i dati inviati dal form
    $isbn = $_POST["isbn"];
    $titolo = $_POST["titolo"];
    $anno_pubblicazione = $_POST["anno_pubblicazione"];
    $succursale = $_POST["succursale"];
    $lingua = $_POST["lingua"];

    // Creo la query SQL
    $sql = "INSERT INTO Libro (ISBN, titolo, anno_pubblicazione, succursale, lingua)
            VALUES ('$isbn', '$titolo', '$anno_pubblicazione', '$succursale', '$lingua')";

    // Eseguo la query
    $query = mysqli_query($link, $sql);

    if (!$query) {
        echo "Si è verificato un errore: " . mysqli_error($link);
        exit;
    }

    mysqli_close($link);

    // Reindirizzamento alla pagina libri
    header("Location: libri.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Nuovo Libro</title>
    <style>
        body { font-family: Arial; padding: 20px; }
        form input, form select { margin-bottom: 10px; display: block; padding: 8px; width: 300px; }
        label { font-weight: bold; margin-top: 10px; }
        button {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px 16px;
            cursor: pointer;
        }
        button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

<h2>Inserisci un Nuovo Libro</h2>

<a href="libri.php">
    <button style="background-color: #dc3545;">Esci</button>
</a>

<form method="POST" action="">
    <label>ISBN:</label>
    <input type="text" name="isbn" required>

    <label>Titolo:</label>
    <input type="text" name="titolo" required>

    <label>Anno di Pubblicazione:</label>
    <input type="number" name="anno_pubblicazione" required>

    <label>Succursale:</label>
    <input type="text" name="succursale" required>

    <label>Lingua:</label>
    <input type="text" name="lingua" required>

    <button type="submit">Inserisci</button>
</form>

</body>
</html>

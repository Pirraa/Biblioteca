<?php
require_once("strumenti/connect.php"); // Connessione al DB
include("strumenti/navbar.php");       // Navbar

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Leggo i dati inviati dal form
    $nome = $_POST["nome"];
    $cognome = $_POST["cognome"];
    $data_nascita = $_POST["data_nascita"];
    $luogo_nascita = $_POST["luogo_nascita"];

    // Creo la query SQL
    $sql = "INSERT INTO Autore (nome, cognome, data_nascita, luogo_nascita)
            VALUES ('$nome', '$cognome', '$data_nascita', '$luogo_nascita')";

    // Eseguo la query
    $query = mysqli_query($link, $sql);

    if (!$query) {
        echo "Si è verificato un errore: " . mysqli_error($link);
        exit;
    }

    mysqli_close($link);

    // Reindirizzamento alla pagina autori
    header("Location: autori.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Nuovo Autore</title>
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
        .exit-btn {
            background-color: #dc3545;
            margin-left: 10px;
        }
        .exit-btn:hover {
            background-color: #b02a37;
        }
    </style>
</head>
<body>

<h2>Inserisci un Nuovo Autore</h2>

<form method="POST" action="">
    <label>Nome:</label>
    <input type="text" name="nome" required>

    <label>Cognome:</label>
    <input type="text" name="cognome" required>

    <label>Data di Nascita:</label>
    <input type="date" name="data_nascita" required>

    <label>Luogo di Nascita:</label>
    <input type="text" name="luogo_nascita" required>

    <button type="submit">Inserisci</button>
    <button type="button" class="exit-btn" onclick="window.location.href='autori.php'">Esci</button>
</form>

</body>
</html>

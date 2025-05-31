<?php
require_once("strumenti/connect.php"); // Connessione al DB
include("strumenti/navbar.php");         // Navbar


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Leggo i dati inviati dal form
    $matricola = $_POST["matricola"];
    $nome = $_POST["nome"];
    $cognome = $_POST["cognome"];
    $indirizzo = $_POST["indirizzo"];
    $telefono = $_POST["telefono"];

    // Creo la query SQL manualmente
    $sql = "INSERT INTO Utente (matricola, nome, cognome, indirizzo, telefono)
            VALUES ('$matricola', '$nome', '$cognome', '$indirizzo', '$telefono')";

    // Eseguo la query
    $query = mysqli_query($link, $sql);

    if (!$query) {
        echo "Si è verificato un errore: " . mysqli_error($link);
        exit;
    }

    mysqli_close($link);

    // Reindirizzamento alla pagina utenti
    header("Location: utenti.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Nuovo Utente</title>
    <style>
        body { font-family: Arial; padding: 20px; }
        form input { margin-bottom: 10px; display: block; }
        label { font-weight: bold; }
    </style>
</head>
<body>

<h2>Inserisci un Nuovo Utente</h2>

<a href="index.php">
    <button style="padding: 8px 16px; font-size: 14px; background-color: #dc3545; color: white; border: none; cursor: pointer;">
        Esci
    </button>
</a>

<form method="POST" action="">
    <label>Matricola:</label>
    <input type="text" name="matricola" required>

    <label>Nome:</label>
    <input type="text" name="nome" required>

    <label>Cognome:</label>
    <input type="text" name="cognome" required>

    <label>Indirizzo:</label>
    <input type="text" name="indirizzo" required>

    <label>Telefono:</label>
    <input type="text" name="telefono" required>

    <button type="submit">Inserisci</button>
</form>

</body>
</html>

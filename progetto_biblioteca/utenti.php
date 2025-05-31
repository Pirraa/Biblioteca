<?php
require_once("strumenti/connect.php"); // Connessione al DB
include("strumenti/navbar.php");         // Navbar
?>


<!DOCTYPE html>
<html>
<head>
    <title>Elenco Utenti</title>
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
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        a{
            text-decoration: none;
            margin-right: 10px;
        }
        .message {
            margin-top: 15px;
            padding: 10px;
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
            width: fit-content;
        }
    </style>
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

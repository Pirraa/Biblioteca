<?php
require_once("strumenti/connect.php"); // Connessione al DB
include("strumenti/navbar.php");         // Navbar
?>

<!DOCTYPE html>
<html>
<head>
    <title>Elenco Autori</title>
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

<h2>Elenco degli Autori</h2>

<a href="cerca_autori.php">
    <button>Ricerca</button>
</a>

<a href="inserisci_autore.php">
    <button>Inserisci Nuovo Autore</button>
</a>

<?php
// Query per ottenere tutti gli autori
$query = "SELECT id_autore, nome, cognome, data_nascita, luogo_nascita FROM Biblioteca.Autore";

$result = mysqli_query($link, $query);

// Verifica se ci sono risultati
if (mysqli_num_rows($result) > 0) {
    echo "<table>";
    echo "<tr><th>ID Autore</th><th>Nome</th><th>Cognome</th><th>Data di Nascita</th><th>Luogo di Nascita</th></tr>";

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row["id_autore"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["nome"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["cognome"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["data_nascita"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["luogo_nascita"]) . "</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "<p class='message'>Nessun autore trovato.</p>";
}
?>

</body>
</html>

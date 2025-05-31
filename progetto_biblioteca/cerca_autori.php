<?php
require_once("strumenti/connect.php"); // Connessione al DB
include("strumenti/navbar.php");       // Navbar

$autore = "";
$query = "SELECT * FROM Autore"; // Default query

// Se è stato inviato un autore tramite GET
if (isset($_GET["autore"]) && !empty(trim($_GET["autore"]))) {
    $autore = mysqli_real_escape_string($link, $_GET["autore"]);
    $query = "SELECT * FROM Autore WHERE nome LIKE '%$autore%' OR cognome LIKE '%$autore%'";
}

$result = mysqli_query($link, $query);

if (!$result) {
    echo "Errore nella query: " . mysqli_error($link);
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Ricerca Autore</title>
    <style>
        body { font-family: Arial; padding: 20px; }
        input[type="text"] {
            padding: 8px;
            width: 300px;
            margin-bottom: 10px;
        }
        button {
            padding: 8px 16px;
            background-color: #28a745;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #28a745;
        }
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
         .exit-btn {
            background-color: #dc3545;
            margin-left: 10px;
        }
        .exit-btn:hover {
            background-color: #b02a37;
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

<h2>Ricerca Autori per Nome o Cognome</h2>

<form method="GET" action="">
    <input type="text" name="autore" placeholder="Inserisci nome o cognome (anche parziale)" value="<?php echo htmlspecialchars($autore); ?>">
    <button type="submit">Cerca</button>
    <button type="button" class="exit-btn" onclick="window.location.href='autori.php'">Esci</button>
</form>

<?php
if (mysqli_num_rows($result) > 0) {
    echo "<table>";
    echo "<tr><th>Nome</th><th>Cognome</th></tr>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row["nome"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["cognome"]) . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p class='message'>Nessun autore trovato.</p>";
}
?>

</body>
</html>

<?php
require_once("strumenti/connect.php"); // Connessione al DB
include("strumenti/navbar.php");       // Navbar

$titolo = "";
$query = "SELECT * FROM Libro"; // Default query

// Se è stato inviato un titolo tramite GET
if (isset($_GET["titolo"]) && !empty(trim($_GET["titolo"]))) {
    $titolo = mysqli_real_escape_string($link, $_GET["titolo"]);
    $query = "SELECT * FROM Libro WHERE titolo LIKE '%$titolo%'";
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
    <title>Ricerca Libro</title>
    <style>
        body { font-family: Arial; padding: 20px; }
        input[type="text"] {
            padding: 8px;
            width: 300px;
            margin-bottom: 10px;
        }
        button {
            padding: 8px 16px;
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
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
    </style>
</head>
<body>

<h2>Ricerca Libri per Titolo</h2>

<form method="GET" action="">
    <input type="text" name="titolo" placeholder="Inserisci titolo (anche parziale)" value="<?php echo htmlspecialchars($titolo); ?>">
    <button type="submit">Cerca</button>
    <a href="cerca_libro.php"><button type="button" style="background-color:#6c757d;">Reset</button></a>
</form>

<?php
if (mysqli_num_rows($result) > 0) {
    echo "<table>";
    echo "<tr><th>Titolo</th><th>ISBN</th><th>Anno</th><th>Succursale</th><th>Lingua</th></tr>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row["titolo"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["ISBN"]) . "</td>";
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

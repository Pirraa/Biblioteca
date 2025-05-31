<?php
require_once("strumenti/connect.php"); // Connessione al DB
include("strumenti/navbar.php");       // Navbar

$nome = "";
$cognome = "";
$result = null;

// Se sono stati forniti nome e cognome dell'autore
if (isset($_GET["nome"]) && isset($_GET["cognome"]) &&
    !empty(trim($_GET["nome"])) && !empty(trim($_GET["cognome"]))) {

    $nome = mysqli_real_escape_string($link, $_GET["nome"]);
    $cognome = mysqli_real_escape_string($link, $_GET["cognome"]);

    $query = "
        SELECT A.nome, A.cognome, L.titolo, L.anno_pubblicazione
        FROM Autore A
        JOIN AutoreLibro AL ON A.id_autore = AL.id_autore
        JOIN Libro L ON AL.id_libro = L.id_libro
        WHERE A.cognome = '$cognome' AND A.nome = '$nome'
        ORDER BY L.anno_pubblicazione
    ";

    $result = mysqli_query($link, $query);

    if (!$result) {
        echo "Errore nella query: " . mysqli_error($link);
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Libri per Autore</title>
    <style>
        body { font-family: Arial; padding: 20px; }
        input[type="text"] {
            padding: 8px;
            width: 250px;
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

<h2>Ricerca Libri per Autore</h2>

<form method="GET" action="">
    <label>Nome:</label>
    <input type="text" name="nome" placeholder="Es. Umberto" value="<?php echo htmlspecialchars($nome); ?>">

    <label>Cognome:</label>
    <input type="text" name="cognome" placeholder="Es. Eco" value="<?php echo htmlspecialchars($cognome); ?>">

    <button type="submit">Cerca</button>
    <a href="libri_autore.php"><button type="button" style="background-color:#6c757d;">Reset</button></a>
</form>

<?php
if ($result !== null) {
    if (mysqli_num_rows($result) > 0) {
        echo "<table>";
        echo "<tr><th>Autore</th><th>Titolo</th><th>Anno di Pubblicazione</th></tr>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row["nome"]) . " " . htmlspecialchars($row["cognome"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["titolo"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["anno_pubblicazione"]) . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>Nessun libro trovato per questo autore.</p>";
    }
}
?>

</body>
</html>

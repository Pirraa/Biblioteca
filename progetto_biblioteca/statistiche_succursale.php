<?php
require_once("strumenti/connect.php");
include("strumenti/navbar.php");

$data_inizio = "";
$data_fine = "";
$result = null;
$error = "";

// Gestione form
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['data_inizio'], $_GET['data_fine'])) {
    $data_inizio = mysqli_real_escape_string($link, $_GET['data_inizio']);
    $data_fine = mysqli_real_escape_string($link, $_GET['data_fine']);

    if (!empty($data_inizio) && !empty($data_fine)) {
        $query = "
            SELECT succursale, COUNT(*) AS numero_prestiti
            FROM Prestito
            WHERE data_uscita BETWEEN '$data_inizio' AND '$data_fine'
            GROUP BY succursale
        ";
        $result = mysqli_query($link, $query);

        if (!$result) {
            $error = "Errore durante l'esecuzione della query: " . mysqli_error($link);
        }
    } else {
        $error = "Inserire entrambe le date.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Statistiche Prestiti per Succursale</title>
    <style>
        body { font-family: Arial; padding: 20px; }
        form input {
            margin: 10px 5px;
            padding: 8px;
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
        .error { color: red; }
    </style>
</head>
<body>

<h2>Statistiche Prestiti per Succursale</h2>

<form method="GET" action="">
    <label>Data Inizio:</label>
    <input type="date" name="data_inizio" value="<?php echo htmlspecialchars($data_inizio); ?>" required>

    <label>Data Fine:</label>
    <input type="date" name="data_fine" value="<?php echo htmlspecialchars($data_fine); ?>" required>

    <button type="submit">Visualizza</button>
</form>

<?php
if (!empty($error)) {
    echo "<p class='error'>$error</p>";
}

if ($result && mysqli_num_rows($result) > 0) {
    echo "<h3>Risultati</h3>";
    echo "<table>";
    echo "<tr><th>Succursale</th><th>Numero Prestiti</th></tr>";

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row["succursale"]) . "</td>";
        echo "<td>" . $row["numero_prestiti"] . "</td>";
        echo "</tr>";
    }

    echo "</table>";
} elseif ($result && mysqli_num_rows($result) === 0) {
    echo "<p>Nessun prestito trovato per l'intervallo selezionato.</p>";
}
?>

</body>
</html>

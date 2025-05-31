<?php
require_once("strumenti/connect.php"); // Connessione al DB
include("strumenti/navbar.php");      // Navbar

$message = "";
$results = [];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cerca_prestiti'])) {
    $data_inizio = !empty($_POST['data_inizio']) ? mysqli_real_escape_string($link, $_POST['data_inizio']) : null;
    $data_fine = !empty($_POST['data_fine']) ? mysqli_real_escape_string($link, $_POST['data_fine']) : null;

    if ($data_inizio && $data_fine) {
        // Query con intervallo date su data_uscita
        $query = "
            SELECT P.*, U.nome, U.cognome
            FROM Biblioteca.Prestito P
            JOIN Biblioteca.Utente U ON P.matricola = U.matricola
            WHERE P.data_uscita BETWEEN '$data_inizio' AND '$data_fine'
        ";
    } else {
        // Query default: data_restituzione_prevista > oggi
        $query = "
            SELECT P.*, U.nome, U.cognome
            FROM Biblioteca.Prestito P
            JOIN Biblioteca.Utente U ON P.matricola = U.matricola
            WHERE P.data_restituzione_prevista > CURRENT_DATE
            ORDER BY P.data_restituzione_prevista
        ";
    }

    $result = mysqli_query($link, $query);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            $results = mysqli_fetch_all($result, MYSQLI_ASSOC);
        } else {
            $message = "Nessun prestito trovato con i criteri specificati.";
        }
    } else {
        $message = "Errore nella query: " . mysqli_error($link);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Ricerca Prestiti</title>
    <style>
        body { font-family: Arial; padding: 20px; }
        label { display: block; margin-top: 10px; }
        input { padding: 5px; width: 200px; }
        button {
            margin-top: 20px;
            padding: 10px 15px;
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        .exit-btn {
            background-color: #6c757d;
            margin-left: 10px;
        }
        .exit-btn:hover {
            background-color: #5a6268;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #aaa;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #ddd;
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

<h2>Ricerca Prestiti</h2>

<form method="post" action="">
    <label for="data_inizio">Data Inizio (opzionale):</label>
    <input type="date" id="data_inizio" name="data_inizio" value="<?php echo isset($_POST['data_inizio']) ? htmlspecialchars($_POST['data_inizio']) : ''; ?>">

    <label for="data_fine">Data Fine (opzionale):</label>
    <input type="date" id="data_fine"  name="data_fine" value="<?php echo isset($_POST['data_fine']) ? htmlspecialchars($_POST['data_fine']) : ''; ?>">

    <button type="submit" name="cerca_prestiti">Cerca</button>
    <button type="button" class="exit-btn" onclick="window.location.href='prestiti.php'">Esci</button>
</form>

<?php if ($message): ?>
    <div class="message"><?php echo $message; ?></div>
<?php endif; ?>

<?php if (!empty($results)): ?>
    <table>
        <tr>
            <th>ID Libro</th>
            <th>Matricola</th>
            <th>Succursale</th>
            <th>Data Uscita</th>
            <th>Data Restituzione Prevista</th>
            <th>Nome Utente</th>
            <th>Cognome Utente</th>
        </tr>
        <?php foreach ($results as $row): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['id_libro']); ?></td>
                <td><?php echo htmlspecialchars($row['matricola']); ?></td>
                <td><?php echo htmlspecialchars($row['succursale']); ?></td>
                <td><?php echo htmlspecialchars($row['data_uscita']); ?></td>
                <td><?php echo htmlspecialchars($row['data_restituzione_prevista']); ?></td>
                <td><?php echo htmlspecialchars($row['nome']); ?></td>
                <td><?php echo htmlspecialchars($row['cognome']); ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>

</body>
</html>

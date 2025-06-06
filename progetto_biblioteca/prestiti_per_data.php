<?php
require_once("strumenti/connect.php"); // Connessione al DB
include("strumenti/navbar.php");      // Navbar

$message = "";
$results = [];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cerca_prestiti'])) {
    $data_inizio = $_POST['data_inizio'];
    $data_fine = $_POST['data_fine'];

    // Validazioni
    if (($data_inizio && !$data_fine) || (!$data_inizio && $data_fine)) {
        $message = "Se si inserisce una data, entrambe le date devono essere compilate.";
    } elseif ($data_inizio && $data_fine && $data_fine < $data_inizio) {
        $message = "La data di fine deve essere uguale o successiva alla data di inizio.";
    } else {
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
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Ricerca Prestiti</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

<h2>Ricerca Prestiti</h2>

<form method="post" action="">
    <label for="data_inizio">Data Inizio (opzionale):</label>
    <?php
    if (isset($_POST['data_inizio'])) {
        $valore_data_inizio = htmlspecialchars($_POST['data_inizio']);
    } else {
        $valore_data_inizio = '';
    }
    ?>
    <input type="date" id="data_inizio" name="data_inizio" value="<?php echo $valore_data_inizio; ?>">

    <label for="data_fine">Data Fine (opzionale):</label>
    <?php
    if (isset($_POST['data_fine'])) {
        $valore_data_fine = htmlspecialchars($_POST['data_fine']);
    } else {
        $valore_data_fine = '';
    }
    ?>
    <input type="date" id="data_fine" name="data_fine" value="<?php echo $valore_data_fine; ?>">

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

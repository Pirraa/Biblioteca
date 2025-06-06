

<?php
require_once("strumenti/connect.php"); // Connessione al DB
include("strumenti/navbar.php");      // Navbar

$message = "";

$succursali = [];
$result_succursali = mysqli_query($link, "SELECT nome FROM Biblioteca.Succursale ORDER BY nome");
if ($result_succursali) 
{
    while ($row = mysqli_fetch_assoc($result_succursali)) 
    {
        $succursali[] = $row['nome'];
    }
} else {
    $message = "Errore nel recupero delle succursali: " . mysqli_error($link);
    exit;
}

//modifica id libro con nome libro
//metti matricole utenti tutte numeri o tutte lettere

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cancella_prestito'])) {
    // Prendi i dati dal form
    $id_libro =  $_POST['id_libro'];
    $matricola = $_POST['matricola'];
    $succursale =  $_POST['succursale'];
    $data_uscita = $_POST['data_uscita'];

    // Controlli base
    if (empty($id_libro) || empty($matricola) || empty($succursale) || empty($data_uscita)) {
        $message = "Compila tutti i campi obbligatori.";
    } else {
        // Query di cancellazione
        $query = "
            DELETE FROM Biblioteca.Prestito
            WHERE id_libro = '$id_libro' 
              AND matricola = '$matricola' 
              AND succursale = '$succursale' 
              AND data_uscita = '$data_uscita'
        ";

        if (mysqli_query($link, $query)) {
            //controllo righe modificate dall'ultima query con questa funzione
            if (mysqli_affected_rows($link) > 0) {
                $message = "Prestito cancellato con successo!";
            } else {
                $message = "Nessun prestito trovato con i dati specificati.";
            }
        } else {
            $message = "Errore durante la cancellazione: " . mysqli_error($link);
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Elimina Prestito</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

<h2>Elimina Prestito</h2>

<?php if ($message): ?>
    <div class="message"><?php echo htmlspecialchars($message); ?></div>
<?php endif; ?>

<form method="post" action="">
    <label for="id_libro">ID Libro (obbligatorio):</label>
    <input type="number" id="id_libro" name="id_libro" required min="1">

    <label for="matricola">Matricola Utente (obbligatorio):</label>
    <input type="text" id="matricola" name="matricola" required maxlength="6">

    <label>Succursale:</label>
    <select name="succursale" required>
        <?php foreach ($succursali as $succursale): ?>
            <option value="<?php echo htmlspecialchars($succursale); ?>">
                <?php echo htmlspecialchars($succursale); ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label for="data_uscita">Data Uscita (obbligatoria):</label>
    <input type="date" id="data_uscita" name="data_uscita" required>

    <button type="submit" name="cancella_prestito">Elimina Prestito</button>
    <button type="button" class="exit-btn" onclick="window.location.href='prestiti.php'">Esci</button>
</form>

</body>
</html>

<?php
require_once("strumenti/connect.php");
include("strumenti/navbar.php");

$message = "";

// Recupera tutte le succursali
$succursali = [];
$result_succursali = mysqli_query($link, "SELECT nome FROM Biblioteca.Succursale ORDER BY nome");
if ($result_succursali) {
    while ($row = mysqli_fetch_assoc($result_succursali)) {
        $succursali[] = $row['nome'];
    }
} else {
    $message = "Errore nel recupero delle succursali: " . mysqli_error($link);
    exit;
}

// Recupera id_copia e titolo dei libri in prestito
$copie_in_prestito = [];
$query_copie = "
    SELECT DISTINCT P.id_copia, L.titolo
    FROM Biblioteca.Prestito P
    JOIN Biblioteca.CopiaLibro C ON P.id_copia = C.id_copia
    JOIN Biblioteca.Libro L ON C.ISBN = L.ISBN
    ORDER BY P.id_copia";
$result_copie = mysqli_query($link, $query_copie);
if ($result_copie) {
    while ($row = mysqli_fetch_assoc($result_copie)) {
        $copie_in_prestito[] = $row;
    }
} else {
    $message = "Errore nel recupero delle copie in prestito: " . mysqli_error($link);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cancella_prestito'])) {
    $id_copia = $_POST['id_copia'];
    $matricola = $_POST['matricola'];
    $data_uscita = $_POST['data_uscita'];

    if (empty($id_copia) || empty($matricola) || empty($data_uscita)) {
        $message = "Compila tutti i campi obbligatori.";
    } else {
        $query = "
            DELETE FROM Biblioteca.Prestito
            WHERE id_copia = '$id_copia' 
              AND matricola = '$matricola' 
              AND data_uscita = '$data_uscita'
        ";

        if (mysqli_query($link, $query)) {
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
    <label for="id_copia">Seleziona Copia Libro in Prestito:</label>
    <select id="id_copia" name="id_copia" required>
        <option value="" disabled selected>Seleziona una copia</option>
        <?php foreach ($copie_in_prestito as $copia): ?>
            <option value="<?php echo htmlspecialchars($copia['id_copia']); ?>">
                <?php echo htmlspecialchars($copia['id_copia'] . " - " . $copia['titolo']); ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label for="matricola">Matricola Utente (obbligatorio):</label>
    <input type="text" id="matricola" name="matricola" required maxlength="6">

    <label for="data_uscita">Data Uscita (obbligatoria):</label>
    <input type="date" id="data_uscita" name="data_uscita" required>

    <label>Succursale:</label>
    <select name="succursale" required>
        <?php foreach ($succursali as $succursale): ?>
            <option value="<?php echo htmlspecialchars($succursale); ?>">
                <?php echo htmlspecialchars($succursale); ?>
            </option>
        <?php endforeach; ?>
    </select>

    <button type="submit" name="cancella_prestito">Elimina Prestito</button>
    <button type="button" class="exit-btn" onclick="window.location.href='prestiti.php'">Esci</button>
</form>

</body>
</html>

<?php
require_once("strumenti/connect.php"); // Connessione al DB
include("strumenti/navbar.php");      // Navbar

$message = "";

// Query per ottenere le copie disponibili (cioè copie NON attualmente in prestito attivo)
$query = "
SELECT CL.id_copia, L.titolo, CL.succursale, L.ISBN
FROM CopiaLibro CL
JOIN Libro L ON CL.ISBN = L.ISBN
LEFT JOIN Prestito P ON CL.id_copia = P.id_copia AND P.data_restituzione_prevista >= CURDATE()
WHERE P.id_copia IS NULL;
";

$copie_result = mysqli_query($link, $query);
if (!$copie_result) {
    die("Errore nella query copie disponibili: " . mysqli_error($link));
}
$copie = [];
while ($row = mysqli_fetch_assoc($copie_result)) {
    $copie[] = $row;
}


$query = "SELECT matricola, nome, cognome FROM Utente";
$utenti_result = mysqli_query($link, $query);
if (!$utenti_result) {
    die("Errore nella query utenti: " . mysqli_error($link));
}
$utenti = [];
while ($row = mysqli_fetch_assoc($utenti_result)) {
    $utenti[] = $row;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['inserisci_prestito'])) {

 
    $id_copia = $_POST['id_copia'];
    $matricola = $_POST['matricola'];
    $data_uscita = $_POST['data_uscita'];
    $data_restituzione_prevista = $_POST['data_restituzione_prevista'];


    if (empty($id_copia) || empty($matricola) || empty($data_uscita)) {
        $message = "Compila tutti i campi obbligatori.";
    } elseif (!empty($data_restituzione_prevista) && strtotime($data_uscita) > strtotime($data_restituzione_prevista)) {
        $message = "La data di uscita non può essere successiva alla data di restituzione prevista.";
    } elseif (strtotime($data_uscita) < strtotime(date('Y-m-d'))) {
        $message = "La data di uscita non può essere nel passato.";
    } else {
        // Controlla se la copia è già in prestito attivo
        $query_check = "SELECT * FROM Prestito 
                        WHERE id_copia = $id_copia 
                        AND data_restituzione_prevista >= CURDATE()";
        $check_result = mysqli_query($link, $query_check);
        if (!$check_result) {
            die("Errore nella query di controllo prestito: " . mysqli_error($link));
        }
        if (mysqli_num_rows($check_result) > 0) {
            $message = "La copia selezionata è già in prestito.";
        } else {
            // Se data_restituzione_prevista non inserita, calcola +30 giorni
            if (empty($data_restituzione_prevista)) {
                $data_restituzione_prevista = date('Y-m-d', strtotime($data_uscita . ' +30 days'));
            }
            
            $query_insert = "INSERT INTO Prestito (id_copia, matricola, data_uscita, data_restituzione_prevista)
                             VALUES ('$id_copia', '$matricola', '$data_uscita', '$data_restituzione_prevista')";
            if (mysqli_query($link, $query_insert)) {
                $message = "Prestito inserito con successo!";
            } else {
                $message = "Errore durante l'inserimento: " . mysqli_error($link);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Nuovo Prestito</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

<h2>Inserisci Nuovo Prestito</h2>

<?php if ($message): ?>
    <div class="message"><?php echo htmlspecialchars($message); ?></div>
<?php endif; ?>

<form method="post" action="">
    <label for="id_copia">Copia Libro (Titolo - Succursale):</label>
    <select id="id_copia" name="id_copia" required>
        <?php foreach ($copie as $copia): ?>
            <option value="<?php echo htmlspecialchars($copia['id_copia']); ?>">
                <?php echo htmlspecialchars($copia['titolo'] . " - " . $copia['succursale'] . " (ID copia: " . $copia['id_copia'] . ")"); ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label for="matricola">Utente:</label>
    <select id="matricola" name="matricola" required>
        <?php foreach ($utenti as $utente): ?>
            <option value="<?php echo htmlspecialchars($utente['matricola']); ?>">
                <?php echo htmlspecialchars($utente['nome'] . " " . $utente['cognome']); ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label for="data_uscita">Data Uscita:</label>
    <input type="date" id="data_uscita" name="data_uscita" required>

    <label for="data_restituzione_prevista">Data Restituzione Prevista (opzionale):</label>
    <input type="date" id="data_restituzione_prevista" name="data_restituzione_prevista">

    <button type="submit" name="inserisci_prestito">Inserisci Prestito</button>
    <button type="button" class="exit-btn" onclick="window.location.href='prestiti.php'">Esci</button>
</form>

</body>
</html>

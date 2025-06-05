<?php
require_once("strumenti/connect.php"); // Connessione al DB
include("strumenti/navbar.php");      // Navbar

$message = "";

    $succursali = [];
    $result_succursali = mysqli_query($link, "SELECT nome FROM Biblioteca.Succursale ORDER BY nome");
    if ($result_succursali) {
        while ($row = mysqli_fetch_assoc($result_succursali)) {
            $succursali[] = $row['nome'];
        }
        mysqli_free_result($result_succursali);
    } else {
        echo "Errore nel recupero delle succursali: " . mysqli_error($link);
        exit;
    }

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cancella_prestito'])) {
    // Prendi i dati dal form
    $id_libro = mysqli_real_escape_string($link, $_POST['id_libro']);
    $matricola = mysqli_real_escape_string($link, $_POST['matricola']);
    $succursale = mysqli_real_escape_string($link, $_POST['succursale']);
    $data_uscita = mysqli_real_escape_string($link, $_POST['data_uscita']);

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
    <style>
        body { font-family: Arial; padding: 20px; }
        form input, form select { margin-bottom: 10px; display: block; padding: 8px; width: 300px; }
        label { font-weight: bold; margin-top: 10px; }
        button {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px 16px;
            cursor: pointer;
        }
        button:hover {
            background-color: #28a745;
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

<h2>Elimina Prestito</h2>

<?php if ($message): ?>
    <div class="message"><?php echo htmlspecialchars($message); ?></div>
<?php endif; ?>

<form method="post" action="">
    <label for="id_libro">ID Libro (obbligatorio):</label>
    <input type="number" id="id_libro" name="id_libro" required min="1">

    <label for="matricola">Matricola Utente (obbligatorio):</label>
    <input type="number" id="matricola" name="matricola" required maxlength="6">

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

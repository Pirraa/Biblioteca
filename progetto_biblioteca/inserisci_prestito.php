<?php
require_once("strumenti/connect.php"); // Connessione al DB
include("strumenti/navbar.php");      // Navbar

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['inserisci_prestito'])) {
    // Prendi i dati dal form
    $id_libro = mysqli_real_escape_string($link, $_POST['id_libro']);
    $matricola = mysqli_real_escape_string($link, $_POST['matricola']);
    $succursale = mysqli_real_escape_string($link, $_POST['succursale']);
    $data_uscita = mysqli_real_escape_string($link, $_POST['data_uscita']);
    $data_restituzione_prevista = mysqli_real_escape_string($link, $_POST['data_restituzione_prevista']);

    // Controlli base (puoi migliorare)
    if (empty($id_libro) || empty($matricola) || empty($succursale) || empty($data_uscita)) {
        $message = "Compila tutti i campi obbligatori.";
    } else {
        // Query di inserimento
        $query = "INSERT INTO Biblioteca.Prestito (id_libro, matricola, succursale, data_uscita, data_restituzione_prevista)
                  VALUES ('$id_libro', '$matricola', '$succursale', '$data_uscita', " . 
                  ($data_restituzione_prevista ? "'$data_restituzione_prevista'" : "NULL") . ")";

        if (mysqli_query($link, $query)) {
            $message = "Prestito inserito con successo!";
        } else {
            $message = "Errore durante l'inserimento: " . mysqli_error($link);
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Nuovo Prestito</title>
    <style>
        body { font-family: Arial; padding: 20px; }
        label { display: block; margin-top: 10px; }
        input, select { padding: 5px; width: 300px; }
        button {
            margin-top: 20px;
            padding: 10px 15px;
            background-color: #28a745;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #218838;
        }
        .message {
            margin-top: 15px;
            padding: 10px;
            border: 1px solid #ccc;
            background-color: #eef;
            width: 320px;
        }
        .exit-btn {
            background-color: #dc3545;
            margin-left: 10px;
        }
        .exit-btn:hover {
            background-color: #b02a37;
        }
    </style>
</head>
<body>

<h2>Inserisci Nuovo Prestito</h2>

<?php if ($message): ?>
    <div class="message"><?php echo htmlspecialchars($message); ?></div>
<?php endif; ?>

<form method="post" action="">
    <label for="id_libro">ID Libro (deve esistere):</label>
    <input type="number" id="id_libro" name="id_libro" required min="1">

    <label for="matricola">Matricola Utente (deve esistere):</label>
    <input type="text" id="matricola" name="matricola" required maxlength="6">

    <label for="succursale">Succursale (deve esistere):</label>
    <input type="text" id="succursale" name="succursale" required maxlength="100">

    <label for="data_uscita">Data Uscita:</label>
    <input type="date" id="data_uscita" name="data_uscita" required>

    <label for="data_restituzione_prevista">Data Restituzione Prevista (opzionale):</label>
    <input type="date" id="data_restituzione_prevista" name="data_restituzione_prevista">

    <button type="submit" name="inserisci_prestito">Inserisci Prestito</button>
    <button type="button" class="exit-btn" onclick="window.location.href='prestiti.php'">Esci</button>
</form>

</body>
</html>

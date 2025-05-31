<?php
require_once("strumenti/connect.php"); // Connessione al DB
include("strumenti/navbar.php");      // Navbar

$message = "";

$query="SELECT id_libro,titolo FROM Biblioteca.Libro";
$libri_result = mysqli_query($link, $query);
if (!$libri_result) {
    die("Errore nella query libri: " . mysqli_error($link));
}
$libri = [];
while ($row = mysqli_fetch_assoc($libri_result)) {
    $libri[] = $row;
}

$query="SELECT matricola,nome FROM Biblioteca.Utente";
$utenti_result = mysqli_query($link, $query);
if (!$utenti_result) {
    die("Errore nella query utenti: " . mysqli_error($link));
}
$utenti = [];
while ($row = mysqli_fetch_assoc($utenti_result)) {
    $utenti[] = $row;
}

$query="SELECT nome FROM Biblioteca.Succursale";
$succursali_result = mysqli_query($link, $query);
if (!$succursali_result) {
    die("Errore nella query: succursali " . mysqli_error($link));
}
$succursali = [];
while ($row = mysqli_fetch_assoc($succursali_result)) {
    $succursali[] = $row;
}

$query="SELECT * from Biblioteca.Prestito";
$prestiti_result = mysqli_query($link, $query);    
if (!$prestiti_result) {
    die("Errore nella query prestiti: " . mysqli_error($link));
}
$prestiti = [];
while ($row = mysqli_fetch_assoc($prestiti_result)) {
    $prestiti[] = $row;
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['inserisci_prestito'])) {
    // Prendi i dati dal form
    $id_libro =  $_POST['id_libro'];
    $matricola =  $_POST['matricola'];
    $succursale = $_POST['succursale'];
    $data_uscita =  $_POST['data_uscita'];
    $data_restituzione_prevista = $_POST['data_restituzione_prevista'];

    // Controlli base (puoi migliorare), aggiungi controllo che data inizio sia minore della data fine e sia nel futuro
    // Controlli base unificati
    if (empty($id_libro) || empty($matricola) || empty($succursale) || empty($data_uscita)) {
        $message = "Compila tutti i campi obbligatori.";
    } elseif (!empty($data_restituzione_prevista) && strtotime($data_uscita) > strtotime($data_restituzione_prevista)) {
        $message = "La data di uscita non può essere successiva alla data di restituzione prevista.";
    } elseif (strtotime($data_uscita) < strtotime(date('Y-m-d'))) {
        $message = "La data di uscita non può essere nel passato.";
    }
    else 
    {
        // Controlla se il libro è già in prestito
        $prestito_esistente = false;
        foreach ($prestiti as $prestito) 
        {
            if ($prestito['id_libro'] == $id_libro && $prestito['matricola'] == $matricola && $prestito['succursale'] == $succursale) 
            {
                $prestito_esistente = true;
                break;
            }
        }
        if ($prestito_esistente) 
        {
            $message = "Questo prestito esiste già.";
        } else 
        {
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
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Nuovo Prestito</title>
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
            background-color: #218838;
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

<h2>Inserisci Nuovo Prestito</h2>

<?php if ($message): ?>
    <div class="message"><?php echo htmlspecialchars($message); ?></div>
<?php endif; ?>

<form method="post" action="">
    <label for="id_libro">Libro:</label>
    <select id="id_libro" name="id_libro" required>
        <?php foreach ($libri as $libro): ?>
            <option value="<?php echo htmlspecialchars($libro['id_libro']); ?>">
                <?php echo htmlspecialchars($libro['titolo']); ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label for="matricola">Utente:</label>
    <select id="matricola" name="matricola" required>
        <?php foreach ($utenti as $utente): ?>
            <option value="<?php echo htmlspecialchars($utente['matricola']); ?>">
                <?php echo htmlspecialchars($utente['nome']); ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label for="succursale">Succursale:</label>
    <select id="succursale" name="succursale" required>
        <?php foreach ($succursali as $succursale): ?>
            <option value="<?php echo htmlspecialchars($succursale['nome']); ?>">
                <?php echo htmlspecialchars($succursale['nome']); ?>
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

<?php
require_once("strumenti/connect.php"); // Connessione al DB
include("strumenti/navbar.php");       // Navbar

$errore = ""; // Variabile per messaggi d'errore

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Leggo i dati inviati dal form
    $matricola = trim($_POST["matricola"]);
    $nome = trim($_POST["nome"]);
    $cognome = trim($_POST["cognome"]);
    $indirizzo = trim($_POST["indirizzo"]);
    $telefono = trim($_POST["telefono"]);

    // Controllo se la matricola è già presente
    $check_sql = "SELECT matricola FROM Utente WHERE matricola = ?";
    $stmt = mysqli_prepare($link, $check_sql);
    mysqli_stmt_bind_param($stmt, "s", $matricola);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) > 0) {
        $errore = "Matricola già presente. Inserisci un valore univoco.";
    } else {
        // Inserisco il nuovo utente
        $insert_sql = "INSERT INTO Utente (matricola, nome, cognome, indirizzo, telefono) VALUES (?, ?, ?, ?, ?)";
        $stmt_insert = mysqli_prepare($link, $insert_sql);
        mysqli_stmt_bind_param($stmt_insert, "sssss", $matricola, $nome, $cognome, $indirizzo, $telefono);
        $eseguito = mysqli_stmt_execute($stmt_insert);

        if (!$eseguito) {
            $errore = "Errore durante l'inserimento: " . mysqli_error($link);
        } else {
            mysqli_close($link);
            header("Location: utenti.php");
            exit;
        }
    }

    mysqli_close($link);
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Nuovo Utente</title>
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
    </style>
</head>
<body>
    <?php if (!empty($errore)): ?>
    <div style="color: red; font-weight: bold; margin-bottom: 20px;">
        <?php echo $errore; ?>
    </div>
<?php endif; ?>


<h2>Inserisci un Nuovo Utente</h2>


<form method="POST" action="">
    <label>Matricola:</label>
    <input type="number" name="matricola" required>

    <label>Nome:</label>
    <input type="text" name="nome" required>

    <label>Cognome:</label>
    <input type="text" name="cognome" required>

    <label>Indirizzo:</label>
    <input type="text" name="indirizzo" required>

    <label>Telefono:</label>
    <input type="number" name="telefono" required>

    <button type="submit">Inserisci</button>
     <button type="button" class="exit-btn" onclick="window.location.href='libri.php'">Esci</button>
</form>

</body>
</html>

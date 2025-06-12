<?php
require_once("strumenti/connect.php"); // Connessione al DB
include("strumenti/navbar.php");       // Navbar

$errore = ""; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $matricola = $_POST["matricola"];
    $nome = $_POST["nome"];
    $cognome = $_POST["cognome"];
    $indirizzo = $_POST["indirizzo"];
    $telefono = $_POST["telefono"];

    
    $check_sql = "SELECT matricola FROM Utente WHERE matricola = '$matricola'";
    $query= mysqli_query($link, $check_sql);

    if (!$query) {
        $errore =  "Si è verificato un errore: " . mysqli_error($link);
        exit;
    }

    if (mysqli_num_rows($query) > 0) {
        $errore = "Matricola già presente. Inserisci un valore univoco.";
    } else {
        
        $insert_sql = "INSERT INTO Utente (matricola, nome, cognome, indirizzo, telefono) VALUES ('$matricola', '$nome', '$cognome', '$indirizzo', '$telefono')";
        $eseguito = mysqli_query($link, $insert_sql);

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
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <?php if (!empty($errore)): ?>
    <div class="message">
        <?php echo $errore; ?>
    </div>
<?php endif; ?>


<h2>Inserisci un Nuovo Utente</h2>


<form method="POST" action="">
    <label>Matricola:</label>
    <input type="text" name="matricola" required>

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

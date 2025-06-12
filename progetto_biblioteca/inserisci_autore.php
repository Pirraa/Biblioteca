<?php
require_once("strumenti/connect.php"); // Connessione al DB
include("strumenti/navbar.php");       // Navbar

$errore = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Leggo i dati inviati dal form
    $nome = $_POST["nome"];
    $cognome = $_POST["cognome"];
    $data_nascita = $_POST["data_nascita"];
    $luogo_nascita = $_POST["luogo_nascita"];

    // Controllo che la data sia minore di oggi
    $oggi = date("Y-m-d");
    if ($data_nascita >= $oggi) {
        $errore = "La data di nascita deve essere precedente a quella di oggi.";
    } else {
        
        $sql = "INSERT INTO Autore (nome, cognome, data_nascita, luogo_nascita)
                VALUES ('$nome', '$cognome', '$data_nascita', '$luogo_nascita')";

       
        $query = mysqli_query($link, $sql);

        if (!$query) {
            echo "Si è verificato un errore: " . mysqli_error($link);
            exit;
        }

        mysqli_close($link);

       
        header("Location: autori.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Nuovo Autore</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

<h2>Inserisci un Nuovo Autore</h2>

<?php if (!empty($errore)): ?>
    <div class="message">
        <?php echo htmlspecialchars($errore); ?>
    </div>
<?php endif; ?>

<form method="POST" action="">
    <label>Nome:</label>
    <input type="text" name="nome" required>

    <label>Cognome:</label>
    <input type="text" name="cognome" required>

    <label>Data di Nascita:</label>
    <input type="date" name="data_nascita" required>

    <label>Luogo di Nascita:</label>
    <input type="text" name="luogo_nascita" required>

    <button type="submit">Inserisci</button>
    <button type="button" class="exit-btn" onclick="window.location.href='autori.php'">Esci</button>
</form>

</body>
</html>

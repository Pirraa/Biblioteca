<?php
require_once("strumenti/connect.php"); // Connessione al DB
include("strumenti/navbar.php");       // Navbar

$autori = [];
    $result = mysqli_query($link, "SELECT id_autore, nome, cognome FROM Biblioteca.Autore ORDER BY cognome, nome");
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $autori[] = $row;
        }
        mysqli_free_result($result);
    } else {
        echo "Errore nel recupero degli autori: " . mysqli_error($link);
        exit;
    }

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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Leggo i dati inviati dal form
    $isbn = $_POST["isbn"];
    $titolo = $_POST["titolo"];
    $anno_pubblicazione = $_POST["anno_pubblicazione"];
    $succursale = $_POST["succursale"];
    $lingua = $_POST["lingua"];
    $autori_selezionati = $_POST["autori"];

    // Creo la query SQL
    $sql = "INSERT INTO Libro (ISBN, titolo, anno_pubblicazione, succursale, lingua)
            VALUES ('$isbn', '$titolo', '$anno_pubblicazione', '$succursale', '$lingua')";

    // Eseguo la query
    $query = mysqli_query($link, $sql);

    if (!$query) {
        echo "Si è verificato un errore: " . mysqli_error($link);
        exit;
    }

    // Recupero l'id del libro appena inserito
    //mi serve per fare l'update anche della tabella di mezzo nella relazione molti a molti
    $id_libro = mysqli_insert_id($link);

    foreach ($autori_selezionati as $id_autore) {
        $id_autore = intval($id_autore);
        $sql_autore_libro = "INSERT INTO AutoreLibro (id_autore, id_libro) VALUES ($id_autore, $id_libro)";
        if (!mysqli_query($link, $sql_autore_libro)) {
            echo "Errore nell'inserimento dell'autore: " . mysqli_error($link);
            exit;
        }
        echo "Autore con ID $id_autore associato al libro con ID $id_libro.<br>";
    }

    mysqli_close($link);

    // Reindirizzamento alla pagina libri
    header("Location: libri.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Nuovo Libro</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

<h2>Inserisci un Nuovo Libro</h2>



<form method="POST" action="">
    <label>ISBN:</label>
    <input type="number" name="isbn" required>

    <label>Titolo:</label>
    <input type="text" name="titolo" required>

    <label>Anno di Pubblicazione:</label>
    <input type="number" name="anno_pubblicazione" required>

    <label>Succursale:</label>
    <select name="succursale" required>
        <?php foreach ($succursali as $succursale): ?>
            <option value="<?php echo htmlspecialchars($succursale); ?>">
                <?php echo htmlspecialchars($succursale); ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label>Lingua:</label>
    <input type="text" name="lingua" required>

    <label>Autori:</label>
    <select name="autori[]" multiple required style="height:120px;">
        <?php foreach ($autori as $autore): ?>
            <option value="<?php echo htmlspecialchars($autore['id_autore']); ?>">
                <?php echo htmlspecialchars($autore['nome'] . ' ' . $autore['cognome']); ?>
            </option>
        <?php endforeach; ?>
    </select>

    <button type="submit">Inserisci</button>
    <button type="button" class="exit-btn" onclick="window.location.href='libri.php'">Esci</button>
</form>

</body>
</html>

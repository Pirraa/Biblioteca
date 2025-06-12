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

    $isbn = mysqli_real_escape_string($link, $_POST["isbn"]);
    $titolo = mysqli_real_escape_string($link, $_POST["titolo"]); // utilizzo mysqli_real_escape_string per prevenire che se il titolo contiene caratteri speciali, questi vengano interpretati come parte della query SQL
    $anno_pubblicazione = intval($_POST["anno_pubblicazione"]);
    $lingua = mysqli_real_escape_string($link, $_POST["lingua"]);
    $num_copie = intval($_POST["num_copie"]);
    $autori_selezionati = $_POST["autori"];
    $succursali_selezionate = $_POST["succursale"]; // array di succursali selezionate con select multipla

    // Controllo se l'ISBN è già presente
    $check_query = "SELECT ISBN FROM Biblioteca.Libro WHERE ISBN = '$isbn'";
    $check_result = mysqli_query($link, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        // ISBN esiste quindi solo inserimento copie
        foreach ($succursali_selezionate as $succursale_corrente) {
            $succursale_corrente = mysqli_real_escape_string($link, $succursale_corrente);
            for ($i = 0; $i < $num_copie; $i++) {
                $sql_copia = "INSERT INTO Biblioteca.CopiaLibro (ISBN, succursale) VALUES ('$isbn', '$succursale_corrente')";
                if (!mysqli_query($link, $sql_copia)) {
                    echo "Errore nell'inserimento della copia: " . mysqli_error($link);
                    exit;
                }
            }
        }
        echo "<p class='message'>Copie aggiunte con successo per il libro esistente con ISBN <strong>$isbn</strong>.</p>";
    } else {
        // ISBN non esiste quindi inserisco libro, autori e copie
        $sql = "INSERT INTO Biblioteca.Libro (ISBN, titolo, anno_pubblicazione, lingua)
                VALUES ('$isbn', '$titolo', $anno_pubblicazione, '$lingua')";
        $query = mysqli_query($link, $sql);

        if (!$query) {
            echo "Errore: " . mysqli_error($link);
            exit;
        }


        foreach ($autori_selezionati as $id_autore) {
            $id_autore = intval($id_autore);
            $sql_autore_libro = "INSERT INTO Biblioteca.AutoreLibro (id_autore, ISBN) VALUES ($id_autore, $isbn)";
            if (!mysqli_query($link, $sql_autore_libro)) {
                echo "Errore nell'inserimento dell'autore: " . mysqli_error($link);
                exit;
            }
        }

        // Inserisco copie per ogni succursale selezionata
        foreach ($succursali_selezionate as $succursale_corrente) {
            $succursale_corrente = mysqli_real_escape_string($link, $succursale_corrente);
            for ($i = 0; $i < $num_copie; $i++) {
                $sql_copia = "INSERT INTO Biblioteca.CopiaLibro (ISBN, succursale) VALUES ('$isbn', '$succursale_corrente')";
                if (!mysqli_query($link, $sql_copia)) {
                    echo "Errore nell'inserimento della copia: " . mysqli_error($link);
                    exit;
                }
            }
        }

        echo "<p class='message'>Libro e copie inseriti con successo.</p>";
    }
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
    <input type="text" name="isbn" required>

    <label>Titolo:</label>
    <input type="text" name="titolo" required>

    <label>Anno di Pubblicazione:</label>
    <input type="number" name="anno_pubblicazione" required>

    <label>Succursale:</label>
    <select name="succursale[]" multiple required style="height:120px;">
        <?php foreach ($succursali as $succursale): ?>
            <option value="<?php echo htmlspecialchars($succursale); ?>">
                <?php echo htmlspecialchars($succursale); ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label>Lingua:</label>
    <input type="text" name="lingua" required>

    <label>Numero di copie per succursale:</label>
    <input type="number" name="num_copie" min="1" required>

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

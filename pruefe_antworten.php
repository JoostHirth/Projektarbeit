<?php
// Verbindung zur Datenbank herstellen
include 'config.php';
$con = new mysqli($servername, $username, $password, $dbname);
if ($con->connect_error) {
    die("Error connecting to server" . $con->connect_error);
}

// Holen Sie die ausgewählte Antwort aus dem POST-Array
$frage_id = $_POST['frage_id'];
$antwort_id = $_POST['antwort_' . $frage_id];

// Holen Sie die korrekte Antwort aus der Datenbank
$sql = "SELECT korrekt FROM quiz_antwort WHERE frage_id = $frage_id AND antwort_id = $antwort_id";
$result = $con->query($sql);

if ($result) {
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $korrekt = $row['korrekt'];

        // Überprüfen, ob die Antwort korrekt ist und entsprechende Nachricht zurückgeben
        if ($korrekt == 1) {
            echo "Richtig!";
        } else {
            echo "Falsch!";
        }
    } else {
        echo "Keine Ergebnisse gefunden.";
    }
} else {
    echo "Fehler bei der Ausführung der Abfrage: " . $con->error;
}

$con->close();
?>

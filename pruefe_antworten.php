<?php
include 'config.php';

// Überprüfen, ob das Formular gesendet wurde
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verbindung zur Datenbank herstellen
    $con = new mysqli($servername, $username, $password, $dbname);
    // Überprüfen, ob die Verbindung erfolgreich hergestellt wurde
    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    }

    // Benutzerantworten verarbeiten und in Variablen speichern
    $benutzer_id = 1; // Beispiel: Festlegen der Benutzer-ID

    // Beispiel: Lesen der POST-Daten für Frage und Antwort
    $frage_id = isset($_POST['frage_id']) ? $_POST['frage_id'] : null;
    $antwort_id = isset($_POST['antwort_id']) ? $_POST['antwort_id'] : null;

    if ($frage_id && $antwort_id) {
        // Überprüfen, ob die Antwort korrekt ist
        // Hier Ihre Logik zur Überprüfung der Antwort und Aktualisierung der Datenbank
    } else {
        echo "Fehler: Nicht alle erforderlichen Daten wurden gesendet.";
    }

    // Schließen Sie die Datenbankverbindung
    $con->close();
} else {
    echo "Ungültige Anfrage.";
}
?>

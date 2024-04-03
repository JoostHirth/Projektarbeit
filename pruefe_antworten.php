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
    $frage_id = isset($_POST['frage_id']) ? $_POST['frage_id'] : null;
    $antwort_id = isset($_POST['antwort_id']) ? $_POST['antwort_id'] : null;

    if ($frage_id && $antwort_id) {
        // Überprüfen, ob die Antwort korrekt ist
        $sql = "SELECT korrekt FROM quiz_antwort WHERE antwort_id = $antwort_id AND frage_id = $frage_id";
        $result = $con->query($sql);
        if ($result) {
            $row = $result->fetch_assoc();
            if ($row) {
                $korrekt = $row['korrekt'];

                if ($korrekt == 1) {
                    // Benutzerantwort ist korrekt
                    // Inkrementieren Sie die Anzahl der richtig beantworteten Fragen für den Benutzer in der Datenbank
                    $sqlUpdate = "UPDATE ergebnisse SET richtig_beantwortete_fragen = richtig_beantwortete_fragen + 1 WHERE benutzer_id = $benutzer_id";
                    if ($con->query($sqlUpdate) === TRUE) {
                        echo "Richtig beantwortete Fragen aktualisiert.";
                    } else {
                        echo "Fehler beim Aktualisieren der richtig beantworteten Fragen: " . $con->error;
                    }
                } else {
                    // Benutzerantwort ist falsch
                    // Inkrementieren Sie die Anzahl der beantworteten Fragen für den Benutzer in der Datenbank
                    $sqlUpdate = "UPDATE ergebnisse SET beantwortete_fragen = beantwortete_fragen + 1 WHERE benutzer_id = $benutzer_id";
                    if ($con->query($sqlUpdate) === TRUE) {
                        echo "Beantwortete Fragen aktualisiert.";
                    } else {
                        echo "Fehler beim Aktualisieren der beantworteten Fragen: " . $con->error;
                    }
                }
            } else {
                echo "Keine Daten gefunden.";
            }
        } else {
            echo "Fehler bei der Ausführung der Abfrage: " . $con->error;
        }
    } else {
        echo "Fehler beim Lesen der POST-Daten.";
    }
    // Schließen Sie die Datenbankverbindung
    $con->close();
} else {
    echo "Ungültige Anfrage.";
}
?>

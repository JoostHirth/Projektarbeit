<?php
include 'config.php';
$con = new mysqli($servername, $username, $password, $dbname);
if ($con->connect_error) {
    die("Error connecting to server" . $con->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Schritt 4: Benutzerantworten erfassen (Annahme: POST-Daten werden verwendet)
    foreach ($_POST as $frage_id => $antwort_id) {
        // Hier können Sie die Benutzerantworten speichern oder verarbeiten
        // Annahme: Sie speichern die Benutzerantworten in einer Datenbank

        // Schritt 5: Antworten überprüfen
        $frage_id = mysqli_real_escape_string($con, $frage_id); // Sicherheitsmaßnahme: SQL-Injektion verhindern
        $antwort_id = mysqli_real_escape_string($con, $antwort_id); // Sicherheitsmaßnahme: SQL-Injektion verhindern

        $korrekte_antwort_query = "SELECT korrekt FROM quiz_antwort WHERE frage_id = '$frage_id' AND antwort_id = '$antwort_id'";
        $korrekte_antwort_result = mysqli_query($con, $korrekte_antwort_query);

        if (mysqli_num_rows($korrekte_antwort_result) > 0) {
            $row = mysqli_fetch_assoc($korrekte_antwort_result);
            $korrekt = $row['korrekt'];
            if ($korrekt == 1) {
                echo "Die Antwort ist korrekt!";
            } else {
                echo "Die Antwort ist falsch!";
            }
        } else {
            echo "Die Antwort wurde nicht gefunden!";
        }
    }
}
?>

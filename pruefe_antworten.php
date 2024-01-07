<?php
// Hier würdest du die Überprüfung der Antworten implementieren
// Für dieses Beispiel geben wir einfach die ausgewählten Antwort-IDs aus

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $antwortIds = $_POST['antwortIds'];
    $frageIds = $_POST['frageIds'];
    if ($antwortIds == $frageIds) {
        echo "richtig";
    }
    else {
        echo "falsch";
    }
}
?>

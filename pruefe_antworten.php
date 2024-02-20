<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $antwortIds = $_POST['antwortIds'];
    $frageIds = $_POST['frageIds'];
    $antwortZeiten = json_decode($_POST['antwortZeiten'], true); // Antwortzeiten der Benutzer

    // Hier kannst du deine eigene Logik zur Punkteberechnung implementieren
    $punkte = array();
    foreach ($frageIds as $frageId) {
        // Hier ein Beispiel für eine mögliche Punktberechnung:
        // Je schneller die Antwort, desto mehr Punkte
        // Du kannst die Berechnung basierend auf deinen Anforderungen anpassen
        // Zum Beispiel kannst du eine lineare, exponentielle oder logarithmische Skalierung verwenden
        // Dies ist nur ein einfaches Beispiel
        $antwortZeit = $antwortZeiten[$frageId];
        $punkte[] = max(0, round((10 - $antwortZeit) * 10)); // Beispiel: Maximal 100 Punkte, wenn die Antwort in weniger als 10 Sekunden erfolgt
    }

    // Jetzt kannst du die Ergebnisse an den Client zurückgeben oder sie in die Datenbank speichern
    echo json_encode($punkte);
}
?>

<?php
include 'config.php';

$conn = new mysqli($servername, $username, $password, $dbname);

// Verbindung überprüfen
if ($conn->connect_error) {
    die("Verbindung fehlgeschlagen: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Schritt 4: Benutzerantworten erfassen (Annahme: POST-Daten werden verwendet)
    foreach ($_POST as $frage_id => $antwort_id) {
        // Hier können Sie die Benutzerantworten speichern oder verarbeiten
        // Annahme: Sie speichern die Benutzerantworten in einer Datenbank

        // Schritt 5: Antworten überprüfen
        $frage_id = mysqli_real_escape_string($conn, $frage_id); // Sicherheitsmaßnahme: SQL-Injektion verhindern
        $antwort_id = mysqli_real_escape_string($conn, $antwort_id); // Sicherheitsmaßnahme: SQL-Injektion verhindern

        $korrekte_antwort_query = "SELECT korrekt FROM quiz_antwort WHERE frage_id = '$frage_id' AND antwort_id = '$antwort_id'";
        $korrekte_antwort_result = mysqli_query($conn, $korrekte_antwort_query);

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

// Verbindung schließen
$conn->close();
?>

<script>
    window.onload = function() {
        // Initialisierung: Submit-Button deaktivieren
        document.getElementById("submitBtn").disabled = true;
        var fullPoints = 1000; 

        // Countdown für die erste Verzögerung von 3 Sekunden
        setTimeout(function() {
            // Aktiviere den Submit-Button
            document.getElementById("submitBtn").disabled = false;

            // Starte den Countdown für die zweite Verzögerung von 10 Sekunden
            var countdown = 10;
            var countdownInterval = setInterval(function() {
                countdown--;
                document.getElementById("countdownTimer").innerHTML = "Nächster Versuch in " + countdown + " Sekunden";
                if (countdown <= 0) {
                    clearInterval(countdownInterval); // Countdown beenden
                    document.getElementById("countdownTimer").innerHTML = ""; // Timer ausblenden
                    document.getElementById("submitBtn").disabled = true; // Submit-Button deaktivieren
                    var points = calculatePoints(elapsedTime); 
                    document.getElementById("ergebnis").innerHTML = "Punkte: " + points;

                    // Hier können Sie die richtige Antwort farblich anzeigen
                    // Annahme: Die richtige Antwort ist mit einer Klasse "richtigeAntwort" gekennzeichnet
                    document.querySelector('.richtigeAntwort').style.color = 'green';
                }
            }, 1000); // Update alle 1000 Millisekunden (1 Sekunde)
        }, 3000); // Starte den Countdown nach 3 Sekunden
        function calculatePoints(elapsedTime) {
            return (elapsedTime < 5) ? fullPoints : Math.round(fullPoints - (elapsedTime - 5) * 200, 0);
        }
    };
</script>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <!-- Hier werden die Fragen und Antworten dynamisch generiert -->
    <!-- Beispiel -->
    <p>Frage 1: Was ist die Hauptstadt von Frankreich?</p>
    <ul>
        <li><input type="radio" name="1" value="1"> Berlin</span></li>
        <li><input type="radio" name="1" value="2"> London</li>
        <li><input type="radio" name="1" value="3"> <span class="richtigeAntwort">Paris</li>
    </ul>

    <!-- Weitere Fragen und Antworten hier einfügen -->

    <input type="submit" id="submitBtn" value="Antworten überprüfen">
    <p id="countdownTimer"></p>
</form>

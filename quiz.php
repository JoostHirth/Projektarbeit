<?php
session_start();
include 'config.php';

$conn = new mysqli($servername, $username, $password, $dbname);

// Verbindung überprüfen
if ($conn->connect_error) {
    die("Verbindung fehlgeschlagen: " . $conn->connect_error);
}

function calculatePoints($countdown) {
    return round($countdown , 0); // Punkteberechnung
}



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_SESSION['benutzername'])) {
        $benutzername = $_SESSION['benutzername'];
        echo "$benutzername";
    }
    // Schritt 4: Benutzerantworten erfassen (Annahme: POST-Daten werden verwendet)
    foreach ($_POST as $frage_id => $antwort_id) {
        $gesamt_punkte = "SELECT gesamt_punkte FROM userdaten WHERE username = '$benutzername'";
        $gesamt_punkteint = (int)$gesamt_punkte;

        $gesamt_fragen = "SELECT gesamt_fragen FROM userdaten WHERE username = '$benutzername'";
        $gesamt_fragenint = (int)$gesamt_fragen;

        $richtig_beantwortet = "SELECT richtig_beantwortet FROM userdaten WHERE username = '$benutzername'";
        $richtig_beantwortetint = (int)$richtig_beantwortet;

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
                $countdown = $_POST['countdownValue']; // Countdown-Wert auslesen
                $points = calculatePoints($countdown); // Punkte berechnen
                echo " Punkte: " . $points; // Punkte ausgeben
                $gesamt_punkteint += $points; 
                $sql_punkte = "UPDATE userdaten SET gesamt_punkte = gesamt_punkte + '$gesamt_punkteint' WHERE username = '$benutzername'";
                mysqli_query($conn, $sql_punkte);
                $gesamt_fragenint ++; 
                $sql_fragen = "UPDATE userdaten SET gesamt_fragen = gesamt_fragen + '$gesamt_fragenint' WHERE username = '$benutzername'";
                mysqli_query($conn, $sql_fragen);
                $richtig_beantwortetint ++; 
                $sql_richtig = "UPDATE userdaten SET richtig_beantwortet = richtig_beantwortet + '$richtig_beantwortetint' WHERE username = '$benutzername'";
                mysqli_query($conn, $sql_richtig);
            } else {
                echo "Die Antwort ist falsch!";
                $gesamt_fragenint ++; 
                $sql_fragen = "UPDATE userdaten SET gesamt_fragen = gesamt_fragen + '$gesamt_fragenint' WHERE username = '$benutzername'";
                mysqli_query($conn, $sql_fragen);
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
    var countdown = 1000; // Start Countdown-Wert

    // Countdown für die erste Verzögerung von 3 Sekunden
    setTimeout(function() {
        // Aktiviere den Submit-Button
        document.getElementById("submitBtn").disabled = false;

        // Starte den Countdown für die zweite Verzögerung von 10 Sekunden
        var countdownInterval = setInterval(function() {
            countdown--;
            document.getElementById("countdownTimer").innerHTML = "Nächster Versuch in " + Math.round(countdown/100, 0) + " Sekunden";
            document.getElementById("countdownValue").value = countdown; // Countdown-Wert aktualisieren
            if (countdown <= 0) {
                clearInterval(countdownInterval); // Countdown beenden
                document.getElementById("countdownTimer").innerHTML = ""; // Timer ausblenden
                document.getElementById("submitBtn").disabled = true; // Submit-Button deaktivieren
                document.getElementById("countdownValue").value = 0; // Countdown-Wert auf 0 setzen

                // Hier können Sie die richtige Antwort farblich anzeigen
                // Annahme: Die richtige Antwort ist mit einer Klasse "richtigeAntwort" gekennzeichnet
                document.querySelector('.richtigeAntwort').style.color = 'green';
            }
        }, 10); // Update alle 1000 Millisekunden (1 Sekunde)
    }, 3000); // Starte den Countdown nach 3 Sekunden

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
    <input type="hidden" id="countdownValue" name="countdownValue" value="">
    <input type="submit" id="submitBtn" value="Antworten überprüfen">
    <p id="countdownTimer"></p>
    <p id="ergebnis"></p>

</form>

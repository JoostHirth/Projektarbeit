<?php
session_start();
include 'config.php';

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Verbindung fehlgeschlagen: " . $conn->connect_error);
}

function calculatePoints($countdown) {
    return round($countdown , 0); 
}

$id = 1;
$vorherige_id = 0;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_SESSION['benutzername'])) {
        $benutzername = $_SESSION['benutzername'];
    }
    else {
        $benutzername = "Gast";
    }
    foreach ($_POST as $frage_id => $antwort_id) {
        $gesamt_punkte = "SELECT gesamt_punkte FROM userdaten WHERE username = '$benutzername'";
        $gesamt_punkteint = (int)$gesamt_punkte;

        $gesamt_fragen = "SELECT gesamt_fragen FROM userdaten WHERE username = '$benutzername'";
        $gesamt_fragenint = (int)$gesamt_fragen;

        $richtig_beantwortet = "SELECT richtig_beantwortet FROM userdaten WHERE username = '$benutzername'";
        $richtig_beantwortetint = (int)$richtig_beantwortet;

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
                $id++;
                $vorherige_id++; 
            } else {
                echo "Die Antwort ist falsch!";
                $gesamt_fragenint ++; 
                $sql_fragen = "UPDATE userdaten SET gesamt_fragen = gesamt_fragen + '$gesamt_fragenint' WHERE username = '$benutzername'";
                mysqli_query($conn, $sql_fragen);
                $id++;
                $vorherige_id++;
            }  

        } else {
            echo "Die Antwort wurde nicht gefunden!";
        }
    }
}
$thema = $_GET['thema'] ?? 1;
echo "$thema";

switch ($thema) {
    case 1:
        $frage_thema = "quiz_frage";
        $antwort_thema = "quiz_antwort";
        break;
    case 2:
        $frage_thema = "quiz_frage2";
        $antwort_thema = "quiz_antwort2";
        break;
    case 3:
        $frage_thema = "quiz_frage3";
        $antwort_thema = "quiz_antwort3";
        break;
    case 4:
        $frage_thema = "quiz_frage4";
        $antwort_thema = "quiz_antwort4";
        break;
}

$sql_fragetext = "SELECT frage_text FROM $frage_thema WHERE frage_id = $id";
$result_fragetext = mysqli_query($conn, $sql_fragetext);
$frage = mysqli_fetch_assoc($result_fragetext)['frage_text'];

$sql_antworttext1 = "SELECT antwort_text FROM $antwort_thema WHERE frage_id = $id AND antwort_id = 1";
$result_antworttext1 = mysqli_query($conn, $sql_antworttext1);
$antwort1 = mysqli_fetch_assoc($result_antworttext1)['antwort_text'];

$sql_antworttext2 = "SELECT antwort_text FROM $antwort_thema WHERE frage_id = $id AND antwort_id = 2";
$result_antworttext2 = mysqli_query($conn, $sql_antworttext2);
$antwort2 = mysqli_fetch_assoc($result_antworttext2)['antwort_text'];

$sql_antworttext3 = "SELECT antwort_text FROM $antwort_thema WHERE frage_id = $id AND antwort_id = 3";
$result_antworttext3 = mysqli_query($conn, $sql_antworttext3);
$antwort3 = mysqli_fetch_assoc($result_antworttext3)['antwort_text'];

if ($id > $vorherige_id || $id == 1) {

    if($id>1){
        echo "<script>";
        echo "startTimer();";
        echo "</script>";
        if ($id <= 20){
            echo '<form method="post" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '">';
            echo "<p>$frage</p>";
            echo '<ul>';
            echo "<li><input type='radio' name='1' value='1'> $antwort1</li>";
            echo "<li><input type='radio' name='1' value='2'> $antwort2</li>";
            echo "<li><input type='radio' name='1' value='3'> $antwort3</li>";
            echo '</ul>';
            // Weitere Fragen und Antworten hier einfügen
            echo '<input type="hidden" id="countdownValue" name="countdownValue" value="">';
            echo '<input type="submit" id="submitBtn" value="Antworten überprüfen">';
            echo '<p id="countdownTimer"></p>';
            echo '<p id="ergebnis"></p>';
            echo '</form>';
        }
    }
    else{
       echo '<form method="post" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '">';
        echo "<p>$frage</p>";
        echo '<ul>';
        echo "<li><input type='radio' name='1' value='1'> $antwort1</li>";
        echo "<li><input type='radio' name='1' value='2'> $antwort2</li>";
        echo "<li><input type='radio' name='1' value='3'> $antwort3</li>";
        echo '</ul>';
        // Weitere Fragen und Antworten hier einfügen
        echo '<input type="hidden" id="countdownValue" name="countdownValue" value="">';
        echo '<input type="submit" id="submitBtn" value="Antworten überprüfen">';
        echo '<p id="countdownTimer"></p>';
        echo '<p id="ergebnis"></p>';
        echo '</form>';
    }
}

// Verbindung schließen
$conn->close();
?>

<script>
window.onload = function() {
    startTimer(); // Timer starten, wenn die Seite geladen wird
};

function startTimer() {
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
            document.getElementById("countdownTimer").innerHTML = "Nächster Versuch in " + Math.round(countdown / 100, 0) + " Sekunden";
            document.getElementById("countdownValue").value = countdown; // Countdown-Wert aktualisieren
            if (countdown <= 0) {
                clearInterval(countdownInterval); // Countdown beenden
                document.getElementById("countdownTimer").innerHTML = ""; // Timer ausblenden
                document.getElementById("submitBtn").disabled = true; // Submit-Button deaktivieren
                document.getElementById("countdownValue").value = 0; // Countdown-Wert auf 0 setzen
            }
        }, 10); // Update alle 1000 Millisekunden (1 Sekunde)
    }, 3000); // Starte den Countdown nach 3 Sekunden
}
</script>

<link rel="stylesheet" href="quiz2.css">
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

<?php
// Starte die PHP-Session
session_start();
// Inkludiere die Konfigurationsdatei
include 'config.php';

// Verbindung zur Datenbank herstellen
$con = new mysqli($servername, $username, $password, $dbname);

// Überprüfen, ob die Verbindung erfolgreich war
if ($con->connect_error) {
    die("Verbindung fehlgeschlagen: " . $con->connect_error);
}

// Funktion zur Berechnung der Punkte
function calculatePoints($countdown) {
    return round($countdown, 0); 
}

// Initialisierung von Variablen
$frage_thema = "";
$antwort_thema = "";
//die id und thema aus dem vorherigen programm druchlauf holen oder das thema beim ersten programdurchlauf aus der hauptseite hollen
$id = isset($_GET['id']) ? intval($_GET['id']) : 1;
$vorherige_id = isset($_GET['vorherige_id']) ? intval($_GET['vorherige_id']) : 0;
$thema = $_GET['thema'] ?? 1;

$frage_id = $id;

// Bestimme das Frage- und Antwortthema basierend auf dem ausgewählten Thema
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

// Abfrage, um die maximale Frage-ID abzurufen
$sql_maxfragen = "SELECT max(frage_id) as max_id FROM $antwort_thema";
$sql_maxfragenresult = mysqli_query($con, $sql_maxfragen);
$sql_maxfragenid = mysqli_fetch_assoc($sql_maxfragenresult)['max_id'];

// Variable zur Anzeige der Frage initialisieren
$show_question = false;

// Überprüfen, ob das Formular abgeschickt wurde und überprüfen ob etwas entfangen wurde
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Benutzername festlegen
    $benutzername = isset($_SESSION['benutzername']) ? $_SESSION['benutzername'] : "Gast";

    if(isset($_POST['next'])) {
        // Wenn 'Nächste Frage' geklickt wurde, Frage anzeigen
        $show_question = true;
    } else {
        // Wenn eine Antwort übergeben wurde
        if(isset($_POST['1'])){
            $antwort_id = htmlspecialchars($_POST['1']);
        } else {
            //antwort id auf etwas setzen was nichts ausgeben kann
            $antwort_id = -1;
        }
        
        // Auswertung der Antwort
        $korrekte_antwort_query = "SELECT korrekt FROM $antwort_thema WHERE frage_id = '$frage_id' AND antwort_id = '$antwort_id'";
        $korrekte_antwort_result = mysqli_query($con, $korrekte_antwort_query);

        if (mysqli_num_rows($korrekte_antwort_result) > 0) {
            $row = mysqli_fetch_assoc($korrekte_antwort_result);
            $korrekt = $row['korrekt'];
            if ($korrekt == 1) {
                // Wenn die Antwort korrekt ist
                $countdown = $_POST['countdownValue']; 
                $points = calculatePoints($countdown);
                // Punkte anzeigen und aktualisieren
                echo "<p id='correctText'>Die Antwort ist korrekt! <span id='points'>Punkte: $points</span></p>";
                $sql_punkte = "UPDATE userdaten SET gesamt_punkte = gesamt_punkte + '$points' WHERE username = '$benutzername'";
                mysqli_query($con, $sql_punkte);
                // Gesamtzahl der Fragen und korrekt beantworteten Fragen aktualisieren
                $sql_fragen = "UPDATE userdaten SET gesamt_fragen = gesamt_fragen + 1 WHERE username = '$benutzername'";
                mysqli_query($con, $sql_fragen);
                $sql_richtig = "UPDATE userdaten SET richtig_beantwortet = richtig_beantwortet + 1 WHERE username = '$benutzername'";
                mysqli_query($con, $sql_richtig);
                $id++;
                $vorherige_id++;
                $beantwortet = true;
            } else {
                // Wenn die Antwort falsch ist
                echo "<p id='wrongText'>Die Antwort ist falsch!</p>";
                $sql_fragen = "UPDATE userdaten SET gesamt_fragen = gesamt_fragen + 1 WHERE username = '$benutzername'";
                mysqli_query($con, $sql_fragen);
                $id++;
                $vorherige_id++;
                $beantwortet = true;
            }  
        } else {
            // Wenn keine Antwort eingegeben wurde
            echo "<p id='noAnswerText'>Antwort wurde nicht eingegeben!</p>";
            $id++;
            $vorherige_id++;
        }

        // Wenn es weitere Fragen gibt, zeige den 'Nächste Frage'-Button an, sonst beende das Quiz
        if ($id <= $sql_maxfragenid) {
            echo '<form class="quiz-form" method="post" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '?thema=' . $thema . '&id=' . $id . '&vorherige_id=' . $vorherige_id . '">';
            echo "<input type='submit' name='next' id='nextBtn' value='Nächste Frage'>";
            echo "</form>";
        } else {
            echo "<div id='quizEndContainer'>";
            echo "<p id='quizEndText'>Quiz beendet</p>";
            echo "<div id='mainPageLink'><a href='hauptseite.php'>Haupseite</a></div>";
            echo "</div>";
        }
    }
}

// Wenn es weitere Fragen gibt, und die der button Näcshte frage gedrückt wurde
if ($id <= $sql_maxfragenid) {
    if ($show_question || $id == 1) {
        // Frage und Antworten aus der Datenbank abrufen und anzeigen
        $sql_fragetext = "SELECT frage_text FROM $frage_thema WHERE frage_id = $id"; 
        $result_fragetext = mysqli_query($con, $sql_fragetext);
        $frage ="";
        if($row = $result_fragetext->fetch_assoc()) {
            $frage = $row["frage_text"];
        }
        $result_fragetext->close();

        $sql_antworttext1 = "SELECT antwort_text FROM $antwort_thema WHERE frage_id = $id AND antwort_id = 1";
        $result_antworttext1 = mysqli_query($con, $sql_antworttext1);
        $antwort1 = $result_antworttext1->fetch_assoc()['antwort_text'];
        $result_antworttext1->close();

        $sql_antworttext2 = "SELECT antwort_text FROM $antwort_thema WHERE frage_id = $id AND antwort_id = 2";
        $result_antworttext2 = mysqli_query($con, $sql_antworttext2);
        $antwort2 = mysqli_fetch_assoc($result_antworttext2)['antwort_text'];
        $result_antworttext2->close();

        $sql_antworttext3 = "SELECT antwort_text FROM $antwort_thema WHERE frage_id = $id AND antwort_id = 3";
        $result_antworttext3 = mysqli_query($con, $sql_antworttext3);
        $antwort3 = mysqli_fetch_assoc($result_antworttext3)['antwort_text'];
        $result_antworttext3->close();

        // Formular zur Anzeige der Frage und Antworten
        echo '<form class="quiz-form" method="post" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '?thema=' . $thema . '&id=' . $id . '&vorherige_id=' . $vorherige_id . '">';
        echo "<div class='question'>$frage</div>";
        echo '<ul class="answers">';
        echo "<li><input type='radio' name='1' value='1'> <span class='answer-text'>$antwort1</span></li>";
        echo "<li><input type='radio' name='1' value='2'> <span class='answer-text'>$antwort2</span></li>";
        echo "<li><input type='radio' name='1' value='3'> <span class='answer-text'>$antwort3</span></li>";
        echo '</ul>';

        // Hidden Input für Countdown und Submit-Button um die werte mit post zu übergeben
        echo '<input type="hidden" id="countdownValue" name="countdownValue" value="">';
        echo '<input type="submit" id="submitBtn"  value="Antworten überprüfen">';
        echo '<p id="countdownTimer"></p>';
        echo '<p id="ergebnis"></p>';
        echo '</form>';
    }   
}

// Datenbankverbindung schließen
$con->close();
?>

<script>
// Nach 2 Sekunden den Submit-Button animieren
setTimeout(function() {
    var btn = document.getElementById('submitBtn');
    btn.style.backgroundColor = "#4CAF50"; 
    btn.style.cursor = "pointer";
    btn.classList.add('animating');
}, 2000);

// Timer starten, wenn die Seite geladen wird
window.onload = function() {
    startTimer();
};

function startTimer() {
    // Submit-Button deaktivieren
    document.getElementById("submitBtn").disabled = true;
    var fullPoints = 1000;
    var countdown = 1000; // Start Countdown-Wert

    // Countdown für die erste Verzögerung von 3 Sekunden
    setTimeout(function() {
        // Submit-Button aktivieren
        document.getElementById("submitBtn").disabled = false;

        // Countdown für die zweite Verzögerung von 10 Sekunden
        var countdownInterval = setInterval(function() {
            countdown--;
            document.getElementById("countdownTimer").innerHTML = "Verbleibende Zeit " + Math.round(countdown / 100, 0) + " Sekunden";
            document.getElementById("countdownValue").value = countdown; // Countdown-Wert aktualisieren
            if (countdown <= 0) {
                clearInterval(countdownInterval); // Countdown beenden
                document.getElementById("countdownTimer").innerHTML = ""; // Timer ausblenden
                document.getElementById("submitBtn").disabled = true; // Submit-Button deaktivieren
                document.getElementById("countdownValue").value = 0; // Countdown-Wert auf 0 setzen
                document.querySelector('form').submit();
            }
        }, 10); // Update alle 1000 Millisekunden (1 Sekunde)
    }, 3000); // Starte den Countdown nach 3 Sekunden
}
</script>

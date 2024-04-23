
<link rel="stylesheet" href="quiz2.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
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
$frage_thema = "";
$antwort_thema = "";
$id = isset($_GET['id']) ? intval($_GET['id']) : 1;
$vorherige_id = isset($_GET['vorherige_id']) ? intval($_GET['vorherige_id']) : 0;
$thema = $_GET['thema'] ?? 1;
$frage_id = $id;
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
$sql_maxfragen = "SELECT max(frage_id) as max_id FROM $antwort_thema";
$sql_maxfragenresult = mysqli_query($conn, $sql_maxfragen);
$sql_maxfragenid = mysqli_fetch_assoc($sql_maxfragenresult)['max_id'];
$show_question = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_SESSION['benutzername'])) {
        $benutzername = $_SESSION['benutzername'];
    }
    else {
        $benutzername = "Gast";
    }
    if(isset($_POST['next']))
    {
    $show_question = true;
    }
    else {
        if(isset($_POST['1'])){
            $antwort_id = htmlspecialchars($_POST['1']);
        }
        else {
            $antwort_id = -1;
        }
        //auswertung der Antwort

        $korrekte_antwort_query = "SELECT korrekt FROM $antwort_thema WHERE frage_id = '$frage_id' AND antwort_id = '$antwort_id'";
        $korrekte_antwort_result = mysqli_query($conn, $korrekte_antwort_query);

        if (mysqli_num_rows($korrekte_antwort_result) > 0) {
            $row = mysqli_fetch_assoc($korrekte_antwort_result);
            $korrekt = $row['korrekt'];
            if ($korrekt == 1) {
                $countdown = $_POST['countdownValue']; 
                $points = calculatePoints($countdown);
                echo "<p id='correctText'>Die Antwort ist korrekt! <span id='points'>Punkte: $points</span></p>";
                 $sql_punkte = "UPDATE userdaten SET gesamt_punkte = gesamt_punkte + '$points' WHERE username = '$benutzername'";
                mysqli_query($conn, $sql_punkte);
                $sql_fragen = "UPDATE userdaten SET gesamt_fragen = gesamt_fragen + 1 WHERE username = '$benutzername'";
                mysqli_query($conn, $sql_fragen);
                $sql_richtig = "UPDATE userdaten SET richtig_beantwortet = richtig_beantwortet + 1 WHERE username = '$benutzername'";
                mysqli_query($conn, $sql_richtig);
                $id++;
                $vorherige_id++;
                $beantwortet = true;
            } else {
                echo "<p id='wrongText'>Die Antwort ist falsch!</p>";
                $sql_fragen = "UPDATE userdaten SET gesamt_fragen = gesamt_fragen + 1 WHERE username = '$benutzername'";
                mysqli_query($conn, $sql_fragen);
                $id++;
                $vorherige_id++;
                $beantwortet = true;
            }  
        } 
        else {
            echo "<p id='noAnswerText'>Antwort wurde nicht eingegeben!</p>";
            $id++;
            $vorherige_id++;
        }
        if ($id <= $sql_maxfragenid)
        {
            echo '<form class="quiz-form" method="post" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '?thema=' . $thema . '&id=' . $id . '&vorherige_id=' . $vorherige_id . '">';
            echo "<input type='submit' name='next' id='nextBtn' value='Nächste Frage'>";
            echo "</form>";
        }
        else{echo "<div id='quizEndContainer'>";
            echo "<p id='quizEndText'>Quiz beendet</p>";
            echo "<div id='mainPageLink'><a href='hauptseite.php'>Haupseite</a></div>";
            echo "</div>";
            

        }
        //ende auswertung der antwort
    }
}
if ($id <= $sql_maxfragenid)
{
    if ($show_question || $id == 1) 
    {
        //fragen hollen und anzeigen
        $sql_fragetext = "SELECT frage_text FROM $frage_thema WHERE frage_id = $id"; 
        $result_fragetext = mysqli_query($conn, $sql_fragetext);
        $frage ="";
        if( $row=$result_fragetext->fetch_assoc())
        {
            $frage =$row["frage_text"];
        }
        $result_fragetext->close();

        $sql_antworttext1 = "SELECT antwort_text FROM $antwort_thema WHERE frage_id = $id AND antwort_id = 1";
        $result_antworttext1 = mysqli_query($conn, $sql_antworttext1);
        $antwort1 = $result_antworttext1->fetch_assoc()['antwort_text'];
        $result_antworttext1->close();

        $sql_antworttext2 = "SELECT antwort_text FROM $antwort_thema WHERE frage_id = $id AND antwort_id = 2";
        $result_antworttext2 = mysqli_query($conn, $sql_antworttext2);
        $antwort2 = mysqli_fetch_assoc($result_antworttext2)['antwort_text'];
        $result_antworttext2->close();

        $sql_antworttext3 = "SELECT antwort_text FROM $antwort_thema WHERE frage_id = $id AND antwort_id = 3";
        $result_antworttext3 = mysqli_query($conn, $sql_antworttext3);
        $antwort3 = mysqli_fetch_assoc($result_antworttext3)['antwort_text'];
        $result_antworttext3->close();

        echo '<form class="quiz-form" method="post" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '?thema=' . $thema . '&id=' . $id . '&vorherige_id=' . $vorherige_id . '">';

        echo "<div class='question'>$frage</div>";
        echo '<ul class="answers">';
        echo "<li><input type='radio' name='1' value='1'> <span class='answer-text'>$antwort1</span></li>";
        echo "<li><input type='radio' name='1' value='2'> <span class='answer-text'>$antwort2</span></li>";
        echo "<li><input type='radio' name='1' value='3'> <span class='answer-text'>$antwort3</span></li>";
        echo '</ul>';

        echo '<input type="hidden" id="countdownValue" name="countdownValue" value="">';
        echo '<input type="submit" id="submitBtn"  value="Antworten überprüfen">';
        echo '<p id="countdownTimer"></p>';
        echo '<p id="ergebnis"></p>';
        echo '</form>';
    }   
}
// Verbindung schließen
$conn->close();
?>

<script>
    setTimeout(function() {
    var btn = document.getElementById('submitBtn');
    btn.style.backgroundColor = "#4CAF50"; 
    btn.style.cursor = "pointer";
    btn.classList.add('animating');
}, 2000);



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

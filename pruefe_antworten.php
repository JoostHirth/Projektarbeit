<?php
include 'config.php'; // Stellen Sie sicher, dass die Konfigurationsdatei eingebunden ist

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $selectedAnswers = $_POST['selected_answers'];
    $correctAnswersCount = 0;

    $con = new mysqli($servername, $username, $password, $dbname);
    if ($con->connect_error) {
        die("Error connecting to server" . $con->connect_error);
    }

    foreach ($selectedAnswers as $frage_id => $selectedAntwortId) {
        // Abrufen der korrekten Antwort aus der Datenbank
        $sql = "SELECT antwort_id FROM quiz_antwort WHERE frage_id = $frage_id AND korrekt = 1";
        $result = $con->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $correctAntwortId = $row['antwort_id'];

            // Überprüfen, ob die ausgewählte Antwort korrekt ist
            if ($selectedAntwortId == $correctAntwortId) {
                $correctAnswersCount++;
                echo "richtig";
                echo "$correctAnswersCount";
            }
        }
    }

    $points = $correctAnswersCount +1; 
    echo "Punkte: $points"; 

    $con->close();
}
?>

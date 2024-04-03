<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz</title>
    <script>
        var fullPoints = 1000; 

        function startTimerWithDelay() {
            setTimeout(startTimer, 5000); // Verzögerung von 5 Sekunden (5000 Millisekunden)
        }

        function startTimer() {
            window.startTime = new Date().getTime(); // Startzeit in Millisekunden
        }

        function stopTimer() {
            if (window.startTime) {
                var endTime = new Date().getTime(); 
                var elapsedTime = (endTime - window.startTime) / 1000; 
                var points = calculatePoints(elapsedTime); 
                document.getElementById("ergebnis").innerHTML = "Punkte: " + points;
            }
        }

        function calculatePoints(elapsedTime) {
            return (elapsedTime < 5) ? fullPoints : Math.round(fullPoints - (elapsedTime - 5) * 200, 0);
        }

        function pruefeAntworten() {
            stopTimer(); 
            
            var elapsedTime = 0;
            if (window.startTime) {
                elapsedTime = (new Date().getTime() - window.startTime) / 1000;
            }
            var points = calculatePoints(elapsedTime); // Punkte berechnen
            document.getElementById("ergebnis").innerHTML = "Punkte: " + points;

            // Das Formular mit den Benutzerantworten senden
            document.getElementById("antwortenForm").submit();
        }
    </script>
</head>
<body onload="startTimerWithDelay()">
    <div class="container">
        <div class="title">
            <h1>QUIZIFY</h1>
            <h3>BKI QUIZ GAME</h3>
        </div>
        
        <div class="container2">
            <form id="antwortenForm" action="pruefe_antworten.php" method="post">
                <?php
                include 'config.php';
                $con = new mysqli($servername, $username, $password, $dbname);
                if ($con->connect_error) {
                    die("Error connecting to server" . $con->connect_error);
                }

                $sql = "SELECT frage_id, frage_text FROM quiz_frage";
                $result = $con->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $frage_id = $row['frage_id'];
                        $frage_text = $row['frage_text'];

                        echo "<h3>Frage $frage_id:</h3>";
                        echo "<p>$frage_text</p>";

                        $antwort_sql = "SELECT antwort_id, antwort_text FROM quiz_antwort WHERE frage_id = $frage_id";
                        $antwort_result = $con->query($antwort_sql);

                        if ($antwort_result->num_rows > 0) {
                            while ($antwort_row = $antwort_result->fetch_assoc()) {
                                $antwort_id = $antwort_row['antwort_id'];
                                $antwort_text = $antwort_row['antwort_text'];
                                echo "<label><input type='radio' name='antwort_$frage_id' value='$antwort_id'> $antwort_text</label><br>";
                            }
                        } else {
                            echo "Keine Antworten gefunden.";
                        }
                    }

                    echo "<button type='button' onclick='pruefeAntworten()'>Antworten überprüfen</button>";
                    echo "<div id='ergebnis'></div>";
                } else {
                    echo "Keine Fragen gefunden.";
                }

                $con->close();
                ?>
            </form>
        </div>
    </div>
</body>
</html>

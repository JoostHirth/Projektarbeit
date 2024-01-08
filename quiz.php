<?php
include 'login.php';

$con = new mysqli($servername, $username, $password, $dbname);

if ($con->connect_error) {
    die("Error connecting to server" . $con->connect_error);
}

// Beispiel: Alle Fragen und zugehörigen Antworten abrufen
$sql = "SELECT frage_id, frage_text FROM quiz_frage";
$result = $con->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $frage_id = $row['frage_id'];
        $frage_text = $row['frage_text'];

        echo "<h3>Frage $frage_id:</h3>";
        echo "<p>$frage_text</p>";

        // Antworten zur aktuellen Frage abrufen
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

    echo "<button onclick='pruefeAntworten()'>Antworten überprüfen</button>";
    echo "<div id='ergebnis'></div>";
} else {
    echo "Keine Fragen gefunden.";
}

$con->close();
?>

<script>
function pruefeAntworten() {
    var antworten = document.querySelectorAll('input[type="radio"]:checked');
    var antwortIds = Array.from(antworten).map(input => input.value);
    var frageIds = Array.from(antworten).map(input => input.name.split('_')[1]);

    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            document.getElementById('ergebnis').innerHTML = xhr.responseText;
        }
    };

    xhr.open('POST', 'pruefe_antworten.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.send('antwortIds=' + antwortIds.join(',') + '&frageIds=' + frageIds.join(','));
}
</script>


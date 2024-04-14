<?php
session_start();
include 'config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hauptseite</title>
</head>
<body>

<?php
$con = new mysqli($servername, $username, $password, $dbname);
if ($con->connect_error) {
    die("Error connecting to server" . $con->connect_error);
}

// SQL-Abfrage, um die Top-10-Werte von allen Benutzern abzurufen
$sql = "SELECT username, gesamt_punkte, richtig_beantwortet, gesamt_fragen
        FROM userdaten
        ORDER BY gesamt_punkte DESC
        LIMIT 10";

$result = mysqli_query($con, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    echo "<h3>Top 10 Spieler</h3>";
    echo "<table>";
    echo "<tr><th>Benutzername</th><th>Gesamtpunkte</th><th>Richtig beantwortet</th><th>Gesamt beantwortet</th></tr>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row['username'] . "</td>";
        echo "<td>" . $row['gesamt_punkte'] . "</td>";
        echo "<td>" . $row['richtig_beantwortet'] . "</td>";
        echo "<td>" . $row['gesamt_fragen'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "Keine Daten verfügbar.";
}


// Verbindung zur Datenbank schließen
mysqli_close($con);


    if (isset($_SESSION['benutzername'])) {
        echo "<p>Angemeldet als: " . $_SESSION['benutzername'] . " (<a href='abmelden.php'>Abmelden</a>)</p>";
        echo "<p><a href='profil.php'>Profil anzeigen</a></p>"; 
    } else {
        echo "<p><a href='login_form.htm'>Anmelden</a> | <a href='regestrieren_form.htm'>Registrieren</a></p>";
    }
    ?>

    <h3>Wähle ein Quiz-Thema:</h3>
    <ul>
        <li><a href='quiz.php'>Quiz Thema 1</a></li>
        <li><a href='quiz.php'>Quiz Thema 2</a></li>
        <li><a href='quiz.php'>Quiz Thema 3</a></li>
        <li><a href='quiz.php'>Quiz Thema 4</a></li>
    </ul>
</body>
</html>

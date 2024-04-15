<?php
session_start();
include 'config.php';

// Überprüfen, ob ein Benutzer angemeldet ist
if (!isset($_SESSION['benutzername'])) {
    die("Benutzer ist nicht angemeldet.");
}

$con = new mysqli($servername, $username, $password, $dbname);
if ($con->connect_error) {
    die("Error connecting to server" . $con->connect_error);
}

$benutzername = $_SESSION['benutzername'];

// SQL-Abfrage, um die Statistiken des angemeldeten Benutzers abzurufen
$sql = "SELECT gesamt_punkte, richtig_beantwortet, gesamt_fragen
        FROM userdaten
        WHERE username = '$benutzername'";

$result = mysqli_query($con, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    echo "<h3>Deine Statistiken</h3>";
    echo "<p>Gesamtpunkte: " . $row['gesamt_punkte'] . "</p>";
    echo "<p>Richtig beantwortet: " . $row['richtig_beantwortet'] . "</p>";
    echo "<p>Gesamt beantwortet: " . $row['gesamt_fragen'] . "</p>";
    if ($row['gesamt_fragen']> 0){
        echo "<p>WR: " . ( $row['richtig_beantwortet'] /  $row['gesamt_fragen'])*100  ."%</p>";
    }
    else {
        echo "";
    }
} else {
    echo "Keine Statistiken verfügbar.";
}

?>

<?php
session_start();
include 'config.php';
$con = new mysqli($servername, $username, $password, $dbname);
if ($con->connect_error) {
    die("Error connecting to server" . $con->connect_error);
}

// Stellen Sie sicher, dass der Benutzer angemeldet ist
if (!isset($_SESSION['benutzername'])) {
    header("Location: login_form.htm"); // Benutzer umleiten, wenn nicht angemeldet
    exit();
}

// SQL-Abfrage, um Benutzerstatistiken abzurufen
$benutzername = $_SESSION['benutzername'];
$sql = "SELECT COUNT(*) AS total_fragen, 
               SUM(korrekt) AS richtig_beantwortet 
        FROM ergebnisse 
        WHERE benutzer_id = (SELECT ID FROM userdaten WHERE username = '$benutzername')";

$result = mysqli_query($con, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $total_fragen = $row['total_fragen'];
    $richtig_beantwortet = $row['richtig_beantwortet'];

    // Statistiken anzeigen
    echo "<h3>Profilstatistiken für " . $benutzername . "</h3>";
    echo "<p>Beantwortete Fragen: " . $total_fragen . "</p>";
    echo "<p>Richtig beantwortete Fragen: " . $richtig_beantwortet . "</p>";
} else {
    echo "Keine Statistiken verfügbar.";
}
?>

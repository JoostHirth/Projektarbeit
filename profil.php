<link rel="stylesheet" href="profil2.css">
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
<nav class="sidebar">

<h2>Credits</h2>
    <h4>Danke an:</h4>
    <h3>Development</h3>
    <p>Alexander Diehl</p>
    <p>Elias Konieczny</p>
    <p>ChatGPT</p>
    <p>W3Schools</p>
    <p>Bard / Gemini</p>
    <h3>Art-Designer</h3>
    <p>Lilly Snow</p>
    <p>ansimuz</p>
    <p>Mounir Tohami</p>
    <p>Screaming Brain Studios</p>

    
    <footer>
        <nav>
           <button class="nez"> <a href="hauptseite.php">Zurück</a></button>
        </nav>
    </footer>
</nav>
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
    echo "<div class='statistics-wrapper'>";
    echo "<h3>Deine Statistiken</h3>";
    echo "<div class='user-statistics'>";
    echo "<div class='statistic-item'><p>Gesamtpunkte:</p> <span>" . $row['gesamt_punkte'] . "</span></div>";
    echo "<div class='statistic-item'><p>Richtig beantwortet:</p> <span>" . $row['richtig_beantwortet'] . "</span></div>";
    echo "<div class='statistic-item'><p>Gesamt beantwortet:</p> <span>" . $row['gesamt_fragen'] . "</span></div>";
    if ($row['gesamt_fragen'] > 0) {
        echo "<div class='statistic-item'>WR: <span>" . ($row['richtig_beantwortet'] / $row['gesamt_fragen']) * 100 . "%</span></div>";
    }
    echo "</div>"; // Closing user-statistics div
    echo "</div>"; // Closing statistics-wrapper div
} else {
    echo "Keine Statistiken verfügbar.";
}



?>

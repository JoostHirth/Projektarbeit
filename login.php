<?php
session_start();

$servername = "localhost";
$username = "Joost";
$password = "12345";
$dbname = "quiz";

$con = new mysqli($servername, $username, $password, $dbname);
//marko
if ($con->connect_error) {
    die("Error connecting to server" . $con->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $benutzername = $_POST['benutzername'];
    $passwort = $_POST['passwort'];

    $sql = "SELECT * FROM userdaten WHERE username='$benutzername'";
    $result = $con->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($passwort, $row['passwort'])) {
            $_SESSION['benutzername'] = $benutzername;
            header("Location: hauptseite.php");
            exit;
        } else {
            echo "Falsches Passwort!";
        }
    } else {
        echo "Benutzer nicht gefunden!";
    }
}

$con->close();
?>
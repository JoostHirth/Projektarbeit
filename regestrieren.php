<?php
session_start();

$servername = "localhost";
$username = "Joost";
$password = "12345";
$dbname = "quiz";

$con = new mysqli($servername, $username, $password, $dbname);

if ($con->connect_error) {
    die("Error connecting to server" . $con->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $benutzername = $_POST['benutzername'];
    $passwort = password_hash($_POST['passwort'], PASSWORD_DEFAULT);

    // Überprüfen, ob der Benutzername bereits vorhanden ist
    $check_sql = "SELECT * FROM userdaten WHERE username='$benutzername'";
    $check_result = $con->query($check_sql);

    if ($check_result->num_rows > 0) {
        echo "Benutzername bereits vergeben. Bitte wähle einen anderen.";
    } else {
        $sql = "INSERT INTO userdaten (username, passwort) VALUES ('$benutzername', '$passwort')";

        if ($con->query($sql) === TRUE) {
            $_SESSION['benutzername'] = $benutzername;
            header("Location: hauptseite.php");
            exit;
        } else {
            echo "Fehler bei der Benutzerkontenerstellung: " . $con->error;
        }
    }
}

$con->close();
?>

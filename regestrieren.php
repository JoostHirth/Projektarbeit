<link rel="stylesheet" href="regestrierenPHP.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

<?php
session_start();
include 'config.php';

$con = new mysqli($servername, $username, $password, $dbname);

if ($con->connect_error) {
    die("Error connecting to server" . $con->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $benutzername = $_POST['benutzername'];
    $passwort = password_hash($_POST['passwort'], PASSWORD_DEFAULT);

    $check_sql = "SELECT * FROM userdaten WHERE username='$benutzername'";
    $check_result = $con->query($check_sql);

    if ($check_result->num_rows > 0) {
        echo '<div class="container">';
        echo '<div class="error-message-container">';
        echo '<h2>Problem occurred ): </h2>';
        echo '<div class="error-message">User already in use</div>';
        echo '<a href="regestrieren_form.htm" class="register-button">Zurück zur Registrierung</a>';
        echo '</div>';
        echo '</div>';
        exit;
    } else {
        $sql = "INSERT INTO userdaten (username, passwort) VALUES ('$benutzername', '$passwort')";

        if ($con->query($sql) === TRUE) {
            $_SESSION['benutzername'] = $benutzername;
            header("Location: hauptseite.php");
            exit;
        } else {
            echo "error";
            exit;
        }
    }
}

$con->close();
?>

<?php
session_start();
include 'config.php';

$con = new mysqli($servername, $username, $password, $dbname);

if ($con->connect_error) {
    die("Error connecting to server" . $con->connect_error);
}

$errorMessage = ""; // Initialisiere die Fehlermeldung

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
            $errorMessage = "Falsches Passwort!";
        }
    } else {
        $errorMessage = "Benutzer nicht gefunden!";
    }
}

$con->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login_form2.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Login</title>
</head>
<body>
    <div class="container">
        <div class="title">
            <h1>QUIZIFY</h1>
            <h3>Anmelden</h3>
        </div>

        <div class="container2">
            <div class="login-form">
                <form action="login.php" method="post">
                    Benutzername: <input type="text" class="name" name="benutzername" required><br>
                    Passwort: <input type="password" class="password" name="passwort" required><br>
                    <button type="submit" class="button1">Anmelden</button>         

                </form>
                <?php if ($errorMessage != "") { ?>
                    <div class="error"><?php echo $errorMessage; ?></div>
                <?php } ?>
            </div>
                    
            <button class="return" onclick="window.history.back();">
                <i class='bx bx-arrow-back'></i>
                <span>Return</span>    
            </button>
        </div>
    </div>
</body>
</html>

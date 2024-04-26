<?php
session_start();
include 'config.php';

$con = new mysqli($servername, $username, $password, $dbname);

if ($con->connect_error) {
    die("Error connecting to server" . $con->connect_error);
}

$errorMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $benutzername = $_POST['benutzername'];
    $passwort = password_hash($_POST['passwort'], PASSWORD_DEFAULT);

    $check_sql = "SELECT * FROM userdaten WHERE username='$benutzername'";
    $check_result = $con->query($check_sql);

    if ($check_result->num_rows > 0) {
        $errorMessage = "Wrong Username or Password";
    } else {
        $sql = "INSERT INTO userdaten (username, passwort) VALUES ('$benutzername', '$passwort')";

        if ($con->query($sql) === TRUE) {
            $_SESSION['benutzername'] = $benutzername;
            header("Location: hauptseite.php");
            exit;
        } else {
            $errorMessage = "Fehler bei der Benutzerkontenerstellung: " . $con->error;
        }
    }
}

$con->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="registrieren3.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Login</title>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var errorMessage = "<?php echo $errorMessage; ?>";
            var form = document.querySelector('form');

            form.addEventListener('submit', function (event) {
                event.preventDefault(); 

                var benutzername = document.querySelector('.name').value;
                var passwort = document.querySelector('.password').value;

                
                if (benutzername === "" || passwort === "") {
                    document.getElementById("error-message").innerText = "Bitte geben Sie Benutzername und Passwort ein!";
                    document.getElementById("error-message").style.display = "block";

                    
                    setTimeout(function() {
                        document.getElementById("error-message").style.display = "none";
                    }, 3000);

                    return;
                }

                if (errorMessage !== "") {
                    document.getElementById("error-message").innerText = errorMessage;
                    document.getElementById("error-message").style.display = "block";

                    setTimeout(function() {
                        document.getElementById("error-message").style.display = "none";
                    }, 3000);
                }
            });
        });
    </script>
</head>
<body>
    <div class="container">
        <div class="title">
            <h1>QUIZIFY</h1>
            <h3>Login</h3>
        </div>

        <div class="container2">
            <div class="regestrieren-form">
                <form id="register-form" action="regestrieren.php" method="post">
                    Benutzername: <input type="text" class="name" name="benutzername" required><br>
                    Passwort: <input type="password" class="password" name="passwort" required><br>
                    <button type="submit" class="button1">Registrieren</button>
                </form>
                <div id="error-message" class="error-message"></div>
            </div>
                    
            <button class="return" onclick="window.history.back();">
                <i class='bx bx-arrow-back'></i>
                <span>Return</span>    
            </button>
        </div>
    </div>
</body>
</html>

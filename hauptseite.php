<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hauptseite</title>
</head>
<body>
    <h2>Willkommen bei Quizify</h2>

    <?php
    if (isset($_SESSION['benutzername'])) {
        echo "<p>Angemeldet als: " . $_SESSION['benutzername'] . " (<a href='abmelden.php'>Abmelden</a>)</p>";
    } else {
        echo "<p><a href='login_form.htm'>Anmelden</a> | <a href='regestrieren_form.htm'>Registrieren</a></p>";
    }
    ?>

    <h3>Wähle ein Quiz-Thema:</h3>
    <ul>
        <li><a href='quiz.php'>Quiz Thema 1</a></li>
    </ul>
</body>
</html>

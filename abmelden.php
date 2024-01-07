<?php
session_start();
session_destroy();
header("Location: hauptseite.php");
exit;
?>

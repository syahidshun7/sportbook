<?php
session_start();
$_SESSION = [];
session_destroy();
setcookie("user", "", time() - 3600, "/");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Logout</title>
</head>
<body>
    <p>Session dan Cookie telah dihapus.</p>
    <a href="login.php">Kembali ke login</a>
</body>
</html>

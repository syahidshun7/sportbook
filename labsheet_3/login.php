<?php
session_start();

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"] ?? "");

    if ($username !== "") {
        $_SESSION["username"] = $username;
        setcookie("user", $username, time() + 86400, "/");
        $message = "Session dan Cookie telah disimpan untuk " . htmlspecialchars($username);
    } else {
        $message = "Username tidak boleh kosong.";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Session & Cookie</title>
</head>
<body>
    <h2>Login</h2>
    <form method="POST" action="">
        <input type="text" name="username" placeholder="Masukkan username">
        <button type="submit">Simpan</button>
    </form>
    <p><?php echo $message; ?></p>
    <a href="logout.php">Logout</a>
</body>
</html>

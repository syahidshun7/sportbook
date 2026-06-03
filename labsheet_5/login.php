<?php
require_once __DIR__ . '/assets/helpers.php';

if (isLoggedIn()) {
    redirectTo('index.php');
}

$error = '';
$lastUsername = $_COOKIE['last_username'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    // Validasi tambahan: field tidak boleh kosong.
    if ($username === '' || $password === '') {
        $error = 'Username dan password wajib diisi.';
    } else {
        $akun = [
            'admin' => '12345',
        ];

        if (isset($akun[$username]) && $akun[$username] === $password) {
            $_SESSION['is_login'] = true;
            $_SESSION['username'] = $username;

            // Cookie sederhana untuk menyimpan riwayat login.
            setcookie('last_username', $username, time() + (7 * 24 * 60 * 60), '/');
            setcookie('last_login', date('Y-m-d H:i:s'), time() + (7 * 24 * 60 * 60), '/');

            redirectTo('index.php');
        } else {
            $error = 'Username atau password tidak valid.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Labsheet 5</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container auth-box">
        <h1>Login Sistem Mahasiswa</h1>
       

        <?php if ($error !== ''): ?>
            <div class="alert alert-error"><?= e($error); ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" value="<?= e($lastUsername); ?>" autocomplete="username">

            <label for="password">Password</label>
            <input type="password" id="password" name="password" autocomplete="current-password">

            <button type="submit">Masuk</button>
        </form>
    </div>
</body>
</html>

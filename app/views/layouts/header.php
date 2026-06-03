<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sportbook</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/style.css">
</head>
<body>
<nav class="navbar">
    <a href="<?= BASE_URL ?>/venues" class="brand">⚽ Sportbook</a>
    <div class="nav-links">
        <?php if (isLoggedIn()): ?>
            <?php if (isAdmin()): ?>
                <a href="<?= BASE_URL ?>/admin">Dashboard</a>
                <a href="<?= BASE_URL ?>/admin/venues">Venue</a>
                <a href="<?= BASE_URL ?>/admin/bookings">Booking</a>
                <a href="<?= BASE_URL ?>/admin/payments">Pembayaran</a>
            <?php else: ?>
                <a href="<?= BASE_URL ?>/venues">Venue</a>
                <a href="<?= BASE_URL ?>/my-bookings">Booking Saya</a>
            <?php endif; ?>
            <span class="user-name">👤 <?= e($_SESSION['nama']) ?></span>
            <a href="<?= BASE_URL ?>/logout" class="btn-logout">Logout</a>
        <?php else: ?>
            <a href="<?= BASE_URL ?>/login">Login</a>
            <a href="<?= BASE_URL ?>/register" class="btn-primary">Daftar</a>
        <?php endif; ?>
    </div>
</nav>
<main class="container">

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin – ArenaSports</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/admin.css">
</head>
<body>

<!-- Overlay for mobile sidebar -->
<div class="adm-overlay" id="admOverlay" onclick="toggleSidebar()"></div>

<!-- SIDEBAR -->
<aside class="adm-sidebar" id="admSidebar">
    <div class="adm-sidebar-header">
        <span class="adm-logo">ARENA<span>SPORTS</span></span>
        <button class="adm-sidebar-close" onclick="toggleSidebar()"><i class="fa-solid fa-xmark"></i></button>
    </div>

    <nav class="adm-nav">
        <a href="<?= BASE_URL ?>/admin" class="adm-nav-item <?= (trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/') === trim(parse_url(BASE_URL.'/admin', PHP_URL_PATH), '/')) ? 'active' : '' ?>">
            <i class="fa-solid fa-chart-pie"></i><span>Dashboard</span>
        </a>
        <a href="<?= BASE_URL ?>/admin/venues" class="adm-nav-item <?= (strpos($_SERVER['REQUEST_URI'], '/admin/venues') !== false) ? 'active' : '' ?>">
            <i class="fa-solid fa-dumbbell"></i><span>Venue</span>
        </a>
        <a href="<?= BASE_URL ?>/admin/bookings" class="adm-nav-item <?= (strpos($_SERVER['REQUEST_URI'], '/admin/bookings') !== false) ? 'active' : '' ?>">
            <i class="fa-solid fa-calendar-check"></i><span>Booking</span>
        </a>
        <a href="<?= BASE_URL ?>/admin/payments" class="adm-nav-item <?= (strpos($_SERVER['REQUEST_URI'], '/admin/payments') !== false) ? 'active' : '' ?>">
            <i class="fa-solid fa-credit-card"></i><span>Pembayaran</span>
        </a>
    </nav>

    <div class="adm-sidebar-footer">
        <a href="<?= BASE_URL ?>/venues" class="adm-nav-item">
            <i class="fa-solid fa-arrow-left"></i><span>Ke Halaman User</span>
        </a>
        <a href="<?= BASE_URL ?>/logout" class="adm-nav-item adm-logout">
            <i class="fa-solid fa-right-from-bracket"></i><span>Keluar</span>
        </a>
    </div>
</aside>

<!-- MAIN WRAPPER -->
<div class="adm-wrapper">

    <!-- TOPBAR -->
    <header class="adm-topbar">
        <button class="adm-menu-btn" onclick="toggleSidebar()">
            <i class="fa-solid fa-bars"></i>
        </button>
        <h1 class="adm-page-title"><?= $pageTitle ?? 'Admin Panel' ?></h1>
        <div class="adm-topbar-right">
            <span class="adm-user-badge">
                <i class="fa-solid fa-circle-user"></i>
                <?= e($_SESSION['user']['nama'] ?? 'Admin') ?>
            </span>
        </div>
    </header>

    <!-- CONTENT -->
    <main class="adm-main">

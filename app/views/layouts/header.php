<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ArenaSports</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="<?= isAdmin() ? 'is-admin' : '' ?>">

<nav class="sports-navbar">
    <div class="navbar-container">
        <a href="<?= BASE_URL ?>/venues" class="navbar-logo">
            ARENA<span>SPORTS</span>
        </a>

        <input type="checkbox" id="menu-cb" class="navbar-cb-hidden">

        <label for="menu-cb" class="navbar-toggle">
            <i class="fa-solid fa-bars icon-bars"></i>
            <i class="fa-solid fa-xmark icon-close"></i>
        </label>

        <ul class="navbar-menu">
            <?php if (isLoggedIn()): ?>
                
                <?php if (isAdmin()): ?>
                    <li>
                        <a href="<?= BASE_URL ?>/admin" class="<?= (strpos($_SERVER['REQUEST_URI'], '/admin') !== false && strpos($_SERVER['REQUEST_URI'], '/venues') === false && strpos($_SERVER['REQUEST_URI'], '/bookings') === false && strpos($_SERVER['REQUEST_URI'], '/payments') === false) ? 'active' : '' ?>">
                            <i class="fa-solid fa-chart-pie"></i> Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="<?= BASE_URL ?>/admin/venues" class="<?= (strpos($_SERVER['REQUEST_URI'], '/admin/venues') !== false) ? 'active' : '' ?>">
                            <i class="fa-solid fa-dumbbell"></i> Venue
                        </a>
                    </li>
                    <li>
                        <a href="<?= BASE_URL ?>/admin/bookings" class="<?= (strpos($_SERVER['REQUEST_URI'], '/admin/bookings') !== false) ? 'active' : '' ?>">
                            <i class="fa-solid fa-calendar-check"></i> Booking
                        </a>
                    </li>
                    <li>
                        <a href="<?= BASE_URL ?>/admin/payments" class="<?= (strpos($_SERVER['REQUEST_URI'], '/admin/payments') !== false) ? 'active' : '' ?>">
                            <i class="fa-solid fa-credit-card"></i> Pembayaran
                        </a>
                    </li>

                <?php else: ?>
                    <li>
                        <a href="<?= BASE_URL ?>/venues" class="<?= (strpos($_SERVER['REQUEST_URI'], 'venues') !== false) ? 'active' : '' ?>">
                            <i class="fa-solid fa-dumbbell"></i> Kategori Venue
                        </a>
                    </li>
                    <li>
                        <a href="<?= BASE_URL ?>/my-bookings" class="<?= (strpos($_SERVER['REQUEST_URI'], 'my-bookings') !== false) ? 'active' : '' ?>">
                            <i class="fa-solid fa-calendar-check"></i> Booking Saya
                        </a>
                    </li>
                <?php endif; ?>

                <li class="user-dropdown">
                    <a href="#" class="dropdown-trigger">
                        <i class="fa-solid fa-circle-user"></i> Halo, <?= e($_SESSION['nama']) ?> <i class="fa-solid fa-chevron-down arrow-icon"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="<?= BASE_URL ?>/logout" class="logout-link">
                                <i class="fa-solid fa-right-from-bracket"></i> Keluar Aplikasi
                            </a>
                        </li>
                    </ul>
                </li>
            
            <?php else: ?>
                <li>
                    <a href="<?= BASE_URL ?>/venues" class="<?= (strpos($_SERVER['REQUEST_URI'], 'venues') !== false) ? 'active' : '' ?>">
                        <i class="fa-solid fa-dumbbell"></i> Kategori Venue
                    </a>
                </li>
                <li class="auth-buttons">
                    <a href="<?= BASE_URL ?>/login" class="nav-btn-login">Masuk</a>
                    <a href="<?= BASE_URL ?>/register" class="nav-btn-register">Daftar</a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</nav>

<!-- HERO BANNER CAROUSEL -->

<?php
$_uri = trim($_SERVER['REQUEST_URI'], '/');
$_base = trim(parse_url(BASE_URL, PHP_URL_PATH) ?? '', '/');
$_path = $_base ? preg_replace('#^' . preg_quote($_base, '#') . '#', '', '/' . $_uri) : '/' . $_uri;
$_path = trim($_path, '/');
?>

<?php if (!isAdmin()): ?>
<nav class="bottom-nav" id="bottomNav">

    <a href="<?= BASE_URL ?>/venues" class="bn-item <?= ($_path === '' || $_path === 'venues') ? 'active' : '' ?>">
        <i class="fa-solid fa-house"></i>
        <span>Home</span>
    </a>

    <?php if (isLoggedIn()): ?>
    <a href="<?= BASE_URL ?>/my-bookings" class="bn-item <?= (str_starts_with($_path, 'my-bookings')) ? 'active' : '' ?>">
        <i class="fa-solid fa-calendar-check"></i>
        <span>Booking</span>
    </a>
    <a href="<?= BASE_URL ?>/logout" class="bn-item bn-item--logout">
        <i class="fa-solid fa-right-from-bracket"></i>
        <span>Keluar</span>
    </a>
    <?php else: ?>
    <a href="<?= BASE_URL ?>/login" class="bn-item <?= ($_path === 'login') ? 'active' : '' ?>">
        <i class="fa-solid fa-right-to-bracket"></i>
        <span>Masuk</span>
    </a>
    <a href="<?= BASE_URL ?>/register" class="bn-item <?= ($_path === 'register') ? 'active' : '' ?>">
        <i class="fa-solid fa-user-plus"></i>
        <span>Daftar</span>
    </a>
    <?php endif; ?>

</nav>
<?php endif; ?>
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
<body>

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
<section class="sports-banner">
    <div class="sports-banner-content">
        <span class="banner-tag">SPORTBOOK</span>

        <h1>Temukan Arena Terbaik Untuk Bermain</h1>

        <p>
            Booking lapangan futsal, basket, badminton,
            tenis dan berbagai venue olahraga lainnya.
        </p>

        <a href="#venue-list" class="banner-btn">
            Lihat Venue
        </a>
    </div>
</section>
<main class="sports-container">
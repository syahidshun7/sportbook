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
            
            <?php if (isset($_SESSION['user'])): ?>
                
                <?php if (isset($_SESSION['user']['role']) && $_SESSION['user']['role'] === 'admin'): ?>
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
                        <a href="<?= BASE_URL ?>/history" class="<?= (strpos($_SERVER['REQUEST_URI'], 'history') !== false) ? 'active' : '' ?>">
                            <i class="fa-solid fa-calendar-check"></i> Riwayat Booking
                        </a>
                    </li>
                <?php endif; ?>

               <li class="user-dropdown">
    <a href="javascript:void(0)" class="dropdown-trigger" id="dropdownTrigger">
        <i class="fa-solid fa-circle-user"></i> Halo, <?= e($_SESSION['user']['nama']) ?> 
        <i class="fa-solid fa-chevron-down arrow-icon"></i>
    </a>
    <ul class="dropdown-menu" id="dropdownMenu">
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
<script>
(function(){
    var trigger = document.getElementById('dropdownTrigger');
    var menu    = document.getElementById('dropdownMenu');
    if (!trigger || !menu) return;
    trigger.addEventListener('click', function(e){
        if (window.innerWidth <= 768) {
            e.preventDefault();
            menu.classList.toggle('open');
        }
    });
    document.addEventListener('click', function(e){
        if (!trigger.contains(e.target) && !menu.contains(e.target)) {
            menu.classList.remove('open');
        }
    });
})();
</script>
<?php $pageTitle = 'Dashboard'; require_once ROOT_PATH . '/app/views/layouts/admin-layout.php'; ?>

<div class="adm-stats">
    <div class="adm-stat-card">
        <div class="adm-stat-icon"><i class="fa-solid fa-dumbbell"></i></div>
        <div class="adm-stat-body">
            <div class="adm-stat-num"><?= $stats['total_venues'] ?></div>
            <div class="adm-stat-label">Total Venue</div>
        </div>
    </div>
    <div class="adm-stat-card">
        <div class="adm-stat-icon blue"><i class="fa-solid fa-calendar-check"></i></div>
        <div class="adm-stat-body">
            <div class="adm-stat-num"><?= $stats['total_bookings'] ?></div>
            <div class="adm-stat-label">Total Booking</div>
        </div>
    </div>
    <div class="adm-stat-card">
        <div class="adm-stat-icon orange"><i class="fa-solid fa-clock"></i></div>
        <div class="adm-stat-body">
            <div class="adm-stat-num"><?= $stats['pending_payments'] ?></div>
            <div class="adm-stat-label">Pembayaran Pending</div>
        </div>
    </div>
    <div class="adm-stat-card">
        <div class="adm-stat-icon green"><i class="fa-solid fa-wallet"></i></div>
        <div class="adm-stat-body">
            <div class="adm-stat-num" style="font-size:1.2rem"><?= formatRupiah($stats['total_revenue']) ?></div>
            <div class="adm-stat-label">Total Pendapatan</div>
        </div>
    </div>
</div>

<div class="adm-card">
    <div class="adm-card-header">
        <span class="adm-card-title">Menu Cepat</span>
    </div>
    <div style="padding:20px">
        <div class="adm-quick-links">
            <a href="<?= BASE_URL ?>/admin/venues" class="adm-btn adm-btn-primary"><i class="fa-solid fa-dumbbell"></i> Kelola Venue</a>
            <a href="<?= BASE_URL ?>/admin/bookings" class="adm-btn adm-btn-info"><i class="fa-solid fa-calendar-check"></i> Kelola Booking</a>
            <a href="<?= BASE_URL ?>/admin/payments" class="adm-btn adm-btn-success"><i class="fa-solid fa-credit-card"></i> Verifikasi Pembayaran</a>
        </div>
    </div>
</div>

<?php require_once ROOT_PATH . '/app/views/layouts/admin-layout-end.php'; ?>

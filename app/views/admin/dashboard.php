<?php require_once ROOT_PATH . '/app/views/layouts/header.php'; ?>

<div class="sports-container">
    <div class="sports-page-header">
        <div class="header-title-wrapper">
            <span class="sub-title">ADMIN PANEL</span>
            <h2>Dashboard Statistik</h2>
        </div>
        <div class="header-line"></div>
    </div>

    <div class="admin-stats-grid">
        <div class="stat-card">
            <div class="stat-number"><?= $stats['total_venues'] ?></div>
            <div class="stat-label">Total Venue</div>
        </div>
        <div class="stat-card">
            <div class="stat-number"><?= $stats['total_bookings'] ?></div>
            <div class="stat-label">Total Booking</div>
        </div>
        <div class="stat-card">
            <div class="stat-number"><?= $stats['pending_payments'] ?></div>
            <div class="stat-label">Pembayaran Pending</div>
        </div>
        <div class="stat-card">
            <div class="stat-number"><?= formatRupiah($stats['total_revenue']) ?></div>
            <div class="stat-label">Total Pendapatan</div>
        </div>
    </div>

    <div class="quick-links" style="display: flex; gap: 15px; margin-top: 30px;">
        <a href="<?= BASE_URL ?>/admin/venues" class="btn-sports-primary">Kelola Venue</a>
        <a href="<?= BASE_URL ?>/admin/bookings" class="btn-sports-secondary">Kelola Booking</a>
        <a href="<?= BASE_URL ?>/admin/payments" class="btn-sports-secondary">Verifikasi Pembayaran</a>
    </div>
</div>

<?php require_once ROOT_PATH . '/app/views/layouts/footer.php'; ?>
<div class="page-header"><h2>Admin Dashboard</h2></div>

<div class="stats-grid">
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

<div class="quick-links">
    <a href="<?= BASE_URL ?>/admin/venues" class="btn-primary">Kelola Venue</a>
    <a href="<?= BASE_URL ?>/admin/bookings" class="btn-primary">Kelola Booking</a>
    <a href="<?= BASE_URL ?>/admin/payments" class="btn-primary">Verifikasi Pembayaran</a>
</div>

<div class="page-header">
    <h2>Daftar Venue Olahraga</h2>
</div>

<?php if (empty($venues)): ?>
    <div class="alert alert-info">Belum ada venue tersedia.</div>
<?php else: ?>
<div class="venue-grid">
    <?php foreach ($venues as $v): ?>
    <div class="card venue-card">
        <?php if ($v['foto']): ?>
            <img src="<?= BASE_URL ?>/uploads/<?= e($v['foto']) ?>" alt="<?= e($v['nama']) ?>" class="venue-img">
        <?php else: ?>
            <div class="venue-img-placeholder">🏟️</div>
        <?php endif; ?>
        <div class="venue-info">
            <h3><?= e($v['nama']) ?></h3>
            <span class="badge"><?= e($v['jenis_olahraga']) ?></span>
            <p class="venue-address">📍 <?= e($v['alamat']) ?></p>
            <p class="venue-price"><?= formatRupiah($v['harga_per_jam']) ?> / jam</p>
            <?php if (isLoggedIn()): ?>
                <a href="<?= BASE_URL ?>/booking/<?= $v['id'] ?>" class="btn-primary">Booking Sekarang</a>
            <?php else: ?>
                <a href="<?= BASE_URL ?>/login" class="btn-primary">Login untuk Booking</a>
            <?php endif; ?>
        </div>
    </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>



<div class="sports-page-header">
    <div class="header-title-wrapper">
        <span class="sub-title">TEMUKAN ARENA TERBAIK</span>
        <h2>Daftar Venue Olahraga</h2>
    </div>
    <div class="header-line"></div>
</div>

<?php if (empty($venues)): ?>
    <div class="sports-alert-info">
        <i class="fa-solid fa-circle-info"></i>
        <span>Belum ada venue olahraga yang tersedia saat ini. Silakan cek kembali nanti!</span>
    </div>
<?php else: ?>
    
    <div class="sports-venue-grid">
        <?php foreach ($venues as $v): ?>
        <div class="sports-venue-card">
            
            <div class="card-image-wrapper">
                <span class="sports-badge"><?= e($v['jenis_olahraga']) ?></span>
                <?php if ($v['foto']): ?>
                    <img src="<?= BASE_URL ?>/uploads/<?= e($v['foto']) ?>" alt="<?= e($v['nama']) ?>" class="sports-venue-img">
                <?php else: ?>
                    <div class="sports-venue-placeholder">
                        <i class="fa-solid fa-stadium"></i>
                    </div>
                <?php endif; ?>
            </div>

            <div class="sports-venue-info">
                <h3 class="venue-title"><?= e($v['nama']) ?></h3>
                
                <p class="venue-address">
                    <i class="fa-solid fa-location-dot"></i> <?= e($v['alamat']) ?>
                </p>
                
                <div class="venue-meta">
                    <span class="price-label">Harga Sewa</span>
                    <p class="venue-price">
                        <span class="amount"><?= formatRupiah($v['harga_per_jam']) ?></span>
                        <span class="unit">/ jam</span>
                    </p>
                </div>
                
                <div class="card-action">
                    <?php if (isLoggedIn()): ?>
                        <a href="<?= BASE_URL ?>/booking/<?= $v['id'] ?>" class="btn-sports-primary">
                            <span>Booking Sekarang</span> <i class="fa-solid fa-calendar-days"></i>
                        </a>
                    <?php else: ?>
                        <a href="<?= BASE_URL ?>/login" class="btn-sports-secondary">
                            <span>Login untuk Booking</span> <i class="fa-solid fa-right-to-bracket"></i>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
            
        </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
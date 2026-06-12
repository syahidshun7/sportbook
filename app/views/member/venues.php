
</main>
<section class="sports-banner">
    <div class="sports-banner-content">
       

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

<div class="sports-container">
<div id="venue-list" class="sports-page-header">
    <div class="header-title-wrapper">
        <span class="sub-title">TEMUKAN ARENA TERBAIK</span>
        <h2>Daftar Venue Olahraga</h2>
    </div>
    <div class="header-line"></div>
</div>

<form method="GET" action="" class="venue-search-form">
    <input type="text" name="search" value="<?= e($search) ?>" placeholder="Cari nama atau jenis olahraga..." class="sports-input venue-search-input">
    <button type="submit" class="btn-sports-primary venue-search-btn"><i class="fa-solid fa-magnifying-glass"></i> Cari</button>
    <?php if ($search): ?>
        <a href="?" class="btn-sports-secondary venue-search-btn">Reset</a>
    <?php endif; ?>
</form>

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

                <?php if (!empty($v['no_telpon'])): ?>
                <p class="venue-address">
                    <i class="fa-solid fa-phone"></i> <?= e($v['no_telpon']) ?>
                </p>
                <?php endif; ?>

                <?php if (!empty($v['deskripsi'])): ?>
                <p class="venue-desc" style="font-size:.875rem;color:#555;margin:.4rem 0 .6rem;">
                    <?= e($v['deskripsi']) ?>
                </p>
                <?php endif; ?>
                
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

    <?php if ($pages > 1): ?>
    <div class="pagination-wrapper">
        <div class="pagination">
            <?php if ($page > 1): ?>
                <a href="?page=<?= $page-1 ?>&search=<?= urlencode($search) ?>">&laquo;</a>
            <?php endif; ?>
            <?php for ($i = 1; $i <= $pages; $i++): ?>
                <a href="?page=<?= $i ?>&search=<?= urlencode($search) ?>" class="<?= $i === $page ? 'active' : '' ?>"><?= $i ?></a>
            <?php endfor; ?>
            <?php if ($page < $pages): ?>
                <a href="?page=<?= $page+1 ?>&search=<?= urlencode($search) ?>">&raquo;</a>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>

<?php endif; ?>
</div>
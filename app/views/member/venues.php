<!-- HERO BANNER CAROUSEL -->
<div id="sportsHeroCarousel" class="carousel slide sports-hero-carousel" data-bs-ride="carousel">

    <div class="carousel-indicators">
        <button type="button" data-bs-target="#sportsHeroCarousel" data-bs-slide-to="0" class="active"></button>
        <button type="button" data-bs-target="#sportsHeroCarousel" data-bs-slide-to="1"></button>
        <button type="button" data-bs-target="#sportsHeroCarousel" data-bs-slide-to="2"></button>
    </div>

    <div class="carousel-inner">

        <div class="carousel-item active">
            <img src="https://images.unsplash.com/photo-1517649763962-0c623066013b?w=1600&q=80"
                 class="d-block w-100 hero-image"
                 alt="Futsal">
            <div class="carousel-caption sports-caption">
                <h2>Booking Venue Lebih Mudah</h2>
                <p>Cari dan pesan lapangan olahraga favoritmu hanya dalam beberapa klik.</p>
            </div>
        </div>

        <div class="carousel-item">
            <img src="https://images.unsplash.com/photo-1546519638-68e109498ffc?w=1600&q=80"
                 class="d-block w-100 hero-image"
                 alt="Basket">
            <div class="carousel-caption sports-caption">
                <h2>Lapangan Berkualitas</h2>
                <p>Temukan venue olahraga terbaik dengan fasilitas lengkap.</p>
            </div>
        </div>

        <div class="carousel-item">
            <img src="https://images.unsplash.com/photo-1574629810360-7efbbe195018?w=1600&q=80"
                 class="d-block w-100 hero-image"
                 alt="Sepak Bola">
            <div class="carousel-caption sports-caption">
                <h2>Main Tanpa Ribet</h2>
                <p>Jadwalkan pertandingan dan latihan kapan saja.</p>
            </div>
        </div>

    </div>

    <button class="carousel-control-prev" type="button" data-bs-target="#sportsHeroCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
    </button>

    <button class="carousel-control-next" type="button" data-bs-target="#sportsHeroCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
    </button>

</div>
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
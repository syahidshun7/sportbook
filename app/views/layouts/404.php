<?php require_once ROOT_PATH . '/app/views/layouts/header.php'; ?>

<div class="sports-container">
    <div class="sports-error-wrapper">
        <div class="error-icon">
            <i class="fa-solid fa-triangle-exclamation"></i>
        </div>
        <h1>404</h1>
        <h2>Oops! Halaman tidak ditemukan.</h2>
        <p>Mungkin halaman telah dipindahkan atau kamu salah mengetik alamat URL.</p>
        <a href="<?= BASE_URL ?>/venues" class="btn-sports-primary">
            <i class="fa-solid fa-house"></i> Kembali ke Beranda
        </a>
    </div>
</div>

<?php require_once ROOT_PATH . '/app/views/layouts/footer.php'; ?>
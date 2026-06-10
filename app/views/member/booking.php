<div class="sports-container">
    
    <?php if ($error): ?>
        <div class="auth-alert-danger">
            <i class="fa-solid fa-triangle-exclamation"></i>
            <span><?= e($error) ?></span>
        </div>
    <?php endif; ?>

    <div class="sports-page-header">
        <div class="header-title-wrapper">
            <span class="sub-title">PROSES RESERVASI</span>
            <h2>Booking Venue</h2>
        </div>
        <div class="header-line"></div>
    </div>

    <div class="sports-booking-layout">
        
        <div class="sports-booking-sidebar">
            <div class="sports-mini-card">
                <span class="sports-badge"><?= e($venue['jenis_olahraga']) ?></span>
                <?php if (!empty($venue['foto'])): ?>
                    <img src="<?= BASE_URL ?>/uploads/<?= e($venue['foto']) ?>" alt="<?= e($venue['nama']) ?>" class="mini-card-img">
                <?php else: ?>
                    <div class="mini-card-placeholder"><i class="fa-solid fa-stadium"></i></div>
                <?php endif; ?>
                
                <div class="mini-card-body">
                    <h3><?= e($venue['nama']) ?></h3>
                    <p class="sidebar-address"><i class="fa-solid fa-location-dot"></i> <?= e($venue['alamat']) ?></p>
                    <div class="sidebar-price-box">
                        <span class="label">Tarif Lapangan</span>
                        <p><?= formatRupiah($venue['harga_per_jam']) ?> <span class="unit">/ jam</span></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="sports-booking-form-wrapper">
            <form method="POST" action="<?= BASE_URL ?>/booking/<?= $venue['id'] ?>" class="sports-form">
                <?= csrfField() ?>
                
                <div class="form-group">
                    <label for="tanggal"><i class="fa-solid fa-calendar-day"></i> Pilih Tanggal</label>
                    <input type="date" id="tanggal" name="tanggal" min="<?= date('Y-m-d') ?>" required class="sports-input">
                </div>

                <div class="split-2">
                    <div class="form-group">
                        <label for="jam_mulai"><i class="fa-solid fa-clock"></i> Jam Mulai</label>
                        <input type="time" id="jam_mulai" name="jam_mulai" required class="sports-input">
                    </div>
                    <div class="form-group">
                        <label for="jam_selesai"><i class="fa-solid fa-circle-stop"></i> Jam Selesai</label>
                        <input type="time" id="jam_selesai" name="jam_selesai" required class="sports-input">
                    </div>
                </div>

                <div class="form-group">
                    <label for="catatan"><i class="fa-solid fa-comment-dots"></i> Catatan (Opsional)</label>
                    <textarea id="catatan" name="catatan" rows="3" class="sports-input" placeholder="Contoh: Titip rompi / sewa bola tambahan..." style="resize: vertical; min-height: 80px;"></textarea>
                </div>

                <div id="price-preview" class="booking-notice" style="display: none; background: #eefbf3; border-left-color: #2ed573; color: #1e272e;">
                    <i class="fa-solid fa-receipt" style="color: #2ed573; font-size: 1.2rem; margin-top: 0;"></i>
                    <p style="margin: 0; font-weight: 600;">Total Estimasi Biaya: <span id="total-price" style="color: #2ed573; font-weight: 800; font-size: 1.1rem; margin-left: 5px;"></span></p>
                </div>

                <div class="booking-notice">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <p>Pastikan jadwal yang Anda pilih tidak bentrok. Pembayaran wajib dilakukan maksimal 1 jam setelah proses booking selesai.</p>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-sports-primary" style="border: none; cursor: pointer;">
                        <span>Konfirmasi Booking</span> <i class="fa-solid fa-chevron-right"></i>
                    </button>
                    <a href="<?= BASE_URL ?>/venues" class="btn-sports-link">Batal</a>
                </div>
            </form>
        </div>

    </div>
</div>

<script>
const harga = <?= (int)$venue['harga_per_jam'] ?>;
document.querySelectorAll('[name=jam_mulai],[name=jam_selesai]').forEach(el => {
    el.addEventListener('change', () => {
        const start = document.querySelector('[name=jam_mulai]').value;
        const end   = document.querySelector('[name=jam_selesai]').value;
        if (start && end && end > start) {
            const hours = (new Date('1970-01-01T'+end) - new Date('1970-01-01T'+start)) / 3600000;
            const total = hours * harga;
            document.getElementById('total-price').textContent = 'Rp ' + total.toLocaleString('id-ID');
            document.getElementById('price-preview').style.display = 'flex';
        } else {
            document.getElementById('price-preview').style.display = 'none';
        }
    });
});
</script>
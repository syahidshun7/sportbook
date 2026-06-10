<div class="sports-container">
    
    <?php if ($error): ?>
        <div class="auth-alert-danger">
            <i class="fa-solid fa-triangle-exclamation"></i>
            <span><?= e($error) ?></span>
        </div>
    <?php endif; ?>

    <?php if ($success): ?>
        <div class="auth-alert-success">
            <i class="fa-solid fa-circle-check"></i>
            <span><?= e($success) ?></span>
        </div>
    <?php endif; ?>

    <div class="sports-page-header">
        <div class="header-title-wrapper">
            <span class="sub-title">TAHAP AKHIR</span>
            <h2>Konfirmasi Pembayaran</h2>
        </div>
        <div class="header-line"></div>
    </div>

    <div class="sports-payment-layout">
        
        <div class="payment-instructions">
            <div class="sports-mini-card" style="margin-bottom: 25px; padding: 25px;">
                <h3 style="margin-top: 0; font-size: 1.1rem; color: #1e272e; text-transform: uppercase; letter-spacing: 0.5px;">
                    <i class="fa-solid fa-receipt" style="color: #ff4757; margin-right: 8px;"></i> Ringkasan Booking
                </h3>
                <div style="display: flex; flex-direction: column; gap: 12px; margin-top: 15px;">
                    <div style="display: flex; justify-content: space-between; border-bottom: 1px dashed #e4e7eb; padding-bottom: 8px;">
                        <span style="color: #747d8c; font-size: 0.9rem;">Kode Reservasi</span>
                        <strong style="color: #1e272e;">#<?= $booking['id'] ?></strong>
                    </div>
                    <div style="display: flex; justify-content: space-between; border-bottom: 1px dashed #e4e7eb; padding-bottom: 8px;">
                        <span style="color: #747d8c; font-size: 0.9rem;">Jadwal Main</span>
                        <span style="color: #2f3542; font-size: 0.9rem; font-weight: 600;">
                            <?= e($booking['tanggal']) ?> (<?= e($booking['jam_mulai']) ?> - <?= e($booking['jam_selesai']) ?>)
                        </span>
                    </div>
                    <div style="display: flex; justify-content: space-between; padding-top: 5px;">
                        <span style="color: #747d8c; font-weight: 700; font-size: 0.9rem;">Total Tagihan</span>
                        <strong style="color: #2ed573; font-size: 1.3rem; font-weight: 800;"><?= formatRupiah($booking['total_harga']) ?></strong>
                    </div>
                </div>
            </div>

            <h3>Rekening Pembayaran</h3>
            <p class="instruction-lead">Silakan lakukan transfer ke salah satu rekening resmi pengelola ArenaSports di bawah ini sebelum batas waktu habis:</p>
            
            <div class="bank-card-wrapper">
                <div class="bank-item">
                    <div class="bank-logo">BANK BCA</div>
                    <div>
                        <p class="account-number">8291-0421-44</p>
                        <p class="account-name">a.n PT ARENA SPORTS INDONESIA</p>
                    </div>
                </div>
                <div class="bank-item" style="background: #2c3e50;">
                    <div class="bank-logo" style="color: #3498db;">BANK MANDIRI</div>
                    <div>
                        <p class="account-number">132-0023-441-211</p>
                        <p class="account-name">a.n PT ARENA SPORTS INDONESIA</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="payment-form-card">
            <form method="POST" action="<?= BASE_URL ?>/payment/<?= $booking['id'] ?>" enctype="multipart/form-data" class="sports-form">
                <?= csrfField() ?>

                <div class="form-group">
                    <label for="metode"><i class="fa-solid fa-wallet"></i> Metode Pembayaran</label>
                    <select name="metode" id="metode" required class="sports-input" style="background-color: #fff; cursor: pointer;">
                        <option value="">-- Pilih Metode --</option>
                        <option value="Transfer Bank">Transfer Bank</option>
                        <option value="QRIS">QRIS</option>
                        <option value="Tunai">Tunai</option>
                    </select>
                </div>

                <div class="form-group">
                    <label><i class="fa-solid fa-file-invoice-dollar"></i> Bukti Transfer <small style="color: #a4b0be; text-transform: none;">(JPG/PNG/PDF, maks 2MB)</small></label>
                    
                    <div class="file-upload-zone">
                        <input type="file" name="bukti_transfer" accept=".jpg,.jpeg,.png,.pdf" required class="sports-file-input" id="buktiTransferInput">
                        <div class="upload-placeholder" id="uploadPlaceholder">
                            <i class="fa-solid fa-cloud-arrow-up"></i>
                            <p id="uploadText">Klik atau seret file bukti transfer Anda ke sini</p>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn-sports-primary" style="border: none; cursor: pointer; width: 100%; margin-top: 10px;">
                    <span>Upload & Konfirmasi</span> <i class="fa-solid fa-paper-plane"></i>
                </button>
                
                <div style="text-align: center; margin-top: 20px;">
                    <a href="<?= BASE_URL ?>/my-bookings" class="btn-sports-link"><i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Booking</a>
                </div>
            </form>
        </div>

    </div>
</div>

<script>
const fileInput = document.getElementById('buktiTransferInput');
const uploadText = document.getElementById('uploadText');
const uploadZone = document.querySelector('.file-upload-zone');

if (fileInput) {
    fileInput.addEventListener('change', function(e) {
        if (this.files && this.files[0]) {
            uploadText.textContent = "File terpilih: " + this.files[0].name;
            uploadText.style.color = "#2ed573";
            uploadZone.style.borderColor = "#2ed573";
        }
    });
}
</script>
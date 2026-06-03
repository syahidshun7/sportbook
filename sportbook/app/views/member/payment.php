<?php if ($error): ?><div class="alert alert-error"><?= e($error) ?></div><?php endif; ?>
<?php if ($success): ?><div class="alert alert-success"><?= e($success) ?></div><?php endif; ?>

<div class="card">
    <h2>Upload Bukti Pembayaran</h2>
    <div class="booking-summary">
        <p><strong>Booking ID:</strong> #<?= $booking['id'] ?></p>
        <p><strong>Total:</strong> <?= formatRupiah($booking['total_harga']) ?></p>
        <p><strong>Tanggal:</strong> <?= e($booking['tanggal']) ?> | <?= e($booking['jam_mulai']) ?> - <?= e($booking['jam_selesai']) ?></p>
    </div>
    <form method="POST" action="<?= BASE_URL ?>/payment/<?= $booking['id'] ?>" enctype="multipart/form-data">
        <?= csrfField() ?>
        <div class="form-group">
            <label>Metode Pembayaran</label>
            <select name="metode" required>
                <option value="">-- Pilih --</option>
                <option value="Transfer Bank">Transfer Bank</option>
                <option value="QRIS">QRIS</option>
                <option value="Tunai">Tunai</option>
            </select>
        </div>
        <div class="form-group">
            <label>Bukti Transfer <small>(JPG/PNG/PDF, maks 2MB)</small></label>
            <input type="file" name="bukti_transfer" accept=".jpg,.jpeg,.png,.pdf" required>
        </div>
        <button type="submit" class="btn-primary">Upload</button>
        <a href="<?= BASE_URL ?>/my-bookings" class="btn-secondary">Kembali</a>
    </form>
</div>

<?php if ($error): ?><div class="alert alert-error"><?= e($error) ?></div><?php endif; ?>

<div class="card">
    <h2>Booking: <?= e($venue['nama']) ?></h2>
    <p>🏷️ <?= e($venue['jenis_olahraga']) ?> | 📍 <?= e($venue['alamat']) ?> | <?= formatRupiah($venue['harga_per_jam']) ?>/jam</p>
    <hr>
    <form method="POST" action="<?= BASE_URL ?>/booking/<?= $venue['id'] ?>">
        <?= csrfField() ?>
        <div class="form-group">
            <label>Tanggal</label>
            <input type="date" name="tanggal" min="<?= date('Y-m-d') ?>" required>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label>Jam Mulai</label>
                <input type="time" name="jam_mulai" required>
            </div>
            <div class="form-group">
                <label>Jam Selesai</label>
                <input type="time" name="jam_selesai" required>
            </div>
        </div>
        <div class="form-group">
            <label>Catatan (opsional)</label>
            <textarea name="catatan" rows="3"></textarea>
        </div>
        <div id="price-preview" class="price-preview" style="display:none">
            Total estimasi: <strong id="total-price"></strong>
        </div>
        <button type="submit" class="btn-primary">Konfirmasi Booking</button>
        <a href="<?= BASE_URL ?>/venues" class="btn-secondary">Batal</a>
    </form>
</div>

<script>
const harga = <?= $venue['harga_per_jam'] ?>;
document.querySelectorAll('[name=jam_mulai],[name=jam_selesai]').forEach(el => {
    el.addEventListener('change', () => {
        const start = document.querySelector('[name=jam_mulai]').value;
        const end   = document.querySelector('[name=jam_selesai]').value;
        if (start && end && end > start) {
            const hours = (new Date('1970-01-01T'+end) - new Date('1970-01-01T'+start)) / 3600000;
            const total = hours * harga;
            document.getElementById('total-price').textContent = 'Rp ' + total.toLocaleString('id-ID');
            document.getElementById('price-preview').style.display = 'block';
        }
    });
});
</script>

<?php if ($success = flashGet('success')): ?><div class="alert alert-success"><?= e($success) ?></div><?php endif; ?>

<div class="page-header">
    <h2>Riwayat Booking Saya</h2>
    <a href="<?= BASE_URL ?>/venues" class="btn-primary">+ Booking Baru</a>
</div>

<?php if (empty($bookings)): ?>
    <div class="alert alert-info">Belum ada booking.</div>
<?php else: ?>
<div class="table-wrap">
<table class="table">
    <thead>
        <tr>
            <th>#</th><th>Venue</th><th>Tanggal</th><th>Jam</th><th>Total</th><th>Status</th><th>Aksi</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($bookings as $b): ?>
        <tr>
            <td><?= $b['id'] ?></td>
            <td><?= e($b['venue_nama']) ?><br><small><?= e($b['jenis_olahraga']) ?></small></td>
            <td><?= e($b['tanggal']) ?></td>
            <td><?= e($b['jam_mulai']) ?> - <?= e($b['jam_selesai']) ?></td>
            <td><?= formatRupiah($b['total_harga']) ?></td>
            <td><span class="badge badge-<?= $b['status'] ?>"><?= ucfirst($b['status']) ?></span></td>
            <td>
                <?php if ($b['status'] === 'pending'): ?>
                    <a href="<?= BASE_URL ?>/payment/<?= $b['id'] ?>" class="btn-sm">Upload Bukti</a>
                    <form method="POST" action="<?= BASE_URL ?>/booking/cancel/<?= $b['id'] ?>" style="display:inline"
                          onsubmit="return confirm('Batalkan booking ini?')">
                        <?= csrfField() ?>
                        <button type="submit" class="btn-sm btn-danger">Batal</button>
                    </form>
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
</div>
<?php endif; ?>

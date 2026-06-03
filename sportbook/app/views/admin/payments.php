<?php if ($success): ?><div class="alert alert-success"><?= e($success) ?></div><?php endif; ?>

<div class="page-header"><h2>Verifikasi Pembayaran</h2></div>

<div class="table-wrap">
<table class="table">
    <thead>
        <tr><th>#</th><th>Member</th><th>Venue</th><th>Total</th><th>Metode</th><th>Bukti</th><th>Status</th><th>Aksi</th></tr>
    </thead>
    <tbody>
    <?php foreach ($payments as $p): ?>
        <tr>
            <td><?= $p['id'] ?></td>
            <td><?= e($p['user_nama']) ?></td>
            <td><?= e($p['venue_nama']) ?></td>
            <td><?= formatRupiah($p['total_harga']) ?></td>
            <td><?= e($p['metode'] ?? '-') ?></td>
            <td>
                <?php if ($p['bukti_transfer']): ?>
                    <a href="<?= BASE_URL ?>/uploads/<?= e($p['bukti_transfer']) ?>" target="_blank" class="btn-sm">Lihat</a>
                <?php else: ?>-<?php endif; ?>
            </td>
            <td><span class="badge badge-<?= $p['status'] ?>"><?= ucfirst($p['status']) ?></span></td>
            <td>
                <form method="POST" action="<?= BASE_URL ?>/admin/payments/update">
                    <?= csrfField() ?>
                    <input type="hidden" name="id" value="<?= $p['id'] ?>">
                    <select name="status" onchange="this.form.submit()" class="select-inline">
                        <?php foreach (['pending','verified','rejected'] as $s): ?>
                            <option value="<?= $s ?>" <?= $p['status']===$s?'selected':'' ?>><?= ucfirst($s) ?></option>
                        <?php endforeach; ?>
                    </select>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
</div>

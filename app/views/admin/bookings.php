<?php if ($success): ?><div class="alert alert-success"><?= e($success) ?></div><?php endif; ?>

<div class="page-header"><h2>Kelola Booking</h2></div>

<div class="table-wrap">
<table class="table">
    <thead>
        <tr><th>#</th><th>Member</th><th>Venue</th><th>Tanggal</th><th>Jam</th><th>Total</th><th>Status</th><th>Aksi</th></tr>
    </thead>
    <tbody>
    <?php foreach ($bookings as $b): ?>
        <tr>
            <td><?= $b['id'] ?></td>
            <td><?= e($b['user_nama']) ?><br><small><?= e($b['email']) ?></small></td>
            <td><?= e($b['venue_nama']) ?></td>
            <td><?= e($b['tanggal']) ?></td>
            <td><?= e($b['jam_mulai']) ?> - <?= e($b['jam_selesai']) ?></td>
            <td><?= formatRupiah($b['total_harga']) ?></td>
            <td><span class="badge badge-<?= $b['status'] ?>"><?= ucfirst($b['status']) ?></span></td>
            <td>
                <form method="POST" action="<?= BASE_URL ?>/admin/bookings/update">
                    <?= csrfField() ?>
                    <input type="hidden" name="id" value="<?= $b['id'] ?>">
                    <select name="status" onchange="this.form.submit()" class="select-inline">
                        <?php foreach (['pending','confirmed','rejected','cancelled'] as $s): ?>
                            <option value="<?= $s ?>" <?= $b['status']===$s?'selected':'' ?>><?= ucfirst($s) ?></option>
                        <?php endforeach; ?>
                    </select>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
</div>

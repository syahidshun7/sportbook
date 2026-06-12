<?php $pageTitle = 'Kelola Booking'; require_once ROOT_PATH . '/app/views/layouts/admin-layout.php'; ?>

<?php if ($success): ?><div class="adm-alert adm-alert-success"><?= e($success) ?></div><?php endif; ?>

<div class="adm-card">
    <form method="GET" action="<?= BASE_URL ?>/admin/bookings" class="adm-filter">
        <input type="text" name="search" placeholder="Cari nama member..." value="<?= e($search) ?>">
        <select name="status">
            <option value="">Semua Status</option>
            <?php foreach (['pending','confirmed','rejected','cancelled'] as $s): ?>
                <option value="<?= $s ?>" <?= $status===$s?'selected':'' ?>><?= ucfirst($s) ?></option>
            <?php endforeach; ?>
        </select>
        <select name="venue_id">
            <option value="0">Semua Venue</option>
            <?php foreach ($venues as $v): ?>
                <option value="<?= $v['id'] ?>" <?= $venueId===$v['id']?'selected':'' ?>><?= e($v['nama']) ?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit" class="adm-btn adm-btn-primary adm-btn-sm"><i class="fa-solid fa-filter"></i> Filter</button>
        <a href="<?= BASE_URL ?>/admin/bookings" class="adm-btn adm-btn-secondary adm-btn-sm">Reset</a>
    </form>

    <div class="adm-table-wrap">
        <table class="adm-table">
            <thead>
                <tr><th>#</th><th>Member</th><th>Venue</th><th>Waktu</th><th>Total</th><th>Status</th><th>Aksi</th></tr>
            </thead>
            <tbody>
            <?php if (empty($bookings)): ?>
                <tr><td colspan="7"><div class="adm-empty"><i class="fa-solid fa-calendar-xmark"></i><p>Data tidak ditemukan.</p></div></td></tr>
            <?php else: ?>
                <?php foreach ($bookings as $b): ?>
                <tr>
                    <td><strong>#<?= $b['id'] ?></strong></td>
                    <td><?= e($b['user_nama']) ?><small><?= e($b['email']) ?></small></td>
                    <td><?= e($b['venue_nama']) ?></td>
                    <td><?= e($b['tanggal']) ?><small><?= e($b['jam_mulai']) ?> – <?= e($b['jam_selesai']) ?></small></td>
                    <td><?= formatRupiah($b['total_harga']) ?></td>
                    <td><span class="adm-badge adm-badge-<?= $b['status'] ?>"><?= ucfirst($b['status']) ?></span></td>
                    <td class="adm-actions">
                        <form method="POST" action="<?= BASE_URL ?>/admin/bookings/update" style="display:inline">
                            <?= csrfField() ?>
                            <input type="hidden" name="id" value="<?= $b['id'] ?>">
                            <select name="status" onchange="this.form.submit()" class="adm-select-status">
                                <?php foreach (['pending','confirmed','rejected','cancelled'] as $s): ?>
                                    <option value="<?= $s ?>" <?= $b['status']===$s?'selected':'' ?>><?= ucfirst($s) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </form>
                        <form method="POST" action="<?= BASE_URL ?>/admin/bookings/delete" style="display:inline"
                              onsubmit="return showConfirm(this,'Hapus booking #<?= $b['id'] ?>?')">
                            <?= csrfField() ?>
                            <input type="hidden" name="id" value="<?= $b['id'] ?>">
                            <button type="submit" class="adm-btn adm-btn-danger adm-btn-sm">Hapus</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php if ($totalPages > 1):
        $query = array_filter(['search'=>$search,'status'=>$status,'venue_id'=>$venueId]);
        $qs = $query ? '&'.http_build_query($query) : '';
    ?>
    <div class="adm-pagination">
        <?php if ($page > 1): ?><a href="?page=<?= $page-1 ?><?= $qs ?>">&laquo;</a><?php endif; ?>
        <?php for ($i=1; $i<=$totalPages; $i++): ?>
            <a href="?page=<?= $i ?><?= $qs ?>" class="<?= $i===$page?'active':'' ?>"><?= $i ?></a>
        <?php endfor; ?>
        <?php if ($page < $totalPages): ?><a href="?page=<?= $page+1 ?><?= $qs ?>">&raquo;</a><?php endif; ?>
    </div>
    <?php endif; ?>
</div>

<?php require_once ROOT_PATH . '/app/views/layouts/admin-layout-end.php'; ?>

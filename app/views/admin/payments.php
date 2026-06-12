<?php $pageTitle = 'Verifikasi Pembayaran'; require_once ROOT_PATH . '/app/views/layouts/admin-layout.php'; ?>

<?php if ($success): ?><div class="adm-alert adm-alert-success"><?= e($success) ?></div><?php endif; ?>

<div class="adm-card">
    <form method="GET" action="<?= BASE_URL ?>/admin/payments" class="adm-filter">
        <input type="text" name="search" placeholder="Cari nama member..." value="<?= e($search) ?>">
        <select name="status">
            <option value="">Semua Status</option>
            <?php foreach (['pending','verified','rejected'] as $s): ?>
                <option value="<?= $s ?>" <?= $status===$s?'selected':'' ?>><?= ucfirst($s) ?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit" class="adm-btn adm-btn-primary adm-btn-sm"><i class="fa-solid fa-filter"></i> Filter</button>
        <a href="<?= BASE_URL ?>/admin/payments" class="adm-btn adm-btn-secondary adm-btn-sm">Reset</a>
    </form>

    <div class="adm-table-wrap">
        <table class="adm-table">
            <thead>
                <tr><th>#</th><th>Member</th><th>Venue</th><th>Total</th><th>Metode</th><th>Bukti</th><th>Status</th><th>Aksi</th></tr>
            </thead>
            <tbody>
            <?php if (empty($payments)): ?>
                <tr><td colspan="8"><div class="adm-empty"><i class="fa-solid fa-credit-card"></i><p>Tidak ada data pembayaran.</p></div></td></tr>
            <?php else: ?>
                <?php foreach ($payments as $p): ?>
                <tr>
                    <td><strong>#<?= $p['id'] ?></strong></td>
                    <td><?= e($p['user_nama']) ?></td>
                    <td><?= e($p['venue_nama']) ?></td>
                    <td><?= formatRupiah($p['total_harga']) ?></td>
                    <td><span class="adm-badge adm-badge-light"><?= e($p['metode'] ?? '-') ?></span></td>
                    <td>
                        <?php if ($p['bukti_transfer']): ?>
                            <a href="<?= BASE_URL ?>/uploads/<?= e($p['bukti_transfer']) ?>" target="_blank" class="adm-btn adm-btn-info adm-btn-sm">
                                <i class="fa-solid fa-image"></i> Lihat
                            </a>
                        <?php else: ?>–<?php endif; ?>
                    </td>
                    <td><span class="adm-badge adm-badge-<?= $p['status'] ?>"><?= ucfirst($p['status']) ?></span></td>
                    <td>
                        <form method="POST" action="<?= BASE_URL ?>/admin/payments/update" class="adm-actions">
                            <?= csrfField() ?>
                            <input type="hidden" name="id" value="<?= $p['id'] ?>">
                            <select name="status" onchange="this.form.submit()" class="adm-select-status">
                                <?php foreach (['pending','verified','rejected'] as $s): ?>
                                    <option value="<?= $s ?>" <?= $p['status']===$s?'selected':'' ?>><?= ucfirst($s) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php if ($totalPages > 1):
        $query = array_filter(['search'=>$search,'status'=>$status]);
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

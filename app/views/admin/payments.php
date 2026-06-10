<?php require_once ROOT_PATH . '/app/views/layouts/header.php'; ?>

<div class="sports-container">
    <div class="sports-page-header">
        <div class="header-title-wrapper">
            <span class="sub-title">ADMIN PANEL</span>
            <h2>Verifikasi Pembayaran</h2>
        </div>
        <div class="header-line"></div>
    </div>

    <?php if ($success): ?><div class="alert alert-success"><?= e($success) ?></div><?php endif; ?>

    <form method="GET" action="<?= BASE_URL ?>/admin/payments" class="filter-bar">
        <input type="text" name="search" placeholder="Cari member..." value="<?= e($search) ?>" class="input-search">
        <select name="status" class="select-inline">
            <option value="">Semua Status</option>
            <?php foreach (['pending','verified','rejected'] as $s): ?>
                <option value="<?= $s ?>" <?= $status===$s?'selected':'' ?>><?= ucfirst($s) ?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit" class="btn-sports-primary">Filter</button>
        <a href="<?= BASE_URL ?>/admin/payments" class="btn-sports-secondary">Reset</a>
    </form>

    <div class="sports-card-table">
        <div class="table-wrap">
            <table class="table">
                <thead>
                    <tr><th>#</th><th>Member</th><th>Venue</th><th>Total</th><th>Metode</th><th>Bukti</th><th>Status</th><th>Aksi</th></tr>
                </thead>
                <tbody>
                <?php if (empty($payments)): ?>
                    <tr><td colspan="8" style="text-align:center">Tidak ada data pembayaran.</td></tr>
                <?php else: ?>
                    <?php foreach ($payments as $p): ?>
                        <tr>
                            <td><strong>#<?= $p['id'] ?></strong></td>
                            <td><?= e($p['user_nama']) ?></td>
                            <td><?= e($p['venue_nama']) ?></td>
                            <td><?= formatRupiah($p['total_harga']) ?></td>
                            <td><span class="badge badge-light"><?= e($p['metode'] ?? '-') ?></span></td>
                            <td>
                                <?php if ($p['bukti_transfer']): ?>
                                    <a href="<?= BASE_URL ?>/uploads/<?= e($p['bukti_transfer']) ?>" target="_blank" class="btn-sm btn-info">
                                        <i class="fa-solid fa-image"></i> Lihat
                                    </a>
                                <?php else: ?> - <?php endif; ?>
                            </td>
                            <td><span class="badge badge-<?= $p['status'] ?>"><?= ucfirst($p['status']) ?></span></td>
                            <td>
                                <form method="POST" action="<?= BASE_URL ?>/admin/payments/update" class="action-buttons">
                                    <?= csrfField() ?>
                                    <input type="hidden" name="id" value="<?= $p['id'] ?>">
                                    <select name="status" onchange="this.form.submit()" class="select-status-table">
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
    </div>

    <?php
    $query = array_filter(['search'=>$search,'status'=>$status]);
    $qs = $query ? '&' . http_build_query($query) : '';
    ?>
   <?php
$query = array_filter(['search'=>$search,'status'=>$status]);
$qs = $query ? '&' . http_build_query($query) : '';
?>

<div class="pagination-wrapper">
    <div class="pagination">
        <?php if ($page > 1): ?>
            <a href="?page=<?= $page-1 ?><?= $qs ?>">&laquo; Prev</a>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="?page=<?= $i ?><?= $qs ?>" class="<?= $i===$page ? 'active' : '' ?>">
                <?= $i ?>
            </a>
        <?php endfor; ?>

        <?php if ($page < $totalPages): ?>
            <a href="?page=<?= $page+1 ?><?= $qs ?>">Next &raquo;</a>
        <?php endif; ?>
    </div>
</div>
</div>

<?php require_once ROOT_PATH . '/app/views/layouts/footer.php'; ?>
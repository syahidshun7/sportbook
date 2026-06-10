<?php require_once ROOT_PATH . '/app/views/layouts/header.php'; ?>

<div class="sports-container">
    <div class="sports-page-header">
        <div class="header-title-wrapper">
            <span class="sub-title">ADMIN PANEL</span>
            <h2>Kelola Booking</h2>
        </div>
        <div class="header-line"></div>
    </div>

    <?php if ($success): ?><div class="alert alert-success"><?= e($success) ?></div><?php endif; ?>

    <form method="GET" action="<?= BASE_URL ?>/admin/bookings" class="filter-bar">
        <input type="text" name="search" placeholder="Cari nama member..." value="<?= e($search) ?>" class="input-search">
        
        <select name="status" class="select-inline">
            <option value="">Semua Status</option>
            <?php foreach (['pending','confirmed','rejected','cancelled'] as $s): ?>
                <option value="<?= $s ?>" <?= $status===$s?'selected':'' ?>><?= ucfirst($s) ?></option>
            <?php endforeach; ?>
        </select>
        
        <select name="venue_id" class="select-inline">
            <option value="0">Semua Venue</option>
            <?php foreach ($venues as $v): ?>
                <option value="<?= $v['id'] ?>" <?= $venueId===$v['id']?'selected':'' ?>><?= e($v['nama']) ?></option>
            <?php endforeach; ?>
        </select>
        
        <button type="submit" class="btn-sports-primary">Filter</button>
        <a href="<?= BASE_URL ?>/admin/bookings" class="btn-sports-secondary">Reset</a>
    </form>

    <div class="sports-card-table">
        <div class="table-wrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th><th>Member</th><th>Venue</th><th>Waktu</th><th>Total</th><th>Status</th><th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (empty($bookings)): ?>
                    <tr><td colspan="7" style="text-align:center">Data tidak ditemukan.</td></tr>
                <?php else: ?>
                    <?php foreach ($bookings as $b): ?>
                    <tr>
                        <td><strong>#<?= $b['id'] ?></strong></td>
                        <td><?= e($b['user_nama']) ?><br><small><?= e($b['email']) ?></small></td>
                        <td><?= e($b['venue_nama']) ?></td>
                        <td><?= e($b['tanggal']) ?><br><small><?= e($b['jam_mulai']) ?> - <?= e($b['jam_selesai']) ?></small></td>
                        <td><?= formatRupiah($b['total_harga']) ?></td>
                        <td><span class="badge badge-<?= $b['status'] ?>"><?= ucfirst($b['status']) ?></span></td>
                        <td class="action-buttons">
                            <form method="POST" action="<?= BASE_URL ?>/admin/bookings/update" style="display:inline">
                                <?= csrfField() ?>
                                <input type="hidden" name="id" value="<?= $b['id'] ?>">
                                <select name="status" onchange="this.form.submit()" class="select-status-table">
                                    <?php foreach (['pending','confirmed','rejected','cancelled'] as $s): ?>
                                        <option value="<?= $s ?>" <?= $b['status']===$s?'selected':'' ?>><?= ucfirst($s) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </form>
                            
                            <form method="POST" action="<?= BASE_URL ?>/admin/bookings/delete" style="display:inline"
                                    onsubmit="return confirm('Hapus booking #<?= $b['id'] ?>?')">
                                <?= csrfField() ?>
                                <input type="hidden" name="id" value="<?= $b['id'] ?>">
                                <button type="submit" class="btn-sm btn-danger">Hapus</button>
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
    $query = array_filter(['search'=>$search, 'status'=>$status, 'venue_id'=>$venueId]);
    $qs = $query ? '&' . http_build_query($query) : '';
    ?>
    
    <?php if ($totalPages > 1): ?>
    <div class="pagination-wrapper">
        <div class="pagination">
            <?php if ($page > 1): ?>
                <a href="?page=<?= $page-1 ?><?= $qs ?>">&laquo; Prev</a>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <a href="?page=<?= $i ?><?= $qs ?>" class="<?= $i === (int)$page ? 'active' : '' ?>">
                    <?= $i ?>
                </a>
            <?php endfor; ?>

            <?php if ($page < $totalPages): ?>
                <a href="?page=<?= $page+1 ?><?= $qs ?>">Next &raquo;</a>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>
</div>

<?php require_once ROOT_PATH . '/app/views/layouts/footer.php'; ?>
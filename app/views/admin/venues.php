<?php $pageTitle = 'Kelola Venue'; require_once ROOT_PATH . '/app/views/layouts/admin-layout.php'; ?>

<?php if ($error): ?><div class="adm-alert adm-alert-error"><?= e($error) ?></div><?php endif; ?>
<?php if ($success): ?><div class="adm-alert adm-alert-success"><?= e($success) ?></div><?php endif; ?>

<div class="adm-card">
    <div class="adm-card-header">
        <span class="adm-card-title">Daftar Venue</span>
        <button onclick="document.getElementById('modal-add').classList.add('open')" class="adm-btn adm-btn-primary adm-btn-sm">
            <i class="fa-solid fa-plus"></i> Tambah Venue
        </button>
    </div>

    <div class="adm-table-wrap">
        <table class="adm-table">
            <thead>
                <tr><th>Nama</th><th>Jenis</th><th>Harga/Jam</th><th>Status</th><th>Aksi</th></tr>
            </thead>
            <tbody>
            <?php if (empty($venues)): ?>
                <tr><td colspan="5"><div class="adm-empty"><i class="fa-solid fa-dumbbell"></i><p>Belum ada venue.</p></div></td></tr>
            <?php else: ?>
                <?php foreach ($venues as $v): ?>
                <tr>
                    <td><strong><?= e($v['nama']) ?></strong><small><?= e($v['alamat'] ?? '') ?></small></td>
                    <td><?= e($v['jenis_olahraga']) ?></td>
                    <td><?= formatRupiah($v['harga_per_jam']) ?></td>
                    <td><span class="adm-badge adm-badge-<?= $v['status'] ?>"><?= ucfirst($v['status']) ?></span></td>
                    <td class="adm-actions">
                        <button onclick="openEdit(<?= htmlspecialchars(json_encode($v), ENT_QUOTES) ?>)" class="adm-btn adm-btn-info adm-btn-sm">Edit</button>
                        <form method="POST" action="<?= BASE_URL ?>/admin/venues/delete" style="display:inline"
                              onsubmit="return showConfirm(this,'Hapus venue ini? Tindakan ini tidak dapat dibatalkan.')">
                            <?= csrfField() ?>
                            <input type="hidden" name="id" value="<?= $v['id'] ?>">
                            <button type="submit" class="adm-btn adm-btn-danger adm-btn-sm">Hapus</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Tambah -->
<div id="modal-add" class="adm-modal">
    <div class="adm-modal-box">
        <div class="adm-modal-header">
            <h3>Tambah Venue</h3>
            <button class="adm-modal-close" onclick="document.getElementById('modal-add').classList.remove('open')"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <form method="POST" action="<?= BASE_URL ?>/admin/venues" enctype="multipart/form-data">
            <?= csrfField() ?>
            <div class="adm-modal-body">
                <div class="adm-form-group"><label>Nama</label><input type="text" name="nama" required></div>
                <div class="adm-form-group"><label>Jenis Olahraga</label><input type="text" name="jenis_olahraga" required></div>
                <div class="adm-form-group"><label>Alamat</label><input type="text" name="alamat" required></div>
                <div class="adm-form-group"><label>Deskripsi</label><textarea name="deskripsi"></textarea></div>
                <div class="adm-form-group"><label>No. Telepon</label><input type="text" name="no_telpon"></div>
                <div class="adm-form-group"><label>Google Map URL</label><input type="text" name="google_map" placeholder="https://maps.google.com/..."></div>
                <div class="adm-form-group"><label>Harga/Jam</label><input type="number" name="harga_per_jam" required></div>
                <div class="adm-form-group"><label>Foto</label><input type="file" name="foto" accept=".jpg,.jpeg,.png"></div>
            </div>
            <div class="adm-modal-footer">
                <button type="button" onclick="document.getElementById('modal-add').classList.remove('open')" class="adm-btn adm-btn-secondary">Batal</button>
                <button type="submit" class="adm-btn adm-btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit -->
<div id="modal-edit" class="adm-modal">
    <div class="adm-modal-box">
        <div class="adm-modal-header">
            <h3>Edit Venue</h3>
            <button class="adm-modal-close" onclick="document.getElementById('modal-edit').classList.remove('open')"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <form method="POST" action="<?= BASE_URL ?>/admin/venues/update" enctype="multipart/form-data">
            <?= csrfField() ?>
            <input type="hidden" name="id" id="edit-id">
            <div class="adm-modal-body">
                <div class="adm-form-group"><label>Nama</label><input type="text" name="nama" id="edit-nama" required></div>
                <div class="adm-form-group"><label>Jenis Olahraga</label><input type="text" name="jenis_olahraga" id="edit-jenis" required></div>
                <div class="adm-form-group"><label>Alamat</label><input type="text" name="alamat" id="edit-alamat" required></div>
                <div class="adm-form-group"><label>Deskripsi</label><textarea name="deskripsi" id="edit-deskripsi"></textarea></div>
                <div class="adm-form-group"><label>No. Telepon</label><input type="text" name="no_telpon" id="edit-no_telpon"></div>
                <div class="adm-form-group"><label>Google Map URL</label><input type="text" name="google_map" id="edit-google_map" placeholder="https://maps.google.com/..."></div>
                <div class="adm-form-group"><label>Harga/Jam</label><input type="number" name="harga_per_jam" id="edit-harga" required></div>
                <div class="adm-form-group">
                    <label>Status</label>
                    <select name="status" id="edit-status">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
                <div class="adm-form-group"><label>Foto Baru (opsional)</label><input type="file" name="foto" accept=".jpg,.jpeg,.png"></div>
            </div>
            <div class="adm-modal-footer">
                <button type="button" onclick="document.getElementById('modal-edit').classList.remove('open')" class="adm-btn adm-btn-secondary">Batal</button>
                <button type="submit" class="adm-btn adm-btn-primary">Update</button>
            </div>
        </form>
    </div>
</div>

<script>
function openEdit(v) {
    document.getElementById('edit-id').value = v.id;
    document.getElementById('edit-nama').value = v.nama;
    document.getElementById('edit-jenis').value = v.jenis_olahraga;
    document.getElementById('edit-alamat').value = v.alamat;
    document.getElementById('edit-deskripsi').value = v.deskripsi || '';
    document.getElementById('edit-no_telpon').value = v.no_telpon || '';
    document.getElementById('edit-google_map').value = v.google_map || '';
    document.getElementById('edit-harga').value = v.harga_per_jam;
    document.getElementById('edit-status').value = v.status;
    document.getElementById('modal-edit').classList.add('open');
}
// close modal on overlay click
document.querySelectorAll('.adm-modal').forEach(function(m){
    m.addEventListener('click', function(e){ if(e.target === m) m.classList.remove('open'); });
});
</script>

<?php require_once ROOT_PATH . '/app/views/layouts/admin-layout-end.php'; ?>

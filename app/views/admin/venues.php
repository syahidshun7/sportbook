<?php if ($error): ?><div class="alert alert-error"><?= e($error) ?></div><?php endif; ?>
<?php if ($success): ?><div class="alert alert-success"><?= e($success) ?></div><?php endif; ?>

<div class="page-header">
    <h2>Kelola Venue</h2>
    <button onclick="document.getElementById('modal-add').style.display='flex'" class="btn-primary">+ Tambah Venue</button>
</div>

<div class="table-wrap">
<table class="table">
    <thead><tr><th>Nama</th><th>Jenis</th><th>Harga/Jam</th><th>Status</th><th>Aksi</th></tr></thead>
    <tbody>
    <?php foreach ($venues as $v): ?>
        <tr>
            <td><?= e($v['nama']) ?></td>
            <td><?= e($v['jenis_olahraga']) ?></td>
            <td><?= formatRupiah($v['harga_per_jam']) ?></td>
            <td><span class="badge badge-<?= $v['status'] ?>"><?= ucfirst($v['status']) ?></span></td>
            <td>
                <button onclick="openEdit(<?= htmlspecialchars(json_encode($v), ENT_QUOTES) ?>)" class="btn-sm">Edit</button>
                <form method="POST" action="<?= BASE_URL ?>/admin/venues/delete" style="display:inline"
                      onsubmit="return confirm('Hapus venue ini?')">
                    <?= csrfField() ?>
                    <input type="hidden" name="id" value="<?= $v['id'] ?>">
                    <button type="submit" class="btn-sm btn-danger">Hapus</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
</div>

<!-- Modal Tambah -->
<div id="modal-add" class="modal" style="display:none">
    <div class="modal-content">
        <h3>Tambah Venue</h3>
        <form method="POST" action="<?= BASE_URL ?>/admin/venues" enctype="multipart/form-data">
            <?= csrfField() ?>
            <div class="form-group"><label>Nama</label><input type="text" name="nama" required></div>
            <div class="form-group"><label>Jenis Olahraga</label><input type="text" name="jenis_olahraga" required></div>
            <div class="form-group"><label>Alamat</label><input type="text" name="alamat" required></div>
            <div class="form-group"><label>Deskripsi</label><textarea name="deskripsi"></textarea></div>
            <div class="form-group"><label>Harga/Jam</label><input type="number" name="harga_per_jam" required></div>
            <div class="form-group"><label>Foto</label><input type="file" name="foto" accept=".jpg,.jpeg,.png"></div>
            <button type="submit" class="btn-primary">Simpan</button>
            <button type="button" onclick="document.getElementById('modal-add').style.display='none'" class="btn-secondary">Batal</button>
        </form>
    </div>
</div>

<!-- Modal Edit -->
<div id="modal-edit" class="modal" style="display:none">
    <div class="modal-content">
        <h3>Edit Venue</h3>
        <form method="POST" action="<?= BASE_URL ?>/admin/venues/update" enctype="multipart/form-data">
            <?= csrfField() ?>
            <input type="hidden" name="id" id="edit-id">
            <div class="form-group"><label>Nama</label><input type="text" name="nama" id="edit-nama" required></div>
            <div class="form-group"><label>Jenis Olahraga</label><input type="text" name="jenis_olahraga" id="edit-jenis" required></div>
            <div class="form-group"><label>Alamat</label><input type="text" name="alamat" id="edit-alamat" required></div>
            <div class="form-group"><label>Deskripsi</label><textarea name="deskripsi" id="edit-deskripsi"></textarea></div>
            <div class="form-group"><label>Harga/Jam</label><input type="number" name="harga_per_jam" id="edit-harga" required></div>
            <div class="form-group">
                <label>Status</label>
                <select name="status" id="edit-status">
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>
            <div class="form-group"><label>Foto Baru (opsional)</label><input type="file" name="foto" accept=".jpg,.jpeg,.png"></div>
            <button type="submit" class="btn-primary">Update</button>
            <button type="button" onclick="document.getElementById('modal-edit').style.display='none'" class="btn-secondary">Batal</button>
        </form>
    </div>
</div>

<script>
function openEdit(v) {
    document.getElementById('edit-id').value    = v.id;
    document.getElementById('edit-nama').value  = v.nama;
    document.getElementById('edit-jenis').value = v.jenis_olahraga;
    document.getElementById('edit-alamat').value = v.alamat;
    document.getElementById('edit-deskripsi').value = v.deskripsi || '';
    document.getElementById('edit-harga').value = v.harga_per_jam;
    document.getElementById('edit-status').value = v.status;
    document.getElementById('modal-edit').style.display = 'flex';
}
</script>

<h2>Daftar Mahasiswa</h2>
<form method="GET">
    <input type="hidden" name="action" value="search">
    <input type="text" name="keyword" placeholder="Cari NIM atau Nama..." value="<?= htmlspecialchars($_GET['keyword'] ?? '') ?>">
    <button type="submit">Cari</button>
    <a href="?action=index">Reset</a>
</form>
<br>
<a href="?action=create">Tambah</a>
<table border="1">
    <tr><th>NIM</th><th>Nama</th><th>Prodi</th><th>Aksi</th></tr>
    <?php foreach($data as $m): ?>
    <tr>
        <td><?= $m->nim ?></td>
        <td><?= $m->nama ?></td>
        <td><?= $m->prodi ?></td>
        <td>
            <a href="?action=edit&id=<?= $m->id ?>">Edit</a> |
            <a href="?action=delete&id=<?= $m->id ?>" onclick="return confirm('Yakin?')">Hapus</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

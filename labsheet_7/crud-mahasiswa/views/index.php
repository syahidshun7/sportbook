<?php include __DIR__ . '/header.php'; ?>
<h2>Daftar Mahasiswa</h2>
<a href="public/tambah.php">Tambah</a>
<table border="1" cellpadding="5" cellspacing="0">
    <tr><th>NIM</th><th>Nama</th><th>Prodi</th><th>Aksi</th></tr>
    <?php foreach($mahasiswas as $m): ?>
    <tr>
        <td><?= $m->nim ?></td>
        <td><?= $m->nama ?></td>
        <td><?= $m->prodi ?></td>
        <td>
            <a href="public/edit.php?id=<?= $m->id ?>">Edit</a> |
            <a href="public/hapus.php?id=<?= $m->id ?>" onclick="return confirm('Hapus?')">Hapus</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
<?php include __DIR__ . '/footer.php'; ?>

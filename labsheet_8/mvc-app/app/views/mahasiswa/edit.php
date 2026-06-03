<h2>Edit Mahasiswa</h2>
<form action="?action=update&id=<?= $mhs->id ?>" method="POST">
    <label>NIM:</label><br>
    <input type="text" name="nim" value="<?= htmlspecialchars($mhs->nim) ?>" required><br><br>

    <label>Nama:</label><br>
    <input type="text" name="nama" value="<?= htmlspecialchars($mhs->nama) ?>" required><br><br>

    <label>Prodi:</label><br>
    <input type="text" name="prodi" value="<?= htmlspecialchars($mhs->prodi) ?>" required><br><br>

    <input type="submit" value="Update">
</form>
<br><a href="?action=index">Kembali</a>

<?php include __DIR__ . '/header.php'; ?>
<h2>Tambah Mahasiswa</h2>
<form action="" method="POST">
    <label>NIM:</label><br>
    <input type="text" name="nim" required><br><br>

    <label>Nama:</label><br>
    <input type="text" name="nama" required><br><br>

    <label>Prodi:</label><br>
    <input type="text" name="prodi" required><br><br>

    <input type="submit" value="Simpan">
</form>
<br><a href="../index.php">Kembali</a>
<?php include __DIR__ . '/footer.php'; ?>

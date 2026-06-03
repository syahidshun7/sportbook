<?php include __DIR__ . '/header.php'; ?>
<h2>Edit Mahasiswa</h2>
<form action="" method="POST">
    <input type="hidden" name="id" value="<?= $mhs->id ?>">

    <label>NIM:</label><br>
    <input type="text" name="nim" value="<?= htmlspecialchars($mhs->nim) ?>" required><br><br>

    <label>Nama:</label><br>
    <input type="text" name="nama" value="<?= htmlspecialchars($mhs->nama) ?>" required><br><br>

    <label>Prodi:</label><br>
    <input type="text" name="prodi" value="<?= htmlspecialchars($mhs->prodi) ?>" required><br><br>

    <input type="submit" value="Update">
</form>
<br><a href="../index.php">Kembali</a>
<?php include __DIR__ . '/footer.php'; ?>

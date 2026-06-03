<?php
require_once 'config/Database.php';
require_once 'model/Mahasiswa.php';

use Config\Database;
use Model\Mahasiswa;

$db = new Database();
$conn = $db->getConnection();

$mhs = new Mahasiswa($conn);
$data = $mhs->getById($_GET['id']);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Mahasiswa</title>
</head>
<body>
    <h2>Form Edit Data Mahasiswa</h2>
    <form action="proses_edit.php" method="POST">
        <input type="hidden" name="id" value="<?= $data['id'] ?>">

        <label>Nama:</label><br>
        <input type="text" name="nama" value="<?= htmlspecialchars($data['nama']) ?>" required><br><br>

        <label>NIM:</label><br>
        <input type="text" name="nim" value="<?= htmlspecialchars($data['nim']) ?>" required><br><br>

        <label>Jurusan:</label><br>
        <input type="text" name="jurusan" value="<?= htmlspecialchars($data['jurusan']) ?>" required><br><br>

        <input type="submit" value="Update">
    </form>
</body>
</html>

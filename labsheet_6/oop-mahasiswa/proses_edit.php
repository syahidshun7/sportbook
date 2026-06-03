<?php
require_once 'config/Database.php';
require_once 'model/Mahasiswa.php';

use Config\Database;
use Model\Mahasiswa;

$db = new Database();
$conn = $db->getConnection();

$mhs = new Mahasiswa($conn);
$mhs->nama = $_POST['nama'];
$mhs->nim = $_POST['nim'];
$mhs->jurusan = $_POST['jurusan'];

if ($mhs->update($_POST['id'])) {
    echo "Data berhasil diupdate. <a href='index.php'>Kembali</a>";
} else {
    echo "Gagal mengupdate data.";
}

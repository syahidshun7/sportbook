<?php
require_once 'config/Database.php';
require_once 'model/Mahasiswa.php';

use Config\Database;
use Model\Mahasiswa;

$db = new Database();
$conn = $db->getConnection();

$mhs = new Mahasiswa($conn);

if ($mhs->hapus($_GET['id'])) {
    echo "Data berhasil dihapus. <a href='index.php'>Kembali</a>";
} else {
    echo "Gagal menghapus data.";
}

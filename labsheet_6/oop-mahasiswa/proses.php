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

if ($mhs->simpan()) {
    echo "Data berhasil disimpan. <a href='form.php'>Input lagi</a> | <a href='index.php'>Lihat Data</a>";
} else {
    echo "Gagal menyimpan data.";
}

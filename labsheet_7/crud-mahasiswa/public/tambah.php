<?php
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../repositories/MahasiswaRepository.php';

$database = new Database();
$db = $database->getConnection();
$repo = new MahasiswaRepository($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mhs = new Mahasiswa();
    $mhs->nim = $_POST['nim'];
    $mhs->nama = $_POST['nama'];
    $mhs->prodi = $_POST['prodi'];

    if ($repo->insert($mhs)) {
        header("Location: ../index.php");
        exit;
    }
}

include __DIR__ . '/../views/tambah.php';

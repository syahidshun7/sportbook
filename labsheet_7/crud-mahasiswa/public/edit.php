<?php
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../repositories/MahasiswaRepository.php';

$database = new Database();
$db = $database->getConnection();
$repo = new MahasiswaRepository($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mhs = new Mahasiswa();
    $mhs->id = $_POST['id'];
    $mhs->nim = $_POST['nim'];
    $mhs->nama = $_POST['nama'];
    $mhs->prodi = $_POST['prodi'];

    if ($repo->update($mhs)) {
        header("Location: ../index.php");
        exit;
    }
}

$mhs = $repo->findById($_GET['id']);
include __DIR__ . '/../views/edit.php';

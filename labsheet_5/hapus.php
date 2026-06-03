<?php
require_once __DIR__ . '/assets/helpers.php';
requireLogin();

$id = isset($_GET['id']) ? (int) $_GET['id'] : -1;
$list = loadMahasiswa();
$target = getMahasiswaByIndex($list, $id);

if ($target === null) {
    setFlash('Data mahasiswa tidak ditemukan.', 'error');
    redirectTo('index.php');
}

// Jika ada file CV lama, hapus dari folder uploads.
if ($target->cv !== '') {
    $oldFile = uploadDirPath() . '/' . $target->cv;
    if (is_file($oldFile)) {
        unlink($oldFile);
    }
}

array_splice($list, $id, 1);
saveMahasiswa($list);

setFlash('Data mahasiswa berhasil dihapus.');
redirectTo('index.php');

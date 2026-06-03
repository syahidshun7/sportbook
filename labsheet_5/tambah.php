<?php
require_once __DIR__ . '/assets/helpers.php';
requireLogin();

$errors = [];
$nama = '';
$nim = '';
$jurusan = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim($_POST['nama'] ?? '');
    $nim = trim($_POST['nim'] ?? '');
    $jurusan = trim($_POST['jurusan'] ?? '');

    if ($nama === '' || $nim === '' || $jurusan === '') {
        $errors[] = 'Semua field wajib diisi.';
    }

    if ($nim !== '' && !preg_match('/^[0-9]+$/', $nim)) {
        $errors[] = 'NIM hanya boleh berisi angka.';
    }

    $list = loadMahasiswa();
    foreach ($list as $item) {
        if ($item->nim === $nim) {
            $errors[] = 'NIM sudah terdaftar, gunakan NIM lain.';
            break;
        }
    }

    if (count($errors) === 0) {
        $list[] = new Mahasiswa($nama, $nim, $jurusan, '');
        saveMahasiswa($list);

        setFlash('Data mahasiswa berhasil ditambahkan.');
        redirectTo('index.php');
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Mahasiswa</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container form-box">
        <h1>Tambah Data Mahasiswa</h1>

        <?php foreach ($errors as $err): ?>
            <div class="alert alert-error"><?= e($err); ?></div>
        <?php endforeach; ?>

        <form method="POST" action="">
            <label for="nama">Nama</label>
            <input type="text" id="nama" name="nama" value="<?= e($nama); ?>">

            <label for="nim">NIM</label>
            <input type="text" id="nim" name="nim" value="<?= e($nim); ?>">

            <label for="jurusan">Jurusan</label>
            <input type="text" id="jurusan" name="jurusan" value="<?= e($jurusan); ?>">

            <button type="submit">Simpan</button>
            <a class="btn btn-ghost" href="index.php">Kembali</a>
        </form>
    </div>
</body>
</html>

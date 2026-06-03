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

$errors = [];
$nama = $target->nama;
$nim = $target->nim;
$jurusan = $target->jurusan;

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

    foreach ($list as $index => $item) {
        if ($index !== $id && $item->nim === $nim) {
            $errors[] = 'NIM sudah dipakai mahasiswa lain.';
            break;
        }
    }

    if (count($errors) === 0) {
        $list[$id] = new Mahasiswa($nama, $nim, $jurusan, $target->cv);
        saveMahasiswa($list);

        setFlash('Data mahasiswa berhasil diubah.');
        redirectTo('index.php');
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Mahasiswa</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container form-box">
        <h1>Edit Data Mahasiswa</h1>

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

            <button type="submit">Update</button>
            <a class="btn btn-ghost" href="index.php">Kembali</a>
        </form>
    </div>
</body>
</html>

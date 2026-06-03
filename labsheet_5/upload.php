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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_FILES['cv'])) {
        $errors[] = 'File CV belum dipilih.';
    } else {
        $file = $_FILES['cv'];

        if ($file['error'] !== UPLOAD_ERR_OK) {
            $errors[] = 'Terjadi kesalahan saat upload file.';
        } else {
            $maxSize = 2 * 1024 * 1024;
            $allowedExt = ['pdf', 'doc', 'docx'];

            $originalName = $file['name'];
            $ext = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

            if (!in_array($ext, $allowedExt, true)) {
                $errors[] = 'Format file harus PDF, DOC, atau DOCX.';
            }

            if ($file['size'] > $maxSize) {
                $errors[] = 'Ukuran file maksimal 2 MB.';
            }

            if (count($errors) === 0) {
                $safeBase = preg_replace('/[^a-zA-Z0-9_-]/', '_', pathinfo($originalName, PATHINFO_FILENAME));
                $newName = $target->nim . '_' . time() . '_' . $safeBase . '.' . $ext;
                $destination = uploadDirPath() . '/' . $newName;

                if (move_uploaded_file($file['tmp_name'], $destination)) {
                    if ($target->cv !== '') {
                        $oldFile = uploadDirPath() . '/' . $target->cv;
                        if (is_file($oldFile)) {
                            unlink($oldFile);
                        }
                    }

                    $list[$id]->cv = $newName;
                    saveMahasiswa($list);

                    setFlash('CV berhasil diupload.');
                    redirectTo('index.php');
                } else {
                    $errors[] = 'Gagal menyimpan file ke folder uploads.';
                }
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload CV Mahasiswa</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container form-box">
        <h1>Upload CV</h1>
        <p class="muted">Mahasiswa: <strong><?= e($target->nama); ?></strong> (<?= e($target->nim); ?>)</p>

        <?php foreach ($errors as $err): ?>
            <div class="alert alert-error"><?= e($err); ?></div>
        <?php endforeach; ?>

        <form method="POST" action="" enctype="multipart/form-data">
            <label for="cv">Pilih File CV (PDF/DOC/DOCX, max 2 MB)</label>
            <input type="file" id="cv" name="cv" accept=".pdf,.doc,.docx,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document">

            <button type="submit">Upload</button>
            <a class="btn btn-ghost" href="index.php">Kembali</a>
        </form>
    </div>
</body>
</html>

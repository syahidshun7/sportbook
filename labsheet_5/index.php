<?php
require_once __DIR__ . '/assets/helpers.php';
requireLogin();

$flash = getFlash();
$username = $_SESSION['username'] ?? 'Pengguna';
$keyword = trim($_GET['keyword'] ?? '');

$allMahasiswa = loadMahasiswa();
$rows = [];

foreach ($allMahasiswa as $index => $mhs) {
    if ($keyword === '' || stripos($mhs->nim, $keyword) !== false) {
        $rows[] = [
            'id' => $index,
            'data' => $mhs,
        ];
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Mahasiswa - Labsheet 5</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <header class="topbar">
            <div>
                <h1>Manajemen Data Mahasiswa</h1>
                <p class="muted">Halo, <?= e($username); ?>.</p>
                <?php if (isset($_COOKIE['last_login'])): ?>
                    <p class="muted">Login terakhir: <?= e($_COOKIE['last_login']); ?></p>
                <?php endif; ?>
            </div>
            <div class="actions">
                <a class="btn" href="tambah.php">Tambah Data</a>
                <a class="btn btn-ghost" href="logout.php">Logout</a>
            </div>
        </header>

        <?php if ($flash !== null): ?>
            <div class="alert <?= $flash['type'] === 'error' ? 'alert-error' : 'alert-success'; ?>">
                <?= e($flash['message']); ?>
            </div>
        <?php endif; ?>

        <form method="GET" action="" class="search-form">
            <label for="keyword">Cari NIM</label>
            <input type="text" id="keyword" name="keyword" value="<?= e($keyword); ?>" placeholder="Contoh: 2443908">
            <button type="submit">Cari</button>
            <a class="btn btn-ghost" href="index.php">Reset</a>
        </form>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>NIM</th>
                        <th>Jurusan</th>
                        <th>CV</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($rows) === 0): ?>
                        <tr>
                            <td colspan="6">Data tidak ditemukan.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($rows as $no => $row): ?>
                            <?php $mhs = $row['data']; ?>
                            <tr>
                                <td><?= $no + 1; ?></td>
                                <td><?= e($mhs->nama); ?></td>
                                <td><?= e($mhs->nim); ?></td>
                                <td><?= e($mhs->jurusan); ?></td>
                                <td>
                                    <?php if ($mhs->cv !== ''): ?>
                                        <a href="download.php?id=<?= $row['id']; ?>">Download CV</a>
                                    <?php else: ?>
                                        <span class="muted">Belum ada</span>
                                    <?php endif; ?>
                                </td>
                                <td class="table-actions">
                                    <a href="edit.php?id=<?= $row['id']; ?>">Edit</a>
                                    <a href="hapus.php?id=<?= $row['id']; ?>" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
                                    <a href="upload.php?id=<?= $row['id']; ?>">Upload CV</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>

<?php
$angka1 = 10;
$angka2 = 5;
$teks = "Pemrograman Web";
$status = true;
$nilaiUjian = null;
$hasilKelulusan = null;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nilaiUjian = (float) ($_POST["nilai_ujian"] ?? 0);
    $hasilKelulusan = $nilaiUjian >= 75 ? "Lulus" : "Tidak Lulus";
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tipe Data, Operator, dan Percabangan</title>
</head>
<body>
    <h2>Tipe Data</h2>
    <p>$angka1 = <?php echo $angka1; ?> (<?php echo gettype($angka1); ?>)</p>
    <p>$angka2 = <?php echo $angka2; ?> (<?php echo gettype($angka2); ?>)</p>
    <p>$teks = <?php echo $teks; ?> (<?php echo gettype($teks); ?>)</p>
    <p>$status = <?php echo $status ? "true" : "false"; ?> (<?php echo gettype($status); ?>)</p>

    <h2>Operator Aritmatika</h2>
    <p><?php echo $angka1 . " + " . $angka2 . " = " . ($angka1 + $angka2); ?></p>
    <p><?php echo $angka1 . " - " . $angka2 . " = " . ($angka1 - $angka2); ?></p>
    <p><?php echo $angka1 . " * " . $angka2 . " = " . ($angka1 * $angka2); ?></p>
    <p><?php echo $angka1 . " / " . $angka2 . " = " . ($angka1 / $angka2); ?></p>

    <h2>Operator Perbandingan</h2>
    <p><?php echo $angka1 . " > " . $angka2 . " : " . (($angka1 > $angka2) ? "true" : "false"); ?></p>
    <p><?php echo $angka1 . " == " . $angka2 . " : " . (($angka1 == $angka2) ? "true" : "false"); ?></p>

    <h2>Percabangan Nilai Ujian</h2>
    <form method="POST" action="">
        <input type="number" name="nilai_ujian" min="0" max="100" step="0.01" required>
        <button type="submit">Cek Status</button>
    </form>

    <?php if ($nilaiUjian !== null): ?>
        <p>Nilai Ujian: <?php echo $nilaiUjian; ?></p>
        <p>Status: <?php echo $hasilKelulusan; ?></p>
    <?php endif; ?>
</body>
</html>

<?php
require_once __DIR__ . '/assets/helpers.php';
requireLogin();

$id = isset($_GET['id']) ? (int) $_GET['id'] : -1;
$list = loadMahasiswa();
$target = getMahasiswaByIndex($list, $id);

if ($target === null || $target->cv === '') {
    setFlash('File CV tidak ditemukan.', 'error');
    redirectTo('index.php');
}

$filePath = uploadDirPath() . '/' . $target->cv;
if (!is_file($filePath)) {
    setFlash('File CV tidak ada di server.', 'error');
    redirectTo('index.php');
}

$ext = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
$contentType = 'application/octet-stream';

if ($ext === 'pdf') {
    $contentType = 'application/pdf';
} elseif ($ext === 'doc') {
    $contentType = 'application/msword';
} elseif ($ext === 'docx') {
    $contentType = 'application/vnd.openxmlformats-officedocument.wordprocessingml.document';
}

header('Content-Description: File Transfer');
header('Content-Type: ' . $contentType);
header('Content-Disposition: attachment; filename="' . basename($target->cv) . '"');
header('Content-Length: ' . filesize($filePath));
header('Pragma: public');

readfile($filePath);
exit;

<?php
$file = $_GET["file"] ?? "";
$file = basename($file);
$path = __DIR__ . DIRECTORY_SEPARATOR . "uploads" . DIRECTORY_SEPARATOR . $file;

if ($file === "" || !is_file($path)) {
    echo "File tidak ditemukan.";
    exit;
}

header("Content-Description: File Transfer");
header("Content-Type: application/octet-stream");
header('Content-Disposition: attachment; filename="' . $file . '"');
header("Content-Length: " . filesize($path));
readfile($path);
exit;
?>

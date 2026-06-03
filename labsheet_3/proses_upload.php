<?php
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: upload_form.php");
    exit;
}

if (!isset($_FILES["fileToUpload"]) || $_FILES["fileToUpload"]["error"] !== UPLOAD_ERR_OK) {
    echo "Upload gagal.";
    echo '<br><a href="upload_form.php">Kembali</a>';
    exit;
}

$uploadDir = __DIR__ . DIRECTORY_SEPARATOR . "uploads";
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

$fileName = basename($_FILES["fileToUpload"]["name"]);
$targetFile = $uploadDir . DIRECTORY_SEPARATOR . $fileName;
$fileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
$fileSize = (int) $_FILES["fileToUpload"]["size"];

if (($fileType === "jpg" || $fileType === "png") && $fileSize <= 1048576) {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetFile)) {
        echo "File berhasil diupload.";
    } else {
        echo "Gagal upload file.";
    }
} else {
    echo "File harus .jpg/.png dan maksimal 1MB.";
}

echo '<br><a href="upload_form.php">Kembali</a>';
?>

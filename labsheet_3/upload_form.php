<?php
$uploadDir = __DIR__ . DIRECTORY_SEPARATOR . "uploads";
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

$files = array_values(array_filter(scandir($uploadDir), function ($file) use ($uploadDir) {
    return is_file($uploadDir . DIRECTORY_SEPARATOR . $file);
}));
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Upload & Download File</title>
</head>
<body>
    <h2>Upload File</h2>
    <form action="proses_upload.php" method="POST" enctype="multipart/form-data">
        <input type="file" name="fileToUpload" accept=".jpg,.png" required>
        <input type="submit" value="Upload">
    </form>

    <h3>Download File</h3>
    <ul>
        <?php foreach ($files as $file): ?>
            <li>
                <?php echo htmlspecialchars($file); ?> -
                <a href="download.php?file=<?php echo urlencode($file); ?>">Download</a>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>

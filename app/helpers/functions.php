<?php
function e(string $str): string {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

function csrfField(): string {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return '<input type="hidden" name="csrf_token" value="' . $_SESSION['csrf_token'] . '">';
}

function verifyCsrf(): void {
    if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'] ?? '', $_POST['csrf_token'])) {
        http_response_code(403);
        exit('Invalid CSRF token');
    }
    // Regenerate after use
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

function uploadFile(string $inputName, string $subDir): string {
    $file = $_FILES[$inputName];
    if ($file['error'] !== UPLOAD_ERR_OK) throw new Exception('Upload gagal');
    if ($file['size'] > MAX_FILE_SIZE) throw new Exception('File terlalu besar (max 2MB)');

    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime  = $finfo->file($file['tmp_name']);
    if (!in_array($mime, ALLOWED_MIME)) throw new Exception('Tipe file tidak diizinkan');

    $ext      = pathinfo($file['name'], PATHINFO_EXTENSION);
    $filename = bin2hex(random_bytes(16)) . '.' . $ext;
    $dest     = UPLOAD_PATH . '/' . $subDir . '/' . $filename;
    move_uploaded_file($file['tmp_name'], $dest);
    return $subDir . '/' . $filename;
}

function formatRupiah(float $amount): string {
    return 'Rp ' . number_format($amount, 0, ',', '.');
}

function flashSet(string $key, string $msg): void {
    $_SESSION['flash'][$key] = $msg;
}

function flashGet(string $key): ?string {
    $msg = $_SESSION['flash'][$key] ?? null;
    unset($_SESSION['flash'][$key]);
    return $msg;
}

function isLoggedIn(): bool {
    return isset($_SESSION['user_id']);
}

function isAdmin(): bool {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}

function alertModal(string $type, string $message): void {
    $GLOBALS['_alert_modal'] = ['type' => $type, 'message' => $message];
}

function alertModalFromFlash(): void {
    if ($msg = flashGet('success')) { alertModal('success', $msg); return; }
    if ($msg = flashGet('error'))   { alertModal('error',   $msg); }
}

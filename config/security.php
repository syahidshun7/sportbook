<?php
// Security headers
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: DENY');
header('X-XSS-Protection: 1; mode=block');
header('Referrer-Policy: strict-origin-when-cross-origin');

// App constants
define('BASE_URL', (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http')
    . '://' . $_SERVER['HTTP_HOST']
    . rtrim(dirname(dirname($_SERVER['SCRIPT_NAME'])), '/\\') . '/public');
if (!defined('ROOT_PATH')) define('ROOT_PATH', dirname(__DIR__));
define('UPLOAD_PATH', ROOT_PATH . '/public/uploads');

// Session config
define('SESSION_LIFETIME', 3600);       // 1 jam
define('MAX_LOGIN_ATTEMPTS', 5);
define('LOGIN_LOCKOUT_TIME', 15 * 60);  // 15 menit

// Upload config
define('MAX_FILE_SIZE', 2 * 1024 * 1024); // 2MB
define('ALLOWED_MIME', ['image/jpeg', 'image/png', 'application/pdf']);

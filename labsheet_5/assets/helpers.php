<?php
session_start();

require_once __DIR__ . '/Mahasiswa.php';

function dataFilePath(): string
{
    return __DIR__ . '/../data_mahasiswa.txt';
}

function uploadDirPath(): string
{
    return __DIR__ . '/../uploads';
}

function ensureStorageReady(): void
{
    if (!file_exists(dataFilePath())) {
        file_put_contents(dataFilePath(), '');
    }

    if (!is_dir(uploadDirPath())) {
        mkdir(uploadDirPath(), 0777, true);
    }
}

function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

function redirectTo(string $path): void
{
    header('Location: ' . $path);
    exit;
}

function isLoggedIn(): bool
{
    return isset($_SESSION['is_login']) && $_SESSION['is_login'] === true;
}

function requireLogin(): void
{
    if (!isLoggedIn()) {
        redirectTo('login.php');
    }
}

function setFlash(string $message, string $type = 'success'): void
{
    $_SESSION['flash'] = [
        'message' => $message,
        'type' => $type,
    ];
}

function getFlash(): ?array
{
    if (!isset($_SESSION['flash'])) {
        return null;
    }

    $flash = $_SESSION['flash'];
    unset($_SESSION['flash']);

    return $flash;
}

function loadMahasiswa(): array
{
    ensureStorageReady();
    $lines = file(dataFilePath(), FILE_IGNORE_NEW_LINES);
    $list = [];

    foreach ($lines as $line) {
        $obj = Mahasiswa::fromLine($line);
        if ($obj !== null) {
            $list[] = $obj;
        }
    }

    return $list;
}

function saveMahasiswa(array $list): bool
{
    $lines = [];
    foreach ($list as $item) {
        if ($item instanceof Mahasiswa) {
            $lines[] = $item->toLine();
        }
    }

    $content = implode(PHP_EOL, $lines);
    if ($content !== '') {
        $content .= PHP_EOL;
    }

    return file_put_contents(dataFilePath(), $content) !== false;
}

function getMahasiswaByIndex(array $list, int $index): ?Mahasiswa
{
    return $list[$index] ?? null;
}

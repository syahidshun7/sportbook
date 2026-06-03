<?php
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../repositories/MahasiswaRepository.php';

$database = new Database();
$db = $database->getConnection();
$repo = new MahasiswaRepository($db);

$repo->delete($_GET['id']);
header("Location: ../index.php");
exit;

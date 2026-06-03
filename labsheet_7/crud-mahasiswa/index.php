<?php
require_once "config/Database.php";
require_once "repositories/MahasiswaRepository.php";

$database = new Database();
$db = $database->getConnection();
$repo = new MahasiswaRepository($db);
$mahasiswas = $repo->getAll();

include "views/index.php";

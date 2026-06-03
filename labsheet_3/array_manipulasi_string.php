<?php
$mahasiswa = ["Budi", "Santi", "Iwan"];

foreach ($mahasiswa as $nama) {
    echo "Nama: " . $nama . "<br>";
}

$teks = "selamat belajar php";
echo strtoupper($teks) . "<br>";
echo str_replace("php", "coding", $teks);
?>

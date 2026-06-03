<?php 
$nama = isset($_GET['name']) ? $_GET['name'] : 'Tamu';
$umur = isset($_GET['age']) ? $_GET['age'] : 'Tamu';
echo "<h1>Hallo, " . htmlspecialchars($nama) . "!</h1>";
echo "<p>you are " . htmlspecialchars($umur) . " years old</p>";
?>
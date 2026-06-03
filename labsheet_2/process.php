<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $gender = $_POST['gender'];
    $hobbies = isset($_POST['hobby']) ? $_POST['hobby'] : [];
    $description = $_POST['deskripsi'];
    $selectedOption = $_POST['dropdown'];

    echo "Nama: " . htmlspecialchars($name, ENT_QUOTES, 'UTF-8') . "<br>";
    echo "Jenis Kelamin: " . htmlspecialchars($gender, ENT_QUOTES, 'UTF-8') . "<br>";
    echo "Hobi: " . implode(", ", array_map(function($hobby) {
        return htmlspecialchars($hobby, ENT_QUOTES, 'UTF-8');
    }, $hobbies)) . "<br>";
    echo "Deskripsi: " . htmlspecialchars($description, ENT_QUOTES, 'UTF-8') . "<br>";
    echo "Pilihan: " . htmlspecialchars($selectedOption, ENT_QUOTES, 'UTF-8') . "<br>";

    if ($_POST['username'] == 'admin' && $_POST['password'] == '12345') {
 header("Location: dashboard.php");
 exit();
 } else {
 header("Location: login.php?error=1");
 exit();
 }
}

?>
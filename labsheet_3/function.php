<?php
function luasLingkaran($radius) {
    $luas = 3.14 * $radius * $radius;
    return "Luas Lingkaran: " . $luas;
}
echo luasLingkaran(7);
?>

<?php
if (isset($_GET['code'])) {
 http_response_code($_GET['code']);
 switch ($_GET['code']) {
 case 404:
 echo "Halaman tidak ditemukan.";
 break;
 case 500:
 echo "Terjadi kesalahan server.";
 break;
 default:
 echo "Kode tidak dikenali.";
 }
} else {
 http_response_code(200);
 echo "Halaman normal.";
}
?>
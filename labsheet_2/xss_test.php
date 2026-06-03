<?php
if (isset($_GET['nama_depan'])) {
 echo "Hello, " . htmlspecialchars($_GET['nama_depan'], ENT_QUOTES, 'UTF-8');

}

if (isset($_GET['nama_belakang'])) {
 echo "Hello, " . $_GET['nama_belakang'];
}

?>


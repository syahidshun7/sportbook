<?php
require_once __DIR__ . '/assets/helpers.php';

session_unset();
session_destroy();

setcookie('last_username', '', time() - 3600, '/');
setcookie('last_login', '', time() - 3600, '/');

header('Location: login.php');
exit;

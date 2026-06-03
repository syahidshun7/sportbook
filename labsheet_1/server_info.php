<?php
echo "<h1>Server Information</h1>";
echo "<p>Server Name: " . htmlspecialchars($_SERVER['SERVER_NAME']) . "</p>";
echo "<p>Server IP: " . htmlspecialchars($_SERVER['SERVER_ADDR']) . "</p>";
echo "<p>Server Software: " . htmlspecialchars($_SERVER['SERVER_SOFTWARE']) . "</p>";
?>
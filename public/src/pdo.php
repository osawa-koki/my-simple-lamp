<?php
$dsn = getenv('DB_DSN');
$username = getenv('DB_USERNAME');
$password = getenv('DB_PASSWORD');
$pdo = new PDO($dsn, $username, $password);
?>

<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'is115_bookingsystem');
$dsn = 'mysql:dbname=' . DB_NAME . ';host=' . DB_HOST; // Driver settes her

try {
    $pdo = new PDO($dsn, DB_USER, DB_PASS);
} catch (PDOException $e) {
    echo "Oi, her gikk det galt!";
}

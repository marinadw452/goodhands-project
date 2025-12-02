<?php
$host = $_ENV["MYSQLHOST"] ?? "mysql.railway.internal";
$db   = $_ENV["MYSQLDATABASE"] ?? "railway";
$user = $_ENV["MYSQLUSER"] ?? "root";
$pass = $_ENV["MYSQLPASSWORD"] ?? "";
$port = $_ENV["MYSQLPORT"] ?? "3306";

$conn = mysqli_connect($host, $user, $pass, $db, $port);
if (!$conn) die("خطأ في الاتصال: " . mysqli_connect_error());

mysqli_query($conn, "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");
?>

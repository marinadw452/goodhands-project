<?php
session_start();

// اتصال MySQL (محلي أو على Railway)
$host = $_ENV["MYSQLHOST"] ?? "127.0.0.1";
$db   = $_ENV["MYSQLDATABASE"] ?? "goodhands";
$user = $_ENV["MYSQLUSER"] ?? "root";
$pass = $_ENV["MYSQLPASSWORD"] ?? "";
$port = $_ENV["MYSQLPORT"] ?? "3306";

$conn = mysqli_connect($host, $user, $pass, $db, $port);
if (!$conn) {
    die("فشل الاتصال: " . mysqli_connect_error());
}

// إنشاء جدول المستخدمين تلقائيًا
mysqli_query($conn, "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");
?>

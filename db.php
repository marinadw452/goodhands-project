<?php
session_start();

// على Railway لازم نستخدم المتغيرات اللي Railway بيحطها تلقائيًا
$host = $_ENV["MYSQLHOST"] ?? "mysql.railway.internal";
$db   = $_ENV["MYSQLDATABASE"] ?? "railway";
$user = $_ENV["MYSQLUSER"] ?? "root";
$pass = $_ENV["MYSQLPASSWORD"]; // مهم: ما تحطش قيمة افتراضية هنا
$port = $_ENV["MYSQLPORT"] ?? "3306";

// لو الـ pass فاضي (يعني مش موجود)، نجرب بدون باسوورد أو نوقف
if ($pass === null) {
    die("MYSQLPASSWORD مش موجود في الـ Variables على Railway!");
}

$conn = mysqli_connect($host, $user, $pass, $db, $port);

if (!$conn) {
    // رسالة واضحة عشان نعرف المشكلة فورًا
    die("فشل الاتصال بـ MySQL على Railway!<br>
         Host: $host<br>
         DB: $db<br>
         User: $user<br>
         Port: $port<br>
         Error: " . mysqli_connect_error());
}

// إنشاء الجدول تلقائيًا
mysqli_query($conn, "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");
?>

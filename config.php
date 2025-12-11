<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$host = getenv("MYSQLHOST") ?: "127.0.0.1";
$port = getenv("MYSQLPORT") ?: "3306";
$user = getenv("MYSQLUSER") ?: "root";
$pass = getenv("MYSQLPASSWORD");

// في XAMPP غالبًا كلمة المرور فاضية
if ($pass === false || $pass === null) $pass = "";
$db   = getenv("MYSQLDATABASE") ?: "railway";

$conn = mysqli_connect($host, $user, $pass, $db, (int)$port);
mysqli_set_charset($conn, "utf8mb4");

// احذفي echo بعد ما تتأكدي
// echo "تم الاتصال بنجاح";
?>

<?php
$host     = getenv("MYSQLHOST");
$user     = getenv("MYSQLUSER");
$password = getenv("MYSQLPASSWORD");
$database = getenv("MYSQLDATABASE");
$port     = getenv("MYSQLPORT");

$conn = new mysqli($host, $user, $password, $database, $port);

if ($conn->connect_error) {
    error_log("❌ فشل الاتصال بقاعدة البيانات: " . $conn->connect_error);
    die("فشل الاتصال بقاعدة البيانات");
} else {
    error_log("✅ تم الاتصال بنجاح بقاعدة البيانات: $database على $host:$port بواسطة $user");
}

return $conn;
?>

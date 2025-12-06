<?php
$host = getenv("MYSQLHOST");
$user = getenv("MYSQLUSER");
$password = getenv("MYSQLPASSWORD");
$database = getenv("MYSQLDATABASE");
$port = getenv("MYSQLPORT");

$conn = new mysqli($host, $user, $password, $database, $port);

if ($conn->connect_error) {
    die("❌ فشل الاتصال: " . $conn->connect_error);
}
echo "✅ تم الاتصال بنجاح بقاعدة البيانات!";

$result = $conn->query("SELECT 1");
if ($result) {
    echo " | نتيجة الاستعلام: ";
    print_r($result->fetch_assoc());
}

$conn->close();
?>

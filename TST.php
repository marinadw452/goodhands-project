<?php
$host = getenv("MYSQLHOST");       // اسم السيرفر من البيئة
$user = getenv("MYSQLUSER");       // اسم المستخدم
$password = getenv("MYSQLPASSWORD"); // كلمة المرور
$database = getenv("MYSQLDATABASE"); // اسم قاعدة البيانات
$port = getenv("MYSQLPORT");       // المنفذ

$conn = new mysqli($host, $user, $password, $database, $port);

if ($conn->connect_error) {
    die("❌ فشل الاتصال: " . $conn->connect_error);
}
echo "✅ تم الاتصال بنجاح بقاعدة البيانات!";

// اختبار استعلام بسيط
$result = $conn->query("SELECT 1");
if ($result) {
    echo "نتيجة الاستعلام: ";
    print_r($result->fetch_assoc());
}

$conn->close();
?>

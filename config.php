<?php
// قراءة المتغيرات من البيئة (Railway يوفرها تلقائيًا)
$host     = getenv("MYSQLHOST");
$user     = getenv("MYSQLUSER");
$password = getenv("MYSQLPASSWORD");
$database = getenv("MYSQLDATABASE");
$port     = getenv("MYSQLPORT");

// الاتصال باستخدام mysqli
$conn = new mysqli($host, $user, $password, $database, $port);

// التحقق من الاتصال
if ($conn->connect_error) {
    error_log("❌ فشل الاتصال بقاعدة البيانات: " . $conn->connect_error);
    die("فشل الاتصال بقاعدة البيانات");
} else {
    error_log("✅ تم الاتصال بنجاح بقاعدة البيانات: $database على السيرفر $host:$port");
}

// بإمكانك هنا إرجاع $conn لاستخدامه في باقي الملفات
return $conn;
?>

<?php
// ===============================
// إعداد الاتصال بقاعدة البيانات (Railway Ready)
// ===============================

// جلب DSN من متغير البيئة
$dsn = getenv('DATABASE_URL');

try {
    if ($dsn) {
        // الاتصال بالقاعدة على Railway
        $conn = new PDO($dsn);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } else {
        // fallback للاتصال المحلي (لتطوير محلي)
        $host = 'localhost';
        $dbname = 'goodhands_db';
        $username = 'root';
        $password = '';
        $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
} catch (Exception $e) {
    $conn = null;
    // يمكنك تسجيل الخطأ في log إذا أحببت
    // error_log($e->getMessage());
}
?>

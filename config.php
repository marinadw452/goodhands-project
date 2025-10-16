<?php
// ===============================
// إعداد الاتصال بقاعدة البيانات (Railway Ready)
// ===============================

// نحاول جلب الـ DSN من متغير البيئة DATABASE_URL
$dsn = getenv('DATABASE_URL');

try {
    if ($dsn) {
        // الاتصال باستخدام متغير البيئة
        $conn = new PDO($dsn);
    } else {
        // إذا المتغير غير موجود، fallback للاتصال المحلي (مثال)
        $host = 'localhost';
        $dbname = 'goodhands_db';
        $username = 'root';
        $password = '';
        $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    }

    // إعدادات الأمان
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (Exception $e) {
    // في حال فشل الاتصال
    $conn = null;
    // يمكنك تسجيل الخطأ في ملف log لكن لا تعرضه للمستخدم النهائي
    // error_log($e->getMessage());
}
?>

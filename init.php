<?php
// بدء الجلسة لو احتجت
session_start();

// الاتصال بقاعدة البيانات
$databaseUrl = getenv("DATABASE_URL");

if (!$databaseUrl) {
    die("DATABASE_URL غير معرف في متغيرات البيئة!");
}

$conn = pg_connect($databaseUrl);
if (!$conn) {
    die("فشل الاتصال بقاعدة البيانات: " . pg_last_error());
}

// إنشاء جدول المستخدمين
$result = pg_query($conn, "
    CREATE TABLE IF NOT EXISTS users (
        id SERIAL PRIMARY KEY,
        username VARCHAR(100) UNIQUE NOT NULL,
        password TEXT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )
");

if (!$result) {
    die("فشل إنشاء الجدول: " . pg_last_error());
} else {
    echo "تم إنشاء الجدول بنجاح!";
}

// إغلاق الاتصال (اختياري)
pg_close($conn);
?>

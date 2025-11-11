<?php
// لا تحتاج session هنا
$DATABASE_URL = getenv("DATABASE_URL");

$conn = pg_connect($DATABASE_URL);

if (!$conn) {
    die("فشل الاتصال بقاعدة البيانات: " . pg_last_error());
}

// إنشاء الجدول إذا ما كان موجود
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
}
?>
    

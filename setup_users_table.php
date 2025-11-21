<?php
require_once "config.php"; // الاتصال بقاعدة البيانات (PDO)

try {
    // حذف الجدول إذا كان موجود
    $conn->exec("DROP TABLE IF EXISTS users CASCADE");

    // إنشاء الجدول من جديد
    $conn->exec("
        CREATE TABLE users (
            id SERIAL PRIMARY KEY,
            username VARCHAR(50) UNIQUE NOT NULL,
            email VARCHAR(100) UNIQUE NOT NULL,
            password VARCHAR(255) NOT NULL,
            user_type VARCHAR(10) NOT NULL CHECK (user_type IN ('buyer', 'seller')),
            created_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP
        )
    ");

    echo 'تم حذف وإنشاء جدول users بنجاح!';
} catch (PDOException $e) {
    echo 'خطأ: ' . $e->getMessage();
}
?>

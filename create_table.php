<?php
require_once "config.php";

try {
    // حذف جدول users إن وُجد
    $conn->exec("DROP TABLE IF EXISTS users CASCADE");

    // إعادة إنشاء جدول users
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

    echo "تم حذف الجدول السابق وإنشاؤه من جديد بنجاح!";
} catch (PDOException $e) {
    die('خطأ أثناء تنفيذ العملية: ' . $e->getMessage());
}
?>

<?php
require_once "config.php";

try {
    $sql = "
    CREATE TABLE IF NOT EXISTS users (
        id SERIAL PRIMARY KEY,
        username VARCHAR(100) UNIQUE NOT NULL,
        password TEXT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );
    ";
    $conn->exec($sql);
    echo "✅ تم إنشاء جدول users بنجاح!";
} catch (PDOException $e) {
    echo "❌ فشل إنشاء الجدول: " . $e->getMessage();
}
?>

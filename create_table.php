<?php
require_once "config.php";

try {
    $conn->exec("
        CREATE TABLE IF NOT EXISTS users (
            id SERIAL PRIMARY KEY,
            username VARCHAR(100) UNIQUE NOT NULL,
            password TEXT NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )
    ");
    echo "تم إنشاء الجدول بنجاح!";
} catch (PDOException $e) {
    die("فشل إنشاء الجدول: " . $e->getMessage());
}
?>

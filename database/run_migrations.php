<?php
require_once __DIR__ . "/config.php"; // اتصال PostgreSQL

try {
    $sql = <<<SQL
CREATE TABLE IF NOT EXISTS users (
    id SERIAL PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    user_type VARCHAR(10) NOT NULL CHECK (user_type IN ('buyer', 'seller')),
    created_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP
);
SQL;

    $conn->exec($sql);

    echo "✅ جدول users تم إنشاؤه بنجاح!";
} catch (PDOException $e) {
    echo "❌ خطأ أثناء إنشاء الجدول: " . $e->getMessage();
}

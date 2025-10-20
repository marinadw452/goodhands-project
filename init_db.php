<?php
require_once "config.php";

try {
    $sql = file_get_contents("init.sql");
    $conn->exec($sql);
    echo "✅ تم إنشاء الجداول بنجاح";
} catch (PDOException $e) {
    echo "❌ خطأ أثناء إنشاء الجداول: " . $e->getMessage();
}
?>

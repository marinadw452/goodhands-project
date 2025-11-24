<?php
require_once __DIR__ . "/../config.php";

try {
    $sql = file_get_contents(__DIR__ . "/init.sql");  // قراءة ملف SQL

    $conn->exec($sql); // تنفيذ SQL

    echo "تم تنفيذ ملف init.sql وإنشاء الجداول بنجاح.";
} catch (PDOException $e) {
    echo "خطأ أثناء تنفيذ ملف SQL: " . $e->getMessage();
}

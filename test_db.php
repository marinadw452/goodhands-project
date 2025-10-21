<?php
require_once "config.php"; // يستخدم نفس الاتصال الأصلي بدون أي تعديل

try {
    $stmt = $conn->query("SELECT NOW()");
    $time = $stmt->fetchColumn();
    echo "✅ اتصال ناجح بقاعدة البيانات!<br>";
    echo "🕒 الوقت الحالي في السيرفر: " . $time;
} catch (PDOException $e) {
    echo "❌ فشل الاتصال بقاعدة البيانات:<br>" . $e->getMessage();
}
?>

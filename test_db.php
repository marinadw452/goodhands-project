<?php
require_once "config.php";

try {
    $stmt = $conn->query("SELECT NOW()");
    $time = $stmt->fetchColumn();
    echo "✅ اتصال ناجح بقاعدة البيانات!<br>";
    echo "🕒 الوقت الحالي في السيرفر: " . $time;
} catch (PDOException $e) {
    echo "<pre>";
    echo "❌ فشل الاتصال بقاعدة البيانات:\n";
    echo $e->getMessage();
    echo "</pre>";
}
?>

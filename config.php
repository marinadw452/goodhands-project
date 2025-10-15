<?php
// ===============================
// إعداد الاتصال بقاعدة البيانات
// ===============================

// القيم التالية تُستخدم فقط كمثال
$host = 'localhost';
$dbname = 'goodhands_db';
$username = 'root';
$password = '';

try {
    // نحاول الاتصال بقاعدة البيانات (حتى لو ما موجودة ما يعطي خطأ)
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    // إعدادات الأمان
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    // في حال ما كانت قاعدة البيانات جاهزة، نخلي الاتصال "null"
    $conn = null;
    // ما نعرض أي خطأ للمستخدم النهائي
}
?>

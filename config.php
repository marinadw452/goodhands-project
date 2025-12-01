<?php
// جلب المتغيرات من البيئة
$host = getenv("PGHOST");
$port = getenv("PGPORT");
$user = getenv("PGUSER");
$password = getenv("PGPASSWORD");
$dbname = getenv("PGDATABASE");

// بناء سلسلة الاتصال
$conn_string = "host=$host port=$port dbname=$dbname user=$user password=$password";

// الاتصال
$conn = pg_connect($conn_string);

if (!$conn) {
    die("❌ فشل الاتصال بقاعدة البيانات: " . pg_last_error());
}

// echo "تم الاتصال بنجاح";

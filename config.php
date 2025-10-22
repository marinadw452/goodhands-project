<?php
session_start();

$databaseUrl = getenv("DATABASE_URL");

if (!$databaseUrl) {
    die("DATABASE_URL غير معرف في متغيرات البيئة!");
}

$conn = pg_connect($databaseUrl);
if (!$conn) {
    die("فشل الاتصال بقاعدة البيانات: " . pg_last_error());
}

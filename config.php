<?php
// الاتصال بقاعدة البيانات عبر متغير البيئة DATABASE_URL
$DATABASE_URL = getenv("DATABASE_URL");

if (!$DATABASE_URL) {
    die("❌ DATABASE_URL غير موجود في المتغيرات البيئية.");
}

$conn = pg_connect($DATABASE_URL) or die("❌ فشل الاتصال: " . pg_last_error());

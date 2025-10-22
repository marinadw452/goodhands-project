<?php
// جرب الاتصال بقاعدة البيانات باستخدام DATABASE_URL
$databaseUrl = getenv("DATABASE_URL");

$conn = pg_connect($databaseUrl);

if (!$conn) {
    die("فشل الاتصال بقاعدة البيانات: " . pg_last_error());
} else {
    echo "تم الاتصال بقاعدة البيانات بنجاح ✅";
}
?>

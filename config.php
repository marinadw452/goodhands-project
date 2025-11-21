<?php
$DATABASE_URL = getenv("DATABASE_URL");
$conn = pg_connect($DATABASE_URL) or die("Connect failed: ".pg_last_error());

// عرض اسم القاعدة والمخطط
$res = pg_query($conn, "SELECT current_database() AS db, current_schema() AS schema, current_setting('search_path') AS sp");
print_r(pg_fetch_assoc($res));

// التأكد إن الجدول موجود
$res2 = pg_query($conn, "SELECT table_schema, table_name FROM information_schema.tables WHERE table_name='users'");
while ($row = pg_fetch_assoc($res2)) {
    print_r($row);
}
?>

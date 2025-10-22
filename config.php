<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$databaseUrl = getenv("DATABASE_URL");

try {
    if ($databaseUrl) {
        // اتصال مباشر بـ DATABASE_URL
        $conn = new PDO(
            $databaseUrl,
            null,
            null,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES => false
            ]
        );
    } else {
        // اتصال باستخدام المتغيرات المفصلة
        $host = getenv("PGHOST");
        $port = getenv("PGPORT");
        $dbname = getenv("PGDATABASE");
        $user = getenv("PGUSER");
        $password = getenv("PGPASSWORD");

        $conn = new PDO(
            "pgsql:host=$host;port=$port;dbname=$dbname",
            $user,
            $password,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES => false
            ]
        );
    }
} catch (PDOException $e) {
    die("❌ فشل الاتصال بقاعدة البيانات: " . $e->getMessage());
}
?>

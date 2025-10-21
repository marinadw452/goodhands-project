<?php
$databaseUrl = getenv("DATABASE_URL");

if ($databaseUrl) {
    // لو المتغير DATABASE_URL موجود، نستخدمه مباشرة
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
    // لو مو موجود، نستخدم المتغيرات المفصلة
    $host = getenv("PGHOST");
    $port = getenv("PGPORT");
    $dbname = getenv("PGDATABASE");
    $user = getenv("PGUSER");
    $password = getenv("PGPASSWORD");

    try {
        $conn = new PDO(
            "pgsql:host=$host;port=$port;dbname=$dbname",
            $user,
            $password,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES => false
            ]
        );
    } catch (PDOException $e) {
        die("فشل الاتصال بقاعدة البيانات: " . $e->getMessage());
    }
}
?>

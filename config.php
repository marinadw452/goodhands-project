<?php
$databaseUrl = getenv("DATABASE_URL");

try {
    if ($databaseUrl) {
        // تعديل URL ليكون متوافق مع PDO
        $databaseUrl = str_replace("postgres://", "pgsql://", $databaseUrl);
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

    // إنشاء جدول المستخدمين إن لم يكن موجود
    $conn->exec("
        CREATE TABLE IF NOT EXISTS users (
            id SERIAL PRIMARY KEY,
            username VARCHAR(100) UNIQUE NOT NULL,
            password TEXT NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )
    ");

} catch (PDOException $e) {
    die('فشل الاتصال بقاعدة البيانات: ' . $e->getMessage());
}
?>

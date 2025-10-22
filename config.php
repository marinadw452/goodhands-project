<?php
$databaseUrl = getenv("DATABASE_URL");

if ($databaseUrl) {
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
?>

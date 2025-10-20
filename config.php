<?php
$host = getenv("PGHOST") ?: "containers-us-west-92.railway.app";
$port = getenv("PGPORT") ?: "5432";
$dbname = getenv("PGDATABASE") ?: "railway";
$user = getenv("PGUSER") ?: "postgres";
$password = getenv("PGPASSWORD") ?: "xxxxxxxxxxxxxxxx";

try {
    $conn = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("فشل الاتصال بقاعدة البيانات: " . $e->getMessage());
}
?>

<?php
$host = getenv("PGHOST") 
$port = getenv("PGPORT") 
$dbname = getenv("PGDATABASE") 
$user = getenv("PGUSER") 
$password = getenv("PGPASSWORD")

try {
    $conn = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("فشل الاتصال بقاعدة البيانات: " . $e->getMessage());
}
?>

<?php
// seller_categories_api.php
session_start();
require_once "../../config.php";
header('Content-Type: application/json; charset=utf-8');

if (!isset($_SESSION['seller_id'])) {
  echo json_encode(["ok"=>false,"error"=>"Unauthorized"]); exit;
}

$res = $conn->query("SELECT id, name FROM categories ORDER BY name ASC");
$data = [];
while($row = $res->fetch_assoc()) $data[] = $row;

echo json_encode(["ok"=>true,"data"=>$data]);

<?php
// seller_orders_update.php
session_start();
require_once "../../config.php";
header('Content-Type: application/json; charset=utf-8');

if (!isset($_SESSION['seller_id'])) {
  echo json_encode(["ok" => false, "error" => "Unauthorized"]);
  exit;
}
$seller_id = (int)$_SESSION['seller_id'];

$order_id = (int)($_POST['order_id'] ?? 0);
$status = trim((string)($_POST['status'] ?? ''));
$expected = trim((string)($_POST['expected_delivery_date'] ?? ''));

$allowed = ["PENDING","PAID","SHIPPED","DELIVERED","CANCELLED"];
if ($order_id <= 0) { echo json_encode(["ok"=>false,"error"=>"order_id غير صحيح"]); exit; }
if (!in_array($status, $allowed, true)) { echo json_encode(["ok"=>false,"error"=>"status غير صحيح"]); exit; }
if ($expected !== '' && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $expected)) {
  echo json_encode(["ok"=>false,"error"=>"صيغة التاريخ غير صحيحة"]); exit;
}

// تحقق أن الطلب يخص البائع
$sqlCheck = "SELECT 1 FROM order_items WHERE order_id = ? AND seller_id = ? LIMIT 1";
$stmt = $conn->prepare($sqlCheck);
$stmt->bind_param("ii", $order_id, $seller_id);
$stmt->execute();
if (!$stmt->get_result()->fetch_assoc()) {
  echo json_encode(["ok"=>false,"error"=>"لا تملك صلاحية تعديل هذا الطلب"]);
  exit;
}

// Upsert tracking
// 1) حاول تحديث
if ($expected === '') {
  $sqlUp = "UPDATE seller_order_tracking SET status = ?, expected_delivery_date = NULL, delivered_at = IF(?='DELIVERED', NOW(), delivered_at) WHERE order_id = ? AND seller_id = ?";
  $del = $status;
  $stmt2 = $conn->prepare($sqlUp);
  $stmt2->bind_param("siii", $status, $order_id, $seller_id, $seller_id); // (لن تمر) -> سنستخدم صيغة أبسط
}

// صيغة واضحة:
if ($expected === '') {
  $sql = "
    INSERT INTO seller_order_tracking (order_id, seller_id, status, expected_delivery_date, delivered_at)
    VALUES (?, ?, ?, NULL, IF(?='DELIVERED', NOW(), NULL))
    ON DUPLICATE KEY UPDATE
      status = VALUES(status),
      expected_delivery_date = NULL,
      delivered_at = IF(VALUES(status)='DELIVERED', NOW(), delivered_at)
  ";
  $stmt3 = $conn->prepare($sql);
  $stmt3->bind_param("iiss", $order_id, $seller_id, $status, $status);
} else {
  $sql = "
    INSERT INTO seller_order_tracking (order_id, seller_id, status, expected_delivery_date, delivered_at)
    VALUES (?, ?, ?, ?, IF(?='DELIVERED', NOW(), NULL))
    ON DUPLICATE KEY UPDATE
      status = VALUES(status),
      expected_delivery_date = VALUES(expected_delivery_date),
      delivered_at = IF(VALUES(status)='DELIVERED', NOW(), delivered_at)
  ";
  $stmt3 = $conn->prepare($sql);
  $stmt3->bind_param("iisss", $order_id, $seller_id, $status, $expected, $status);
}

if (!$stmt3->execute()) {
  echo json_encode(["ok"=>false,"error"=>"فشل الحفظ"]);
  exit;
}

echo json_encode(["ok"=>true]);

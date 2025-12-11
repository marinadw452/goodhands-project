<?php
// seller_orders_api.php
session_start();
require_once "../../config.php";
header('Content-Type: application/json; charset=utf-8');

if (!isset($_SESSION['seller_id'])) {
  echo json_encode(["ok" => false, "error" => "Unauthorized"]);
  exit;
}
$seller_id = (int)$_SESSION['seller_id'];

if (!isset($conn)) {
  echo json_encode(["ok" => false, "error" => "DB connection not found"]);
  exit;
}

function safe($v){ return trim((string)$v); }

// ===== تفاصيل طلب واحد للبائع =====
if (isset($_GET['order_id']) && $_GET['order_id'] !== '') {
  $order_id = (int)$_GET['order_id'];

  // تأكد أن الطلب يحتوي عناصر تخص هذا البائع
  $sqlOrder = "
    SELECT
      o.id AS order_id,
      o.status AS order_status,
      DATE_FORMAT(o.created_at, '%Y-%m-%d %H:%i') AS created_at,
      o.total_amount,
      u.full_name AS buyer_name,
      u.email AS buyer_email,
      CONCAT_WS(' - ', a.city, a.street, a.details) AS address_text,
      a.phone AS address_phone,
      IFNULL(SUM(oi.line_total), 0) AS seller_total,
      sot.status AS seller_status,
      DATE_FORMAT(sot.expected_delivery_date, '%Y-%m-%d') AS expected_delivery_date,
      sot.delivered_at
    FROM orders o
    JOIN order_items oi ON oi.order_id = o.id AND oi.seller_id = ?
    LEFT JOIN users u ON u.id = o.buyer_id
    LEFT JOIN addresses a ON a.id = o.shipping_address_id
    LEFT JOIN seller_order_tracking sot ON sot.order_id = o.id AND sot.seller_id = ?
    WHERE o.id = ?
    GROUP BY o.id
    LIMIT 1
  ";
  $stmt = $conn->prepare($sqlOrder);
  $stmt->bind_param("iii", $seller_id, $seller_id, $order_id);
  $stmt->execute();
  $order = $stmt->get_result()->fetch_assoc();

  if (!$order) {
    echo json_encode(["ok" => false, "error" => "الطلب غير موجود أو لا يخص هذا البائع"]);
    exit;
  }

  // عناصر الطلب الخاصة بالبائع + صورة أساسية
  $sqlItems = "
    SELECT
      p.title AS product_title,
      oi.qty,
      oi.unit_price,
      oi.line_total,
      pi.image_url
    FROM order_items oi
    JOIN products p ON p.id = oi.product_id
    LEFT JOIN product_images pi ON pi.product_id = p.id AND pi.is_primary = 1
    WHERE oi.order_id = ? AND oi.seller_id = ?
    ORDER BY oi.id DESC
  ";
  $stmt2 = $conn->prepare($sqlItems);
  $stmt2->bind_param("ii", $order_id, $seller_id);
  $stmt2->execute();
  $res2 = $stmt2->get_result();

  $items = [];
  while ($row = $res2->fetch_assoc()) $items[] = $row;

  echo json_encode(["ok" => true, "order" => $order, "items" => $items]);
  exit;
}


// ===== قائمة الطلبات للبائع =====
$q = safe($_GET['q'] ?? '');
$status = safe($_GET['status'] ?? ''); // seller_status
$sort = safe($_GET['sort'] ?? 'newest');
$page = max(1, (int)($_GET['page'] ?? 1));
$pageSize = min(50, max(5, (int)($_GET['pageSize'] ?? 10)));
$offset = ($page - 1) * $pageSize;

$where = " WHERE oi.seller_id = ? ";
$params = [$seller_id];
$types = "i";

if ($status !== '') {
  $where .= " AND sot.status = ? ";
  $types .= "s";
  $params[] = $status;
}

if ($q !== '') {
  $where .= " AND (CAST(o.id AS CHAR) LIKE CONCAT('%', ?, '%') OR u.full_name LIKE CONCAT('%', ?, '%')) ";
  $types .= "ss";
  $params[] = $q;
  $params[] = $q;
}

$orderBy = " ORDER BY o.id DESC ";
if ($sort === "oldest") $orderBy = " ORDER BY o.id ASC ";
if ($sort === "delivery_soon") $orderBy = " ORDER BY (sot.expected_delivery_date IS NULL), sot.expected_delivery_date ASC, o.id DESC ";

// Count distinct orders
$sqlCount = "
  SELECT COUNT(DISTINCT o.id) AS cnt
  FROM orders o
  JOIN order_items oi ON oi.order_id = o.id
  LEFT JOIN users u ON u.id = o.buyer_id
  LEFT JOIN seller_order_tracking sot ON sot.order_id = o.id AND sot.seller_id = oi.seller_id
  $where
";
$stmtC = $conn->prepare($sqlCount);
$stmtC->bind_param($types, ...$params);
$stmtC->execute();
$total = (int)($stmtC->get_result()->fetch_assoc()['cnt'] ?? 0);

$totalPages = max(1, (int)ceil($total / $pageSize));
if ($page > $totalPages) { $page = $totalPages; $offset = ($page - 1) * $pageSize; }

// Data
$sqlData = "
  SELECT
    o.id AS order_id,
    DATE_FORMAT(o.created_at, '%Y-%m-%d %H:%i') AS created_at,
    u.full_name AS buyer_name,
    u.email AS buyer_email,
    IFNULL(SUM(oi.line_total),0) AS seller_total,
    IFNULL(sot.status, o.status) AS seller_status,
    DATE_FORMAT(sot.expected_delivery_date, '%Y-%m-%d') AS expected_delivery_date
  FROM orders o
  JOIN order_items oi ON oi.order_id = o.id
  LEFT JOIN users u ON u.id = o.buyer_id
  LEFT JOIN seller_order_tracking sot ON sot.order_id = o.id AND sot.seller_id = oi.seller_id
  $where
  GROUP BY o.id
  $orderBy
  LIMIT ? OFFSET ?
";

$types2 = $types . "ii";
$params2 = array_merge($params, [$pageSize, $offset]);

$stmtD = $conn->prepare($sqlData);
$stmtD->bind_param($types2, ...$params2);
$stmtD->execute();
$res = $stmtD->get_result();

$data = [];
$late = 0;
$processing = 0;
$today = date("Y-m-d");

while ($row = $res->fetch_assoc()) {
  $data[] = $row;
  if (($row['seller_status'] ?? '') === 'PAID') $processing++;

  $exp = $row['expected_delivery_date'] ?? null;
  if ($exp && ($row['seller_status'] !== 'DELIVERED') && ($row['seller_status'] !== 'CANCELLED') && $exp < $today) {
    $late++;
  }
}

echo json_encode([
  "ok" => true,
  "data" => $data,
  "page" => $page,
  "pageSize" => $pageSize,
  "offset" => $offset,
  "total" => $total,
  "totalPages" => $totalPages,
  "stats" => [
    "total" => $total,
    "processing" => $processing,
    "late" => $late
  ]
]);

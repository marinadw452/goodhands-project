<?php
/**
 * ============================================================
 * home_api.php
 * ------------------------------------------------------------
 * API خاص بالصفحة الرئيسية (index.php) لإرجاع بيانات JSON تشمل:
 * 1) التصنيفات categories
 * 2) منتجات الأحدث (products) مع:
 *    - فلترة (بحث q) + فلترة (category_id)
 *    - فقط المنتجات المنشورة PUBLISHED
 *    - اسم التصنيف + اسم المتجر + الصورة الرئيسية
 *    - دعم Pagination عبر page/limit
 * 3) منتجات مميزة featured (مثلاً آخر 6 منتجات منشورة)
 *
 * المدخلات عبر GET:
 * - q           : نص البحث (اختياري)
 * - category_id : رقم التصنيف (اختياري)
 * - limit       : عدد العناصر في الصفحة (افتراضي 12) بين 4 و 48
 * - page        : رقم الصفحة (افتراضي 1)
 *
 * المخرجات:
 * - ok: true/false
 * - categories: [...]
 * - featured: [...]
 * - products: [...]
 * - pagination: {page, limit, total, totalPages}
 * ============================================================
 */

// تحميل إعدادات الاتصال بقاعدة البيانات ($conn)
require_once "../../config.php";

// تحديد أن الرد سيكون JSON مع ترميز UTF-8
header('Content-Type: application/json; charset=utf-8');

/* ============================================================
   1) قراءة باراميترات GET وتنظيفها/تحويلها
============================================================ */

// نص البحث (قد يكون فارغ)
$q = trim($_GET['q'] ?? '');

// category_id: إذا موجود وغير فارغ نحوله إلى int وإلا نجعله null
$category_id = ($_GET['category_id'] ?? '') !== '' ? (int)$_GET['category_id'] : null;

// limit: عدد العناصر في الصفحة، مع وضع حدود منطقية
$limit = (int)($_GET['limit'] ?? 12);
if ($limit < 4) $limit = 4;   // الحد الأدنى
if ($limit > 48) $limit = 48; // الحد الأقصى

// page: رقم الصفحة الحالية
$page = (int)($_GET['page'] ?? 1);
if ($page < 1) $page = 1;

// offset: بداية السحب من قاعدة البيانات
$offset = ($page - 1) * $limit;

/* ============================================================
   2) جلب التصنيفات Categories
   - تُستخدم لعرض شرائح/أزرار التصنيفات في الواجهة
============================================================ */
$cats = [];
$res = $conn->query("SELECT id, name FROM categories ORDER BY id ASC");
while($row = $res->fetch_assoc()) $cats[] = $row;

/* ============================================================
   3) تجهيز شروط فلترة المنتجات Products
   - نعرض فقط PUBLISHED
   - مع إمكانية الفلترة بالتصنيف والبحث
   - نستخدم prepared statements للباراميترات (آمن)
============================================================ */

// شرط ابتدائي: المنتجات المنشورة فقط
$where = " WHERE p.status='PUBLISHED' ";

// متغيرات لتجميع أنواع الباراميترات (bind_param types) وقيمها
$types = "";   // مثل: "iss"
$params = [];  // قيم الباراميترات بالترتيب

// فلترة حسب التصنيف إن تم تحديده
if ($category_id !== null) {
  $where .= " AND p.category_id = ? ";
  $types .= "i";
  $params[] = $category_id;
}

// فلترة حسب البحث في العنوان والوصف (LIKE)
if ($q !== '') {
  // نستخدم CONCAT('%', ?, '%') حتى يبحث عن أي تطابق جزئي
  $where .= " AND (p.title LIKE CONCAT('%', ?, '%') OR p.description LIKE CONCAT('%', ?, '%')) ";
  $types .= "ss";
  $params[] = $q;
  $params[] = $q;
}

/* ============================================================
   4) حساب عدد النتائج total (لأجل Pagination)
   - نفس شروط where تماماً
============================================================ */
$sqlCount = "SELECT COUNT(*) AS cnt FROM products p $where";
$stmtC = $conn->prepare($sqlCount);

// ربط الباراميترات إن وجدت
if ($types !== "") $stmtC->bind_param($types, ...$params);

// تنفيذ الاستعلام
$stmtC->execute();

// استخراج العدد الإجمالي
$total = (int)($stmtC->get_result()->fetch_assoc()['cnt'] ?? 0);

/* ============================================================
   5) جلب المنتجات مع تفاصيل إضافية
   - joins:
     categories => category_name
     sellers    => shop_name
     product_images => image_url للصورة الأساسية
   - ترتيب تنازلي بالأحدث
   - LIMIT و OFFSET للصفحات
============================================================ */
$sql = "
  SELECT
    p.id, p.title, p.description, p.price, p.stock_qty, p.created_at,
    c.name AS category_name,
    s.shop_name,
    pi.image_url
  FROM products p
  LEFT JOIN categories c ON c.id = p.category_id
  LEFT JOIN sellers s ON s.user_id = p.seller_id
  LEFT JOIN product_images pi ON pi.product_id = p.id AND pi.is_primary = 1
  $where
  ORDER BY p.id DESC
  LIMIT ? OFFSET ?
";

$stmt = $conn->prepare($sql);

// ربط باراميترات الفلترة + limit/offset
if ($types === "") {
  // لا يوجد فلترة (لا بحث ولا تصنيف): فقط limit/offset
  $stmt->bind_param("ii", $limit, $offset);
} else {
  // يوجد فلترة: نضيف نوعين جديدين (ii) للـ limit/offset
  $types2 = $types . "ii";
  $params2 = array_merge($params, [$limit, $offset]);
  $stmt->bind_param($types2, ...$params2);
}

$stmt->execute();
$resP = $stmt->get_result();

// تجميع المنتجات في مصفوفة
$products = [];
while($row = $resP->fetch_assoc()) $products[] = $row;

/* ============================================================
   6) جلب المنتجات المميزة Featured
   - مثال: آخر 6 منتجات منشورة
   - هنا بدون فلترة بحث/تصنيف
============================================================ */
$featured = [];
$resF = $conn->query("
  SELECT p.id, p.title, p.price, pi.image_url
  FROM products p
  LEFT JOIN product_images pi ON pi.product_id = p.id AND pi.is_primary = 1
  WHERE p.status='PUBLISHED'
  ORDER BY p.id DESC
  LIMIT 6
");
while($row = $resF->fetch_assoc()) $featured[] = $row;

/* ============================================================
   7) إخراج الاستجابة النهائية JSON
============================================================ */
echo json_encode([
  "ok" => true,
  "categories" => $cats,
  "featured" => $featured,
  "products" => $products,
  "pagination" => [
    "page" => $page,
    "limit" => $limit,
    "total" => $total,
    "totalPages" => max(1, (int)ceil($total / $limit)) // ضمان ألا تكون 0
  ]
]);

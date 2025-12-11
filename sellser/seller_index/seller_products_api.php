<?php
/**
 * ============================================================
 * seller_products_api.php
 * ------------------------------------------------------------
 * API خاص بالبائع لإدارة المنتجات (CRUD) عبر طلبات JSON (POST).
 *
 * يعتمد على:
 * - جلسة المستخدم (Session) للتحقق من تسجيل الدخول والصلاحية (SELLER)
 * - config.php لتجهيز اتصال قاعدة البيانات ($conn)
 *
 * الأوامر (action) المدعومة:
 * - categories : جلب التصنيفات
 * - list       : جلب منتجات البائع (مع اسم التصنيف + الصورة الأساسية)
 * - create     : إضافة منتج جديد
 * - update     : تعديل منتج موجود (للبائع فقط)
 * - delete     : حذف منتج (للبائع فقط)
 * ============================================================
 */

session_start();
require '../../config.php';

header('Content-Type: application/json; charset=utf-8');

/**
 * إرجاع رد فشل موحّد بصيغة JSON ثم إيقاف التنفيذ
 */
function bad($msg){
  echo json_encode(['ok'=>false,'error'=>$msg], JSON_UNESCAPED_UNICODE);
  exit;
}

/**
 * إرجاع رد نجاح موحّد بصيغة JSON ثم إيقاف التنفيذ
 * $data: بيانات إضافية تُدمج مع ok=true
 */
function ok($data=[]){
  echo json_encode(array_merge(['ok'=>true], $data), JSON_UNESCAPED_UNICODE);
  exit;
}

/* ============================================================
   1) التأكد من الاتصال بقاعدة البيانات
   - نتوقع وجود $conn من config.php
============================================================ */
if (!isset($conn) || !$conn) {
  bad('فشل الاتصال بقاعدة البيانات');
}

/* ============================================================
   2) التحقق من الصلاحيات (AuthZ)
   - لا نسمح إلا للمستخدم المسجّل + دوره SELLER
============================================================ */
$userId = $_SESSION['user_id'] ?? null; // رقم المستخدم من الجلسة
$role   = $_SESSION['role'] ?? '';      // الدور من الجلسة

// نقبل SELLER بأحرف كبيرة أو seller بأحرف صغيرة (حسب نظامك)
$isSeller = ($role === 'SELLER' || $role === 'seller');

// لو لا يوجد مستخدم أو ليس بائع => ممنوع
if (!$userId || !$isSeller) bad('غير مصرح');

/* ============================================================
   3) قراءة جسم الطلب كـ JSON
   - الواجهة الأمامية ترسل JSON عبر fetch + POST
============================================================ */
$raw = file_get_contents("php://input"); // قراءة raw body
$input = json_decode($raw, true);        // تحويل إلى مصفوفة assoc
if (!is_array($input)) $input = [];      // حماية: لو JSON غير صالح

// تحديد الإجراء المطلوب
$action = $input['action'] ?? '';

/* ============================================================
   4) action = categories
   - جلب قائمة التصنيفات (لملء dropdown)
============================================================ */
if ($action === 'categories') {
  // ملاحظة: هذا الاستعلام لا يحتاج prepared لأنه بدون مدخلات من المستخدم
  $res = mysqli_query($conn, "SELECT id, name FROM categories ORDER BY name ASC");
  if(!$res) bad('خطأ في قراءة التصنيفات');

  // تجميع النتائج في مصفوفة
  $cats = [];
  while($row = mysqli_fetch_assoc($res)) $cats[] = $row;

  ok(['items' => $cats]);
}

/* ============================================================
   5) action = list
   - جلب منتجات البائع فقط
   - مع:
     * اسم التصنيف category_name (LEFT JOIN)
     * الصورة الأساسية image_url من جدول product_images
============================================================ */
if ($action === 'list') {
  $sql = "SELECT
            p.id, p.category_id, p.title, p.description, p.price, p.stock_qty, p.status,
            c.name AS category_name,
            (
              SELECT pi.image_url
              FROM product_images pi
              WHERE pi.product_id = p.id AND pi.is_primary = 1
              ORDER BY pi.id DESC LIMIT 1
            ) AS image_url
          FROM products p
          LEFT JOIN categories c ON c.id = p.category_id
          WHERE p.seller_id = ?
          ORDER BY p.created_at DESC";

  // نستخدم prepared statement لأن فيه متغير ($userId)
  $stmt = mysqli_prepare($conn, $sql);
  if(!$stmt) bad('خطأ في تجهيز الاستعلام');

  // ربط المتغير: i = integer
  mysqli_stmt_bind_param($stmt, "i", $userId);

  // تنفيذ الاستعلام
  mysqli_stmt_execute($stmt);

  // جلب النتائج
  $res = mysqli_stmt_get_result($stmt);
  $items = [];
  while($row = mysqli_fetch_assoc($res)) $items[] = $row;

  // إغلاق الـ statement
  mysqli_stmt_close($stmt);

  ok(['items' => $items]);
}

/* ============================================================
   6) action = create
   - إضافة منتج جديد للبائع الحالي
   - يتحقق من القيم الأساسية
   - category_id:
     * إذا فارغ => NULL
     * إذا موجود => رقم صحيح
============================================================ */
if ($action === 'create') {
  // قراءة وتنظيف البيانات
  $title       = trim($input['title'] ?? '');
  $description = trim($input['description'] ?? '');
  $price       = (float)($input['price'] ?? 0);
  $stock       = (int)($input['stock_qty'] ?? 0);
  $category    = $input['category_id'] ?? null; // قد تأتي '' أو null أو رقم
  $status      = $input['status'] ?? 'DRAFT';

  // تحقق من صحة البيانات
  if ($title === '') bad('اسم المنتج مطلوب');
  if ($price < 0) bad('السعر غير صحيح');
  if ($stock < 0) bad('المخزون غير صحيح');

  // التحقق من الحالة، وإن كانت غير معروفة نعود لـ DRAFT
  if (!in_array($status, ['DRAFT','PUBLISHED','ARCHIVED'], true)) $status = 'DRAFT';

  /**
   * التعامل مع category_id:
   * - لو فاضي أو null => نخزن NULL
   * - وإلا نحوله int ونخزنه
   */
  if ($category === '' || $category === null) {
    $stmt = mysqli_prepare($conn,
      "INSERT INTO products (seller_id, category_id, title, description, price, stock_qty, status)
       VALUES (?, NULL, ?, ?, ?, ?, ?)"
    );
    if(!$stmt) bad('خطأ في تجهيز الإضافة');

    // الأنواع: i seller_id, s title, s description, d price, i stock, s status
    mysqli_stmt_bind_param($stmt, "issdis", $userId, $title, $description, $price, $stock, $status);
  } else {
    $category = (int)$category;

    $stmt = mysqli_prepare($conn,
      "INSERT INTO products (seller_id, category_id, title, description, price, stock_qty, status)
       VALUES (?, ?, ?, ?, ?, ?, ?)"
    );
    if(!$stmt) bad('خطأ في تجهيز الإضافة');

    // الأنواع: i seller_id, i category_id, s title, s description, d price, i stock, s status
    mysqli_stmt_bind_param($stmt, "iissdis", $userId, $category, $title, $description, $price, $stock, $status);
  }

  // تنفيذ الإضافة
  $okExec = mysqli_stmt_execute($stmt);

  // رقم المنتج الجديد (مهم لرفع الصورة بعد الإضافة)
  $newId  = mysqli_insert_id($conn);

  mysqli_stmt_close($stmt);

  if(!$okExec) bad('فشل إضافة المنتج');

  // نعيد id حتى تستخدمه الواجهة لرفع الصورة
  ok(['id' => $newId]); // ✅ مهم لرفع الصورة بعد الإضافة
}

/* ============================================================
   7) action = update
   - تعديل منتج موجود
   - يتحقق أن المنتج تابع للبائع الحالي (seller_id)
   - category_id:
     * إذا فاضي => NULL
     * إذا موجود => رقم
============================================================ */
if ($action === 'update') {
  $id = (int)($input['id'] ?? 0);
  if ($id <= 0) bad('معرّف المنتج غير صحيح');

  // قراءة وتنظيف البيانات
  $title       = trim($input['title'] ?? '');
  $description = trim($input['description'] ?? '');
  $price       = (float)($input['price'] ?? 0);
  $stock       = (int)($input['stock_qty'] ?? 0);
  $category    = $input['category_id'] ?? null;
  $status      = $input['status'] ?? 'DRAFT';

  // تحقق من البيانات
  if ($title === '') bad('اسم المنتج مطلوب');
  if ($price < 0) bad('السعر غير صحيح');
  if ($stock < 0) bad('المخزون غير صحيح');
  if (!in_array($status, ['DRAFT','PUBLISHED','ARCHIVED'], true)) $status = 'DRAFT';

  // إن كان التصنيف فارغاً => نخزن NULL
  if ($category === '' || $category === null) {
    $stmt = mysqli_prepare($conn,
      "UPDATE products
       SET category_id = NULL, title = ?, description = ?, price = ?, stock_qty = ?, status = ?
       WHERE id = ? AND seller_id = ?"
    );
    if(!$stmt) bad('خطأ في تجهيز التعديل');

    // s title, s desc, d price, i stock, s status, i id, i userId
    mysqli_stmt_bind_param($stmt, "ssdisii", $title, $description, $price, $stock, $status, $id, $userId);
  } else {
    $category = (int)$category;

    $stmt = mysqli_prepare($conn,
      "UPDATE products
       SET category_id = ?, title = ?, description = ?, price = ?, stock_qty = ?, status = ?
       WHERE id = ? AND seller_id = ?"
    );
    if(!$stmt) bad('خطأ في تجهيز التعديل');

    // i category, s title, s desc, d price, i stock, s status, i id, i userId
    mysqli_stmt_bind_param($stmt, "issdisii", $category, $title, $description, $price, $stock, $status, $id, $userId);
  }

  // تنفيذ التعديل
  $okExec = mysqli_stmt_execute($stmt);
  if(!$okExec) {
    mysqli_stmt_close($stmt);
    bad('فشل تعديل المنتج');
  }

  // عدد الصفوف المتأثرة:
  // - 0 قد يعني: لا يوجد منتج بهذا id للبائع، أو البيانات نفسها لم تتغير
  $affected = mysqli_stmt_affected_rows($stmt);
  mysqli_stmt_close($stmt);

  // في كودك: تعتبر 0 = فشل/ليس لك
  if($affected === 0) bad('لم يتم التعديل (قد لا يكون المنتج لك)');

  ok();
}

/* ============================================================
   8) action = delete
   - حذف منتج تابع للبائع الحالي فقط
============================================================ */
if ($action === 'delete') {
  $id = (int)($input['id'] ?? 0);
  if ($id <= 0) bad('معرّف المنتج غير صحيح');

  $stmt = mysqli_prepare($conn, "DELETE FROM products WHERE id = ? AND seller_id = ?");
  if(!$stmt) bad('خطأ في تجهيز الحذف');

  mysqli_stmt_bind_param($stmt, "ii", $id, $userId);

  $okExec = mysqli_stmt_execute($stmt);
  if(!$okExec) {
    mysqli_stmt_close($stmt);
    bad('فشل حذف المنتج');
  }

  // إذا 0 => لم يُحذف شيء (المنتج غير موجود أو ليس لهذا البائع)
  $affected = mysqli_stmt_affected_rows($stmt);
  mysqli_stmt_close($stmt);

  if($affected === 0) bad('لم يتم الحذف (قد لا يكون المنتج لك)');
  ok();
}

/* ============================================================
   9) في حال لم يطابق action أي شيء
============================================================ */
bad('Action غير معروف');

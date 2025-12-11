<?php
// seller_product_create.php
session_start();
require_once "../../config.php";
header('Content-Type: application/json; charset=utf-8');

function bad($msg){
  echo json_encode(["ok"=>false,"error"=>$msg], JSON_UNESCAPED_UNICODE);
  exit;
}

if (!isset($_SESSION['seller_id'])) {
  bad("Unauthorized");
}
$seller_id = (int)$_SESSION['seller_id'];

// قراءة بيانات المنتج
$title       = trim($_POST['title'] ?? '');
$description = trim($_POST['description'] ?? '');
$category_id = ($_POST['category_id'] ?? '') === '' ? null : (int)$_POST['category_id'];
$status      = trim($_POST['status'] ?? 'DRAFT');
$price       = (float)($_POST['price'] ?? 0);
$stock_qty   = (int)($_POST['stock_qty'] ?? 0);

// تحقق المدخلات
$allowedStatus = ["DRAFT","PUBLISHED","ARCHIVED"];
if ($title === '' || mb_strlen($title) > 160) bad("عنوان المنتج مطلوب (حد أقصى 160)");
if (!in_array($status, $allowedStatus, true)) bad("حالة المنتج غير صحيحة");
if ($price < 0) bad("السعر غير صحيح");
if ($stock_qty < 0) bad("الكمية غير صحيحة");

if (!isset($_FILES['images']) || empty($_FILES['images']['name'][0])) {
  bad("الصور مطلوبة");
}

/**
 * مجلد الرفع (مسار فعلي على السيرفر)
 * نرفع داخل seller/uploads/products
 *
 * ملاحظة:
 * - __DIR__ هنا هو مجلد هذا الملف
 * - نطلع 3 مستويات فوق للوصول للجذر (حسب تركيب مشروعك الحالي)
 * - ثم ندخل على seller/uploads/products
 */
$uploadDir = __DIR__ . '../../../uploads/products';
if (!is_dir($uploadDir)) {
  if (!mkdir($uploadDir, 0755, true)) {
    bad("تعذر إنشاء مجلد الرفع");
  }
}

// إدخال المنتج + الصور داخل Transaction
$conn->begin_transaction();

try {
  // إدخال المنتج
  if ($category_id === null) {
    $sql = "INSERT INTO products (seller_id, category_id, title, description, price, stock_qty, status)
            VALUES (?, NULL, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if(!$stmt) throw new Exception("فشل تجهيز إدخال المنتج");
    $stmt->bind_param("issdis", $seller_id, $title, $description, $price, $stock_qty, $status);
  } else {
    $sql = "INSERT INTO products (seller_id, category_id, title, description, price, stock_qty, status)
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if(!$stmt) throw new Exception("فشل تجهيز إدخال المنتج");
    $stmt->bind_param("iissdis", $seller_id, $category_id, $title, $description, $price, $stock_qty, $status);
  }

  if (!$stmt->execute()) throw new Exception("فشل حفظ المنتج");
  $product_id = (int)$conn->insert_id;

  // تجهيز بيانات الملفات
  $names = $_FILES['images']['name'];
  $tmp   = $_FILES['images']['tmp_name'];
  $err   = $_FILES['images']['error'];
  $size  = $_FILES['images']['size'];

  $maxFiles = 10;
  $count = min(count($names), $maxFiles);

  // تجهيز إدخال الصور
  $insertImg = $conn->prepare("INSERT INTO product_images (product_id, image_url, is_primary) VALUES (?, ?, ?)");
  if(!$insertImg) throw new Exception("فشل تجهيز حفظ الصور");

  $primarySet = false;

  for ($i=0; $i<$count; $i++) {
    if ($err[$i] !== UPLOAD_ERR_OK) continue;

    // تحقق نوع الصورة الحقيقي عبر finfo
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime  = $finfo->file($tmp[$i]);

    $allowed = [
      "image/jpeg" => "jpg",
      "image/png"  => "png",
      "image/webp" => "webp",
    ];

    if (!isset($allowed[$mime])) {
      throw new Exception("نوع صورة غير مدعوم. استخدم JPG/PNG/WEBP");
    }

    if ($size[$i] > 5 * 1024 * 1024) { // 5MB
      throw new Exception("حجم الصورة كبير جدًا (أقصى 5MB)");
    }

    // امتداد حسب MIME
    $ext = $allowed[$mime];

    /* ============================================================
       8) إنشاء اسم ملف فريد (نفس الكود الذي طلبته)
    ============================================================ */
    $filename = 'p' . $product_id . '_' . bin2hex(random_bytes(8)) . '.' . $ext;
    $path = $uploadDir . '/' . $filename; // المسار النهائي على القرص

    // نقل الملف من المسار المؤقت إلى مسارنا
    if(!move_uploaded_file($tmp[$i], $path)) {
      throw new Exception("فشل رفع الصورة");
    }

    /* ============================================================
       9) تخزين المسار في قاعدة البيانات (معدّل)
       المطلوب: seller/uploads/products/....
    ============================================================ */
    $url = 'uploads/products/' . $filename;
    // أول صورة = primary
    $is_primary = $primarySet ? 0 : 1;
    $primarySet = true;

    $insertImg->bind_param("isi", $product_id, $url, $is_primary);
    if (!$insertImg->execute()) throw new Exception("فشل حفظ صورة المنتج");
  }

  if (!$primarySet) throw new Exception("لم يتم رفع أي صورة صالحة");

  $conn->commit();
  echo json_encode(["ok"=>true, "product_id"=>$product_id], JSON_UNESCAPED_UNICODE);

} catch (Exception $e) {
  $conn->rollback();
  echo json_encode(["ok"=>false, "error"=>$e->getMessage()], JSON_UNESCAPED_UNICODE);
}

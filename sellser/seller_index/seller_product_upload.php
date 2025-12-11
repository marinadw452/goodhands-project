<?php
/**
 * ============================================================
 * seller_product_upload.php
 * ------------------------------------------------------------
 * سكربت رفع صورة منتج للبائع.
 *
 * الفكرة العامة:
 * 1) يتأكد أن المستخدم مسجّل ودوره SELLER
 * 2) يستقبل product_id + ملف image عبر POST (multipart/form-data)
 * 3) يتحقق أن المنتج ملك للبائع الحالي (seller_id)
 * 4) يتحقق من حجم الصورة ونوعها (JPG/PNG/WEBP)
 * 5) ينقل الملف إلى مجلد uploads/products باسم فريد
 * 6) يحفظ المسار في جدول product_images ويجعلها الصورة الأساسية (is_primary=1)
 *    عبر Transaction: يطفئ الأساسي السابق ثم يضيف الجديد
 * ============================================================
 */

session_start();
require '../../config.php';

header('Content-Type: application/json; charset=utf-8');

/**
 * دوال مساعدة لإرجاع رد JSON موحد
 */
function bad($msg){
  echo json_encode(['ok'=>false,'error'=>$msg], JSON_UNESCAPED_UNICODE);
  exit;
}
function ok($data=[]){
  echo json_encode(array_merge(['ok'=>true], $data), JSON_UNESCAPED_UNICODE);
  exit;
}

/* ============================================================
   1) التحقق من الصلاحيات (AuthZ)
============================================================ */
$userId = $_SESSION['user_id'] ?? null; // رقم المستخدم
$role   = $_SESSION['role'] ?? '';      // دوره
$isSeller = ($role === 'SELLER' || $role === 'seller');

if(!$userId || !$isSeller) bad('غير مصرح');

/* ============================================================
   2) قراءة product_id من POST
   - لأن رفع الملفات يتم غالباً بـ FormData (multipart)
============================================================ */
$productId = (int)($_POST['product_id'] ?? 0);
if($productId <= 0) bad('product_id غير صحيح');

/* ============================================================
   3) التحقق من وجود ملف الصورة ونجاح الرفع
   - UPLOAD_ERR_OK يعني لا يوجد خطأ
============================================================ */
if(!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK){
  bad('لم يتم اختيار صورة أو حدث خطأ في الرفع');
}

$file = $_FILES['image']; // اختصار لبيانات الملف

/* ============================================================
   4) تحقق الملكية: المنتج لازم يكون للبائع الحالي
   - حتى لا يرفع شخص صورة لمنتج لا يخصه
============================================================ */
$stmt = mysqli_prepare($conn, "SELECT id FROM products WHERE id = ? AND seller_id = ? LIMIT 1");
mysqli_stmt_bind_param($stmt, "ii", $productId, $userId);
mysqli_stmt_execute($stmt);
$res   = mysqli_stmt_get_result($stmt);
$owned = mysqli_fetch_assoc($res);
mysqli_stmt_close($stmt);

if(!$owned) bad('هذا المنتج لا يخصك');

/* ============================================================
   5) التحقق من حجم الملف
   - تحديد حد أقصى 2MB
============================================================ */
$maxSize = 2 * 1024 * 1024; // 2MB بالبايت
if($file['size'] > $maxSize) bad('حجم الصورة كبير (أقصى شيء 2MB)');

/* ============================================================
   6) التحقق من نوع الملف (MIME) عبر finfo
   - أفضل من الاعتماد على امتداد الملف فقط
============================================================ */
$finfo = new finfo(FILEINFO_MIME_TYPE);
$mime  = $finfo->file($file['tmp_name']); // قراءة نوع الملف الحقيقي من الملف المؤقت

// الأنواع المسموح بها + الامتداد المناسب للحفظ
$allowed = [
  'image/jpeg' => 'jpg',
  'image/png'  => 'png',
  'image/webp' => 'webp'
];

if(!isset($allowed[$mime])) bad('نوع الصورة غير مدعوم (JPG/PNG/WEBP فقط)');

$ext = $allowed[$mime]; // الامتداد النهائي الذي سنستخدمه

/* ============================================================
   7) إنشاء مجلد الرفع إن لم يكن موجوداً
============================================================ */
$uploadDir = __DIR__ . '../../../uploads/products'; // مسار فعلي على السيرفر
if(!is_dir($uploadDir)){
  // mkdir مع recursive=true لإنشاء المسار بالكامل إذا كان ناقص
  if(!mkdir($uploadDir, 0755, true)) bad('تعذر إنشاء مجلد الرفع');
}

/* ============================================================
   8) إنشاء اسم ملف فريد
   - لتفادي تعارض الأسماء
   - نستخدم random_bytes لمزيد من الأمان
============================================================ */
$filename = 'p' . $productId . '_' . bin2hex(random_bytes(8)) . '.' . $ext;
$path = $uploadDir . '/' . $filename; // المسار النهائي على القرص

// نقل الملف من المسار المؤقت إلى مسارنا
if(!move_uploaded_file($file['tmp_name'], $path)) bad('فشل حفظ الصورة');

/* ============================================================
   9) إنشاء رابط/مسار نسبي لحفظه في قاعدة البيانات
   - هذا يستخدمه الفرونت-إند لعرض الصورة
============================================================ */
$imageUrl = 'uploads/products/' . $filename;

/* ============================================================
   10) حفظ بيانات الصورة بقاعدة البيانات وتعيينها كصورة أساسية
   - Transaction لضمان الاتساق:
     1) إلغاء primary القديم
     2) إدخال الجديد كـ primary
   - لو حصل خطأ: rollback
============================================================ */
mysqli_begin_transaction($conn);

try{
  // (أ) إلغاء الصورة الأساسية السابقة (إن وجدت)
  $stmt = mysqli_prepare($conn, "UPDATE product_images SET is_primary = 0 WHERE product_id = ?");
  mysqli_stmt_bind_param($stmt, "i", $productId);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_close($stmt);

  // (ب) إضافة الصورة الجديدة كصورة أساسية
  $stmt = mysqli_prepare($conn, "INSERT INTO product_images (product_id, image_url, is_primary) VALUES (?, ?, 1)");
  mysqli_stmt_bind_param($stmt, "is", $productId, $imageUrl);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_close($stmt);

  // حفظ التغييرات
  mysqli_commit($conn);

} catch(Throwable $e){
  // إلغاء التغييرات في قاعدة البيانات
  mysqli_rollback($conn);

  // ملاحظة: الملف تم رفعه فعلاً على القرص، لكن فشل الحفظ في DB
  // (يمكن لاحقاً إضافة تنظيف: حذف الملف عند الفشل إن رغبت)
  bad('تم رفع الصورة لكن فشل حفظها في قاعدة البيانات');
}

/* ============================================================
   11) رد نجاح مع رابط الصورة
============================================================ */
ok(['url' => $imageUrl]);

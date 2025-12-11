<?php
$page_title = "إنشاء حساب جديد";
include 'includes/header.php';
require 'config.php';

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $full_name = trim($_POST['full_name'] ?? '');
  $email     = trim($_POST['email'] ?? '');
  $password  = $_POST['password'] ?? '';
  $role      = strtoupper(trim($_POST['role'] ?? 'BUYER'));

  // قبول BUYER أو SELLER فقط
  if (!in_array($role, ['BUYER', 'SELLER'], true)) $role = 'BUYER';

  if ($full_name === '' || $email === '' || $password === '') {
    $error = "فضلاً أدخل الاسم والبريد وكلمة المرور.";
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $error = "البريد الإلكتروني غير صحيح.";
  } elseif (strlen($password) < 6) {
    $error = "كلمة المرور يجب أن تكون 6 أحرف على الأقل.";
  } else {
    // هل البريد موجود مسبقًا؟
    $stmt = mysqli_prepare($conn, "SELECT id FROM users WHERE email = ? LIMIT 1");
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    $exists = mysqli_fetch_assoc($res);
    mysqli_stmt_close($stmt);

    if ($exists) {
      $error = "البريد مستخدم مسبقًا، جرّب بريدًا آخر.";
    } else {

      $hashed = password_hash($password, PASSWORD_BCRYPT);

      mysqli_begin_transaction($conn);

      try {
        // إدخال المستخدم
        $stmt = mysqli_prepare($conn, "INSERT INTO users (full_name, email, password_hash, role) VALUES (?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "ssss", $full_name, $email, $hashed, $role);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        $newId = mysqli_insert_id($conn);

        // إذا بائع: أنشئ سجل بائع
        if ($role === 'SELLER') {
          $shop_name = "متجر " . $full_name;
          $shop_bio  = NULL;
          $phone     = NULL;

          $stmt = mysqli_prepare($conn, "INSERT INTO sellers (user_id, shop_name, shop_bio, phone) VALUES (?, ?, ?, ?)");
          mysqli_stmt_bind_param($stmt, "isss", $newId, $shop_name, $shop_bio, $phone);
          mysqli_stmt_execute($stmt);
          mysqli_stmt_close($stmt);
        }

        mysqli_commit($conn);

        // جلسة تسجيل الدخول
        $_SESSION['user_id']   = $newId;
        $_SESSION['full_name'] = $full_name;
        $_SESSION['email']     = $email;
        $_SESSION['role']      = $role;

        if ($role === 'SELLER') header("Location: index.php#seller-panel");
        else header("Location: index.php");
        exit;

      } catch (Throwable $e) {
        mysqli_rollback($conn);
        $error = "حصل خطأ أثناء إنشاء الحساب. حاول مرة أخرى.";
      }
    }
  }
}
?>

<link rel="stylesheet" href="assets/css/style.css">
<link rel="stylesheet" href="assets/css/login.css">

<style>
/* ===== Force-center just for signup page (مضمون ضد تعارضات CSS) ===== */
.signup-page{
  min-height: calc(100dvh - var(--navH, 0px)) !important;
  display: grid !important;
  place-items: center !important;
  padding: 24px 12px 40px !important;
  margin-top:100px;
}

.signup-page .auth-wrap{
  min-height: unset !important;
  width: 100% !important;
  display: grid !important;
  place-items: center !important;
  padding: 0 !important;
  margin: 0 !important;
}

.signup-page .auth-card{
  margin: 0 auto !important;
  width: min(520px, 92vw) !important;
}
</style>

<div class="signup-page">
  <main class="auth-wrap">
    <section class="auth-card">
      <div class="auth-header">
        <img src="images/LOGO.png" alt="أيدي طيّبة" class="auth-logo">
        <h1>إنشاء حساب جديد</h1>
        <p>اختر نوع الحساب مرة واحدة أثناء التسجيل</p>
      </div>

      <?php if ($error): ?>
        <div class="auth-alert"><?= htmlspecialchars($error) ?></div>
      <?php endif; ?>

      <form class="auth-form" method="post" action="sign-up.php" autocomplete="on">
        <label class="field">
          <span>الاسم الكامل</span>
          <input type="text" name="full_name" required>
        </label>

        <label class="field">
          <span>البريد الإلكتروني</span>
          <input type="email" name="email" placeholder="name@gmail.com" required>
        </label>

        <label class="field">
          <span>كلمة المرور</span>
          <input type="password" name="password" required>
        </label>

        <div class="role-row">
          <span>نوع الحساب</span>
          <div class="role-options">
            <label><input type="radio" name="role" value="BUYER" checked> مشتري</label>
            <label><input type="radio" name="role" value="SELLER"> بائع</label>
          </div>
        </div>

        <button class="auth-btn" type="submit">إنشاء الحساب</button>

        <div class="auth-footer">
          <a href="login.php" class="link">لدي حساب؟ تسجيل الدخول</a>
          <span class="dot">•</span>
          <a href="index.php" class="link muted">العودة للرئيسية</a>
        </div>
      </form>
    </section>

    <div class="auth-bg-glow" aria-hidden="true"></div>
  </main>
</div>

<script>
/* احسب ارتفاع الـ navbar الحقيقي وخزنه في CSS variable */
(function(){
  const nav = document.querySelector('.navbar'); // غيّريها لو كلاس النافبار مختلف
  const h = nav ? nav.getBoundingClientRect().height : 0;
  document.documentElement.style.setProperty('--navH', h + 'px');
})();
</script>

<?php include 'includes/footer.php'; ?>

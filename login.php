<?php
$page_title = "تسجيل الدخول";
include 'includes/header.php';
require 'config.php';

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email    = trim($_POST['email'] ?? '');
  $password = $_POST['password'] ?? '';

  if ($email === '' || $password === '') {
    $error = "فضلاً أدخل البريد الإلكتروني وكلمة المرور.";
  } else {
    $stmt = mysqli_prepare($conn, "SELECT id, full_name, email, password_hash, role, is_active FROM users WHERE email = ? LIMIT 1");
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);

    if (!$user) {
      $error = "البريد الإلكتروني أو كلمة المرور غير صحيحة.";
    } elseif ((int)$user['is_active'] !== 1) {
      $error = "هذا الحساب غير مفعل.";
    } else {
      if (!password_verify($password, $user['password_hash'])) {
        $error = "البريد الإلكتروني أو كلمة المرور غير صحيحة.";
      } else {
        $_SESSION['user_id']   = $user['id'];
        $_SESSION['full_name'] = $user['full_name'];
        $_SESSION['email']     = $user['email'];
        $_SESSION['role']      = $user['role'];
        $_SESSION['seller_id'] = $user['id'];

        if ($user['role'] === 'SELLER') header("Location: index.php#seller-panel");
        else header("Location: index.php");
        exit;
      }
    }
  }
}
?>

<link rel="stylesheet" href="assets/css/style.css">
<link rel="stylesheet" href="assets/css/login.css">

<style>
/* ===== Force-center just for login page (مضمون ضد تعارضات CSS) ===== */
.login-page{
  min-height: calc(100dvh - var(--navH, 0px)) !important;
  display: grid !important;
  place-items: center !important;
  padding: 24px 12px 40px !important;
margin-top:100px;
}

.login-page .auth-wrap{
  min-height: unset !important;
  width: 100% !important;
  display: grid !important;
  place-items: center !important;
  padding: 0 !important;
  margin: 0 !important;
}

.login-page .auth-card{
  margin: 0 auto !important;
  width: min(520px, 92vw) !important;
}
</style>

<!-- wrapper خاص بالصفحة -->
<div class="login-page">

  <main class="auth-wrap">
    <section class="auth-card">
      <div class="auth-header">
        <img src="images/LOGO.png" alt="أيدي طيّبة" class="auth-logo">
        <h1>تسجيل الدخول</h1>
        <p>ادخل بياناتك للوصول لحسابك كبائع أو مشتري</p>
      </div>

      <?php if ($error): ?>
        <div class="auth-alert"><?= htmlspecialchars($error) ?></div>
      <?php endif; ?>

      <form class="auth-form" method="post" action="login.php" autocomplete="on">
        <label class="field">
          <span>البريد الإلكتروني</span>
          <input type="email" name="email" placeholder="name@gmail.com" required>
        </label>

        <label class="field">
          <span>كلمة المرور</span>
          <div class="password-wrap">
            <input id="password" type="password" name="password" placeholder="••••••••" required>
            <button class="toggle-pass" type="button" aria-label="إظهار كلمة المرور" onclick="togglePass()">
              👁️
            </button>
          </div>
        </label>

        <button class="auth-btn" type="submit">دخول</button>

        <div class="auth-footer">
          <a href="sign-up.php" class="link">إنشاء حساب جديد</a>
          <span class="dot">•</span>
          <a href="index.php" class="link muted">العودة للرئيسية</a>
        </div>
      </form>
    </section>

    <div class="auth-bg-glow" aria-hidden="true"></div>
  </main>

</div>

<script>
function togglePass(){
  const input = document.getElementById('password');
  input.type = input.type === 'password' ? 'text' : 'password';
}

/* ===== احسب ارتفاع الـ navbar الحقيقي وخزنه في CSS variable ===== */
(function(){
  const nav = document.querySelector('.navbar'); // تأكد اسم كلاس نافبار عندك
  const h = nav ? nav.getBoundingClientRect().height : 0;
  document.documentElement.style.setProperty('--navH', h + 'px');
})();
</script>

<?php include 'includes/footer.php'; ?>

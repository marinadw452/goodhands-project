<?php
session_start();
require_once 'db.php'; // لو عندك ملف الاتصال
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>أيدي طيّبة</title>
  <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
</head>
<body>

<!-- Navbar -->
<nav class="navbar">
  <!-- اللوجو على اليمين (يتحرك لما تضغط عليه) -->
  <a href="index.php" class="logo-link">
    <img src="images/LOGO.png" class="logo" alt="أيدي طيّبة">
  </a>

  <!-- القوائم في المنتصف -->
  <ul class="nav-links">
    <li><a href="index.php">الرئيسية</a></li>
    <li><a href="#">نساء</a></li>
    <li><a href="#">رجالي</a></li>
    <li><a href="#">أثاث</a></li>
    <li><a href="about.php">حول</a></li>
    <li><a href="contact.php">الاتصال</a></li>
  </ul>

  <!-- تسجيل الدخول على اليسار (أصفر زي الصورة) -->
  <div id="auth-section">
    <?php if(isset($_SESSION['username'])): ?>
      <div class="user-icon" title="<?= htmlspecialchars($_SESSION['username']) ?>">
        <?= strtoupper(substr($_SESSION['username'], 0, 1)) ?>
      </div>
      <ul class="user-menu">
        <li><?= htmlspecialchars($_SESSION['username']) ?></li>
        <li><a href="logout.php">تسجيل الخروج</a></li>
      </ul>
    <?php else: ?>
      <button id="login-btn">تسجيل الدخول</button>
    <?php endif; ?>
  </div>
</nav>

<!-- Hero Section -->
<section class="section-hero-wrap">
  <div class="slider">
    <img src="images/4.png" class="slide active" alt="">
    <img src="images/123.png" class="slide" alt="">
    <img src="images/11.png" class="slide" alt="">
    <img src="images/14.png" class="slide" alt="">
  </div>
  <div class="overlay"></div>
  <div class="hero-content">
    <h1>أيدي طيّبة</h1>
    <h3>كل قطعة تعكس إبداع صانعها.</h3>
    <button class="btn">تصفح</button>
  </div>
</section>

<!-- Sidebar تسجيل الدخول (من اليسار) -->
<div id="sidebar-login">
  <button class="close-btn" id="close-sidebar">×</button>
  <form action="login.php" method="post">
    <h2>تسجيل الدخول</h2>
    <div id="login-msg" class="form-msg" style="display:none"></div>
    <input type="text" name="username" placeholder="اسم المستخدم" required>
    <input type="password" name="password" placeholder="كلمة المرور" required>
    <button type="submit" class="submit">دخول</button>
  </form>
  <a class="signup-link" href="sign-up.php">إنشاء حساب جديد</a>
</div>

<script src="script.js"></script>
<script src="golden-air.js"></script>
<script>
  // فتح الـ Sidebar
  document.getElementById('login-btn')?.addEventListener('click', () => {
    document.getElementById('sidebar-login').classList.add('open');
  });
  document.getElementById('close-sidebar')?.addEventListener('click', () => {
    document.getElementById('sidebar-login').classList.remove('open');
  });

  // قائمة المستخدم
  document.querySelector('.user-icon')?.addEventListener('click', function() {
    this.nextElementSibling.classList.toggle('active');
  });
</script>
</body>
</html>

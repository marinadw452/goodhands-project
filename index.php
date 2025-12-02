<?php session_start(); ?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>أيدي طيّبة</title>
  <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="style.css" />
</head>
<body>

<!-- Navbar -->
<nav class="navbar">
  <div class="container nav-container">
    <!-- زر تسجيل الدخول (يسار) -->
    <div id="auth-section">
      <?php if(isset($_SESSION['username'])): ?>
        <div class="user-icon" title="<?= $_SESSION['username'] ?>">
          <?= strtoupper(substr($_SESSION['username'],0,1)) ?>
        </div>
        <div class="user-menu">
          <p><?= $_SESSION['username'] ?></p>
          <a href="logout.php">تسجيل الخروج</a>
        </div>
      <?php else: ?>
        <button id="login-btn">تسجيل الدخول</button>
      <?php endif; ?>
    </div>

    <!-- القوائم (وسط) -->
    <ul class="nav-links">
      <li><a href="index.php">الرئيسية</a></li>
      <li><a href="#">نساء</a></li>
      <li><a href="#">رجالي</a></li>
      <li><a href="#">أثاث</a></li>
      <li><a href="about.php">حول</a></li>
      <li><a href="contact.php">الاتصال</a></li>
    </ul>

    <!-- اللوجو (يمين) -->
    <a href="index.php" class="logo-link">
      <img src="images/LOGO.png" alt="أيدي طيّبة" class="logo">
    </a>
  </div>
</nav>

<!-- Hero Section -->
<section class="hero">
  <div class="slider">
    <img src="images/4.png" class="slide active" alt="">
    <img src="images/123.png" class="slide" alt="">
    <img src="images/11.png" class="slide" alt="">
    <img src="images/14.png" class="slide" alt="">
  </div>
  <div class="overlay"></div>
  <div class="hero-content">
    <h1>أيدي طيّبة</h1>
    <p>كل قطعة تعكس إبداع صانعها.</p>
    <button class="btn">تصفح الآن</button>
  </div>
</section>

<!-- Sidebar Login -->
<div id="sidebar-login">
  <button class="close-btn">×</button>
  <div class="login-form">
    <h2>تسجيل الدخول</h2>
    <form action="login.php" method="post">
      <input type="text" name="username" placeholder="اسم المستخدم" required />
      <input type="password" name="password" placeholder="كلمة المرور" required />
      <button type="submit" class="submit">دخول</button>
    </form>
    <a href="sign-up.php" class="signup-link">إنشاء حساب جديد</a>
  </div>
</div>

<script src="script.js"></script>
</body>
</html>

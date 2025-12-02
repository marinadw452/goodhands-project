<?php session_start(); ?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $page_title ?? 'أيدي طيّبة'; ?></title>
  <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
</head>
<body>

<!-- Navbar -->
<nav class="navbar">
  <div class="container nav-container">
    <!-- تسجيل الدخول (يسار) -->
    <div id="auth-section">
      <?php if(isset($_SESSION['username'])): ?>
        <div class="user-icon" title="<?= htmlspecialchars($_SESSION['username']) ?>">
          <?= strtoupper(substr($_SESSION['username'],0,1)) ?>
        </div>
        <div class="user-menu">
          <p><?= htmlspecialchars($_SESSION['username']) ?></p>
          <a href="logout.php">تسجيل الخروج</a>
        </div>
      <?php else: ?>
        <button id="login-btn">تسجيل الدخول</button>
      <?php endif; ?>
    </div>

    <!-- القوائم -->
    <ul class="nav-links">
      <li><a href="index.php" <?php if(basename($_SERVER['PHP_SELF'])=='index.php') echo 'class="active"'; ?>>الرئيسية</a></li>
      <li><a href="#">نساء</a></li>
      <li><a href="#">رجالي</a></li>
      <li><a href="#">أثاث</a></li>
      <li><a href="about.php" <?php if(basename($_SERVER['PHP_SELF'])=='about.php') echo 'class="active"'; ?>>حول</a></li>
      <li><a href="contact.php" <?php if(basename($_SERVER['PHP_SELF'])=='contact.php') echo 'class="active"'; ?>>الاتصال</a></li>
    </ul>

    <!-- اللوجو (يمين) -->
    <a href="index.php" class="logo-link">
      <img src="images/LOGO.png" alt="أيدي طيّبة" class="logo">
    </a>
  </div>
</nav>

<!-- Sidebar Login (موجود في كل الصفحات) -->
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

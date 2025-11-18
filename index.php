<?php
session_start();
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Good Hands</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

<nav class="navbar">
  <img src="images/LOGO.png" class="logo" alt="Logo">
  <ul class="nav-links">
    <li><a href="#" class="fade-link">الرئيسية</a></li>
    <li><a href="#" class="fade-link">نساء</a></li>
    <li><a href="#" class="fade-link">رجالي</a></li>
    <li><a href="#" class="fade-link">أثاث</a></li>
    <li><a href="#" class="fade-link">حول</a></li>
    <li><a href="#" class="fade-link">الاتصال</a></li>
  </ul>

  <div class="cart-icon">🛒</div>

  <div id="auth-section">
    <?php if(isset($_SESSION['username'])): ?>
      <div class="user-icon" title="<?php echo htmlspecialchars($_SESSION['username']); ?>">
        <?php echo strtoupper(htmlspecialchars($_SESSION['username'][0])); ?>
      </div>
      <ul class="user-menu">
        <li><?php echo htmlspecialchars($_SESSION['username']); ?></li>
        <li><a href="logout.php">تسجيل الخروج</a></li>
      </ul>
    <?php else: ?>
      <!-- زر صغير ظاهر على اليسار (css يتحكم بالموقع) -->
      <button id="login-btn">تسجيل الدخول</button>
    <?php endif; ?>
  </div>
</nav>

<section class="section-hero-wrap">
  <div class="slider">
    <img src="images/4.png" class="slide active" alt="صورة 1">
    <img src="images/123.png" class="slide" alt="صورة 2">
    <img src="images/11.png" class="slide" alt="صورة 3">
    <img src="images/14.png" class="slide" alt="صورة 4">
  </div>
  <div class="overlay"></div>

  <div class="hero-content">
    <h1>أيدي طيّبه</h1>
    <h3>كل قطعة تعكس إبداع صانعها.</h3>
    <button class="btn">تصفح</button>
  </div>
</section>

<!-- القائمة الجانبية لتسجيل الدخول (مخبأة افتراضياً) -->
<div id="sidebar-login" aria-hidden="true">
  <button class="close-btn" id="close-sidebar">&times;</button>

  <form id="login-form">
    <h2>تسجيل الدخول</h2>

    <div id="login-msg" class="form-msg" style="display:none"></div>

    <input type="text" name="username" id="login-username" placeholder="اسم المستخدم" required>
    <input type="password" name="password" id="login-password" placeholder="كلمة المرور" required>

    <button type="submit" class="submit">دخول</button>
  </form>

  <a class="signup-link" href="sign-up.php">تسجيل جديد</a>
</div>

<script src="script.js"></script>
<script src="golden-air.js"></script>
</body>
</html>

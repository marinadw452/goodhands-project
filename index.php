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
    <!-- اللوقو -->
    <img src="images/LOGO.png" class="logo" alt="Logo">

    <!-- روابط التنقل -->
    <ul class="nav-links">
      <li><a href="#" class="fade-link">الرئيسية</a></li>
      <li><a href="#" class="fade-link">نساء</a></li>
      <li><a href="#" class="fade-link">رجالي</a></li>
      <li><a href="#" class="fade-link">أثاث</a></li>
      <li><a href="about.php" class="fade-link">حول</a></li>
      <li><a href="#" class="fade-link">الاتصال</a></li>
    </ul>

    <!-- أيقونة السلة -->
    <div class="cart-icon">🛒</div>

    <!-- تسجيل الدخول / المستخدم -->
    <div id="auth-section">
      <?php if(isset($_SESSION['username'])): ?>
        <div class="user-icon"><?php echo strtoupper($_SESSION['username'][0]); ?></div>
        <ul class="user-menu">
          <li><?php echo $_SESSION['username']; ?></li>
          <li><a href="logout.php">تسجيل الخروج</a></li>
        </ul>
      <?php else: ?>
        <a href="auth.php"><button id="authlog">تسجيل الدخول</button></a>
      <?php endif; ?>
    </div>
  </nav>

  <!-- قسم الهيرو -->
  <section class="hero">
    <div class="slider">
      <img src="images/4.png" class="slide active" alt="صورة 1">
      <img src="images/123.png" class="slide" alt="صورة 2">
      <img src="images/11.png" class="slide" alt="صورة 3">
      <img src="images/14.png" class="slide" alt="صورة 4">
    </div>
    <div class="overlay"></div>
    <div class="hero-content">
      <h1>أيدي طيّبه</h1>
      <h1>Good Hands</h1>
      <p>"كل قطعة تعكس إبداع صانعها."</p>
      <button class="btn">تصفح</button>
    </div>
  </section>

  <!-- سكربتات -->
  <script src="script.js"></script>
  <script src="golden-air.js"></script>

</body>
</html>

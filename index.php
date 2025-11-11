<?php
session_start();
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>حولنا - Good Hands</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  
<!-- Navbar مشابه للصفحة الرئيسية -->
<nav class="navbar">
  <img src="images/LOGO.png" class="logo" alt="Logo">
  <ul class="nav-links">
    <li><a href="index.php" class="fade-link">الرئيسية</a></li>
    <li><a href="index.php#نساء" class="fade-link">نساء</a></li>
    <li><a href="index.php#رجالي" class="fade-link">رجالي</a></li>
    <li><a href="index.php#أثاث" class="fade-link">أثاث</a></li>
    <li><a href="about.php" class="fade-link">حول</a></li>
    <li><a href="index.php#الاتصال" class="fade-link">الاتصال</a></li>
  </ul>
  <div class="cart-icon">🛒</div>

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

<!-- قسم حولنا -->
<section class="aboutMe" id="aboutMe">
    <div class="aboutContainer">
        <div class="aboutImage">
            <img src="images/about.jpg" alt="صورة عن مجموعة Good Hands">
        </div>
        <div class="textContainer">
            <h2 class="aboutTitle">من نحن</h2>
            <p class="aboutMePar">
                نحن مجموعة من طلاب طيّبة، مطورين ويب مبدعين، نسعى لدعم الأسر المنتجة والأيادي الذهبية في المملكة.  
                هدفنا هو توفير منصة سهلة وآمنة للوصول إلى منتجاتهم بأسرع وقت وبأعلى جودة.
            </p>
            <a href="index.php" class="btn aboutBtn">العودة للرئيسية</a>
        </div>
    </div>
</section>

</body>
</html>

<?php session_start(); ?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Good Hands</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <!-- القائمة الجانبية لتسجيل الدخول -->
<div id="sidebar-login">
  <button id="close-sidebar">&times;</button>
  <form>
    <h2>تسجيل الدخول</h2>
    <input type="text" placeholder="اسم المستخدم">
    <input type="password" placeholder="كلمة المرور">
    <button type="submit" class="btn" style="width:100%;margin-top:10px;">دخول</button>
  </form>
  <a href="sign-up.php " class="signup-link" style="color:#f7e57e;margin-top:18px;display:block;text-align:center;font-weight:bold;">تسجيل جديد</a>
</div>
  <div class="overlay"></div>
  <nav class="navbar">
    <button id="side-login-btn" class="btn">تسجيل الدخول</button>
    <img src="images/LOGO.png" class="logo" alt="Logo">
    <ul class="nav-links">
      <li><a href="#" class="fade-link">الرئيسية</a></li>
      <li><a href="#" class="fade-link">نساء</a></li>
      <li><a href="#" class="fade-link">رجالي</a></li>
      <li><a href="#" class="fade-link">أثاث</a></li>
      <li><a href="about.php" class="fade-link">حول</a></li>
      <li><a href="#" class="fade-link">الاتصال</a></li>
    </ul>
    <div class="cart-icon">🛒</div>
    <div id="auth-section" style="display:none;">
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
  <!-- القائمة الجانبية لتسجيل الدخول -->
  <div id="sidebar-login">
    <button id="close-sidebar">&times;</button>
    <form>
      <h2>تسجيل الدخول</h2>
      <input type="text" placeholder="اسم المستخدم">
      <input type="password" placeholder="كلمة المرور">
      <button type="submit" class="btn" style="width:100%;margin-top:10px;">دخول</button>
    </form>
  </div>
  <section class="hero">
    <div class="hero-content">
      <h1>أيدي طيّبه</h1>
      <h3>كل قطعة تعكس إبداع صانعها.</h3>
      <button class="btn">تصفح</button>
    </div>
  </section>
  <script src="script.js"></script>
</body>
</html>


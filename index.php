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
  <nav class="navbar">
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
    <button id="side-login-btn" class="btn" style="margin-left:auto; margin-right:20px;">تسجيل الدخول</button>
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
  <div id="sidebar-login" style="position:fixed;top:0;left:0;width:350px;max-width:90vw;height:100vh;background:rgba(0,0,0,0.7);backdrop-filter:blur(8px);z-index:100;display:none;flex-direction:column;align-items:center;justify-content:center;box-shadow:0 0 30px #000;">
    <button id="close-sidebar" style="position:absolute;top:20px;left:20px;background:none;border:none;font-size:28px;color:#fff;cursor:pointer;">&times;</button>
    <form style="width:80%;max-width:300px;display:flex;flex-direction:column;gap:18px;align-items:center;justify-content:center;">
      <h2 style="color:#f7e57e;margin-bottom:10px;">تسجيل الدخول</h2>
      <input type="text" placeholder="اسم المستخدم" style="width:100%;padding:12px 10px;border-radius:8px;border:none;background:rgba(255,255,255,0.15);color:#fff;font-size:17px;box-shadow:0 2px 8px rgba(0,0,0,0.08);text-align:center;">
      <input type="password" placeholder="كلمة المرور" style="width:100%;padding:12px 10px;border-radius:8px;border:none;background:rgba(255,255,255,0.15);color:#fff;font-size:17px;box-shadow:0 2px 8px rgba(0,0,0,0.08);text-align:center;">
      <button type="submit" class="btn" style="width:100%;margin-top:10px;">دخول</button>
    </form>
  </div>

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

  <script src="script.js"></script>
  <script src="golden-air.js"></script>
  <script>
    // زر فتح القائمة الجانبية
    document.getElementById('side-login-btn').onclick = function() {
      document.getElementById('sidebar-login').style.display = 'flex';
    };
    // زر إغلاق القائمة الجانبية
    document.getElementById('close-sidebar').onclick = function() {
      document.getElementById('sidebar-login').style.display = 'none';
    };
    // إغلاق عند الضغط خارج الفورم
    document.getElementById('sidebar-login').addEventListener('click', function(e) {
      if(e.target === this) this.style.display = 'none';
    });
  </script>
</body>
</html>

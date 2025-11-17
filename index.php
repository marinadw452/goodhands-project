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
  <!-- ===== زر فتح نافذة تسجيل الدخول ===== -->
<button onclick="openLoginPanel()" class="open-login-btn">تسجيل الدخول</button>

<!-- ===== النافذة الجانبية ===== -->
<!-- النافذة الجانبية لتسجيل الدخول -->
<div id="loginPanel" class="login-sidebar">
    <span class="close-btn" onclick="closeLoginPanel()">&times;</span>

    <h3>تسجيل الدخول</h3>

    <form method="POST" action="login.php">
        <input type="text" name="username" placeholder="اسم المستخدم أو الإيميل" required>
        <input type="password" name="password" placeholder="كلمة المرور" required>
        <button type="submit" name="login">دخول</button>
    </form>

    <p>ما عندك حساب؟ <a href="signup.php">سجل الآن</a></p>
</div>

<style>
/* ===== نافذة تسجيل الدخول الجانبية ===== */
.login-sidebar {
  position: fixed;
  top: 0;
  right: -350px; /* مخفية افتراضياً */
  width: 320px;
  height: 100%;
  background: rgba(0, 0, 0, 0.6); /* خلفية شفافة مشابهة للNavbar */
  backdrop-filter: blur(10px); /* ضبابية */
  box-shadow: -3px 0 12px rgba(0,0,0,0.4);
  transition: 0.4s;
  z-index: 9999;
  padding: 30px 20px;
  display: flex;
  flex-direction: column;
  align-items: center;
  color: #fff;
  font-family: 'Arial', sans-serif;
}

/* المحتوى الداخلي */
.login-sidebar h3 {
  margin-bottom: 20px;
  font-size: 24px;
  font-weight: bold;
  color: #f7e57e; /* نفس تأثير الهوفر للروابط */
  text-align: center;
}

/* الحقول */
.login-sidebar input,
.login-sidebar select {
  width: 100%;
  padding: 12px;
  margin-bottom: 15px;
  border-radius: 8px;
  border: none;
  outline: none;
  font-size: 15px;
  background: rgba(255,255,255,0.2);
  color: #fff;
  transition: 0.3s;
}

.login-sidebar input::placeholder,
.login-sidebar select {
  color: #ddd;
}

/* تأثير التركيز على الحقول */
.login-sidebar input:focus {
  background: rgba(255,255,255,0.3);
  box-shadow: 0 0 8px rgba(247,229,126,0.6);
}

/* زر الدخول */
.login-sidebar button {
  width: 100%;
  padding: 12px;
  background: #f7e57e;
  color: #000;
  font-weight: bold;
  font-size: 16px;
  border: none;
  border-radius: 8px;
  cursor: pointer;
  transition: 0.3s;
}

.login-sidebar button:hover {
  background: #ffd700;
}

/* رابط التسجيل */
.login-sidebar p {
  margin-top: 15px;
  font-size: 14px;
}

.login-sidebar p a {
  color: #f7e57e;
  text-decoration: none;
  font-weight: bold;
  transition: color 0.3s;
}

.login-sidebar p a:hover {
  color: #ffd700;
}

/* زر اغلاق النافذة */
.login-sidebar .close-btn {
  font-size: 28px;
  cursor: pointer;
  align-self: flex-start;
  margin-bottom: 15px;
  transition: color 0.3s;
}

.login-sidebar .close-btn:hover {
  color: #f7e57e;
}
</style>

<script>
function openLoginPanel() {
    document.getElementById("loginPanel").style.right = "0";
}
function closeLoginPanel() {
    document.getElementById("loginPanel").style.right = "-350px";
}
</script>

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



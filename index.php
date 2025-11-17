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

<!-- ================= Navbar ================= -->
<nav class="navbar">
  <img src="images/LOGO.png" class="logo" alt="Logo">

  <ul class="nav-links">
    <li><a href="#">الرئيسية</a></li>
    <li><a href="#">نساء</a></li>
    <li><a href="#">رجالي</a></li>
    <li><a href="#">أثاث</a></li>
    <li><a href="about.php">حول</a></li>
    <li><a href="#">الاتصال</a></li>
  </ul>
</nav>

<!-- ================= Hero Slider ================= -->
<section class="hero">
  <div class="slider">
      <img src="images/4.png" class="slide active" alt="صورة 1">
      <img src="images/123.png" class="slide" alt="صورة 2">
      <img src="images/11.png" class="slide" alt="صورة 3">
      <img src="images/14.png" class="slide" alt="صورة 4">
  </div>
</section>

<!-- ================= زر فتح النافذة ================= -->
<button onclick="openLoginPanel()" class="open-login-btn">تسجيل الدخول</button>

<!-- ================= Sidebar Login ================= -->
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

<script src="script.js"></script>
</body>
</html>

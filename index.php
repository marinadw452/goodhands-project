<?php require_once 'db.php'; 
// كل شيء متعلق بالداتابيس محذوف تمامًا
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>أيدي طيّبة</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

<!-- Navbar -->
<nav class="navbar">
  <img src="images/LOGO.png" class="logo" alt="شعار">
  <ul class="nav-links">
    <li><a href="#">الرئيسية</a></li>
    <li><a href="#">نساء</a></li>
    <li><a href="#">رجالي</a></li>
    <li><a href="#">أثاث</a></li>
    <li><a href="#">حول</a></li>
    <li><a href="#">الاتصال</a></li>
  </ul>
  <div class="cart-icon">Cart</div>
  
  <!-- اختار واحد من الاثنين:
      إما يظهر زر تسجيل الدخول (غير شغال)
      أو يظهر أيقونة مستخدم وهمية -->
      
  <!-- خيار 1: زر تسجيل الدخول (مثل ما كان) -->
  <button id="login-btn">تسجيل الدخول</button>

  <!-- خيار 2: أيقونة مستخدم وهمية (شيل التعليق لو تبيها) -->
  <!--
  <div class="user-icon">م</div>
  <ul class="user-menu">
    <li>محمد</li>
    <li><a href="#">تسجيل خروج</a></li>
  </ul>
  -->
</nav>

<!-- Hero + Slider -->
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
    <h3>كل قطعة تعكس إبداع صانعها</h3>
    <button class="btn">تصفح الآن</button>
  </div>
</section>

<!-- Sidebar Login (يفتح ويشتغل عادي، بس ما يرس

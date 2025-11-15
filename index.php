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
  
  <!-- أيقونات يمين -->
  <div class="nav-right-icons">
    <span class="icon-container">
      🛒
      <span class="badge">0</span>
    </span>

    <span class="icon">🤍</span>
    <span class="icon">🔍</span>
    <span class="icon">👤</span>
  </div>

  <!-- مربع البحث -->
  <div class="search-box">
    <span class="search-icon">🔍</span>
    <input type="text" placeholder="ما الذي تبحث عنه؟">
  </div>

  <!-- اللوقو يسار (نفس لوقوك) -->
  <img src="images/LOGO.png" class="logo" alt="Logo">
</nav>


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
</body>
</html>  


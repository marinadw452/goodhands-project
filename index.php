<?php
session_start();
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>أيدي طيبة</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<nav class="navbar">
  <img src="images/LOGO.png" class="logo" alt="Logo">
  <ul class="nav-links">
    <li><a href="#">الرئيسية</a></li>
    <li><a href="#">نساء</a></li>
    <li><a href="#">رجالي</a></li>
    <li><a href="#">أثاث</a></li>
    <li><a href="#">حول</a></li>
    <li><a href="#">اتصال</a></li>
  </ul>

  <div id="auth-section">
    <?php if (isset($_SESSION['username'])): ?>
      <span>مرحبًا، <?php echo htmlspecialchars($_SESSION['username']); ?></span>
      <a href="logout.php">تسجيل الخروج</a>
    <?php else: ?>
      <a href="login.php"><button>تسجيل الدخول</button></a>
    <?php endif; ?>
  </div>
</nav>
</body>
</html>

<?php
session_start();

// ربط MySQL تلقائي من Railway Variables
$host = $_ENV["MYSQLHOST"] ?? "mysql.railway.internal";
$db   = $_ENV["MYSQLDATABASE"] ?? "railway";
$user = $_ENV["MYSQLUSER"] ?? "root";
$pass = $_ENV["MYSQLPASSWORD"] ?? "";
$port = $_ENV["MYSQLPORT"] ?? "3306";

$conn = mysqli_connect($host, $user, $pass, $db, $port);

if (!$conn) {
    die("فشل الاتصال: " . mysqli_connect_error());
}

// إنشاء جدول users تلقائيًا
mysqli_query($conn, "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");

// تسجيل الدخول
if ($_POST['login'] ?? false) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    $res = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
    if ($row = mysqli_fetch_assoc($res)) {
        if (password_verify($password, $row['password'])) {
            $_SESSION['username'] = $username;
            header("Location: index.php");
            exit;
        }
    }
    $error = "اسم المستخدم أو كلمة المرور خطأ";
}
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

<nav class="navbar">
  <img src="images/LOGO.png" class="logo" alt="Logo">
  <ul class="nav-links">
    <li><a href="#">الرئيسية</a></li>
    <li><a href="#">نساء</a></li>
    <li><a href="#">رجالي</a></li>
    <li><a href="#">أثاث</a></li>
    <li><a href="#">حول</a></li>
    <li><a href="#">الاتصال</a></li>
  </ul>
  <?php if (isset($_SESSION['username'])): ?>
    <div class="user-icon"><?= strtoupper($_SESSION['username'][0]) ?></div>
  <?php else: ?>
    <button id="login-btn">تسجيل الدخول</button>
  <?php endif; ?>
</nav>

<!-- باقي الصفحة زي ما هي -->
<section class="section-hero-wrap">
  <div class="slider">
    <img src="images/4.png" class="slide active" alt="">
    <img src="images/123.png" class="slide" alt="">
    <img src="images/11.png" class="slide" alt="">
    <img src="images/14.png" class="slide" alt="">
  </div>
  <div class="hero-content">
    <h1>أيدي طيّبة</h1>
    <h3>كل قطعة تحكي قصة إبداع</h3>
    <button class="btn">تصفح الآن</button>
  </div>
</section>

<!-- نافذة تسجيل الدخول -->
<div id="sidebar-login" style="display:none;">
  <button class="close-btn">&times;</button>
  <form method="post">
    <h2>تسجيل الدخول</h2>
    <?php if (isset($error)) echo "<p style='color:red'>$error</p>"; ?>
    <input type="text" name="username" placeholder="اسم المستخدم" required>
    <input type="password" name="password" placeholder="كلمة المرور" required>
    <button type="submit" name="login">دخول</button>
  </form>
  <a href="sign-up.php">إنشاء حساب جديد</a>
</div>

<script src="script.js"></script>
<script src="golden-air.js"></script>
<script>
  document.getElementById('login-btn')?.addEventListener('click', () => {
    document.getElementById('sidebar-login').style.display = 'block';
  });
  document.querySelector('.close-btn').addEventListener('click', () => {
    document.getElementById('sidebar-login').style.display = 'none';
  });
</script>
</body>
</html>

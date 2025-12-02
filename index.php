<?php require_once 'db.php'; 

$error = "";
if (isset($_POST['login'])) {
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
    $error = "بيانات غير صحيحة";
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
  
  <?php if (isset($_SESSION['username'])): ?>
    <div class="user-icon"><?= strtoupper(substr($_SESSION['username'],0,1)) ?></div>
    <ul class="user-menu">
      <li><?= htmlspecialchars($_SESSION['username']) ?></li>
      <li><a href="logout.php">تسجيل خروج</a></li>
    </ul>
  <?php else: ?>
    <button id="login-btn">تسجيل الدخول</button>
  <?php endif; ?>
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

<!-- Sidebar Login -->
<div id="sidebar-login">
  <button class="close-btn">×</button>
  <form method="post">
    <h2>تسجيل الدخول</h2>
    <?php if($error): ?><div class="form-msg error"><?= $error ?></div><?php endif; ?>
    <input type="text" name="username" placeholder="اسم المستخدم" required>
    <input type="password" name="password" placeholder="كلمة المرور" required>
    <button type="submit" name="login" class="submit">دخول</button>
  </form>
  <a href="sign-up.php" class="signup-link">إنشاء حساب جديد</a>
</div>

<script src="script.js"></script>
<script src="golden-air.js"></script>
<script>
  const sidebar = document.getElementById('sidebar-login');
  document.getElementById('login-btn')?.onclick = () => sidebar.classList.add('open');
  document.querySelector('.close-btn').onclick = () => sidebar.classList.remove('open');
  document.querySelector('.user-icon')?.onclick = () => document.querySelector('.user-menu').classList.toggle('active');
</script>
</body>
</html>

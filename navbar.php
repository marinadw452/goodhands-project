<nav class="navbar">
  <div class="container nav-container">
    <div id="auth-section">
      <?php if(isset($_SESSION['username'])): ?>
        <div class="user-icon" title="<?= $_SESSION['username'] ?>">
          <?= strtoupper(substr($_SESSION['username'],0,1)) ?>
        </div>
        <div class="user-menu">
          <p><?= $_SESSION['username'] ?></p>
          <a href="logout.php">تسجيل الخروج</a>
        </div>
      <?php else: ?>
        <button id="login-btn">تسجيل الدخول</button>
      <?php endif; ?>
    </div>

    <ul class="nav-links">
      <li><a href="index.php">الرئيسية</a></li>
      <li><a href="#">نساء</a></li>
      <li><a href="#">رجالي</a></li>
      <li><a href="#">أثاث</a></li>
      <li><a href="about.php">حول</a></li>
      <li><a href="contact.php">الاتصال</a></li>
    </ul>

    <a href="index.php" class="logo-link">
      <img src="images/LOGO.png" alt="أيدي طيّبة" class="logo">
    </a>
  </div>
</nav>

<!-- Sidebar Login (نفس الكود اللي في index.php) -->
<div id="sidebar-login">
  <button class="close-btn">×</button>
  <div class="login-form">
    <h2>تسجيل الدخول</h2>
    <form action="login.php" method="post">
      <input type="text" name="username" placeholder="اسم المستخدم" required />
      <input type="password" name="password" placeholder="كلمة المرور" required />
      <button type="submit" class="submit">دخول</button>
    </form>
    <a href="sign-up.php" class="signup-link">إنشاء حساب جديد</a>
  </div>
</div>

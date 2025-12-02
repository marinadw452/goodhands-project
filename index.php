<nav class="navbar">
  <img src="images/LOGO.png" class="logo" alt="شعار">
  <ul class="nav-links">
    <li><a href="index.php">الرئيسية</a></li>
    <li><a href="#">نساء</a></li>
    <li><a href="#">رجالي</a></li>
    <li><a href="#">أثاث</a></li>
    <li><a href="about.php">حول</a></li>
    <li><a href="contact.php">تواصل</a></li>
  </ul>

  <?php if (isset($_SESSION['username'])): ?>
    <div class="user-icon" title="<?= $_SESSION['username'] ?>">
      <?= strtoupper(substr($_SESSION['username'], 0, 1)) ?>
    </div>
    <ul class="user-menu">
      <li><?= htmlspecialchars($_SESSION['username']) ?></li>
      <li><a href="logout.php">تسجيل الخروج</a></li>
    </ul>
  <?php else: ?>
    <button id="login-btn">تسجيل الدخول</button>
  <?php endif; ?>
</nav>

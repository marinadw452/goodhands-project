<?php
session_start();
require_once "config.php"; // ✅ عدّل المسار إذا db.php داخل includes

// ===== جلب التصنيفات من قاعدة البيانات =====
$categories = [];
$q = $conn->query("SELECT id, name FROM categories ORDER BY id ASC");
if ($q) {
  while ($row = $q->fetch_assoc()) {
    $categories[] = $row;
  }
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $page_title ?? 'أيدي طيّبة'; ?></title>
  <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
</head>
<body>

<!-- Navbar -->
<nav class="navbar">
  <div class="container nav-container">

    <!-- تسجيل الدخول (يسار) -->
    <div id="auth-section">
      <?php
        $isLoggedIn = isset($_SESSION['user_id']);
        $role = $_SESSION['role'] ?? '';
        $isSeller = ($role === 'SELLER' || $role === 'seller');

        $displayName = $_SESSION['full_name'] ?? ($_SESSION['username'] ?? 'مستخدم');
        $initial = mb_strtoupper(mb_substr($displayName, 0, 1, 'UTF-8'), 'UTF-8');
      ?>

      <?php if($isLoggedIn): ?>
        <div class="user-dropdown">
          <button class="user-icon-btn" id="userMenuBtn" type="button" aria-haspopup="true" aria-expanded="false"
                  title="<?= htmlspecialchars($displayName) ?>">
            <span class="user-icon"><?= htmlspecialchars($initial) ?></span>
          </button>

          <div class="user-menu" id="userMenu" aria-hidden="true">
            <p class="user-name"><?= htmlspecialchars($displayName) ?></p>

            <?php if($isSeller): ?>
              <button class="menu-link" type="button" id="myProductsBtn">منتجاتي</button>
            <?php endif; ?>
              
               <a class="menu-link" href="seller/dashboard/index.php" style="text-decoration:none;">متابعة طلباتي</a>

            <a class="menu-link danger" href="logout.php">تسجيل الخروج</a>
          </div>
        </div>
      <?php else: ?>
        <a class="btn" href="login.php" style="text-decoration:none;">تسجيل الدخول</a>
      <?php endif; ?>
    </div>

    <!-- القوائم (ديناميكية) -->
    <ul class="nav-links">
      <li>
        <a href="index.php" <?php if(basename($_SERVER['PHP_SELF'])=='index.php') echo 'class="active"'; ?>>
          الرئيسية
        </a>
      </li>

      <?php foreach($categories as $cat): ?>
        <?php
          // يعتبر الرابط Active عندما تكون في products.php ومعك category_id مطابق
          $isActiveCat = (
            basename($_SERVER['PHP_SELF']) === 'products.php'
            && isset($_GET['category_id'])
            && (int)$_GET['category_id'] === (int)$cat['id']
          );
        ?>
        <li>
          <a href="products.php?category_id=<?= (int)$cat['id'] ?>" <?= $isActiveCat ? 'class="active"' : '' ?>>
            <?= htmlspecialchars($cat['name']) ?>
          </a>
        </li>
      <?php endforeach; ?>

      <li>
        <a href="about.php" <?php if(basename($_SERVER['PHP_SELF'])=='about.php') echo 'class="active"'; ?>>
          حول
        </a>
      </li>
      <li>
        <a href="contact.php" <?php if(basename($_SERVER['PHP_SELF'])=='contact.php') echo 'class="active"'; ?>>
          الاتصال
        </a>
      </li>
    </ul>

    <!-- اللوجو (يمين) -->
    <a href="index.php" class="logo-link">
      <img src="images/LOGO.png" alt="أيدي طيّبة" class="logo">
    </a>

  </div>
</nav>

<!-- Sidebar Login (موجود في كل الصفحات) -->
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

<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST['username'];
  $_SESSION['username'] = $username;
  header("Location: index.php");
  exit();
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>تسجيل الدخول - Good Hands</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="login-container">
    <h2>تسجيل الدخول</h2>
    <form method="POST">
      <label for="username">اسم المستخدم:</label>
      <input type="text" id="username" name="username" required>

      <label for="password">كلمة المرور:</label>
      <input type="password" id="password" name="password" required>

      <button type="submit">دخول</button>
    </form>
    <a href="index.php" class="back-link">العودة للرئيسية</a>
  </div>
</body>
</html>

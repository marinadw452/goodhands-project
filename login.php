<?php
session_start();
require_once "config.php"; // إعدادات قاعدة البيانات

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password_plain = $_POST['password'];

    if(empty($username) || empty($password_plain)){
        $message = "أدخل اسم مستخدم وكلمة مرور.";
    } else {
        $password_hashed = password_hash($password_plain, PASSWORD_DEFAULT);
        try {
            $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':password', $password_hashed);
            $stmt->execute();
            $message = "تم التسجيل بنجاح.";
        } catch(PDOException $e){
            if($e->getCode() == 23000){
                $message = "اسم المستخدم موجود بالفعل.";
            } else {
                $message = "خطأ: " . $e->getMessage();
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>تسجيل الدخول - أيدي طيبة</title>
  <link rel="stylesheet" href="style.css">
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
</head>
<body>
  <div class="container">
    <!-- نموذج يسار -->
    <div class="form-container">
      <form method="POST">
        <h1>تسجيل الدخول</h1>

        <?php if($message != ""): ?>
          <p class="message"><?php echo $message; ?></p>
        <?php endif; ?>

        <div class="input-box">
          <input type="text" name="username" placeholder="اسم المستخدم" required>
          <i class="bx bxs-user"></i>
        </div>

        <div class="input-box">
          <input type="password" name="password" placeholder="كلمة المرور" required>
          <i class="bx bxs-lock-alt"></i>
        </div>

        <div class="remember-forgot">
          <label><input type="checkbox"> تذكرني</label>
          <a href="#">نسيت كلمة المرور؟</a>
        </div>

        <button type="submit" class="btn">دخول</button>

        <div class="register-link">
          <p>ليس لديك حساب؟ <a href="#">إنشاء حساب</a></p>
        </div>
      </form>
    </div>

    <!-- صورة يمين -->
    <div class="overlay-container"></div>
  </div>

  <div id="credits">Made by Good Hands</div>
</body>
</html>

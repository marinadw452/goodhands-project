<?php
session_start();
require_once "config.php";

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
  <link rel="stylesheet" href="login.css">
</head>
<body>

  <div class="box">
    <h1>تسجيل الدخول</h1>

    <?php if($message != ""): ?>
      <p class="message"><?php echo $message; ?></p>
    <?php endif; ?>

    <form action="login.php" method="POST">
      <div class="input-box">
        <input type="text" name="username" placeholder="اسم المستخدم" required>
      </div>
      <div class="input-box">
        <input type="password" name="password" placeholder="كلمة المرور" required>
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

</body>
</html>

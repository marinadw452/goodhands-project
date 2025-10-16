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
<style>
body {
  margin: 0;
  padding: 0;
  font-family: 'Poppins', sans-serif;
  background: url('imges/mm.png') no-repeat center center fixed;
  background-size: cover;
  height: 100vh;
  display: flex;
  justify-content: center;
  align-items: center;
}

.box {
  background: rgba(0, 0, 0, 0.6);
  padding: 40px 30px;
  border-radius: 20px;
  box-shadow: 0 0 20px rgba(255,255,255,0.2);
  width: 320px;
  text-align: center;
  color: white;
}

h1 {
  margin-bottom: 20px;
  font-size: 26px;
  color: #fff;
}

.input-box {
  margin-bottom: 15px;
  position: relative;
}

.input-box input {
  width: 100%;
  padding: 12px 15px;
  border: none;
  outline: none;
  border-radius: 30px;
  background: rgba(255,255,255,0.2);
  color: white;
  font-size: 14px;
}

.input-box input::placeholder {
  color: #ddd;
}

.remember-forgot {
  display: flex;
  justify-content: space-between;
  font-size: 13px;
  color: #ddd;
  margin-bottom: 15px;
}

.btn {
  width: 100%;
  padding: 10px;
  background-color: rgba(255,255,255,0.8);
  border: none;
  border-radius: 30px;
  font-weight: bold;
  color: #333;
  cursor: pointer;
  transition: 0.3s;
}

.btn:hover {
  background-color: #fff;
  box-shadow: 0 0 10px rgba(255,255,255,0.4);
}

.register-link {
  font-size: 13px;
  margin-top: 15px;
}

.register-link a {
  color: #fff;
  text-decoration: underline;
}
</style>
</head>
<body>

<div class="box">
  <h1>تسجيل الدخول</h1>

  <?php if($message != ""): ?>
    <p style="color: #ff8080; font-size:14px;"><?php echo $message; ?></p>
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

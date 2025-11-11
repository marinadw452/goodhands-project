<?php
session_start();
require_once "config.php";

$message = "";

// تسجيل الدخول
if(isset($_POST['login'])){
    $username = trim($_POST['username']);
    $password_plain = trim($_POST['password']);

    if(empty($username) || empty($password_plain)){
        $message = "الرجاء إدخال جميع الحقول.";
    } else {
        $query = pg_query_params($conn, "SELECT * FROM users WHERE username=$1", [$username]);

        if(pg_num_rows($query) > 0){
            $user = pg_fetch_assoc($query);
            if(password_verify($password_plain, $user['password'])){
                $_SESSION['username'] = $user['username'];
                header("Location: index.php");
                exit();
            } else {
                $message = "كلمة المرور غير صحيحة.";
            }
        } else {
            $message = "المستخدم غير موجود.";
        }
    }
}

// إنشاء حساب جديد
if(isset($_POST['signup'])){
    $username = trim($_POST['username']);
    $password_plain = trim($_POST['password']);

    if(empty($username) || empty($password_plain)){
        $message = "الرجاء إدخال جميع الحقول.";
    } else {
        $check = pg_query_params($conn, "SELECT * FROM users WHERE username=$1", [$username]);

        if(pg_num_rows($check) > 0){
            $message = "اسم المستخدم موجود بالفعل.";
        } else {
            $password_hash = password_hash($password_plain, PASSWORD_DEFAULT);
            pg_query_params($conn, "INSERT INTO users (username, password) VALUES ($1, $2)", [$username, $password_hash]);
            $_SESSION['username'] = $username;
            header("Location: index.php");
            exit();
        }
    }
}

?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>تسجيل الدخول</title>

<style>
body {
  margin: 0; padding: 0;
  height: 100vh;
  display: flex; justify-content: center; align-items: center;
  background: url('images/placeholder.png') no-repeat center center fixed; /* استبدلي بالصورة لاحقًا */
  background-size: cover;
  font-family: Arial, sans-serif;
}

.overlay {
  position: absolute;
  width: 100%; height: 100%;
  background: rgba(0,0,0,0.4);
  backdrop-filter: blur(5px);
  z-index: 0;
}

.container {
  position: relative;
  width: 320px;  /* أصغر من السابق */
  height: 380px; /* أصغر وأكثر تناسق */
  perspective: 1000px;
  z-index: 1;
}

.card {
  width: 100%; height: 100%;
  position: relative;
  transform-style: preserve-3d;
  transition: transform 0.8s;
}

.card.flip {
  transform: rotateY(180deg);
}

.form-box {
  position: absolute;
  width: 100%; height: 100%;
  background: rgba(255,255,255,0.15);
  border-radius: 12px;
  backdrop-filter: blur(10px);
  box-shadow: 0 0 12px rgba(0,0,0,0.3);
  padding: 25px;
  backface-visibility: hidden;
  display: flex;
  flex-direction: column;
  justify-content: center;
}

.form-box h2 {
  text-align: center;
  color: #fff;
  margin-bottom: 15px;
  font-size: 22px;
}

input {
  width: 100%;
  padding: 10px;
  margin-bottom: 12px;
  border-radius: 6px;
  border: none;
  outline: none;
  background: rgba(255,255,255,0.8);
  font-size: 15px;
}

button {
  width: 100%;
  padding: 10px;
  border: none;
  background: #f5e1c3;
  border-radius: 6px;
  cursor: pointer;
  font-weight: bold;
  font-size: 16px;
}

.switch {
  text-align: center;
  margin-top: 10px;
  color: #fff;
  cursor: pointer;
  font-size: 14px;
}

.signup-box {
  transform: rotateY(180deg);
}

.message {
  color: yellow;
  text-align: center;
  font-size: 14px;
  margin-bottom: 10px;
}
</style>

</head>
<body>

<div class="overlay"></div>

<div class="container">
  <div class="card" id="flip-card">

    <!-- Login Form -->
    <div class="form-box login-box">
      <h2>تسجيل الدخول</h2>

      <?php if($message): ?>
      <p class="message"><?php echo $message; ?></p>
      <?php endif; ?>

      <form method="POST">
        <input type="text" name="username" placeholder="اسم المستخدم">
        <input type="password" name="password" placeholder="كلمة المرور">
        <button type="submit" name="login">دخول</button>
      </form>

      <p class="switch" onclick="flipCard()">ليس لديك حساب؟ إنشاء حساب</p>
    </div>

    <!-- Signup Form -->
    <div class="form-box signup-box">
      <h2>إنشاء حساب</h2>

      <form method="POST">
        <input type="text" name="username" placeholder="اسم المستخدم">
        <input type="password" name="password" placeholder="كلمة المرور">
        <button type="submit" name="signup">تسجيل</button>
      </form>

      <p class="switch" onclick="flipCard()">لديك حساب؟ تسجيل الدخول</p>
    </div>

  </div>
</div>

<script>
function flipCard(){
  document.getElementById("flip-card").classList.toggle("flip");
}
</script>

</body>
</html>

<?php
session_start();
require_once "config.php"; // تأكد من إعداد الاتصال بقاعدة البيانات في هذا الملف

// الرسائل
$regMessage = "";
$loginMessage = "";

// معالجة التسجيل
if(isset($_POST['register'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password_plain = $_POST['password'];

    if(empty($username) || empty($email) || empty($password_plain)){
        $regMessage = "الرجاء إدخال جميع الحقول";
    } else {
        $password_hashed = password_hash($password_plain, PASSWORD_DEFAULT);
        try {
            $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $password_hashed);
            $stmt->execute();
            $regMessage = "تم التسجيل بنجاح!";
        } catch(PDOException $e){
            if($e->getCode() == 23000){
                $regMessage = "اسم المستخدم أو البريد موجود بالفعل.";
            } else {
                $regMessage = "خطأ: " . $e->getMessage();
            }
        }
    }
}

// معالجة تسجيل الدخول
if(isset($_POST['login'])) {
    $email = $_POST['lgEmail'];
    $password = $_POST['lgPassword'];

    if(empty($email) || empty($password)){
        $loginMessage = "الرجاء إدخال البريد وكلمة المرور";
    } else {
        $stmt = $conn->prepare("SELECT * FROM users WHERE email=:email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if($user && password_verify($password, $user['password'])){
            $_SESSION['user'] = $user['username'];
            $loginMessage = "تم تسجيل الدخول بنجاح!";
        } else {
            $loginMessage = "البريد أو كلمة المرور غير صحيحة";
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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
<style>
@import url("https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap");

* { font-family: "Poppins", sans-serif; margin:0; padding:0; box-sizing:border-box; }
body {
  height:100vh;
  display:flex; justify-content:center; align-items:center;
  background:url('mn.png') no-repeat center center fixed;
  background-size:cover;
  position:relative;
  overflow:hidden;
}
body::before {
  content:"";
  position:absolute; top:0; left:0; width:100%; height:100%;
  background: rgba(0,0,0,0.4);
  backdrop-filter: blur(10px);
  z-index:0;
}
.container {
  position:relative; z-index:2;
  width:768px; max-width:100%; min-height:500px;
  border-radius:25px; overflow:hidden;
  box-shadow:0 14px 28px rgba(0,0,0,0.25),0 10px 10px rgba(0,0,0,0.22);
}

/* form styles */
.form-container { position:absolute; top:0; height:100%; width:50%;
  background: rgba(0,0,0,0.45); backdrop-filter: blur(15px);
  color:#F5E1C3; display:flex; justify-content:center; align-items:center;
  flex-direction:column; padding:40px; transition: all 0.6s ease-in-out; border-radius:25px;
}
.register-container { left:0; opacity:0; z-index:1; }
.container.right-panel-active .register-container { transform:translateX(100%); opacity:1; z-index:5; animation: show 0.6s; }
.login-container { left:0; z-index:2; }
.container.right-panel-active .login-container { transform:translateX(100%); }
@keyframes show { 0%,49.99%{opacity:0; z-index:1;} 50%,100%{opacity:1; z-index:5;} }

input { width:100%; padding:12px; margin:8px 0; border:none; border-radius:10px; background: rgba(255,255,255,0.1); color:#fff; outline:none; transition:0.3s; }
input:focus { background: rgba(255,255,255,0.25); }
button { border:none; border-radius:10px; padding:12px 40px; background:#F5E1C3; color:#000; cursor:pointer; margin-top:15px; transition:0.3s; }
button:hover { background:#E0CFA0; }
span, a { color:#F5E1C3; }
.overlay-container { position:absolute; top:0; left:50%; width:50%; height:100%; overflow:hidden; transition: transform 0.6s ease-in-out; z-index:100; }
.container.right-panel-active .overlay-container { transform:translate(-100%); }
.overlay { background: url('mn.png') no-repeat center center; background-size:cover; position: relative; height:100%; width:200%; left:-100%; transition: transform 0.6s ease-in-out; }
.overlay::before { content:""; position:absolute; top:0; left:0; width:100%; height:100%; background: rgba(0,0,0,0.4);}
.container.right-panel-active .overlay { transform:translateX(50%); }
.overlay-panel { position:absolute; display:flex; align-items:center; justify-content:center; flex-direction:column; padding:0 40px; text-align:center; top:0; height:100%; width:50%; transition: transform 0.6s ease-in-out; color:#F5E1C3; }
.overlay-left { transform:translateX(-20%);}
.container.right-panel-active .overlay-left { transform:translateX(0);}
.overlay-right { right:0; transform:translateX(0);}
.container.right-panel-active .overlay-right { transform:translateX(20%);}
.social-container a { border:1px solid #dddddd; border-radius:50%; display:inline-flex; justify-content:center; align-items:center; margin:0 5px; height:40px; width:40px; transition:0.3s; }
.social-container a:hover { border-color:#F5E1C3; }
small { color:#f7e57e; margin-bottom:5px; display:block; }
.message { color:#f7e57e; text-align:center; margin-bottom:10px; }
</style>
</head>
<body>

<div class="container" id="container">

  <div class="form-container register-container">
    <form method="POST">
      <h1>تسجيل جديد</h1>
      <?php if($regMessage != "") echo "<p class='message'>{$regMessage}</p>"; ?>
      <input type="text" name="username" placeholder="اسم المستخدم" required />
      <input type="email" name="email" placeholder="البريد الإلكتروني" required />
      <input type="password" name="password" placeholder="كلمة المرور" required />
      <button type="submit" name="register">تسجيل</button>
      <span>أو استخدم حسابك</span>
      <div class="social-container">
        <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
        <a href="#"><i class="fa-brands fa-google"></i></a>
        <a href="#"><i class="fa-brands fa-tiktok"></i></a>
      </div>
    </form>
  </div>

  <div class="form-container login-container">
    <form method="POST">
      <h1>تسجيل الدخول</h1>
      <?php if($loginMessage != "") echo "<p class='message'>{$loginMessage}</p>"; ?>
      <input type="email" name="lgEmail" placeholder="البريد الإلكتروني" required />
      <input type="password" name="lgPassword" placeholder="كلمة المرور" required />
      <div style="display:flex; justify-content:space-between; width:100%; margin:15px 0;">
        <label><input type="checkbox"> تذكرني</label>
        <a href="#">نسيت كلمة المرور؟</a>
      </div>
      <button type="submit" name="login">دخول</button>
      <span>أو استخدم حسابك</span>
      <div class="social-container">
        <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
        <a href="#"><i class="fa-brands fa-google"></i></a>
        <a href="#"><i class="fa-brands fa-tiktok"></i></a>
      </div>
    </form>
  </div>

  <div class="overlay-container">
    <div class="overlay">
      <div class="overlay-panel overlay-left">
        <h1>مرحباً بك</h1>
        <p>إذا كان لديك حساب، سجل الدخول الآن</p>
        <button class="ghost" id="loginBtn">دخول <i class="fa-solid fa-arrow-left"></i></button>
      </div>
      <div class="overlay-panel overlay-right">
        <h1>ابدأ رحلتك الآن</h1>
        <p>إذا لم يكن لديك حساب، سجل معنا الآن</p>
        <button class="ghost" id="registerBtn">تسجيل <i class="fa-solid fa-arrow-right"></i></button>
      </div>
    </div>
  </div>

</div>

<script>
const container = document.getElementById('container');
document.getElementById('registerBtn').addEventListener('click', ()=> {
  container.classList.add('right-panel-active');
});
document.getElementById('loginBtn').addEventListener('click', ()=> {
  container.classList.remove('right-panel-active');
});
</script>

</body>
</html>

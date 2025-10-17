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
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
  <style>
  * {
    font-family: "Poppins", sans-serif;
    margin: 0;
    padding: 0;
    box-sizing: border-box;
  }

  body {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    background-color: #fff;
    color: #fff;
  }

  /* الإطار */
  .frame-container {
    position: relative;
    width: 440px;
    height: 600px;
    background: url('mae.png') no-repeat center center;
    background-size: cover;
    display: flex;
    justify-content: center;
    align-items: center;
  }

  /* الصندوق داخل الصورة */
  .container {
    width: 75%;
    background: rgba(0, 0, 0, 0.45);
    border: 1px solid rgba(245, 225, 195, 0.3);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    box-shadow: 0 0 40px rgba(0, 0, 0, 0.5);
    color: #F5E1C3;
    border-radius: 20px;
    padding: 30px;
    transition: all 0.3s ease;
  }

  .container:hover {
    background: rgba(0, 0, 0, 0.55);
    box-shadow: 0 0 50px rgba(0, 0, 0, 0.6);
  }

  .container h1 {
    font-size: 28px;
    text-align: center;
    color: #F5E1C3;
    text-shadow: 0 0 12px rgba(245, 225, 195, 0.4);
    margin-bottom: 25px;
  }

  .input-box {
    position: relative;
    width: 100%;
    height: 45px;
    margin: 15px 0;
  }

  .input-box input {
    width: 100%;
    height: 100%;
    background: rgba(255, 255, 255, 0.15);
    border: none;
    outline: none;
    border-radius: 10px;
    font-size: 16px;
    color: #fff;
    padding: 10px 15px;
    box-shadow: inset 0 0 10px rgba(245, 225, 195, 0.1);
    transition: background 0.3s ease, box-shadow 0.3s ease;
  }

  .input-box input:focus {
    background: rgba(255, 255, 255, 0.25);
    box-shadow: 0 0 10px rgba(245, 225, 195, 0.3);
  }

  .input-box input::placeholder {
    color: rgba(245, 225, 195, 0.7);
  }

  .remember-forgot {
    display: flex;
    justify-content: space-between;
    font-size: 14px;
    margin: -10px 0 20px;
    color: #F5E1C3;
  }

  .remember-forgot a {
    color: #f7e57e;
    text-decoration: none;
    transition: 0.3s;
  }

  .remember-forgot a:hover {
    color: #fff;
    text-shadow: 0 0 8px rgba(245, 225, 195, 0.5);
  }

  .btn {
    width: 100%;
    height: 40px;
    background: #F5E1C3;
    border: none;
    outline: none;
    border-radius: 10px;
    cursor: pointer;
    font-size: 16px;
    font-weight: 600;
    color: #000;
    transition: 0.3s;
    box-shadow: 0 0 15px rgba(245, 225, 195, 0.4);
  }

  .btn:hover {
    background: #E0CFA0;
    box-shadow: 0 0 25px rgba(245, 225, 195, 0.6);
  }

  .register-link {
    font-size: 14.5px;
    text-align: center;
    margin: 25px 0 15px;
    color: #F5E1C3;
  }

  .register-link p a {
    color: #f7e57e;
    text-decoration: none;
    font-weight: 600;
    transition: 0.3s;
  }

  .register-link p a:hover {
    color: #fff;
    text-shadow: 0 0 8px rgba(245, 225, 195, 0.6);
  }

  #credits {
    position: fixed;
    bottom: 10px;
    right: 10px;
    color: rgba(80, 80, 80, 0.8);
    font-size: 12px;
    font-family: Arial, sans-serif;
  }

  .message {
    color: #f7e57e;
    text-align: center;
    margin-bottom: 10px;
  }
  </style>
</head>

<body>
  <div class="frame-container">
    <div class="container">
      <form action="login.php" method="POST">
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
  </div>

  <div id="credits">Made by Good Hands</div>
</body>
</html>

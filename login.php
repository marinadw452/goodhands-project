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
  <img src="mm.png" class="dacgrwnd" alt="خلفيه">  
    <title>تسجيل الدخول - أيدي طيبة</title>
<link rel="stylesheet" href="login.css">
</head>
<body>

<div class="box">
  <div class="container">
    <div class="top-header">
      <h1>تسجيل الدخول</h1>
      <div class="input-box">
          <input type="text" placeholder="سم المستخدم" required />
          <!-- <i class="bx bxs-user"></i> -->
        </div>
        <div class="input-box">
          <input type="password" placeholder="كلمة المرور" required />
          <!-- <i class="bx bxs-lock-alt"></i> -->
        </div>

        <div class="remember-forgot">
          <label><input type="checkbox" /> Remember me</label>
          <a href="#">Forgot password?</a>
        </div>

        <button type="submit" class="btn">Login</button>

        <div class="register-link">
          <p>Don't have an account? <a href="#">Register here!</a></p>
        </div>
      </form>
    </div>
  </body>
</html>

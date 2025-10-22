<?php
session_start();
require_once "config.php";

$message = "";

// إذا المستخدم ضغط تسجيل
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password_plain = $_POST['password'];

    if(empty($username) || empty($password_plain)){
        $message = "أدخل اسم مستخدم وكلمة مرور.";
    } else {
        // تحقق إذا المستخدم موجود
        $check = pg_query_params($conn, "SELECT * FROM users WHERE username=$1", [$username]);
        if(pg_num_rows($check) > 0){
            $message = "اسم المستخدم موجود بالفعل.";
        } else {
            $password_hashed = password_hash($password_plain, PASSWORD_DEFAULT);
            $insert = pg_query_params($conn, "INSERT INTO users (username, password) VALUES ($1,$2)", [$username, $password_hashed]);
            if($insert){
                $_SESSION['username'] = $username;
                header("Location: index.php");
                exit;
            } else {
                $message = "حدث خطأ أثناء التسجيل.";
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
<title>تسجيل الدخول - Good Hands</title>
<style>
body {
    font-family: 'Poppins', sans-serif;
    background: url('images/login-bg.jpg') no-repeat center center fixed;
    background-size: cover;
    margin:0; padding:0;
}
.container {
    width: 400px;
    margin: 50px auto;
    background: rgba(255,255,255,0.95);
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 0 20px rgba(0,0,0,0.3);
}
h1 {
    text-align: center;
    margin-bottom: 20px;
}
.input-box {
    position: relative;
    margin-bottom: 20px;
}
.input-box input {
    width: 100%;
    padding: 12px 40px 12px 15px;
    border-radius: 8px;
    border: 1px solid #ccc;
}
.input-box i {
    position: absolute;
    right: 15px;
    top: 50%;
    transform: translateY(-50%);
    color: #888;
}
.btn {
    width: 100%;
    padding: 12px;
    border: none;
    background: #1e90ff;
    color: white;
    font-size: 16px;
    border-radius: 8px;
    cursor: pointer;
}
.btn:hover {
    background: #0b75d1;
}
.message {
    color: red;
    text-align: center;
    margin-bottom: 15px;
}
.register-link {
    text-align: center;
    margin-top: 15px;
}
.register-link a {
    text-decoration: none;
    color: #1e90ff;
}
.register-link a:hover {
    text-decoration: underline;
}
</style>
<link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <h1>تسجيل مستخدم جديد</h1>
    <?php if($message != ""): ?>
        <p class="message"><?php echo $message; ?></p>
    <?php endif; ?>
    <form method="POST">
        <div class="input-box">
            <input type="text" name="username" placeholder="اسم المستخدم" required>
            <i class="bx bxs-user"></i>
        </div>
        <div class="input-box">
            <input type="password" name="password" placeholder="كلمة المرور" required>
            <i class="bx bxs-lock-alt"></i>
        </div>
        <button type="submit" class="btn">تسجيل</button>
        <div class="register-link">
            <p>لديك حساب؟ <a href="login.php">تسجيل الدخول</a></p>
        </div>
    </form>
</div>
</body>
</html>

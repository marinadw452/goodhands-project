<?php
session_start();
require_once "config.php";

$message = "";

// =========== تسجيل جديد ============
if(isset($_POST['signup'])){
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password_plain = trim($_POST['password']);

    if(empty($username) || empty($email) || empty($password_plain)){
        $message = "الرجاء إدخال جميع البيانات.";
    } else {
        // تحقق هل البريد مستخدم
        $checkEmail = pg_query_params($conn, "SELECT * FROM users WHERE email=$1", [$email]);
        if(pg_num_rows($checkEmail) > 0){
            $message = "البريد الإلكتروني مستخدم مسبقاً.";
        } else {
            $password_hashed = password_hash($password_plain, PASSWORD_DEFAULT);

            pg_query_params($conn,
                "INSERT INTO users (username, email, password, is_verified) VALUES ($1,$2,$3,false)",
                [$username, $email, $password_hashed]
            );

            // إنشاء كود تحقق
            $code = rand(100000, 999999);
            pg_query_params($conn, "UPDATE users SET verify_code=$1 WHERE email=$2", [$code, $email]);

            // إرسال بريد
            mail($email, "رمز التحقق", "رمز التحقق الخاص بك هو: $code");

            $_SESSION['email_temp'] = $email;

            header("Location: verify.php");
            exit;
        }
    }
}

// =========== تسجيل دخول ============
if(isset($_POST['login'])){
    $email = trim($_POST['email']);
    $password_plain = trim($_POST['password']);

    if(empty($email) || empty($password_plain)){
        $message = "أدخل البريد وكلمة المرور.";
    } else {

        $check = pg_query_params($conn, "SELECT * FROM users WHERE email=$1", [$email]);

        if(pg_num_rows($check) == 0){
            $message = "الحساب غير موجود.";
        } else {
            $user = pg_fetch_assoc($check);

            if(password_verify($password_plain, $user['password'])){
                
                // إذا لم يتحقق سابقاً — أرسل كود جديد
                if(!$user['is_verified']){

                    $code = rand(100000, 999999);
                    pg_query_params($conn, "UPDATE users SET verify_code=$1 WHERE email=$2", [$code, $email]);

                    mail($email, "رمز التحقق", "رمز التحقق الخاص بك هو: $code");

                    $_SESSION['email_temp'] = $email;
                    header("Location: verify.php");
                    exit;

                } else {
                    // تسجيل دخول مباشرة
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['email'] = $user['email'];
                    header("Location: index.php");
                    exit;
                }

            } else {
                $message = "كلمة المرور غير صحيحة.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<title>تسجيل / دخول</title>
<style>
body { font-family: Arial; background:#f5f5f5; padding:40px; }
.box { width:400px; margin:auto; background:white; padding:25px; border-radius:10px; }
input { width:100%; padding:10px; margin-bottom:10px; border-radius:5px; border:1px solid #aaa; }
button { width:100%; padding:10px; background:#007bff; color:white; border:none; border-radius:5px; }
.message {color:red; text-align:center;}
h2 {text-align:center;}
</style>
</head>
<body>

<div class="box">
<h2>تسجيل مستخدم جديد</h2>
<p class="message"><?php echo $message; ?></p>
<form method="POST">
    <input type="text" name="username" placeholder="اسم المستخدم">
    <input type="email" name="email" placeholder="البريد الإلكتروني">
    <input type="password" name="password" placeholder="كلمة المرور">
    <button type="submit" name="signup">تسجيل</button>
</form>
</div>

<br>

<div class="box">
<h2>تسجيل دخول</h2>
<form method="POST">
    <input type="email" name="email" placeholder="البريد الإلكتروني">
    <input type="password" name="password" placeholder="كلمة المرور">
    <button type="submit" name="login">دخول</button>
</form>
</div>

</body>
</html>

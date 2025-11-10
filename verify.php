<?php
session_start();
require_once "config.php";

if(!isset($_SESSION['email_temp'])){
    header("Location: auth.php");
    exit;
}

$message = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $code = trim($_POST['code']);
    $email = $_SESSION['email_temp'];

    $result = pg_query_params($conn, "SELECT verify_code FROM users WHERE email=$1", [$email]);
    $row = pg_fetch_assoc($result);

    if($code == $row['verify_code']){

        pg_query_params($conn, "UPDATE users SET is_verified=true, verify_code=NULL WHERE email=$1", [$email]);

        // جلب اسم المستخدم
        $user = pg_query_params($conn, "SELECT username FROM users WHERE email=$1", [$email]);
        $data = pg_fetch_assoc($user);

        $_SESSION['username'] = $data['username'];
        $_SESSION['email'] = $email;

        unset($_SESSION['email_temp']);

        header("Location: index.php");
        exit;

    } else {
        $message = "الكود غير صحيح.";
    }
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<title>التحقق</title>
<style>
body { font-family: Arial; padding:50px; background:#eee;}
.box { width:400px; margin:auto; background:white; padding:25px; border-radius:10px;}
input {padding:10px; width:100%; margin-bottom:10px;}
button {padding:10px; width:100%; background:#28a745; color:white; border:none; border-radius:5px;}
.message {color:red; text-align:center;}
</style>
</head>
<body>

<div class="box">
<h2>أدخل رمز التحقق</h2>
<p class="message"><?php echo $message; ?></p>
<form method="POST">
    <input type="text" name="code" placeholder="رمز التحقق">
    <button type="submit">تأكيد</button>
</form>
</div>
</body>
</html>

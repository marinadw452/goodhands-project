<!-- sign-up.php -->
<?php
session_start();
$_SESSION['username'] = $_POST['username'] ?? 'مستخدم';
header("Location: index.php");
?>
<!DOCTYPE html><html dir="rtl"><head><meta charset="UTF-8"><title>تسجيل</title><link href="https://fonts.googleapis.com/css2?family=Tajawal&display=swap" rel="stylesheet"><style>body{font-family:Tajawal;background:#f5e1c3;padding:50px;text-align:center;}form{background:white;padding:40px;border-radius:20px;display:inline-block;}</style></head><body>
<h2>إنشاء حساب</h2>
<form method="post">
  <input type="text" name="username" placeholder="اسم المستخدم" required style="padding:12px;margin:10px;width:300px;border-radius:10px;border:1px solid #ba7d37;"><br>
  <button type="submit" style="background:#ffb74d;padding:14px 40px;border:none;border-radius:50px;font-weight:bold;">تسجيل</button>
</form>
</body></html>

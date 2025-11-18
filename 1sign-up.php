<?php
// يمكنك هنا معالجة البيانات عند إرسال النموذج (مثال بسيط فقط)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $type = $_POST['type'] ?? '';
    // هنا يمكنك إضافة كود التحقق أو الحفظ في قاعدة البيانات
    // مثال: إذا نجح التسجيل
    // header('Location: success.php');
    // exit;
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>تسجيل جديد</title>
  <link rel="stylesheet" href="style.css">
  <style>
    body {
      background: #222;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .signup-container {
      background: rgba(0,0,0,0.7);
      backdrop-filter: blur(8px);
      border-radius: 16px;
      box-shadow: 0 0 30px #000;
      padding: 40px 30px;
      width: 100%;
      max-width: 350px;
      display: flex;
      flex-direction: column;
      align-items: center;
    }
    .signup-container h2 {
      color: #f7e57e;
      margin-bottom: 18px;
      text-align: center;
    }
    .signup-container input, .signup-container select {
      width: 100%;
      padding: 12px 10px;
      border-radius: 8px;
      border: none;
      background: rgba(255,255,255,0.15);
      color: #fff;
      font-size: 17px;
      margin-bottom: 16px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.08);
      text-align: center;
      outline: none;
    }
    .signup-container input::placeholder {
      color: #eee;
      opacity: 1;
    }
    .signup-container .btn {
      width: 100%;
      margin-top: 10px;
    }
  </style>
</head>
<body>
  <div class="signup-container">
    <h2>تسجيل مستخدم جديد</h2>
    <form method="post" action="">
      <input type="text" name="username" placeholder="اسم المستخدم" required>
      <input type="email" name="email" placeholder="البريد الإلكتروني" required>
      <input type="password" name="password" placeholder="كلمة المرور" required>
      <select name="type" required>
        <option value="" disabled selected>نوع الحساب</option>
        <option value="buyer">مشتري</option>
        <option value="seller">بائع</option>
      </select>
      <button type="submit" class="btn">تسجيل</button>
    </form>
  </div>
</body>
</html>

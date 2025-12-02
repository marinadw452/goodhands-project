<?php
session_start();

if ($_POST) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if (strlen($username) < 3) {
        $error = "الاسم قصير جدًا";
    } elseif (strlen($password) < 4) {
        $error = "كلمة المرور ضعيفة";
    } else {
        $_SESSION['username'] = $username;
        // هنا ممكن نحفظ في ملف txt لو تبي، بس حاليًا في السيشن بس
        header("Location: index.php");
        exit;
    }
}
?>

<!DOCTYPE html><html dir="rtl"><head><meta charset="UTF-8"><title>إنشاء حساب</title><link rel="stylesheet" href="style.css"></head><body style="text-align:center;padding:100px;background:#111;color:#fff;">
<h2>إنشاء حساب جديد (بدون داتابيس)</h2>
<?php if(isset($error)) echo "<p style='color:red'>$error</p>"; ?>
<form method="post">
  <input type="text" name="username" placeholder="اسم المستخدم" required><br><br>
  <input type="password" name="password" placeholder="كلمة المرور" required><br><br>
  <button type="submit" style="padding:10px 20px;background:#eec857;border:none;border-radius:8px;">إنشاء الحساب</button>
</form>
<br><a href="index.php">العودة</a>
</body></html>

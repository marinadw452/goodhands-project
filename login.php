<?php
session_start();

// كلمات مرور وهمية (غيرها بأي شيء تبيه)
$users = [
    "admin"     => "123456",
    "ahmed"     => "ahmed123",
    "sara"      => "sara2025",
    "test"      => "test"
];

if ($_POST) {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if (isset($users[$username]) && $users[$username] === $password) {
        $_SESSION['username'] = $username;
        header("Location: index.php");
        exit;
    } else {
        $error = "اسم المستخدم أو كلمة المرور غلط";
    }
}
?>

<!DOCTYPE html><html dir="rtl" lang="ar"><head><meta charset="UTF-8"><title>دخول</title><link rel="stylesheet" href="style.css"></head><body style="text-align:center;padding:100px;background:#111;color:#fff;">
<h2>تسجيل الدخول (بدون داتابيس)</h2>
<?php if(isset($error)) echo "<p style='color:red'>$error</p>"; ?>
<form method="post">
  <input type="text" name="username" placeholder="اسم المستخدم" required><br><br>
  <input type="password" name="password" placeholder="كلمة المرور" required><br><br>
  <button type="submit" style="padding:10px 20px;background:#eec857;border:none;border-radius:8px;">دخول</button>
</form>
<br><a href="index.php">العودة للرئيسية</a>
</body></html>

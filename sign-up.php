<?php require_once 'db.php'; 
$error = $success = "";

if (isset($_POST['signup'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    
    $check = mysqli_query($conn, "SELECT id FROM users WHERE username='$username'");
    if (mysqli_num_rows($check) > 0) {
        $error = "الاسم مستخدم من قبل";
    } else {
        mysqli_query($conn, "INSERT INTO users (username, password) VALUES ('$username', '$password')");
        $success = "تم إنشاء الحساب! جاري تحويلك...";
        $_SESSION['username'] = $username;
        echo "<script>setTimeout(()=>location='index.php', 1500)</script>";
    }
}
?>

<!DOCTYPE html><html dir="rtl" lang="ar"><head><meta charset="UTF-8"><title>إنشاء حساب</title><link rel="stylesheet" href="style.css"></head><body style="text-align:center;padding:50px;">
<h2>إنشاء حساب جديد</h2>
<?php if($error): ?><div class="form-msg error"><?= $error ?></div><?php endif; ?>
<?php if($success): ?><div class="form-msg success"><?= $success ?></div><?php endif; ?>
<form method="post">
  <input type="text" name="username" placeholder="اسم المستخدم" required><br><br>
  <input type="password" name="password" placeholder="كلمة المرور" required><br><br>
  <button type="submit" name="signup" class="submit">تسجيل</button>
</form>
<a href="index.php">العودة للرئيسية</a>
</body></html>

<?php
session_start();
require_once "config.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password_plain = trim($_POST['password']);

    if (empty($username) || empty($password_plain)) {
        $message = "الرجاء إدخال اسم المستخدم وكلمة المرور.";
    } else {
        // البحث عن المستخدم في قاعدة البيانات
        $result = pg_query_params($conn, "SELECT * FROM users WHERE username = $1", [$username]);
        $user = pg_fetch_assoc($result);

        if ($user && password_verify($password_plain, $user['password'])) {
            // تسجيل الجلسة
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];

            // إعادة التوجيه إلى الصفحة الرئيسية
            header("Location: index.php");
            exit;
        } else {
            $message = "اسم المستخدم أو كلمة المرور غير صحيحة.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>تسجيل الدخول</title>
</head>
<body>
    <form method="POST">
        <label>اسم المستخدم:</label>
        <input type="text" name="username" required><br>

        <label>كلمة المرور:</label>
        <input type="password" name="password" required><br>

        <button type="submit">دخول</button>
    </form>

    <?php if (!empty($message)): ?>
        <p style="color:red;"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>
</body>
</html>

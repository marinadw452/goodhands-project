<?php
session_start();
require_once "config.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password_plain = trim($_POST['password']);

    if (empty($username) || empty($password_plain)) {
        $message = "الرجاء إدخال جميع الحقول.";
    } else {
        // التحقق إذا المستخدم موجود
        $check = pg_query_params($conn, "SELECT id FROM users WHERE username = $1", [$username]);

        if (pg_num_rows($check) > 0) {
            $message = "اسم المستخدم موجود بالفعل.";
        } else {
            // تشفير كلمة المرور
            $hashed_password = password_hash($password_plain, PASSWORD_DEFAULT);

            // إدخال المستخدم الجديد
            $result = pg_query_params($conn, "
                INSERT INTO users (username, password) VALUES ($1, $2)
                RETURNING id, username
            ", [$username, $hashed_password]);

            if ($result) {
                $user = pg_fetch_assoc($result);

                // بدء الجلسة مباشرة بعد التسجيل
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];

                // توجيه إلى الصفحة الرئيسية
                header("Location: index.php");
                exit;
            } else {
                $message = "حدث خطأ أثناء إنشاء الحساب: " . pg_last_error($conn);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>تسجيل جديد</title>
</head>
<body>
    <h2>إنشاء حساب جديد</h2>
    <form method="POST">
        <label>اسم المستخدم:</label>
        <input type="text" name="username" required><br>

        <label>كلمة المرور:</label>
        <input type="password" name="password" required><br>

        <button type="submit">تسجيل</button>
    </form>

    <?php if (!empty($message)): ?>
        <p style="color:red;"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>
</body>
</html>

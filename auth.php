<?php
session_start();
require_once "config.php";

$message = "";

// تسجيل الدخول
if (isset($_POST['login'])) {
    $username = trim($_POST['username']);
    $password_plain = trim($_POST['password']);

    if (empty($username) || empty($password_plain)) {
        $message = "الرجاء إدخال جميع الحقول.";
    } else {
        $query = pg_query_params($conn, "SELECT * FROM users WHERE username=$1", [$username]);

        if (pg_num_rows($query) > 0) {
            $user = pg_fetch_assoc($query);

            if (password_verify($password_plain, $user['password'])) {

                // تخزين معلومات الجلسة
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];

                // توجيه حسب نوع الحساب
                if ($user['role'] === "seller") {
                    header("Location: seller_dashboard.php");
                } else {
                    header("Location: index.php");
                }
                exit();
            } else {
                $message = "كلمة المرور غير صحيحة.";
            }
        } else {
            $message = "المستخدم غير موجود.";
        }
    }
}

// إنشاء حساب جديد
if (isset($_POST['signup'])) {
    $username = trim($_POST['username']);
    $password_plain = trim($_POST['password']);
    $role = $_POST['role']; // user أو seller

    if (empty($username) || empty($password_plain)) {
        $message = "الرجاء إدخال جميع الحقول.";
    } else {
        $check = pg_query_params($conn, "SELECT * FROM users WHERE username=$1", [$username]);

        if (pg_num_rows($check) > 0) {
            $message = "اسم المستخدم موجود بالفعل.";
        } else {
            $password_hash = password_hash($password_plain, PASSWORD_DEFAULT);

            pg_query_params($conn,
                "INSERT INTO users (username, password, role) VALUES ($1, $2, $3)",
                [$username, $password_hash, $role]
            );

            $_SESSION['username'] = $username;
            $_SESSION['role'] = $role;

            if ($role === "seller") {
                header("Location: seller_dashboard.php");
            } else {
                header("Location: index.php");
            }
            exit();
        }
    }
}
?>

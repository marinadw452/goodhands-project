<?php
// بدء الجلسة
session_start();

// عند إرسال النموذج
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    // ⚠️ هذا مثال بسيط — لاحقاً استبدله بالتحقق من قاعدة البيانات
    $valid_username = "admin";
    $valid_password = "1234";

    if ($username === $valid_username && $password === $valid_password) {
        $_SESSION['username'] = $username;
        header("Location: MS.php"); // إعادة التوجيه لصفحة المتجر
        exit();
    } else {
        $error = "❌ اسم المستخدم أو كلمة المرور غير صحيحة";
    }
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول | مجتمع الأيادي الطيبة</title>
    <link rel="stylesheet" href="m.css">
    <link rel="stylesheet" href="boxicons/css/boxicons.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: "Poppins", sans-serif;
            direction: rtl;
        }

        #bg-video {
            position: fixed;
            top: 0;
            left: 0;
            min-width: 100%;
            min-height: 100%;
            z-index: -1;
            object-fit: cover;
            filter: brightness(70%);
        }

        .box {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 40px;
            width: 320px;
            box-shadow: 0 4px 30px rgba(0,0,0,0.1);
            color: #fff;
            text-align: center;
        }

        .top-header span {
            font-weight: bold;
            font-size: 1.2em;
        }

        .top-header header {
            font-size: 1em;
            margin-top: 10px;
            opacity: 0.9;
        }

        .input-field {
            position: relative;
            margin: 20px 0;
        }

        .input-field input {
            width: 100%;
            padding: 10px 40px 10px 10px;
            border: none;
            border-radius: 25px;
            outline: none;
            background: rgba(255,255,255,0.8);
        }

        .input-field i {
            position: absolute;
            right: 15px;
            top: 10px;
            color: #555;
        }

        .submit {
            background: #222;
            color: #fff;
            border: none;
            border-radius: 25px;
            padding: 10px;
            width: 100%;
            cursor: pointer;
            transition: 0.3s;
        }

        .submit:hover {
            background: #444;
        }

        .bottom {
            display: flex;
            justify-content: space-between;
            font-size: 0.9em;
            margin-top: 10px;
        }

        a {
            color: #fff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        .error {
            color: #ff4d4d;
            background: rgba(255, 0, 0, 0.1);
            border-radius: 8px;
            padding: 8px;
            margin: 10px 0;
        }
    </style>
</head>
<body>

    <!-- خلفية الفيديو -->
    <video autoplay muted loop id="bg-video">
        <source src="mm.mp4" type="video/mp4">
        متصفحك لا يدعم تشغيل الفيديو.
    </video>

    <!-- محتوى الصفحة -->
    <div class="box">
        <div class="container">
            <div class="top-header">
                <span>تسجيل الدخول</span>
                <header>مرحباً بك في مجتمع الأيادي الطيبة</header>
            </div>

            <!-- رسالة خطأ -->
            <?php if (!empty($error)): ?>
                <div class="error"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="input-field">
                    <input type="text" name="username" class="input" placeholder="اسم المستخدم" required>
                    <i class="bx bx-user"></i>
                </div>

                <div class="input-field">
                    <input type="password" name="password" class="input" placeholder="كلمة المرور" required>
                    <i class="bx bx-lock-alt"></i>
                </div>

                <div class="input-field">
                    <input type="submit" class="submit" value="دخول">
                </div>

                <div class="bottom">
                    <div class="left">
                        <input type="checkbox" id="check">
                        <label for="check">تذكرني</label>
                    </div>
                    <div class="right">
                        <a href="#">نسيت كلمة المرور؟</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

</body>
</html>

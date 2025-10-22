<?php
session_start();
require_once "config.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password_plain = $_POST['password'];

    if (empty($username) || empty($password_plain)) {
        $message = "أدخل اسم مستخدم وكلمة مرور.";
    } else {
        try {
            $stmt = $conn->prepare("SELECT * FROM users WHERE username = :username");
            $stmt->bindParam(':username', $username);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                if (password_verify($password_plain, $user['password'])) {
                    $_SESSION['username'] = $username;
                    header("Location: index.php");
                    exit;
                } else {
                    $message = "كلمة المرور غير صحيحة.";
                }
            } else {
                $password_hashed = password_hash($password_plain, PASSWORD_DEFAULT);
                $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
                $stmt->bindParam(':username', $username);
                $stmt->bindParam(':password', $password_hashed);
                $stmt->execute();
                $_SESSION['username'] = $username;
                header("Location: index.php");
                exit;
            }
        } catch (PDOException $e) {
            $message = "خطأ في قاعدة البيانات: " . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>تسجيل الدخول - أيدي طيبة</title>
  <link rel="stylesheet" href="login.css">
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
</head>
<body>
  <div class="container">
    <div class="form-container">
      <form method="POST">
        <h1>تسجيل الدخول</h1>

        <?php if ($message != ""): ?>
          <p class="message"><?php echo $message; ?></p>
        <?php endif; ?>

        <div class="input-box">
          <input type="text" name="username" placeholder="اسم المستخدم" required>
          <i class="bx bxs-user"></i>
        </div>

        <div class="input-box">
          <input type="password" name="password" placeholder="كلمة المرور" required>
          <i class="bx bxs-lock-alt"></i>
        </div>

        <button type="submit" class="btn">دخول / تسجيل</button>
      </form>
    </div>
  </div>
</body>
</html>

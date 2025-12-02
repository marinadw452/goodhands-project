<?php session_start(); ?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>اتصل بنا - أيدي طيّبة</title>
  <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include 'navbar.php'; ?>

<section class="page-hero" style="background-image:url('images/contact-hero.jpg')">
  <div class="overlay"></div>
  <div class="hero-content">
    <h1>تواصل معنا</h1>
    <p>فريقنا جاهز للرد عليك في أي وقت</p>
  </div>
</section>

<div class="container" style="padding:80px 20px;">
  <div style="display:grid;grid-template-columns:1fr 1fr;gap:50px;max-width:1200px;margin:auto;">

    <!-- نموذج التواصل -->
    <div style="background:white;padding:40px;border-radius:20px;box-shadow:0 15px 40px rgba(0,0,0,0.1);">
      <h2 style="font-size:2.2rem;color:#ba7d37;margin-bottom:20px;">أرسل لنا رسالة</h2>
      <form action="send-message.php" method="post">
        <input type="text" name="name" placeholder="اسمك الكريم" required style="width:100%;padding:16px;margin:12px 0;border-radius:12px;border:1px solid #ddd;">
        <input type="email" name="email" placeholder="بريدك الإلكتروني" required style="width:100%;padding:16px;margin:12px 0;border-radius:12px;border:1px solid #ddd;">
        <textarea name="message" rows="6" placeholder="رسالتك..." required style="width:100%;padding:16px;margin:12px 0;border-radius:12px;border:1px solid #ddd;resize:none;"></textarea>
        <button type="submit" class="btn" style="width:100%;padding:18px;font-size:1.2rem;">إرسال الرسالة</button>
      </form>
    </div>

    <!-- معلومات التواصل -->
    <div style="background:white;padding:40px;border-radius:20px;box-shadow:0 15px 40px rgba(0,0,0,0.1);">
      <h2 style="font-size:2.2rem;color:#ba7d37;margin-bottom:30px;">معلومات التواصل</h2>
      <div style="space-y-20">
        <div style="display:flex;gap:20px;align-items:center;">
          <div style="background:#ffb74d;padding:15px;border-radius:50%;width:60px;height:60px;display:flex;align-items:center;justify-content:center;">
            <span style="font-size:28px;">Email</span>
          </div>
          <div>
            <h4 style="font-weight:bold;color:#5d4037;">البريد الإلكتروني</h4>
            <p>info@goodhands.sa</p>
          </div>
        </div>
        <div style="display:flex;gap:20px;align-items:center;">
          <div style="background:#ffb74d;padding:15px;border-radius:50%;width:60px;height:60px;display:flex;align-items:center;justify-content:center;">
            <span style="font-size:28px;">Phone</span>
          </div>
          <div>
            <h4 style="font-weight:bold;color:#5d4037;">الهاتف</h4>
            <p dir="ltr">+966 50 123 4567</p>
          </div>
        </div>
        <div style="display:flex;gap:20px;align-items:center;">
          <div style="background:#ffb74d;padding:15px;border-radius:50%;width:60px;height:60px;display:flex;align-items:center;justify-content:center;">
            <span style="font-size:28px;">Location</span>
          </div>
          <div>
            <h4 style="font-weight:bold;color:#5d4037;">العنوان</h4>
            <p>الرياض، المملكة العربية السعودية</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include 'footer.php'; ?>
<script src="script.js"></script>
</body>
</html>

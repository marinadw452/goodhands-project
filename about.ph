<?php require_once 'db.php'; // أو خليه موجود عشان السيشن ?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>حول أيدي طيّبة</title>
  <link rel="stylesheet" href="style.css">
  <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;900&display=swap" rel="stylesheet">
</head>
<body>

<?php include 'navbar.php'; // هنعمل ملف منفصل للـ navbar عشان يتكرر ?>

<section style="padding:120px 40px 80px; background:linear-gradient(135deg,#111 0%,#1a1a1a 100%); min-height:100vh;">
  <div style="max-width:1100px; margin:0 auto; text-align:center;">
    <h1 style="font-size:3.8rem; color:#d4a574; margin-bottom:30px;">نحن أيدي طيّبة</h1>
    
    <p style="font-size:1.4rem; line-height:2.2; color:#f5e1c3; max-width:900px; margin:0 auto 50px;">
      مجموعة من طلاب طيبة  
      طيبة مطور الويب تعمل على دعم الأسر المنتجة والأيدي الذهبية والعقول القضية ذات التفكير الفني والإبداعي في مملكتنا الحبيبة.  
      طورنا هذا المتجر للوصول إليهم بشكل أسرع وأكثر سلاسة وأمان.
    </p>

    <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(300px,1fr)); gap:30px; margin-top:60px;">
      <img src="images/handcraft1.jpg" alt="صناعة يدوية" style="width:100%; border-radius:16px; box-shadow:0 10px 30px rgba(0,0,0,0.6);">
      <img src="images/handcraft2.jpg" alt="حرف يدوية" style="width:100%; border-radius:16px; box-shadow:0 10px 30px rgba(0,0,0,0.6);">
      <img src="images/handcraft3.jpg" alt="إبداع سعودي" style="width:100%; border-radius:16px; box-shadow:0 10px 30px rgba(0,0,0,0.6);">
    </div>

    <p style="margin-top:70px; font-size:1.6rem; color:#d4a574;">
      كل قطعة تحكي قصة  
      كل يد تعكس إبداع  
      كل طلب يدعم أسرة
    </p>
  </div>
</section>

<?php include 'footer.php'; // لو تبي فوتر بعدين ?>
<script src="script.js"></script>
<script src="golden-air.js"></script>
</body>
</html>

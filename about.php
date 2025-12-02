<?php session_start(); ?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>حول أيدي طيّبة</title>
  <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include 'navbar.php'; ?>

<section class="page-hero" style="background-image:url('images/about-hero.jpg')">
  <div class="overlay"></div>
  <div class="hero-content">
    <h1>حول أيدي طيّبة</h1>
    <p>منصة تجمع الصناع بالعملاء بكل حب وإبداع</p>
  </div>
</section>

<div class="container" style="padding:80px 20px;">
  <div style="max-width:1100px;margin:auto;background:white;border-radius:20px;overflow:hidden;box-shadow:0 15px 40px rgba(0,0,0,0.1);">
    
    <div style="padding:60px 40px;text-align:center;">
      <h2 style="font-size:3rem;color:#ba7d37;margin-bottom:25px;">من نحن</h2>
      <p style="font-size:1.3rem;line-height:2;color:#5d4037;">
        أيدي طيّبة هي منصة إلكترونية سعودية تهدف إلى دعم الحرفيين والصناع التقليديين، 
        وتوفير منتجات يدوية أصيلة بجودة عالية للعملاء في كل مكان.
        نؤمن أن كل قطعة تحمل روح صانعها وقصة تراثنا العريق.
      </p>
    </div>

    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(300px,1fr));gap:30px;padding:40px;background:#f9f5f0;">
      <div style="background:white;padding:30px;border-radius:16px;text-align:center;box-shadow:0 8px 25px rgba(0,0,0,0.08);">
        <h3 style="color:#ba7d37;font-size:1.8rem;margin-bottom:15px;">جودة مضمونة</h3>
        <p>كل منتج يمر بمراجعة دقيقة قبل عرضه</p>
      </div>
      <div style="background:white;padding:30px;border-radius:16px;text-align:center;box-shadow:0 8px 25px rgba(0,0,0,0.08);">
        <h3 style="color:#ba7d37;font-size:1.8rem;margin-bottom:15px;">دعم الصناع</h3>
        <p>نساعد الحرفيين على التوسع وبيع منتجاتهم</p>
      </div>
      <div style="background:white;padding:30px;border-radius:16px;text-align:center;box-shadow:0 8px 25px rgba(0,0,0,0.08);">
        <h3 style="color:#ba7d37;font-size:1.8rem;margin-bottom:15px;">تجربة سهلة</h3>
        <p>تصفح وشراء بكل راحة وأمان</p>
      </div>
    </div>
  </div>
</div>

<?php include 'footer.php'; ?>
<script src="script.js"></script>
</body>
</html>

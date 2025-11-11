<?php
session_start();
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>حولنا - Good Hands</title>
  <link rel="stylesheet" href="styabout.css">
</head>
<body>

<?php include 'navbar.php'; ?> <!-- لو عندك ملف نافبار منفصل -->

<section class="aboutMe" id="aboutMe">
    <div class="aboutContainer">
        <div class="aboutImage">
            <img src="images/about.jpg" alt="صورة عن مجموعة Good Hands">
        </div>
        <div class="textContainer">
            <h2 class="aboutTitle">من نحن</h2>
            <p class="aboutMePar">
                نحن مجموعة من طلاب طيّبة، مطورين ويب مبدعين، نسعى لدعم الأسر المنتجة والأيادي الذهبية في المملكة.  
                هدفنا هو توفير منصة سهلة وآمنة للوصول إلى منتجاتهم بأسرع وقت وبأعلى جودة.
            </p>
            <a href="index.php" class="btn aboutBtn">العودة للرئيسية</a>
        </div>
    </div>
</section>

</body>
</html>

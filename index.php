<?php 
$page_title = "أيدي طيّبة"; 
include 'includes/header.php'; 
?>

<!-- خلفية الأمواج -->
<canvas id="wave-bg"></canvas>

<!-- Hero مع السلايدر -->
<section class="hero">
  <div class="slider-container">
    <div class="slides">
      <img src="images/4.png" class="slide active" alt="أيدي طيّبة">
      <img src="images/123.png" class="slide" alt="حرف يدوية">
      <img src="images/11.png" class="slide" alt="فخار سعودي">
      <img src="images/14.png" class="slide" alt="إبداع يدوي">
    </div>

    <button class="prev-btn">❮</button>
    <button class="next-btn">❯</button>

    <div class="dots">
      <span class="dot active" data-slide="0"></span>
      <span class="dot" data-slide="1"></span>
      <span class="dot" data-slide="2"></span>
      <span class="dot" data-slide="3"></span>
    </div>
  </div>

  <div class="overlay"></div>
  <div class="hero-content">
    <h1>أيدي طيّبة</h1>
    <p>كل قطعة تحكي قصة صانعها بكل حب وإتقان</p>
    <a href="products.php" class="btn">اكتشف المنتجات</a>
  </div>
</section>

<!-- قسم المنتجات المميزة -->
<section class="featured-products-modern">
  <div class="container">
    <div class="section-header">
      <h2>منتجات مميزة</h2>
      <p>أجمل القطع اليدوية المختارة بعناية لك</p>
    </div>

    <div class="modern-grid">
      <!-- 6 منتجات فقط (نفس الكود اللي عندك) -->
      <div class="modern-card" data-aos="fade-up">
        <div class="card-image">
          <img src="images/products/jacket.jpg" alt="جاكيت شتوي">
          <div class="card-badge">جديد</div>
        </div>
        <div class="card-content">
          <h3>جاكيت شتوي</h3>
          <div class="price">150 ريال</div>
          <button class="add-cart">أضف للسلة</button>
        </div>
      </div>
      <!-- باقي 5 منتجات بنفس الطريقة -->
      <!-- ... (اكمل الكروت الـ 6 زي ما هي) ... -->
    </div>

    <div class="view-all">
      <a href="products.php" class="btn-large">عرض جميع المنتجات</a>
    </div>
  </div>
</section>

<?php include 'includes/footer.php'; ?>

<!-- تحميل المكتبات والملفات الخارجية -->
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

<!-- تحميل الـ CSS والـ JS الخاص بالصفحة الرئيسية فقط -->
<link rel="stylesheet" href="assets/css/slider.css">
<link rel="stylesheet" href="assets/css/home.css">

<script src="assets/js/wave-bg.js"></script>
<script src="assets/js/slider.js"></script>
<script src="assets/js/cart.js"></script>

<script>
// تفعيل AOS فقط في الصفحة الرئيسية
AOS.init({ duration: 1000, once: true });
</script>

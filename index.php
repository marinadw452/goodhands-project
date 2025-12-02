<?php 
$page_title = "أيدي طيّبة"; 
include 'includes/header.php'; 
?>

<!-- Hero Section -->
<section class="hero">
  <div class="slider">
    <img src="images/4.png" class="slide active" alt="">
    <img src="images/123.png" class="slide" alt="">
    <img src="images/11.png" class="slide" alt="">
    <img src="images/14.png" class="slide" alt="">
  </div>
  <div class="overlay"></div>
  <div class="hero-content">
    <h1>أيدي طيّبة</h1>
    <p>كل قطعة تحكي قصة صانعها</p>
    <a href="products.php" class="btn">تصفح المنتجات</a>
  </div>
</section>

<!-- قسم المنتجات المميزة في الصفحة الرئيسية -->
<section class="featured-products">
  <div class="container">
    <h2 style="text-align:center;font-size:3rem;color:#ba7d37;margin:80px 0 60px;">منتجات مميزة</h2>
    
    <div class="products-grid">
      <!-- نفس الكروت اللي في products.php بس 6 فقط -->
      <div class="product-card" data-name="جاكيت شتوي" data-price="150 ريال" data-desc="جاكيت شتوي مصنوع يدويًا من الصوف الناعم، دافئ وأنيق جدًا." data-sizes="M,L,XL">
        <img src="images/products/jacket.jpg" alt="جاكيت شتوي">
        <div class="product-info">
          <h3>جاكيت شتوي</h3>
          <p class="tag">جديد</p>
        </div>
        <div class="product-price">150 ريال</div>
        <button class="add-to-cart-btn">أضف إلى السلة</button>
      </div>

      <div class="product-card" data-name="سوار رجالي" data-price="40 ريال" data-desc="سوار جلد طبيعي مع تفاصيل معدنية، يناسب الإطلالات اليومية والرسمية." data-sizes="صغير,متوسط,كبير">
        <img src="images/products/bracelet.jpg" alt="سوار رجالي">
        <div class="product-info">
          <h3>سوار رجالي</h3>
          <p class="tag">جديد</p>
        </div>
        <div class="product-price">40 ريال</div>
        <button class="add-to-cart-btn">أضف إلى السلة</button>
      </div>

      <div class="product-card" data-name="طاولة ريزن" data-price="119 ريال" data-desc="طاولة ديكور مصنوعة من الريزن الشفاف مع لمسات خشبية، قطعة فنية فريدة." data-sizes="">
        <img src="images/products/table.jpg" alt="طاولة ريزن">
        <div class="product-info">
          <h3>طاولة ريزن</h3>
          <p class="tag">جديد</p>
        </div>
        <div class="product-price">119 ريال</div>
        <button class="add-to-cart-btn">أضف إلى السلة</button>
      </div>

      <div class="product-card" data-name="أكواب فنية" data-price="60 ريال" data-desc="مجموعة أكواب خزف مرسومة يدويًا بتصاميم تراثية سعودية أصيلة." data-sizes="صغير,كبير">
        <img src="images/products/cups.jpg" alt="أكواب فنية">
        <div class="product-info">
          <h3>أكواب فنية</h3>
          <p class="tag">جديد</p>
        </div>
        <div class="product-price">60 ريال</div>
        <button class="add-to-cart-btn">أضف إلى السلة</button>
      </div>

      <div class="product-card" data-name="شنطة كروشيه" data-price="145 ريال" data-desc="شنطة كروشيه ملونة بحياكة يدوية متقنة، عملية وأنيقة." data-sizes="">
        <img src="images/products/bag.jpg" alt="شنطة كروشيه">
        <div class="product-info">
          <h3>شنطة كروشيه</h3>
          <p class="tag">جديد</p>
        </div>
        <div class="product-price">145 ريال</div>
        <button class="add-to-cart-btn">أضف إلى السلة</button>
      </div>

      <div class="product-card" data-name="فستان مطرز" data-price="189 ريال" data-desc="فستان مطرز يدويًا بخيوط حريرية فاخرة، مناسب للمناسبات الخاصة." data-sizes="S,M,L,XL">
        <img src="images/products/dress.jpg" alt="فستان مطرز">
        <div class="product-info">
          <h3>فستان مطرز يدوي</h3>
          <p class="tag">جديد</p>
        </div>
        <div class="product-price">189 ريال</div>
        <button class="add-to-cart-btn">أضف إلى السلة</button>
      </div>
    </div>

    <!-- زر عرض المزيد -->
    <div style="text-align:center;margin-top:60px;">
      <a href="products.php" class="btn" style="padding:18px 50px;font-size:1.4rem;">عرض جميع المنتجات</a>
    </div>
  </div>
</section>

<?php include 'includes/footer.php'; ?>

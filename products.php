<?php 
$page_title = "المنتجات - أيدي طيّبة";
include 'includes/header.php'; 
?>

<!-- Hero صغير للمنتجات -->
<section class="page-hero" style="background:linear-gradient(rgba(0,0,0,0.65),rgba(0,0,0,0.7)), url('images/products-hero.jpg') center/cover no-repeat;">
  <div class="hero-content">
    <h1 style="font-size:4.5rem;">منتجاتنا اليدوية</h1>
    <p style="font-size:1.8rem;">كل قطعة تحكي قصة صانعها</p>
  </div>
</section>

<!-- عداد السلة في الأعلى يسار (ثابت) -->
<div id="cart-count" style="position:fixed;top:100px;left:20px;background:#ffb74d;color:#3e2723;padding:10px 18px;border-radius:50px;font-weight:bold;font-size:17px;z-index:999;box-shadow:0 6px 20px rgba(255,183,77,0.5);">
  السلة: <span id="cart-number">0</span>
</div>

<!-- صفحة المنتجات -->
<div class="container" style="padding:80px 20px 120px;">
  <h2 style="text-align:center;font-size:3rem;color:#ba7d37;margin-bottom:60px;">جديد المنتجات</h2>

  <div class="products-grid">
    <!-- منتج 1 -->
    <div class="product-card" data-name="جاكيت شتوي" data-price="150 ريال" data-desc="جاكيت شتوي مصنوع يدويًا من الصوف الناعم، دافئ وأنيق جدًا." data-sizes="M,L,XL">
      <img src="images/products/jacket.jpg" alt="جاكيت شتوي">
      <div class="product-info">
        <h3>جاكيت شتوي</h3>
        <p class="tag">جديد</p>
      </div>
      <div class="product-price">150 ريال</div>
      <button class="add-to-cart-btn">أضف إلى السلة</button>
    </div>

    <!-- منتج 2 -->
    <div class="product-card" data-name="سوار رجالي" data-price="40 ريال" data-desc="سوار جلد طبيعي مع تفاصيل معدنية، يناسب الإطلالات اليومية والرسمية." data-sizes="صغير,متوسط,كبير">
      <img src="images/products/bracelet.jpg" alt="سوار رجالي">
      <div class="product-info">
        <h3>سوار رجالي</h3>
        <p class="tag">جديد</p>
      </div>
      <div class="product-price">40 ريال</div>
      <button class="add-to-cart-btn">أضف إلى السلة</button>
    </div>

    <!-- منتج 3 -->
    <div class="product-card" data-name="طاولة ريزن" data-price="119 ريال" data-desc="طاولة ديكور مصنوعة من الريزن الشفاف مع لمسات خشبية، قطعة فنية فريدة." data-sizes="">
      <img src="images/products/table.jpg" alt="طاولة ريزن">
      <div class="product-info">
        <h3>طاولة ريزن</h3>
        <p class="tag">جديد</p>
      </div>
      <div class="product-price">119 ريال</div>
      <button class="add-to-cart-btn">أضف إلى السلة</button>
    </div>

    <!-- منتج 4 -->
    <div class="product-card" data-name="أكواب فنية" data-price="60 ريال" data-desc="مجموعة أكواب خزف مرسومة يدويًا بتصاميم تراثية سعودية أصيلة." data-sizes="صغير,كبير">
      <img src="images/products/cups.jpg" alt="أكواب فنية">
      <div class="product-info">
        <h3>أكواب فنية</h3>
        <p class="tag">جديد</p>
      </div>
      <div class="product-price">60 ريال</div>
      <button class="add-to-cart-btn">أضف إلى السلة</button>
    </div>

    <!-- منتج 5 -->
    <div class="product-card" data-name="شنطة كروشيه" data-price="145 ريال" data-desc="شنطة كروشيه ملونة بحياكة يدوية متقنة، عملية وأنيقة." data-sizes="">
      <img src="images/products/bag.jpg" alt="شنطة كروشيه">
      <div class="product-info">
        <h3>شنطة كروشيه</h3>
        <p class="tag">جديد</p>
      </div>
      <div class="product-price">145 ريال</div>
      <button class="add-to-cart-btn">أضف إلى السلة</button>
    </div>

    <!-- منتج 6 -->
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
</div>

<!-- نافذة التفاصيل (Modal) -->
<div id="productModal" class="modal">
  <div class="modal-content">
    <span class="close">×</span>
    <img id="modal-img" src="" alt="">
    <h3 id="modal-title"></h3>
    <p id="modal-price" class="price"></p>
    <p id="modal-desc"></p>
    <div id="modal-sizes" style="margin:20px 0;"></div>
    <button id="modal-add-cart" class="btn">أضف إلى السلة</button>
  </div>
</div>

<?php include 'includes/footer.php'; ?>

<style>
/* تنسيق المنتجات مع ستايل أيدي طيّبة */
.products-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
  gap: 35px;
  max-width: 1400px;
  margin: 0 auto;
}
.product-card {
  background: white;
  border-radius: 20px;
  overflow: hidden;
  box-shadow: 0 10px 30px rgba(0,0,0,0.1);
  transition: all 0.4s ease;
  text-align: center;
}
.product-card:hover {
  transform: translateY(-12px);
  box-shadow: 0 20px 40px rgba(255,183,77,0.25);
}
.product-card img {
  width: 100%;
  height: 320px;
  object-fit: cover;
}
.product-info {
  padding: 18px;
  background: #fbf2e9;
}
.product-info h3 {
  font-size: 1.4rem;
  color: #5d4037;
  margin-bottom: 8px;
}
.tag {
  background: #ffb74d;
  color: #3e2723;
  padding: 4px 12px;
  border-radius: 20px;
  font-size: 0.85rem;
  font-weight: bold;
}
.product-price {
  background: #3e2723;
  color: #ffb74d;
  padding: 12px;
  font-size: 1.4rem;
  font-weight: bold;
}
.add-to-cart-btn {
  width: 100%;
  background: #ffb74d;
  color: #3e2723;
  border: none;
  padding: 16px;
  font-size: 1.1rem;
  font-weight: bold;
  cursor: pointer;
  transition: 0.3s;
}
.add-to-cart-btn:hover {
  background: #ffcc80;
}

/* Modal */
.modal {
  display: none;
  position: fixed;
  top: 0; left: 0; right: 0; bottom: 0;
  background: rgba(0,0,0,0.85);
  z-index: 1000;
  justify-content: center;
  align-items: center;
  padding: 20px;
}
.modal-content {
  background: #fdf9f3;
  color: #333;
  border-radius: 20px;
  max-width: 500px;
  width: 100%;
  padding: 30px;
  text-align: center;
  position: relative;
  box-shadow: 0 20px 50px rgba(0,0,0,0.5);
}
.close {
  position: absolute;
  top: 15px;
  left: 20px;
  font-size: 32px;
  cursor: pointer;
  color: #999;
}
.close:hover { color: #333; }
#modal-img { width: 100%; border-radius: 16px; margin-bottom: 20px; }
#modal-title { font-size: 2rem; color: #ba7d37; margin: 15px 0; }
#modal-price { font-size: 1.8rem; color: #3e2723; font-weight: bold; }
#modal-desc { font-size: 1.1rem; line-height: 1.8; color: #555; margin: 15px 0; }
#modal-sizes select {
  padding: 12px;
  border-radius: 12px;
  border: 2px solid #ba7d37;
  font-size: 1rem;
  width: 100%;
  margin-top: 10px;
}
</style>

<script>
// عداد السلة + Modal
document.addEventListener('DOMContentLoaded', () => {
  let cartCount = 0;
  const cartDisplay = document.getElementById('cart-number');
  const modal = document.getElementById('productModal');
  const closeBtn = document.querySelector('.modal .close');

  // فتح الـ Modal عند الضغط على الكارت
  document.querySelectorAll('.product-card').forEach(card => {
    card.addEventListener('click', (e) => {
      if (e.target.classList.contains('add-to-cart-btn')) return;

      const name = card.dataset.name;
      const price = card.dataset.price;
      const desc = card.dataset.desc;
      const sizes = card.dataset.sizes;
      const img = card.querySelector('img').src;

      document.getElementById('modal-img').src = img;
      document.getElementById('modal-title').textContent = name;
      document.getElementById('modal-price').textContent = price;
      document.getElementById('modal-desc').textContent = desc;

      const sizesDiv = document.getElementById('modal-sizes');
      if (sizes) {
        sizesDiv.innerHTML = `<select><option>اختر المقاس</option>${sizes.split(',').map(s => `<option>${s}</option>`).join('')}</select>`;
      } else {
        sizesDiv.innerHTML = '';
      }

      modal.style.display = 'flex';
    });
  });

  // إضافة للسلة من الكارت أو من الـ Modal
  function addToCart() {
    cartCount++;
    cartDisplay.textContent = cartCount;
    alert('تم إضافة المنتج إلى السلة بنجاح!');
  }

  document.querySelectorAll('.add-to-cart-btn, #modal-add-cart').forEach(btn => {
    btn.addEventListener('click', (e) => {
      e.stopPropagation();
      addToCart();
      modal.style.display = 'none';
    });
  });

  // إغلاق الـ Modal
  closeBtn.onclick = () => modal.style.display = 'none';
  window.onclick = (e) => { if (e.target === modal) modal.style.display = 'none'; };
});
</script>

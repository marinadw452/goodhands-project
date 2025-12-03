<?php 
$page_title = "أيدي طيّبة"; 
include 'includes/header.php'; 
?>

<!-- خلفية الأمواج المتحركة الفخمة (تغطي كامل الصفحة وتنزل معك) -->
<canvas id="wave-bg"></canvas>

<!-- Hero مع الصور القديمة + انتقال ناعم -->
<section class="hero">
  <div class="slider">
    <img src="images/4.png" class="slide active" alt="أيدي طيّبة">
    <img src="images/123.png" class="slide" alt="حرف يدوية">
    <img src="images/11.png" class="slide" alt="فخار سعودي">
    <img src="images/14.png" class="slide" alt="إبداع يدوي">
  </div>
  <div class="overlay"></div>
  <div class="hero-content">
    <h1 class="fade-in">أيدي طيّبة</h1>
    <p class="fade-in delay-1">كل قطعة تحكي قصة صانعها بكل حب وإتقان</p>
    <a href="products.php" class="btn fade-in delay-2">اكتشف المنتجات</a>
  </div>
</section>

<!-- قسم المنتجات المميزة (ستايل متاجر عالمية مثل Etsy + Apple + Shein) -->
<section class="featured-products-modern">
  <div class="container">
    <div class="section-header">
      <h2>منتجات مميزة</h2>
      <p>أجمل القطع اليدوية المختارة بعناية لك</p>
    </div>

    <div class="modern-grid">
      <!-- نفس الكروت لكن بتصميم عصري فخم جدًا -->
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

      <div class="modern-card" data-aos="fade-up" data-aos-delay="100">
        <div class="card-image">
          <img src="images/products/bracelet.jpg" alt="سوار رجالي">
          <div class="card-badge">الأكثر مبيعًا</div>
        </div>
        <div class="card-content">
          <h3>سوار رجالي</h3>
          <div class="price">40 ريال</div>
          <button class="add-cart">أضف للسلة</button>
        </div>
      </div>

      <div class="modern-card" data-aos="fade-up" data-aos-delay="200">
        <div class="card-image">
          <img src="images/products/table.jpg" alt="طاولة ريزن">
          <div class="card-badge">فني</div>
        </div>
        <div class="card-content">
          <h3>طاولة ريزن</h3>
          <div class="price">119 ريال</div>
          <button class="add-cart">أضف للسلة</button>
        </div>
      </div>

      <div class="modern-card" data-aos="fade-up" data-aos-delay="300">
        <div class="card-image">
          <img src="images/products/cups.jpg" alt="أكواب فنية">
          <div class="card-badge">تراثي</div>
        </div>
        <div class="card-content">
          <h3>أكواب فنية</h3>
          <div class="price">60 ريال</div>
          <button class="add-cart">أضف للسلة</button>
        </div>
      </div>

      <div class="modern-card" data-aos="fade-up" data-aos-delay="400">
        <div class="card-image">
          <img src="images/products/bag.jpg" alt="شنطة كروشيه">
          <div class="card-badge">أنثوي</div>
        </div>
        <div class="card-content">
          <h3>شنطة كروشيه</h3>
          <div class="price">145 ريال</div>
          <button class="add-cart">أضف للسلة</button>
        </div>
      </div>

      <div class="modern-card" data-aos="fade-up" data-aos-delay="500">
        <div class="card-image">
          <img src="images/products/dress.jpg" alt="فستان مطرز">
          <div class="card-badge">فاخر</div>
        </div>
        <div class="card-content">
          <h3>فستان مطرز يدوي</h3>
          <div class="price">189 ريال</div>
          <button class="add-cart">أضف للسلة</button>
        </div>
      </div>
    </div>

    <div class="view-all">
      <a href="products.php" class="btn-large">عرض جميع المنتجات</a>
    </div>
  </div>
</section>

<?php include 'includes/footer.php'; ?>

<!-- AOS Animation Library -->
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

<style>
/* الأمواج المتحركة في الخلفية */
#wave-bg {
  position: fixed;
  top: 0; left: 0; width: 100%; height: 100%;
  z-index: 1;
  pointer-events: none;
}

/* تحسين الـ Hero */
.hero { position: relative; z-index: 2; }
.fade-in { opacity: 0; animation: fadeIn 1.2s forwards; }
.delay-1 { animation-delay: 0.5s; }
.delay-2 { animation-delay: 1s; }
@keyframes fadeIn { to { opacity: 1; transform: translateY(0); } }
.slide { transition: opacity 1.8s ease-in-out; }

/* قسم المنتجات المميزة - ستايل متاجر عالمية */
.featured-products-modern {
  position: relative;
  z-index: 2;
  background: #fdf9f3;
  padding: 120px 0;
  margin-top: -80px;
}
.section-header {
  text-align: center;
  margin-bottom: 80px;
}
.section-header h2 {
  font-size: 3.5rem;
  color: #ba7d37;
  margin-bottom: 16px;
}
.section-header p {
  font-size: 1.4rem;
  color: #8b5e2b;
}

.modern-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
  gap: 40px;
  max-width: 1400px;
  margin: 0 auto;
  padding: 0 20px;
}
.modern-card {
  background: white;
  border-radius: 24px;
  overflow: hidden;
  box-shadow: 0 15px 40px rgba(0,0,0,0.08);
  transition: all 0.5s cubic-bezier(0.25, 0.8, 0.25, 1);
}
.modern-card:hover {
  transform: translateY(-20px);
  box-shadow: 0 30px 80px rgba(255, 183, 77, 0.25);
}
.card-image {
  position: relative;
  overflow: hidden;
}
.card-image img {
  width: 100%;
  height: 380px;
  object-fit: cover;
  transition: transform 0.8s ease;
}
.modern-card:hover img {
  transform: scale(1.1);
}
.card-badge {
  position: absolute;
  top: 16px;
  right: 16px;
  background: #ffb74d;
  color: #3e2723;
  padding: 8px 16px;
  border-radius: 50px;
  font-size: 0.9rem;
  font-weight: bold;
  box-shadow: 0 4px 15px rgba(255,183,77,0.4);
}
.card-content {
  padding: 24px;
  text-align: center;
}
.card-content h3 {
  font-size: 1.5rem;
  color: #5d4037;
  margin-bottom: 12px;
}
.price {
  font-size: 1.6rem;
  font-weight: bold;
  color: #ba7d37;
  margin-bottom: 20px;
}
.add-cart {
  background: #ffb74d;
  color: #3e2723;
  border: none;
  padding: 14px 32px;
  border-radius: 50px;
  font-weight: bold;
  font-size: 1.1rem;
  cursor: pointer;
  transition: all 0.3s;
}
.add-cart:hover {
  background: #ffcc80;
  transform: translateY(-3px);
  box-shadow: 0 10px 25px rgba(255,183,77,0.4);
}
.view-all {
  text-align: center;
  margin-top: 80px;
}
.btn-large {
  padding: 20px 60px;
  font-size: 1.5rem;
  background: #3e2723;
  color: #ffb74d;
}
.btn-large:hover {
  background: #5d4037;
}
</style>

<script>
// الأمواج المتحركة (الكود اللي أرسلته + تحسينات)
const canvas = document.getElementById('wave-bg');
const ctx = canvas.getContext('2d');
canvas.width = window.innerWidth;
canvas.height = window.innerHeight;

window.addEventListener('resize', () => {
  canvas.width = window.innerWidth;
  canvas.height = window.innerHeight;
});

const waves = [
  { offset: 0, amplitude: 30, wavelength: 200, speed: 0.0008, color: "rgba(255, 183, 77, 0.15)" },
  { offset: 100, amplitude: 25, wavelength: 180, speed: 0.0012, color: "rgba(186, 125, 55, 0.12)" },
  { offset: 200, amplitude: 35, wavelength: 220, speed: 0.0006, color: "rgba(255, 215, 0, 0.1)" }
];

function drawWaves() {
  ctx.clearRect(0, 0, canvas.width, canvas.height);
  waves.forEach(wave => {
    ctx.beginPath();
    ctx.moveTo(0, canvas.height / 2);
    for (let x = 0; x < canvas.width; x += 4) {
      const y = canvas.height / 2 + 
        Math.sin((x + wave.offset + Date.now() * wave.speed) / wave.wavelength) * wave.amplitude;
      ctx.lineTo(x, y);
    }
    ctx.strokeStyle = wave.color;
    ctx.lineWidth = 3;
    ctx.shadowBlur = 20;
    ctx.shadowColor = wave.color;
    ctx.stroke();
  });
  requestAnimationFrame(drawWaves);
}
drawWaves();

// تفعيل AOS
AOS.init({
  duration: 1000,
  once: true
});

// عداد السلة
let cartCount = 0;
document.querySelectorAll('.add-cart').forEach(btn => {
  btn.addEventListener('click', () => {
    cartCount++;
    document.getElementById('cart-number').textContent = cartCount;
    alert('تمت الإضافة إلى السلة!');
  });
});
</script>

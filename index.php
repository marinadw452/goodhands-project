<?php
$page_title = "أيدي طيّبة";
include 'includes/header.php';
?>

<!-- خلفية الأمواج -->
<canvas id="wave-bg"></canvas>

<style>
/* =========================
   Dropdown
========================= */
.user-dropdown { position: relative; display: inline-block; }
.user-icon-btn { background: transparent; border: 0; cursor: pointer; }
.user-icon {
  width: 40px; height: 40px; border-radius: 50%;
  display: inline-flex; align-items: center; justify-content: center;
  font-weight: 800; background: #111; color: #fff;
}
.user-menu {
  position: absolute; top: 50px; right: 0; left: auto; /* RTL */
  width: 220px; background: #fff; border-radius: 14px;
  box-shadow: 0 18px 40px rgba(0,0,0,.15);
  padding: 10px; display: none; z-index: 999;
}
.user-menu.open { display: block; }
.user-name { margin: 6px 8px 10px; font-weight: 700; }
.menu-link {
  width: 100%; text-align: right;
  display: block; padding: 10px 10px;
  border-radius: 10px; text-decoration: none;
  color: #111; background: transparent; border: 0; cursor: pointer;
  font-family: "Tajawal", sans-serif;
}
.menu-link:hover { background: #f3f3f3; }
.menu-link.danger { color: #b00020; }

/* =========================
   Modal + Scroll Fix
========================= */
.modal { position: fixed; inset: 0; display: none; z-index: 2000; direction: rtl; }
.modal.show { display: block; }
.modal-backdrop { position: fixed; inset: 0; background: rgba(0,0,0,.45); }

.modal-card{
  position: relative;
  width: min(900px, 92vw);
  margin: 9vh auto;
  background: #fff;
  border-radius: 18px;
  box-shadow: 0 30px 70px rgba(0,0,0,.25);
  overflow: hidden;

  max-height: 82vh;
  display: flex;
  flex-direction: column;
}

.modal-head{
  display: flex; align-items: center; justify-content: space-between;
  padding: 14px 16px;
  border-bottom: 1px solid #eee;
}

.modal-x{
  background: transparent;
  border: 0;
  font-size: 26px;
  cursor: pointer;
}

.modal-body{
  padding: 16px;
  overflow-y: auto;
  overflow-x: hidden;
  flex: 1;
}

body.modal-open{ overflow: hidden; }

.modal-actions{
  display: flex;
  justify-content: flex-start;
  gap: 10px;
  margin-bottom: 12px;
}

.btn-small{
  padding: 10px 12px;
  border-radius: 12px;
  border: 0;
  cursor: pointer;
  background: #111;
  color: #fff;
  font-family: "Tajawal", sans-serif;
  font-weight: 700;
}
.btn-small.ghost { background: #f2f2f2; color: #111; }

/* =========================
   Form Styling
========================= */
.product-form{
  border: 1px solid #eee;
  border-radius: 16px;
  padding: 14px;
  background: #fafafa;
  margin-bottom: 12px;
}
.product-form.hidden { display: none; }

.field{ display:block; margin: 10px 0; }
.field span{ display:block; font-weight: 700; margin-bottom: 6px; color:#333; }

.product-form input,
.product-form textarea,
.product-form select{
  width: 100%;
  box-sizing: border-box;
  padding: 10px 12px;
  border-radius: 12px;
  border: 1px solid #ddd;
  outline: none;
  font-family: "Tajawal", sans-serif;
}

textarea{ resize: vertical; }

.form-row{
  display:grid;
  grid-template-columns: 1fr 1fr;
  gap: 12px;
}

@media (max-width: 640px){
  .form-row{ grid-template-columns: 1fr; }
  .modal-card{ margin: 6vh auto; }
}

/* =========================
   Products list (Modal)
========================= */
.products-list { display: grid; gap: 10px; }
.product-item {
  border: 1px solid #eee;
  border-radius: 14px;
  padding: 12px;
  display: flex;
  justify-content: space-between;
  gap: 12px;
  background: #fff;
}
.product-item h4 { margin: 0 0 6px; font-size: 16px; }
.product-meta { font-size: 13px; color: #555; display: flex; gap: 10px; flex-wrap: wrap; }
.product-actions { display: flex; gap: 8px; align-items: center; }
.product-actions button {
  border: 0; cursor: pointer; border-radius: 10px; padding: 8px 10px;
  font-family: "Tajawal", sans-serif; font-weight: 700;
}
.product-actions .edit { background: #f2f2f2; }
.product-actions .del { background: #ffe8ea; color: #b00020; }
.modal-msg { margin-top: 10px; color: #b00020; font-weight: 700; }

/* =========================
   Dynamic categories (Home)
========================= */
.cats-row{ display:flex; gap:10px; flex-wrap:wrap; }
.cat-chip{
  border:1px solid #eee;
  padding:10px 12px;
  border-radius: 999px;
  background:#fff;
  cursor:pointer;
  font-weight:800;
  font-family:"Tajawal", sans-serif;
}
.cat-chip.active{ background:#111; color:#fff; border-color:#111; }

.home-controls{
  display:flex;
  gap:10px;
  flex-wrap:wrap;
  align-items:center;
  justify-content:space-between;
  margin-top:14px;
}
.home-controls .search{
  flex:1;
  min-width:220px;
  border:1px solid #eee;
  padding:12px 14px;
  border-radius: 14px;
  outline:none;
  font-family:"Tajawal", sans-serif;
}

.home-controls .select{
  min-width:180px;
  border:1px solid #eee;
  padding:12px 14px;
  border-radius: 14px;
  outline:none;
  font-family:"Tajawal", sans-serif;
  background:#fff;
}

.home-msg{
  margin-top:10px;
  color:#666;
  font-weight:700;
}
/* =========================
  HOME PRO UI (RTL)
========================= */
:root{
  --bg: #fbf7f2;
  --card: #ffffff;
  --text: #1f2937;
  --muted: #6b7280;
  --line: rgba(31,41,55,.10);
  --shadow: 0 18px 45px rgba(31,41,55,.10);
  --shadow2: 0 10px 25px rgba(31,41,55,.08);
  --brand: #f4a742;     /* ذهبي */
  --brand2:#111827;     /* غامق */
  --radius: 22px;
}

body{ background: var(--bg); }

/* حاوية الأقسام */
.home-section{
  padding: 70px 0;
}

.section-header{
  display:flex;
  align-items:flex-end;
  justify-content:space-between;
  gap:14px;
  margin-bottom: 18px;
}

.section-header h2{
  margin:0;
  font-size: clamp(22px, 3vw, 34px);
  letter-spacing: .2px;
  color: var(--text);
}

.section-header p{
  margin:0;
  color: var(--muted);
  font-weight: 600;
}

/* شريط أدوات البحث/الفلترة */
.home-toolbar{
  display:grid;
  grid-template-columns: 1fr 200px;
  gap: 12px;
  margin-top: 16px;
}

@media (max-width: 720px){
  .home-toolbar{ grid-template-columns: 1fr; }
}

.home-input, .home-select{
  width:100%;
  padding: 14px 16px;
  border-radius: 16px;
  border: 1px solid var(--line);
  background: rgba(255,255,255,.85);
  outline: none;
  font-family: "Tajawal", sans-serif;
  box-shadow: 0 6px 18px rgba(31,41,55,.06);
}
.home-input::placeholder{ color: rgba(31,41,55,.45); }

.home-hint{
  margin-top: 10px;
  color: var(--muted);
  font-weight: 700;
}

/* تصنيفات Chips */
.cats-row{
  display:flex;
  gap: 10px;
  flex-wrap: wrap;
  margin-top: 10px;
}

.cat-chip{
  border:1px solid var(--line);
  padding: 10px 14px;
  border-radius: 999px;
  background: rgba(255,255,255,.85);
  cursor:pointer;
  font-weight: 900;
  font-family:"Tajawal", sans-serif;
  color: var(--text);
  box-shadow: 0 8px 18px rgba(31,41,55,.06);
  transition: .2s ease;
}
.cat-chip:hover{ transform: translateY(-2px); box-shadow: var(--shadow2); }
.cat-chip.active{
  background: linear-gradient(135deg, var(--brand), #ffcc7a);
  border-color: rgba(0,0,0,.04);
}

/* شبكة المنتجات (Responsive) */
.products-grid{
  display:grid;
  grid-template-columns: repeat(12, 1fr);
  gap: 18px;
  margin-top: 18px;
}

.product-card{
  grid-column: span 3;
  background: var(--card);
  border: 1px solid var(--line);
  border-radius: var(--radius);
  box-shadow: var(--shadow2);
  overflow:hidden;
  transition: .22s ease;
  display:flex;
  flex-direction: column;
  min-height: 380px;
}

.product-card:hover{
  transform: translateY(-4px);
  box-shadow: var(--shadow);
}

@media (max-width: 1200px){
  .product-card{ grid-column: span 4; }
}
@media (max-width: 860px){
  .product-card{ grid-column: span 6; }
}
@media (max-width: 520px){
  .product-card{ grid-column: span 12; }
}

/* صورة البطاقة */
.product-media{
  position: relative;
  aspect-ratio: 4 / 3;
  background: #f3f4f6;
}
.product-media img{
  width:100%;
  height:100%;
  object-fit: cover;
  display:block;
}

.product-badge{
  position:absolute;
  top: 12px;
  right: 12px;
  background: rgba(17,24,39,.92);
  color:#fff;
  padding: 8px 10px;
  border-radius: 999px;
  font-weight: 900;
  font-size: 12px;
  border:1px solid rgba(255,255,255,.10);
}

/* محتوى البطاقة */
.product-body{
  padding: 14px 14px 12px;
  display:flex;
  flex-direction: column;
  gap: 10px;
  flex: 1;
}

.product-title{
  margin:0;
  font-size: 18px;
  font-weight: 900;
  color: var(--text);
  line-height: 1.5;
  min-height: 54px;
}

.product-meta{
  display:flex;
  align-items:center;
  justify-content:space-between;
  gap:10px;
  flex-wrap:wrap;
  color: var(--muted);
  font-weight: 700;
  font-size: 13px;
}

.product-price{
  font-size: 18px;
  font-weight: 1000;
  color: var(--text);
}

/* أزرار */
.product-actions{
  margin-top:auto;
  display:flex;
  gap: 10px;
}

.btn-solid{
  flex:1;
  border:0;
  border-radius: 14px;
  padding: 12px 12px;
  font-weight: 1000;
  font-family:"Tajawal", sans-serif;
  cursor:pointer;
  background: linear-gradient(135deg, var(--brand), #ffcc7a);
  color: #111;
  transition: .2s ease;
}
.btn-solid:hover{ filter: brightness(0.98); transform: translateY(-1px); }

.btn-ghost{
  border: 1px solid var(--line);
  border-radius: 14px;
  padding: 12px 12px;
  background: rgba(255,255,255,.9);
  color: var(--text);
  font-weight: 900;
  font-family:"Tajawal", sans-serif;
  cursor:pointer;
}

.home-cta{
  display:flex;
  justify-content:center;
  margin-top: 18px;
}

.home-cta button{
  border:0;
  border-radius: 999px;
  padding: 14px 18px;
  font-weight: 1000;
  font-family:"Tajawal", sans-serif;
  cursor:pointer;
  background: var(--brand2);
  color:#fff;
  box-shadow: var(--shadow2);
}
.home-cta button:disabled{
  opacity:.55;
  cursor:not-allowed;
}

/* منع الفراغات الكبيرة غير المفهومة */
.featured-products-modern .modern-grid{ margin-top: 0 !important; }

</style>

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

<!-- =========================
   تصنيفات + بحث ديناميكي
========================= -->
<section class="featured-products-modern">
  <div class="container">
    <div class="section-header">
      <h2>التصنيفات</h2>
      <p>اختر تصنيفًا لتصفية المنتجات أو ابحث بالاسم</p>
    </div>

    <div class="cats-row" id="categoriesRow"></div>

    <div class="home-controls">
      <input class="search" id="homeSearch" placeholder="ابحث عن منتج (اسم/وصف)..." />
      <select class="select" id="homeLimit">
        <option value="8">عرض 8</option>
        <option value="12" selected>عرض 12</option>
        <option value="24">عرض 24</option>
      </select>
    </div>

    <div class="home-msg" id="homeMsg"></div>
  </div>
</section>

<!-- =========================
   منتجات مميزة (ديناميكي)
========================= -->
<section class="featured-products-modern">
  <div class="container">
    <div class="section-header">
      <h2>منتجات مميزة</h2>
      <p>أجمل القطع اليدوية المختارة بعناية لك</p>
    </div>

    <div class="modern-grid" id="featuredGrid">
      <!-- ديناميكي -->
    </div>

    <div class="view-all">
      <a href="products.php" class="btn-large">عرض جميع المنتجات</a>
    </div>
  </div>
</section>

<!-- =========================
   أحدث المنتجات (ديناميكي)
========================= -->
<section class="featured-products-modern">
  <div class="container">
    <div class="section-header">
      <h2>أحدث المنتجات</h2>
      <p>مضاف حديثًا من حرفيين مميزين</p>
    </div>

    <div class="modern-grid" id="latestGrid">
      <!-- ديناميكي -->
    </div>

    <div class="view-all" style="display:flex;gap:10px;justify-content:center;">
      <button class="btn-large" id="loadMoreBtn" type="button">تحميل المزيد</button>
    </div>
  </div>
</section>

<!-- ===== My Products Modal (كما عندك) ===== -->
<div class="modal" id="myProductsModal" aria-hidden="true">
  <div class="modal-backdrop" data-close="1"></div>

  <div class="modal-card" role="dialog" aria-modal="true" aria-labelledby="modalTitle">
    <div class="modal-head">
      <h3 id="modalTitle">منتجاتي</h3>
      <button class="modal-x" type="button" data-close="1" aria-label="إغلاق">×</button>
    </div>

    <div class="modal-body">
      <div class="modal-actions">
        <button class="btn-small" type="button" id="openAddFormBtn">+ إضافة منتج</button>
      </div>

      <form id="productForm" class="product-form hidden">
        <input type="hidden" name="id" id="p_id">

        <label class="field">
          <span>اسم المنتج</span>
          <input type="text" name="title" id="p_title" required>
        </label>

        <label class="field">
          <span>صورة المنتج (اختياري)</span>
          <input type="file" id="p_image" accept="image/*">
          <small style="display:block;margin-top:6px;color:#666">يفضل JPG/PNG — حجم أقل من 2MB</small>
          <img id="p_preview" style="display:none;margin-top:10px;max-width:180px;border-radius:12px;border:1px solid #eee;">
        </label>

        <label class="field">
          <span>الوصف</span>
          <textarea name="description" id="p_desc" rows="3"></textarea>
        </label>

        <div class="form-row">
          <label class="field">
            <span>السعر</span>
            <input type="number" step="0.01" min="0" name="price" id="p_price" required>
          </label>

          <label class="field">
            <span>المخزون</span>
            <input type="number" min="0" name="stock_qty" id="p_stock" required value="0">
          </label>
        </div>

        <div class="form-row">
          <label class="field">
            <span>التصنيف</span>
            <select name="category_id" id="p_category">
              <option value="">بدون تصنيف</option>
            </select>
          </label>

          <label class="field">
            <span>الحالة</span>
            <select name="status" id="p_status">
              <option value="DRAFT">مسودة</option>
              <option value="PUBLISHED">منشور</option>
              <option value="ARCHIVED">مؤرشف</option>
            </select>
          </label>
        </div>

        <div class="modal-actions">
          <button class="btn-small" type="submit">حفظ</button>
          <button class="btn-small ghost" type="button" id="cancelFormBtn">إلغاء</button>
        </div>
      </form>

      <div id="productsList" class="products-list"></div>
      <div id="modalMsg" class="modal-msg"></div>
    </div>
  </div>
</div>

<?php include 'includes/footer.php'; ?>

<!-- تحميل المكتبات والملفات الخارجية -->
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

<link rel="stylesheet" href="assets/css/slider.css">
<link rel="stylesheet" href="assets/css/home.css">
<link rel="stylesheet" href="assets/css/style.css">

<script src="assets/js/wave-bg.js"></script>
<script src="assets/js/slider.js"></script>
<script src="assets/js/cart.js"></script>
<script>
AOS.init({ duration: 1000, once: true });
</script>



<script>
/**
 * ============================================================
 *  هذا السكربت مسؤول عن:
 *  1) فتح/إغلاق قائمة المستخدم (Dropdown) إن وُجدت في الهيدر
 *  2) تحميل بيانات الصفحة الرئيسية ديناميكياً: التصنيفات + المميز + الأحدث
 *  3) نافذة "منتجاتي" للبائع (Modal) مع CRUD (إضافة/تعديل/حذف) + رفع صورة
 * ============================================================
 */

/* ============================================================
   [1] Dropdown toggle (اذا موجود في header)
   - لو عناصر القائمة موجودة بالـ DOM نفعل عليها الأحداث
============================================================ */
const userMenuBtn = document.getElementById('userMenuBtn'); // زر فتح قائمة المستخدم
const userMenu = document.getElementById('userMenu');       // عنصر القائمة نفسه

// نتأكد أن العناصر موجودة قبل ربط الأحداث حتى لا يحصل خطأ في الصفحات التي لا تحتويها
if (userMenuBtn && userMenu){
  // عند الضغط على زر القائمة: تبديل كلاس open (فتح/إغلاق)
  userMenuBtn.addEventListener('click', () => userMenu.classList.toggle('open'));

  // عند الضغط في أي مكان بالصفحة: إذا لم يكن الضغط داخل .user-dropdown نقفل القائمة
  document.addEventListener('click', (e) => {
    if (!e.target.closest('.user-dropdown')) userMenu.classList.remove('open');
  });
}

/* ============================================================
   [2] HOME Dynamic (Categories + Featured + Latest)
   - حالة الصفحة (state) للتحكم بالبحث والتصنيف والصفحة الحالية والحد (limit)
============================================================ */
let homeState = {
  category_id: null, // التصنيف المختار، null يعني الكل
  q: "",             // نص البحث
  page: 1,           // رقم الصفحة الحالية للـ Latest
  limit: 12          // عدد العناصر في الصفحة الواحدة
};

// عناصر الصفحة الرئيسية
const categoriesRow = document.getElementById("categoriesRow"); // صف شرائح التصنيفات
const featuredGrid = document.getElementById("featuredGrid");   // شبكة المنتجات المميزة
const latestGrid = document.getElementById("latestGrid");       // شبكة أحدث المنتجات
const homeMsg = document.getElementById("homeMsg");             // رسالة حالة/معلومات
const homeSearch = document.getElementById("homeSearch");       // حقل البحث
const homeLimit = document.getElementById("homeLimit");         // اختيار عدد العرض limit
const loadMoreBtn = document.getElementById("loadMoreBtn");     // زر تحميل المزيد

/**
 * دالة حماية من حقن HTML (XSS)
 * - تُحوّل الرموز الخاصة إلى Entities
 * - نستخدمها قبل إدخال قيم المستخدم/الداتا داخل HTML
 */
function escapeHtml(str){
  return String(str ?? '')
    .replaceAll('&','&amp;').replaceAll('<','&lt;')
    .replaceAll('>','&gt;').replaceAll('"','&quot;')
    .replaceAll("'","&#039;");
}

/**
 * إنشاء كارد منتج بصيغة HTML
 * p: كائن المنتج القادم من الـ API
 */
function productCard(p){
  // الصورة الافتراضية إن لم توجد
  const img = p.image_url ? escapeHtml(p.image_url) : "images/products/placeholder.png";

  // بيانات المنتج مع حماية HTML
  const title = escapeHtml(p.title || "");
  const price = escapeHtml(p.price || "0");
  const shop = escapeHtml(p.shop_name || "متجر");
  const cat = escapeHtml(p.category_name || "");

  // ملاحظة: زر السلة يستدعي window.addToCart إن كانت موجودة (اختياري)
  return `
    <div class="modern-card" data-aos="fade-up">
      <div class="card-image">
        <img src="${img}" alt="${title}" onerror="this.src='images/products/placeholder.png'">
        ${cat ? `<div class="card-badge">${cat}</div>` : ``}
      </div>
      <div class="card-content">
        <h3>${title}</h3>
        <div class="price">${price} ريال</div>
        <div style="font-size:13px;color:#666;margin-top:6px;">${shop}</div>
        <button class="add-cart" type="button" onclick="window.addToCart?.(${p.id})">أضف للسلة</button>
      </div>
    </div>
  `;
}

/**
 * إنشاء زر (Chip) للتصنيف
 * - id: رقم التصنيف
 * - name: اسم التصنيف
 * - active: هل هو المحدد حالياً؟
 */
function catChip(id, name, active){
  return `<button type="button" class="cat-chip ${active?'active':''}" data-cat="${id ?? ''}">
    ${escapeHtml(name)}
  </button>`;
}

/**
 * تحميل بيانات الصفحة الرئيسية من home_api.php
 * - reset=true: يعني بدأ من صفحة 1 وإفراغ نتائج latestGrid
 */
async function fetchHomeData({reset=false} = {}){
  // عند إعادة الضبط نرجع للصفحة الأولى ونفرّغ شبكة "الأحدث"
  if(reset){
    homeState.page = 1;
    latestGrid.innerHTML = '';
  }

  // رسالة تحميل للمستخدم
  homeMsg.textContent = "جاري التحميل…";

  // تجهيز باراميترات الطلب
  const params = new URLSearchParams();
  params.set("page", String(homeState.page));
  params.set("limit", String(homeState.limit));
  if(homeState.q) params.set("q", homeState.q);
  if(homeState.category_id) params.set("category_id", String(homeState.category_id));

  // استدعاء API الخاص بالهومي
  const res = await fetch("seller/seller_index/home_api.php?" + params.toString());
  const data = await res.json();

  // في حالة فشل الرد
  if(!data.ok){
    homeMsg.textContent = "تعذر تحميل البيانات.";
    return;
  }

  /* ---------------------------
     (A) Render categories only once
     - نعرض التصنيفات مرة واحدة عند أول تحميل
  ---------------------------- */
  if(categoriesRow && categoriesRow.childElementCount === 0){
    const cats = data.categories || [];

    // زر "الكل" ثم باقي التصنيفات
    categoriesRow.innerHTML =
      catChip("", "الكل", homeState.category_id === null) +
      cats.map(c => catChip(c.id, c.name, String(homeState.category_id||"") === String(c.id))).join("");

    // حدث الضغط على أي شريحة تصنيف (Event Delegation)
    categoriesRow.addEventListener("click", (e) => {
      const btn = e.target.closest(".cat-chip");
      if(!btn) return;

      // قراءة قيمة التصنيف من data-cat (فارغ يعني الكل)
      const cat = btn.getAttribute("data-cat");
      homeState.category_id = cat ? Number(cat) : null;

      // تحديث الحالة النشطة Active
      categoriesRow.querySelectorAll(".cat-chip").forEach(x => x.classList.remove("active"));
      btn.classList.add("active");

      // إعادة تحميل البيانات مع reset
      fetchHomeData({reset:true});
    });
  } else {
    // إذا التصنيفات موجودة بالفعل: فقط نحدّث active حسب homeState
    categoriesRow?.querySelectorAll(".cat-chip").forEach(x => {
      const c = x.getAttribute("data-cat");
      x.classList.toggle(
        "active",
        (homeState.category_id === null && c==="") || (c && String(homeState.category_id)===String(c))
      );
    });
  }

  /* ---------------------------
     (B) Featured
     - عرض المنتجات المميزة
  ---------------------------- */
  featuredGrid.innerHTML = (data.featured || []).map(productCard).join("") ||
    `<p style="color:#666">لا توجد منتجات مميزة حالياً.</p>`;

  /* ---------------------------
     (C) Latest (pagination)
     - عرض أحدث المنتجات مع دعم "تحميل المزيد"
  ---------------------------- */
  const prods = data.products || [];

  // إذا الصفحة الأولى ولا توجد نتائج: رسالة "لا توجد منتجات مطابقة"
  if(homeState.page === 1 && prods.length === 0){
    latestGrid.innerHTML = `<p style="color:#666">لا توجد منتجات مطابقة.</p>`;
  } else {
    // إضافة نتائج جديدة بدون مسح القديمة (append)
    latestGrid.insertAdjacentHTML("beforeend", prods.map(productCard).join(""));
  }

  // معلومات التصفح Pagination
  const pag = data.pagination || {};
  const total = pag.total ?? 0;
  const totalPages = pag.totalPages ?? 1;

  // تحديث الرسالة وزر المزيد
  homeMsg.textContent = `عرض صفحة ${pag.page} من ${totalPages} — إجمالي ${total} منتج`;
  loadMoreBtn.disabled = (homeState.page >= totalPages);
  loadMoreBtn.textContent = loadMoreBtn.disabled ? "لا يوجد المزيد" : "تحميل المزيد";
}

/* ---------------------------
   أحداث التحكم بالبحث والحد والتحميل
---------------------------- */

// البحث: عند الضغط Enter فقط
homeSearch?.addEventListener("keyup", (e) => {
  if(e.key === "Enter"){
    homeState.q = homeSearch.value.trim();
    fetchHomeData({reset:true});
  }
});

// تغيير عدد العناصر المعروضة بالصفحة
homeLimit?.addEventListener("change", () => {
  homeState.limit = Number(homeLimit.value || 12);
  fetchHomeData({reset:true});
});

// زر تحميل المزيد: يزيد page ثم يطلب بيانات جديدة بدون reset
loadMoreBtn?.addEventListener("click", () => {
  homeState.page += 1;
  fetchHomeData({reset:false});
});

// تحميل أولي عند فتح الصفحة
fetchHomeData({reset:true});

/* ============================================================
   [3] My Products Modal + CRUD
   - يعتمد على:
     seller_products_api.php  (JSON POST actions)
     seller_product_upload.php (رفع الصورة)
============================================================ */

// عناصر المودال والقائمة والنموذج
const modal = document.getElementById('myProductsModal');     // نافذة المودال
const myProductsBtn = document.getElementById('myProductsBtn'); // زر فتح "منتجاتي"
const productsList = document.getElementById('productsList'); // قائمة المنتجات داخل المودال
const modalMsg = document.getElementById('modalMsg');         // رسالة حالة داخل المودال

// أزرار ونموذج الإضافة/التعديل
const openAddFormBtn = document.getElementById('openAddFormBtn'); // زر "إضافة منتج"
const productForm = document.getElementById('productForm');       // الفورم
const cancelFormBtn = document.getElementById('cancelFormBtn');   // زر إلغاء

// حقول النموذج
const p_id = document.getElementById('p_id');           // حقل مخفي/ID للتمييز بين إنشاء وتحديث
const p_title = document.getElementById('p_title');     // عنوان المنتج
const p_image = document.getElementById('p_image');     // ملف الصورة
const p_preview = document.getElementById('p_preview'); // معاينة الصورة
const p_desc = document.getElementById('p_desc');       // وصف المنتج
const p_price = document.getElementById('p_price');     // السعر
const p_stock = document.getElementById('p_stock');     // المخزون
const p_category = document.getElementById('p_category'); // التصنيف
const p_status = document.getElementById('p_status');     // الحالة (DRAFT / PUBLISHED ...)

// فتح المودال: إظهار + تحميل التصنيفات + تحميل منتجات البائع
function openModal(){
  modal.classList.add('show');
  modal.setAttribute('aria-hidden','false');
  document.body.classList.add('modal-open'); // منع تمرير الخلفية غالباً
  modalMsg.textContent = '';

  hideForm();         // نخفي النموذج بدايةً
  loadCategories();   // نحمّل التصنيفات للـ select
  loadMyProducts();   // نحمّل قائمة المنتجات
}

// إغلاق المودال: إزالة الكلاسات وإخفاء النموذج
function closeModal(){
  modal.classList.remove('show');
  modal.setAttribute('aria-hidden','true');
  document.body.classList.remove('modal-open');
  hideForm();
}

/**
 * إظهار النموذج
 * edit=false: وضع إضافة
 * edit=true: وضع تعديل (لا نصفر القيم هنا لأننا سنملأها من المنتج)
 */
function showForm(edit=false){
  productForm.classList.remove('hidden');

  // وضع الإضافة: تصفير الحقول
  if(!edit){
    p_id.value = '';
    p_title.value = '';
    p_desc.value = '';
    p_price.value = '';
    p_stock.value = 0;
    p_status.value = 'DRAFT';

    // إعادة ضبط الصورة والمعاينة
    p_image.value = '';
    p_preview.style.display = 'none';
    p_preview.src = '';

    // تحميل التصنيفات بدون تحديد تصنيف مسبق
    loadCategories(null);
  }

  // تمرير المستخدم إلى النموذج لسهولة الاستخدام
  productForm.scrollIntoView({behavior:'smooth', block:'start'});
}

// إخفاء النموذج
function hideForm(){ productForm.classList.add('hidden'); }

// زر فتح "منتجاتي"
if (myProductsBtn){
  myProductsBtn.addEventListener('click', () => openModal());
}

// إغلاق المودال عند الضغط على أي عنصر يحمل data-close (مثل زر X أو الخلفية)
modal.addEventListener('click', (e) => {
  if (e.target.dataset.close) closeModal();
});

// زر "إضافة منتج" => إظهار النموذج بوضع الإضافة
openAddFormBtn?.addEventListener('click', ()=> showForm(false));
// زر إلغاء => إخفاء النموذج
cancelFormBtn?.addEventListener('click', hideForm);

/**
 * دالة عامة للتواصل مع seller_products_api.php
 * - ترسل JSON payload وتستقبل JSON response
 */
async function api(payload){
  const res = await fetch('seller/seller_index/seller_products_api.php', {
    method: 'POST',
    headers: {'Content-Type':'application/json'},
    body: JSON.stringify(payload)
  });
  return res.json();
}

/**
 * معاينة الصورة عند اختيار ملف
 * - نستخدم URL.createObjectURL لعرض معاينة قبل الرفع
 */
p_image?.addEventListener('change', () => {
  const file = p_image.files?.[0];
  if (!file) {
    p_preview.style.display = 'none';
    p_preview.src = '';
    return;
  }
  p_preview.src = URL.createObjectURL(file);
  p_preview.style.display = 'block';
});

/**
 * رفع الصورة إلى seller_product_upload.php
 * - لا يرفع إذا لم يحدد المستخدم ملف
 * - يُرسل FormData لأن فيها ملف
 */
async function uploadImage(productId){
  const file = p_image.files?.[0];
  if (!file) return { ok:true, skipped:true }; // لا توجد صورة => اعتبرها ناجحة مع تخطي

  const fd = new FormData();
  fd.append('product_id', productId);
  fd.append('image', file);

  const res = await fetch('seller/seller_index/seller_product_upload.php', { method:'POST', body: fd });
  return res.json();
}

/**
 * تحميل التصنيفات وملؤها في select
 * selectedId: (اختياري) لتحديد تصنيف معين في وضع التعديل
 */
async function loadCategories(selectedId=null){
  const data = await api({action:'categories'});

  // في حال فشل التحميل: ضع خيار افتراضي فقط
  if(!data.ok){
    p_category.innerHTML = '<option value="">بدون تصنيف</option>';
    return;
  }

  const cats = data.items || [];
  p_category.innerHTML = [
    `<option value="">بدون تصنيف</option>`,
    ...cats.map(c => `<option value="${c.id}">${escapeHtml(c.name)}</option>`)
  ].join('');

  // إذا تم تمرير selectedId نحدده في القائمة
  if(selectedId !== null && selectedId !== undefined){
    p_category.value = String(selectedId);
  }
}

/**
 * تحميل منتجات البائع وعرضها في productsList
 */
async function loadMyProducts(){
  productsList.innerHTML = 'جاري التحميل...';

  const data = await api({action:'list'});
  if (!data.ok){
    productsList.innerHTML = '';
    modalMsg.textContent = data.error || 'تعذر تحميل المنتجات';
    return;
  }

  renderProducts(data.items || []);
}

/**
 * رسم/عرض قائمة المنتجات داخل المودال
 * - يضيف أزرار تعديل/حذف مع أحداثها
 */
function renderProducts(items){
  // لا توجد منتجات
  if(!items.length){
    productsList.innerHTML = '<p>لا توجد منتجات بعد. اضغط "إضافة منتج".</p>';
    return;
  }

  // بناء HTML لكل منتج
  productsList.innerHTML = items.map(p => {
    // صورة المنتج أو بديل "بدون صورة"
    const imgHtml = p.image_url
      ? `<img src="${escapeHtml(p.image_url)}" alt="${escapeHtml(p.title)}"
              style="width:70px;height:70px;object-fit:cover;border-radius:14px;border:1px solid #eee;">`
      : `<div style="width:70px;height:70px;border-radius:14px;border:1px dashed #ddd;
                    display:flex;align-items:center;justify-content:center;color:#999;font-size:12px;">
          بدون صورة
        </div>`;

    // نخزن بيانات المنتج كاملة في data-edit بعد ترميزها
    // (حتى نستعملها عند الضغط على زر التعديل)
    return `
      <div class="product-item" style="align-items:center;">
        <div style="display:flex;gap:12px;align-items:center;">
          ${imgHtml}
          <div>
            <h4>${escapeHtml(p.title)}</h4>
            <div class="product-meta">
              <span>السعر: ${escapeHtml(p.price)} ريال</span>
              <span>المخزون: ${escapeHtml(p.stock_qty)}</span>
              <span>الحالة: ${escapeHtml(p.status)}</span>
              <span>التصنيف: ${p.category_name ? escapeHtml(p.category_name) : '-'}</span>
            </div>
          </div>
        </div>

        <div class="product-actions">
          <button class="edit" type="button" data-edit='${encodeURIComponent(JSON.stringify(p))}'>تعديل</button>
          <button class="del" type="button" data-del="${p.id}">حذف</button>
        </div>
      </div>
    `;
  }).join('');

  /* ---------------------------
     زر التعديل:
     - يقرأ المنتج من data-edit
     - يفتح النموذج
     - يملأ الحقول
  ---------------------------- */
  productsList.querySelectorAll('[data-edit]').forEach(btn=>{
    btn.addEventListener('click', ()=>{
      const p = JSON.parse(decodeURIComponent(btn.getAttribute('data-edit')));

      showForm(true); // وضع تعديل

      // تعبئة الحقول من بيانات المنتج
      p_id.value = p.id;
      p_title.value = p.title || '';
      p_desc.value = p.description || '';
      p_price.value = p.price || 0;
      p_stock.value = p.stock_qty || 0;
      p_status.value = p.status || 'DRAFT';

      // الصورة لا نملأ input file (المتصفح يمنع ذلك)، فنصفره ونخفي المعاينة
      p_image.value = '';
      p_preview.style.display = 'none';
      p_preview.src = '';

      // تحميل التصنيفات وتحديد تصنيف المنتج الحالي
      loadCategories(p.category_id);
    });
  });

  /* ---------------------------
     زر الحذف:
     - تأكيد
     - إرسال delete للـ API
     - ثم إعادة تحميل القائمة
  ---------------------------- */
  productsList.querySelectorAll('[data-del]').forEach(btn=>{
    btn.addEventListener('click', async ()=>{
      const id = btn.getAttribute('data-del');
      if(!confirm('هل أنت متأكد من حذف المنتج؟')) return;

      const data = await api({action:'delete', id});
      if(!data.ok){
        modalMsg.textContent = data.error || 'فشل الحذف';
        return;
      }

      modalMsg.textContent = '';
      loadMyProducts();
    });
  });
}

/**
 * إرسال نموذج الإضافة/التعديل
 * - يمنع الإرسال الافتراضي
 * - يحدد هل هو create أو update حسب وجود p_id
 * - يرفع الصورة بعد الحفظ (لو موجودة)
 */
productForm?.addEventListener('submit', async (e)=>{
  e.preventDefault();
  modalMsg.textContent = '';

  // إذا كان لدينا ID => تحديث، وإلا إنشاء جديد
  const isUpdate = !!p_id.value;

  // تجهيز الحمولة للـ API
  const payload = {
    action: isUpdate ? 'update' : 'create',
    id: p_id.value || null,
    title: p_title.value,
    description: p_desc.value,
    price: p_price.value,
    stock_qty: p_stock.value,
    category_id: p_category.value || null,
    status: p_status.value
  };

  // حفظ البيانات الأساسية (بدون الصورة)
  const data = await api(payload);
  if(!data.ok){
    modalMsg.textContent = data.error || 'فشل الحفظ';
    return;
  }

  // تحديد رقم المنتج الذي تم حفظه:
  // - في التحديث: موجود أصلاً
  // - في الإنشاء: يأتي من data.id
  const productId = isUpdate ? Number(p_id.value) : Number(data.id);

  // رفع الصورة إن وجدت
  const up = await uploadImage(productId);
  if(!up.ok){
    // المنتج محفوظ لكن فشل رفع الصورة
    modalMsg.textContent = up.error || 'تم حفظ المنتج لكن فشل رفع الصورة';
  }

  // تنظيف حقل الصورة والمعاينة
  p_image.value = '';
  p_preview.style.display = 'none';
  p_preview.src = '';

  // إخفاء النموذج وتحديث القائمة
  hideForm();
  loadMyProducts();
});
</script>

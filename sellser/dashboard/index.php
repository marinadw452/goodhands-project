<?php
// seller_orders.php
session_start();
require_once "../../config.php";

// تحقق تسجيل دخول البائع
if (!isset($_SESSION['seller_id'])) {
  header("Location: login.php");
  exit;
}
?>
<!doctype html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>لوحة البائع - الطلبات</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

<style>
  :root{
    --bg1:#f7f8fc;
    --bg2:#eef2ff;
    --card:#ffffff;
    --card2:#f7f9ff;
    --stroke: rgba(15, 23, 42, .10);
    --text: rgba(15, 23, 42, .92);
    --muted: rgba(15, 23, 42, .62);
    --gold:#ffb84d;
    --gold2:#ff8a4d;
    --good:#14b8a6;
    --danger:#fb7185;
    --info:#3b82f6;
    --warn:#f59e0b;
  }

  body{
    background:
      radial-gradient(900px 450px at 85% -10%, rgba(255,184,77,.25), transparent 60%),
      radial-gradient(900px 450px at 10% 0%, rgba(59,130,246,.12), transparent 55%),
      linear-gradient(180deg, var(--bg1), var(--bg2));
    color: var(--text);
    min-height: 100vh;
  }

  .glass{
    background: linear-gradient(180deg, var(--card), rgba(255,255,255,.7));
    border: 1px solid var(--stroke);
    border-radius: 1.25rem;
    box-shadow: 0 16px 45px rgba(15,23,42,.10);
    backdrop-filter: blur(6px);
  }

  .soft{
    background: var(--card2);
    border: 1px solid var(--stroke);
    border-radius: 1rem;
  }

  .badge-soft{
    border: 1px solid var(--stroke);
    background: rgba(15,23,42,.03);
    color: var(--text);
    padding: .45rem .65rem;
    border-radius: 999px;
    font-weight: 800;
    white-space: nowrap;
  }

  .stat{
    display:flex; align-items:center; justify-content:space-between; gap:1rem;
    padding: 1rem 1.1rem;
  }

  .stat .icon{
    width: 46px; height: 46px; display:grid; place-items:center;
    border-radius: 14px;
    background: rgba(255,184,77,.18);
    border: 1px solid rgba(255,184,77,.35);
    color: #b45309;
    font-size: 1.25rem;
  }

  .table thead th{
    color: rgba(15,23,42,.65);
    font-weight: 900;
    border-bottom: 1px solid var(--stroke);
    white-space: nowrap;
  }

  .table tbody td{
    border-color: rgba(15,23,42,.08);
    vertical-align: middle;
    color: var(--text);
  }

  .btn-gold{
    background: linear-gradient(135deg, var(--gold), var(--gold2));
    border: none;
    color: #1b1b1b;
    font-weight: 900;
    border-radius: 999px;
    box-shadow: 0 14px 28px rgba(255,138,77,.20);
  }

  .btn-outline-soft{
    border: 1px solid var(--stroke);
    color: var(--text);
    border-radius: 999px;
    background: rgba(255,255,255,.7);
  }
  .btn-outline-soft:hover{
    background: rgba(255,255,255,.9);
    border-color: rgba(15,23,42,.16);
    color: var(--text);
  }

  .form-control, .form-select{
    background: rgba(255,255,255,.95);
    border: 1px solid var(--stroke);
    color: var(--text);
    border-radius: 12px;
  }
  .form-control::placeholder{ color: rgba(15,23,42,.35); }

  .modal-content{
    background: linear-gradient(180deg, rgba(255,255,255,.96), rgba(248,250,252,.96));
    border: 1px solid var(--stroke);
    color: var(--text);
    border-radius: 1.25rem;
    box-shadow: 0 22px 70px rgba(15,23,42,.18);
    backdrop-filter: blur(10px);
  }

  .muted{ color: var(--muted); }
  .mono{ font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace; }

  .product-thumb{
    width: 42px;
    height: 42px;
    border-radius: 12px;
    object-fit: cover;
    border: 1px solid rgba(15,23,42,.10);
    background: rgba(15,23,42,.03);
  }

  /* مهم: جدول Bootstrap dark كان يجعل الخلفية داكنة — نعيده فاتح */
  .table-dark{
    --bs-table-bg: transparent;
    --bs-table-striped-bg: rgba(15,23,42,.02);
    --bs-table-hover-bg: rgba(15,23,42,.04);
    --bs-table-color: var(--text);
  }

  /* badge ألوان Bootstrap على خلفية فاتحة */
  .badge.text-bg-secondary{ background: rgba(100,116,139,.18)!important; color:#0f172a!important; }
  .badge.text-bg-info{ background: rgba(59,130,246,.18)!important; color:#0f172a!important; }
  .badge.text-bg-warning{ background: rgba(245,158,11,.22)!important; color:#0f172a!important; }
  .badge.text-bg-success{ background: rgba(20,184,166,.18)!important; color:#0f172a!important; }
  .badge.text-bg-danger{ background: rgba(251,113,133,.18)!important; color:#0f172a!important; }
    
/* اجعل المودال يأخذ ارتفاع الشاشة مع سكرول داخلي */
#addProductModal .modal-dialog{
  height: calc(100vh - 2rem);
  margin: 1rem auto;
}

#addProductModal .modal-content{
  max-height: calc(100vh - 2rem);
  overflow: hidden;           /* نخلي السكرول داخل body فقط */
}

#addProductModal .modal-body{
  overflow-y: auto !important; /* هذا هو السكرول الحقيقي */
  max-height: calc(100vh - 190px); /* يترك مساحة للهيدر+الفوتر */
}

/* فوتر ثابت عشان زر الحفظ يكون ظاهر دائمًا */
#addProductModal .modal-footer{
  position: sticky;
  bottom: 0;
  background: #fff;
  border-top: 1px solid rgba(15,23,42,.10);
  z-index: 10;
}



</style>

</head>

<body>
  <div class="container py-4 py-lg-5">

    <!-- Header -->
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
      <div>
        <h3 class="mb-1 fw-bold">لوحة البائع — الطلبات</h3>
        <div class="muted">تابع طلبات منتجاتك، حدّث الحالة، وحدد تاريخ التسليم المتوقع.</div>
      </div>
      <div class="d-flex gap-2">
        <a class="btn btn-outline-soft px-3" href="../../index.php?seller-panel">
          <i class="bi bi-house-door"></i> الرئيسية
        </a>
        <a class="btn btn-gold px-4" href="#add_pro" data-bs-toggle="modal" data-bs-target="#addProductModal">
          <i class="bi bi-plus-circle"></i> إضافة منتج
        </a>
      </div>
    </div>

    <!-- Stats -->
    <div class="row g-3 mb-3">
      <div class="col-12 col-md-4">
        <div class="glass stat">
          <div>
            <div class="muted mb-1">إجمالي الطلبات</div>
            <div class="fs-3 fw-black" id="st_total">—</div>
          </div>
          <div class="icon"><i class="bi bi-bag-check"></i></div>
        </div>
      </div>

      <div class="col-12 col-md-4">
        <div class="glass stat">
          <div>
            <div class="muted mb-1">قيد التجهيز (مدفوع)</div>
            <div class="fs-3 fw-black" id="st_processing">—</div>
          </div>
          <div class="icon" style="background: rgba(96,165,250,.14); border-color: rgba(96,165,250,.25); color: var(--info);">
            <i class="bi bi-credit-card-2-front"></i>
          </div>
        </div>
      </div>

      <div class="col-12 col-md-4">
        <div class="glass stat">
          <div>
            <div class="muted mb-1">متأخرة (تجاوزت المتوقع)</div>
            <div class="fs-3 fw-black" id="st_late">—</div>
          </div>
          <div class="icon" style="background: rgba(251,113,133,.14); border-color: rgba(251,113,133,.25); color: var(--danger);">
            <i class="bi bi-exclamation-triangle"></i>
          </div>
        </div>
      </div>
    </div>

    <!-- Filters -->
    <div class="glass p-3 p-lg-4 mb-3">
      <div class="row g-3 align-items-end">
        <div class="col-12 col-lg-4">
          <label class="form-label muted">بحث (رقم الطلب / اسم المشتري)</label>
          <input id="q" class="form-control" placeholder="مثال: 1024 أو محمد">
        </div>

        <div class="col-12 col-lg-3">
          <label class="form-label muted">الحالة (الخاصة بك)</label>
          <select id="status" class="form-select">
            <option value="">الكل</option>
            <option value="PENDING">قيد الانتظار</option>
            <option value="PAID">مدفوع</option>
            <option value="SHIPPED">تم الشحن</option>
            <option value="DELIVERED">تم التسليم</option>
            <option value="CANCELLED">ملغي</option>
          </select>
        </div>

        <div class="col-12 col-lg-3">
          <label class="form-label muted">الترتيب</label>
          <select id="sort" class="form-select">
            <option value="newest">الأحدث</option>
            <option value="oldest">الأقدم</option>
            <option value="delivery_soon">الأقرب تسليمًا</option>
          </select>
        </div>

        <div class="col-12 col-lg-2 d-grid">
          <button id="btnRefresh" class="btn btn-gold">
            <i class="bi bi-arrow-repeat"></i> تحديث
          </button>
        </div>
      </div>
    </div>

    <!-- Orders table -->
    <div class="glass p-0 overflow-hidden">
      <div class="p-3 border-bottom" style="border-color: rgba(255,255,255,.12)!important;">
        <div class="d-flex justify-content-between align-items-center">
          <div class="fw-bold">طلبات منتجاتك</div>
          <div class="muted small" id="lastSync">—</div>
        </div>
      </div>

      <div class="table-responsive">
        <table class="table table-dark table-hover align-middle mb-0">
          <thead>
            <tr>
              <th>#</th>
              <th>الطلب</th>
              <th>المشتري</th>
              <th>إجمالي (منتجاتي)</th>
              <th>حالتي</th>
              <th>التسليم المتوقع</th>
              <th>متبقي</th>
              <th class="text-end">إجراءات</th>
            </tr>
          </thead>
          <tbody id="rows">
            <tr><td colspan="8" class="text-center p-4 muted">جارِ التحميل…</td></tr>
          </tbody>
        </table>
      </div>

      <div class="p-3 d-flex justify-content-between align-items-center border-top" style="border-color: rgba(255,255,255,.12)!important;">
        <div class="muted small" id="pagingInfo">—</div>
        <div class="d-flex gap-2">
          <button class="btn btn-outline-soft btn-sm" id="prevPage" title="السابق"><i class="bi bi-chevron-right"></i></button>
          <button class="btn btn-outline-soft btn-sm" id="nextPage" title="التالي"><i class="bi bi-chevron-left"></i></button>
        </div>
      </div>
    </div>

  </div>

  <!-- Details Modal -->
  <div class="modal fade" id="orderModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <div>
            <div class="fw-bold">تفاصيل الطلب</div>
            <div class="muted small">هذه التفاصيل تخص منتجاتك داخل الطلب فقط.</div>
          </div>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <div class="row g-3">
            <div class="col-12 col-md-6">
              <div class="soft p-3">
                <div class="muted small mb-1">رقم الطلب</div>
                <div class="fw-bold mono" id="m_order_no">—</div>

                <hr style="border-color: rgba(255,255,255,.12);">

                <div class="muted small mb-1">المشتري</div>
                <div class="fw-bold" id="m_buyer">—</div>
                <div class="muted small" id="m_buyer_email">—</div>

                <div class="muted small mt-3 mb-1">عنوان الشحن</div>
                <div class="muted" id="m_address">—</div>
                <div class="muted small mt-2" id="m_phone">—</div>

                <hr style="border-color: rgba(255,255,255,.12);">

                <div class="d-flex justify-content-between align-items-center">
                  <div class="muted small">إجمالي منتجاتي داخل الطلب</div>
                  <div class="badge-soft" id="m_total">—</div>
                </div>
              </div>
            </div>

            <div class="col-12 col-md-6">
              <div class="soft p-3">
                <div class="row g-2">
                  <div class="col-12">
                    <label class="form-label muted">الحالة (الخاصة بك)</label>
                    <select id="m_status" class="form-select">
                      <option value="PENDING">قيد الانتظار</option>
                      <option value="PAID">مدفوع (جاهز للتجهيز)</option>
                      <option value="SHIPPED">تم الشحن</option>
                      <option value="DELIVERED">تم التسليم</option>
                      <option value="CANCELLED">ملغي</option>
                    </select>
                    <div class="muted small mt-1">لن تؤثر على بقية البائعين في نفس الطلب.</div>
                  </div>

                  <div class="col-12">
                    <label class="form-label muted">تاريخ التسليم المتوقع</label>
                    <input type="date" id="m_expected" class="form-control">
                    <div class="muted small mt-1">يساعد على حساب “متبقي/متأخر”.</div>
                  </div>

                  <div class="col-12">
                    <div class="soft p-3 mt-2">
                      <div class="muted small mb-1">حالة الطلب العامة (للعلم فقط)</div>
                      <div class="fw-bold" id="m_order_status_global">—</div>
                      <div class="muted small mt-2">الإجمالي العام للطلب: <span class="mono" id="m_total_global">—</span></div>
                    </div>
                  </div>

                </div>
              </div>
            </div>

            <div class="col-12">
              <div class="soft p-3">
                <div class="fw-bold mb-2">العناصر الخاصة بك</div>
                <div class="table-responsive">
                  <table class="table table-dark table-sm mb-0">
                    <thead>
                      <tr>
                        <th>صورة</th>
                        <th>المنتج</th>
                        <th>الكمية</th>
                        <th>سعر الوحدة</th>
                        <th>الإجمالي</th>
                      </tr>
                    </thead>
                    <tbody id="m_items"></tbody>
                  </table>
                </div>
              </div>
            </div>

          </div>
        </div>

        <div class="modal-footer">
          <input type="hidden" id="m_order_id" value="">
          <button class="btn btn-outline-soft" data-bs-dismiss="modal">إغلاق</button>
          <button class="btn btn-gold" id="btnSave">
            <i class="bi bi-save2"></i> حفظ
          </button>
        </div>
      </div>
    </div>
  </div>
    
    
<!-- Add Product Modal -->
<div class="modal fade" id="addProductModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <div>
          <div class="fw-bold fs-5">إضافة منتج جديد</div>
          <div class="muted small">املأ البيانات وارفع الصور ثم انشر المنتج أو احفظه كمسودة.</div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form id="addProductForm" enctype="multipart/form-data">
        <div class="modal-body">
          <div class="row g-3">

            <!-- Left: Form -->
            <div class="col-12 col-lg-7">
              <div class="soft p-3">
                <div class="row g-3">

                  <div class="col-12">
                    <label class="form-label muted">عنوان المنتج *</label>
                    <input name="title" class="form-control" maxlength="160" required placeholder="مثال: حقيبة جلد يدوي">
                  </div>

                  <div class="col-12">
                    <label class="form-label muted">وصف المنتج</label>
                    <textarea name="description" class="form-control" rows="5" placeholder="وصف مختصر ومقنع..."></textarea>
                  </div>

                  <div class="col-12 col-md-6">
                    <label class="form-label muted">التصنيف</label>
                    <select name="category_id" class="form-select" id="categorySelect">
                      <option value="">— اختر تصنيف —</option>
                    </select>
                  </div>

                  <div class="col-12 col-md-6">
                    <label class="form-label muted">الحالة</label>
                    <select name="status" class="form-select">
                      <option value="DRAFT">مسودة (DRAFT)</option>
                      <option value="PUBLISHED">منشور (PUBLISHED)</option>
                    </select>
                  </div>

                  <div class="col-12 col-md-6">
                    <label class="form-label muted">السعر (ر.س) *</label>
                    <input name="price" type="number" step="0.01" min="0" class="form-control" required placeholder="مثال: 250">
                  </div>

                  <div class="col-12 col-md-6">
                    <label class="form-label muted">الكمية بالمخزون *</label>
                    <input name="stock_qty" type="number" step="1" min="0" class="form-control" required placeholder="مثال: 10">
                  </div>

                </div>
              </div>

              <div class="soft p-3 mt-3">
                <div class="d-flex justify-content-between align-items-center mb-2">
                  <div class="fw-bold">نصائح سريعة</div>
                  <span class="badge-soft">تحسين الظهور</span>
                </div>
                <ul class="muted mb-0">
                  <li>اكتب عنوان واضح مع كلمة مفتاحية (مثلاً: “ميدالية خشبية محفورة”).</li>
                  <li>استخدم 3–6 صور عالية الجودة وخلفية نظيفة.</li>
                  <li>ضع وصفًا يشرح المقاس والخامة وطريقة الاستخدام.</li>
                </ul>
              </div>
            </div>

            <!-- Right: Images -->
            <div class="col-12 col-lg-5">
              <div class="soft p-3">
                <div class="d-flex justify-content-between align-items-center mb-2">
                  <div class="fw-bold">صور المنتج *</div>
                  <span class="muted small">اسحب وأفلت أو اختر صور</span>
                </div>

                <input id="imagesInput" name="images[]" type="file" accept="image/*" class="form-control" multiple required>

                <div class="muted small mt-2">
                  سيتم تعيين أول صورة كـ <b>رئيسية</b> تلقائيًا (Primary).
                </div>

                <div class="row g-2 mt-3" id="previewGrid"></div>
              </div>

              <div class="soft p-3 mt-3">
                <div class="fw-bold mb-2">حالة الإرسال</div>
                <div class="muted small" id="addProductMsg">جاهز…</div>
                <div class="progress mt-2" style="height:10px; display:none;" id="uploadProgressWrap">
                  <div class="progress-bar" role="progressbar" style="width:0%" id="uploadProgress"></div>
                </div>
              </div>

            </div>

          </div>
        </div>

        <div class="modal-footer">
  <button type="button" class="btn btn-outline-soft" data-bs-dismiss="modal">إغلاق</button>
  <button type="submit" class="btn btn-gold" id="btnCreateProduct">
    <i class="bi bi-cloud-arrow-up"></i> حفظ المنتج
  </button>
</div>

      </form>
    </div>
  </div>
</div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

  <script>
    let page = 1;
    const pageSize = 10;
    const modal = new bootstrap.Modal(document.getElementById('orderModal'));

    function statusBadge(status){
      const map = {
        PENDING:   {text:"قيد الانتظار", cls:"badge text-bg-secondary"},
        PAID:      {text:"مدفوع", cls:"badge text-bg-info"},
        SHIPPED:   {text:"تم الشحن", cls:"badge text-bg-warning"},
        DELIVERED: {text:"تم التسليم", cls:"badge text-bg-success"},
        CANCELLED: {text:"ملغي", cls:"badge text-bg-danger"},
      };
      const s = map[status] || {text: status || "—", cls:"badge text-bg-light"};
      return `<span class="${s.cls}">${s.text}</span>`;
    }

    function fmtMoney(n){
      const x = Number(n || 0);
      return x.toLocaleString('ar-EG', {minimumFractionDigits: 0, maximumFractionDigits: 2}) + " ر.س";
    }

    function daysLeft(expected, status){
      if(!expected) return `<span class="muted">—</span>`;
      if(status === "DELIVERED" || status === "CANCELLED") return `<span class="muted">—</span>`;

      const d1 = new Date();
      const d2 = new Date(expected + "T00:00:00");
      const diff = Math.ceil((d2 - d1) / (1000*60*60*24));

      if (diff > 0) return `<span class="badge-soft">متبقي ${diff} يوم</span>`;
      if (diff === 0) return `<span class="badge-soft">اليوم</span>`;
      return `<span class="badge text-bg-danger">متأخر ${Math.abs(diff)} يوم</span>`;
    }

    function safeText(t){
      return (t ?? "").toString().replaceAll("<","&lt;").replaceAll(">","&gt;");
    }

    function loadOrders(){
      const q = $("#q").val().trim();
      const status = $("#status").val();
      const sort = $("#sort").val();

      $("#rows").html(`<tr><td colspan="8" class="text-center p-4 muted">جارِ التحميل…</td></tr>`);

      $.ajax({
        url: "seller_orders_api.php",
        method: "GET",
        dataType: "json",
        data: { q, status, sort, page, pageSize },
        success: function(res){
          if(!res.ok){
            $("#rows").html(`<tr><td colspan="8" class="text-center p-4 text-danger">حدث خطأ: ${safeText(res.error || "غير معروف")}</td></tr>`);
            return;
          }

          $("#st_total").text(res.stats.total ?? 0);
          $("#st_processing").text(res.stats.processing ?? 0);
          $("#st_late").text(res.stats.late ?? 0);

          $("#pagingInfo").text(`صفحة ${res.page} من ${res.totalPages} — إجمالي ${res.total} طلب`);
          $("#lastSync").text(`آخر تحديث: ${new Date().toLocaleString('ar-EG')}`);

          // ضبط أزرار الصفحات
          $("#prevPage").prop("disabled", res.page <= 1);
          $("#nextPage").prop("disabled", res.page >= res.totalPages);

          if(res.data.length === 0){
            $("#rows").html(`<tr><td colspan="8" class="text-center p-4 muted">لا توجد طلبات مطابقة.</td></tr>`);
            return;
          }

          const rows = res.data.map((o, idx) => {
            const sellerStatus = o.seller_status || o.order_status || "PENDING";
            return `
              <tr>
                <td class="muted">${(res.offset + idx + 1)}</td>
                <td>
                  <div class="fw-bold mono">#${o.order_id}</div>
                  <div class="muted small">تاريخ: ${safeText(o.created_at || "—")}</div>
                </td>
                <td>
                  <div class="fw-bold">${safeText(o.buyer_name || "—")}</div>
                  <div class="muted small">${safeText(o.buyer_email || "")}</div>
                </td>
                <td class="fw-bold">${fmtMoney(o.seller_total)}</td>
                <td>${statusBadge(sellerStatus)}</td>
                <td class="mono">${safeText(o.expected_delivery_date || "—")}</td>
                <td>${daysLeft(o.expected_delivery_date, sellerStatus)}</td>
                <td class="text-end">
                  <button class="btn btn-outline-soft btn-sm" onclick="openOrder(${o.order_id})">
                    <i class="bi bi-eye"></i> عرض
                  </button>
                </td>
              </tr>
            `;
          }).join("");

          $("#rows").html(rows);
        },
        error: function(){
          $("#rows").html(`<tr><td colspan="8" class="text-center p-4 text-danger">فشل الاتصال بالخادم.</td></tr>`);
        }
      });
    }

    window.openOrder = function(orderId){
      $.ajax({
        url: "seller_orders_api.php",
        method: "GET",
        dataType: "json",
        data: { order_id: orderId },
        success: function(res){
          if(!res.ok){
            alert(res.error || "خطأ");
            return;
          }

          const o = res.order;

          $("#m_order_id").val(o.order_id);
          $("#m_order_no").text("#" + o.order_id);

          $("#m_buyer").text(o.buyer_name || "—");
          $("#m_buyer_email").text(o.buyer_email || "");

          $("#m_address").text(o.address_text || "—");
          $("#m_phone").text(o.address_phone ? ("هاتف: " + o.address_phone) : "");

          $("#m_total").text(fmtMoney(o.seller_total));

          // حالتك: من tracking، وإن لم يوجد نعرض order_status كقيمة افتراضية فقط
          const sellerStatus = o.seller_status || o.order_status || "PENDING";
          $("#m_status").val(sellerStatus);

          $("#m_expected").val(o.expected_delivery_date || "");

          // معلومات عامة للعلم
          $("#m_order_status_global").html(statusBadge(o.order_status || "PENDING"));
          $("#m_total_global").text(fmtMoney(o.total_amount || 0));

          const itemsHtml = (res.items || []).map(it => {
            const img = it.image_url ? it.image_url : "";
            const thumb = img
              ? `<img class="product-thumb" src="${img}" alt="">`
              : `<div class="product-thumb d-grid place-items-center text-center muted" style="display:grid;place-items:center;">—</div>`;

            return `
              <tr>
                <td>${thumb}</td>
                <td class="fw-bold">${safeText(it.product_title || "—")}</td>
                <td class="mono">${it.qty ?? 0}</td>
                <td class="mono">${fmtMoney(it.unit_price)}</td>
                <td class="mono">${fmtMoney(it.line_total)}</td>
              </tr>
            `;
          }).join("");

          $("#m_items").html(itemsHtml || `<tr><td colspan="5" class="muted text-center p-3">لا توجد عناصر.</td></tr>`);

          modal.show();
        },
        error: function(){ alert("فشل جلب تفاصيل الطلب"); }
      });
    }

    $("#btnSave").on("click", function(){
      const order_id = $("#m_order_id").val();
      const status = $("#m_status").val();
      const expected_delivery_date = $("#m_expected").val();

      $.ajax({
        url: "seller_orders_update.php",
        method: "POST",
        dataType: "json",
        data: { order_id, status, expected_delivery_date },
        success: function(res){
          if(!res.ok){
            alert(res.error || "لم يتم الحفظ");
            return;
          }
          modal.hide();
          loadOrders();
        },
        error: function(){ alert("فشل الحفظ"); }
      });
    });

    $("#btnRefresh").on("click", function(){ page = 1; loadOrders(); });

    // Enter للبحث
    $("#q").on("keyup", function(e){
      if(e.key === "Enter"){ page = 1; loadOrders(); }
    });

    $("#status, #sort").on("change", function(){ page = 1; loadOrders(); });

    $("#prevPage").on("click", function(){ if(page > 1){ page--; loadOrders(); } });
    $("#nextPage").on("click", function(){ page++; loadOrders(); });

    // init
    loadOrders();
  </script>
    
<script>
  // 1) تحميل التصنيفات (من API بسيط)
  function loadCategories(){
    $.getJSON("seller_categories_api.php", function(res){
      if(!res.ok) return;
      const opts = res.data.map(c => `<option value="${c.id}">${c.name}</option>`).join("");
      $("#categorySelect").append(opts);
    });
  }
  loadCategories();

  // 2) Preview الصور
  $("#imagesInput").on("change", function(){
    const files = this.files || [];
    const $grid = $("#previewGrid");
    $grid.empty();

    Array.from(files).slice(0, 12).forEach((f, idx) => {
      const url = URL.createObjectURL(f);
      $grid.append(`
        <div class="col-4">
          <div class="soft p-1" style="border-radius:14px;">
            <img src="${url}" class="w-100" style="height:110px; object-fit:cover; border-radius:12px;">
            <div class="muted small mt-1 text-center">${idx===0 ? "صورة رئيسية" : "صورة"}</div>
          </div>
        </div>
      `);
    });
  });

  // 3) Submit عبر AJAX (مع progress)
  $("#addProductForm").on("submit", function(e){
    e.preventDefault();

    const form = this;
    const fd = new FormData(form);

    $("#btnCreateProduct").prop("disabled", true);
    $("#addProductMsg").text("جارِ رفع الصور وحفظ المنتج…");
    $("#uploadProgressWrap").show();
    $("#uploadProgress").css("width","0%").text("");

    $.ajax({
      url: "seller_product_create.php",
      method: "POST",
      data: fd,
      processData: false,
      contentType: false,
      dataType: "json",
      xhr: function(){
        const xhr = new window.XMLHttpRequest();
        xhr.upload.addEventListener("progress", function(evt){
          if(evt.lengthComputable){
            const percent = Math.round((evt.loaded / evt.total) * 100);
            $("#uploadProgress").css("width", percent + "%");
          }
        }, false);
        return xhr;
      },
      success: function(res){
        if(!res.ok){
          $("#addProductMsg").text("خطأ: " + (res.error || "غير معروف"));
          $("#btnCreateProduct").prop("disabled", false);
          return;
        }
        $("#addProductMsg").text("✅ تم إنشاء المنتج بنجاح (ID: " + res.product_id + ")");
        form.reset();
        $("#previewGrid").empty();
        $("#uploadProgress").css("width","100%");
        $("#btnCreateProduct").prop("disabled", false);

        // أغلق المودال بعد نجاح
        setTimeout(() => {
          const modalEl = document.getElementById('addProductModal');
          bootstrap.Modal.getInstance(modalEl).hide();
          $("#addProductMsg").text("جاهز…");
          $("#uploadProgressWrap").hide();
          $("#uploadProgress").css("width","0%");
        }, 600);
      },
      error: function(){
        $("#addProductMsg").text("فشل الاتصال بالخادم.");
        $("#btnCreateProduct").prop("disabled", false);
      }
    });
  });
</script>

</body>
</html>

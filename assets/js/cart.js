// نظام السلة العام - يشتغل في كل الصفحات
document.addEventListener('DOMContentLoaded', () => {
  const cartNumber = document.getElementById('cart-number');
  if (!cartNumber) return;

  // جلب عدد السلة من localStorage
  let cartCount = parseInt(localStorage.getItem('goodhands_cart') || '0');
  cartNumber.textContent = cartCount;

  // دالة الإضافة للسلة
  window.addToCart = function() {
    cartCount++;
    cartNumber.textContent = cartCount;
    localStorage.setItem('goodhands_cart', cartCount);
    
    // تنبيه ناعم
    const toast = document.createElement('div');
    toast.textContent = 'تمت الإضافة إلى السلة';
    toast.style.cssText = `
      position:fixed; top:120px; left:50%; transform:translateX(-50%);
      background:#ffb74d; color:#3e2723; padding:12px 30px; border-radius:50px;
      font-weight:bold; z-index:9999; box-shadow:0 10px 30px rgba(0,0,0,0.2);
      animation: toast 3s forwards;
    `;
    document.body.appendChild(toast);
    setTimeout(() => toast.remove(), 3000);
  };

  // ربط كل الأزرار
  document.querySelectorAll('.add-cart, .add-to-cart-btn, #modal-add-cart').forEach(btn => {
    btn.addEventListener('click', (e) => {
      e.preventDefault();
      e.stopPropagation();
      addToCart();
    });
  });
});

// أنيميشن التنبيه
const style = document.createElement('style');
style.textContent = `
@keyframes toast {
  0%, 100% { opacity:0; transform:translateX(-50%) translateY(-20px); }
  15%, 85% { opacity:1; transform:translateX(-50%) translateY(0); }
}`;
document.head.appendChild(style);

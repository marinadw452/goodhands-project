// ===== Slider =====
const slides = document.querySelectorAll('.slide');
let current = 0;
const intervalTime = 4000;

setInterval(() => {
  slides[current].classList.remove('active');
  current = (current + 1) % slides.length;
  slides[current].classList.add('active');
}, intervalTime);

// ===== Sidebar Login =====
const sidebar = document.getElementById('sidebar-login');
const loginBtn = document.getElementById('login-btn');
const closeSidebar = document.getElementById('close-sidebar');

if (loginBtn) {
  loginBtn.addEventListener('click', () => {
    sidebar.classList.add('open');
    sidebar.setAttribute('aria-hidden', 'false');
  });
}
if (closeSidebar) {
  closeSidebar.addEventListener('click', () => {
    sidebar.classList.remove('open');
    sidebar.setAttribute('aria-hidden', 'true');
  });
}
// إغلاق بالضغط خارج الفورم داخل السايدبار
if (sidebar) {
  sidebar.addEventListener('click', (e) => {
    if (e.target === sidebar) {
      sidebar.classList.remove('open');
      sidebar.setAttribute('aria-hidden', 'true');
    }
  });
}

// ===== Login form via AJAX =====
const loginForm = document.getElementById('login-form');
if (loginForm) {
  loginForm.addEventListener('submit', async (e) => {
    e.preventDefault();
    const username = document.getElementById('login-username').value.trim();
    const password = document.getElementById('login-password').value;

    const msgEl = document.getElementById('login-msg');
    msgEl.style.display = 'none';
    msgEl.className = 'form-msg';

    if (!username || !password) {
      msgEl.textContent = 'الرجاء ملء جميع الحقول.';
      msgEl.classList.add('error');
      msgEl.style.display = 'block';
      return;
    }

    const formData = new FormData();
    formData.append('username', username);
    formData.append('password', password);

    try {
      const res = await fetch('login.php', {
        method: 'POST',
        body: formData,
        credentials: 'same-origin'
      });
      const data = await res.json();
      if (data.success) {
        msgEl.textContent = 'تم تسجيل الدخول بنجاح. جاري التحويل...';
        msgEl.classList.add('success');
        msgEl.style.display = 'block';
        // إعادة تحميل الصفحة لإظهار اسم المستخدم في الشريط
        setTimeout(() => location.reload(), 900);
      } else {
        msgEl.textContent = data.message || 'فشل تسجيل الدخول';
        msgEl.classList.add('error');
        msgEl.style.display = 'block';
      }
    } catch (err) {
      msgEl.textContent = 'خطأ في الاتصال. حاول لاحقاً.';
      msgEl.classList.add('error');
      msgEl.style.display = 'block';
    }
  });
}

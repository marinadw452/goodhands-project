// سليدر تلقائي
let current = 0;
const slides = document.querySelectorAll('.slide');
setInterval(() => {
  slides[current].classList.remove('active');
  current = (current + 1) % slides.length;
  slides[current].classList.add('active');
}, 5000);

// فتح وإغلاق Sidebar
document.getElementById('login-btn')?.addEventListener('click', () => {
  document.getElementById('sidebar-login').classList.add('open');
});
document.querySelector('.close-btn').addEventListener('click', () => {
  document.getElementById('sidebar-login').classList.remove('open');
});

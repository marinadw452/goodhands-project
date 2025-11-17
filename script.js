// ===== Slider =====
const slides = document.querySelectorAll('.slide');
let current = 0;
const intervalTime = 3000;
setInterval(() => {
  slides[current].classList.remove('active');
  current = (current + 1) % slides.length;
  slides[current].classList.add('active');
}, intervalTime);

// ===== Sidebar Login =====
document.getElementById('side-login-btn').onclick = function() {
  document.getElementById('sidebar-login').style.display = 'flex';
};
document.getElementById('close-sidebar').onclick = function() {
  document.getElementById('sidebar-login').style.display = 'none';
};
document.getElementById('sidebar-login').addEventListener('click', function(e) {
  if(e.target === this) this.style.display = 'none';
});

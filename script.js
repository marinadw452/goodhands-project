const slides = document.querySelectorAll('.slide');
let current = 0;
const intervalTime = 3000; // مدة عرض كل صورة بالمللي ثانية

setInterval(() => {
  slides[current].classList.remove('active');
  current = (current + 1) % slides.length;
  slides[current].classList.add('active');
}, intervalTime);

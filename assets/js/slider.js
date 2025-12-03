// السلايدر الأوتوماتيكي الفخم - يشتغل في أي صفحة فيها .slider-container
document.addEventListener('DOMContentLoaded', () => {
  const slider = document.querySelector('.slider-container');
  if (!slider) return;

  const slides = slider.querySelectorAll('.slide');
  const dots = slider.querySelectorAll('.dot');
  const prevBtn = slider.querySelector('.prev-btn');
  const nextBtn = slider.querySelector('.next-btn');

  let currentSlide = 0;
  const totalSlides = slides.length;
  let autoSlideInterval;

  function showSlide(n) {
    slides.forEach(s => s.classList.remove('active'));
    dots.forEach(d => d.classList.remove('active'));

    currentSlide = (n + totalSlides) % totalSlides;
    slides[currentSlide].classList.add('active');
    dots[currentSlide].classList.add('active');
  }

  function nextSlide() {
    showSlide(currentSlide + 1);
  }

  function startAutoSlide() {
    autoSlideInterval = setInterval(nextSlide, 5000);
  }

  function stopAutoSlide() {
    clearInterval(autoSlideInterval);
  }

  // الأحداث
  nextBtn?.addEventListener('click', () => {
    nextSlide();
    stopAutoSlide();
    startAutoSlide();
  });

  prevBtn?.addEventListener('click', () => {
    showSlide(currentSlide - 1);
    stopAutoSlide();
    startAutoSlide();
  });

  dots.forEach((dot, i) => {
    dot.addEventListener('click', () => {
      showSlide(i);
      stopAutoSlide();
      startAutoSlide();
    });
  });

  // ابدأ التنقل التلقائي
  startAutoSlide();
});

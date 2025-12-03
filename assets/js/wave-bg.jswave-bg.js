
// الأمواج المتحركة الفخمة - ثابتة في كل الموقع
const canvas = document.getElementById('wave-bg');
if (!canvas) return; // لو ما كانش موجود في الصفحة

const ctx = canvas.getContext('2d');

function resizeCanvas() {
  canvas.width = window.innerWidth;
  canvas.height = window.innerHeight;
}
resizeCanvas();
window.addEventListener('resize', resizeCanvas);

const waves = [
  { amplitude: 30, wavelength: 200, speed: 0.0008, color: "rgba(255, 183, 77, 0.15)" },
  { amplitude: 25, wavelength: 180, speed: 0.0012, color: "rgba(186, 125, 55, 0.12)" },
  { amplitude: 35, wavelength: 220, speed: 0.0006, color: "rgba(255, 215, 0, 0.10)" }
];

function drawWaves() {
  ctx.clearRect(0, 0, canvas.width, canvas.height);
  const time = Date.now();

  waves.forEach(wave => {
    ctx.beginPath();
    ctx.moveTo(0, canvas.height / 2);

    for (let x = 0; x < canvas.width; x += 4) {
      const y = canvas.height / 2 +
        Math.sin((x + time * wave.speed) / wave.wavelength) * wave.amplitude;
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

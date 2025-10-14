const canvas = document.createElement('canvas');
const ctx = canvas.getContext('2d');

canvas.style.position = 'fixed';
canvas.style.top = 0;
canvas.style.left = 0;
canvas.style.width = '100%';
canvas.style.height = '100%';
canvas.style.zIndex = 1;
canvas.style.pointerEvents = 'none';
document.body.appendChild(canvas);

let w, h;
function resize() {
  w = canvas.width = window.innerWidth;
  h = canvas.height = window.innerHeight;
}
resize();
window.addEventListener('resize', resize);

const waves = [];
const numWaves = 3;
for (let i = 0; i < numWaves; i++) {
  waves.push({
    offset: Math.random() * 1000,
    amplitude: 20 + Math.random() * 30,
    wavelength: 150 + Math.random() * 100,
    speed: 0.001 + Math.random() * 0.001,
  });
}

function draw() {
  ctx.clearRect(0, 0, w, h);

  for (let i = 0; i < waves.length; i++) {
    const wave = waves[i];
    ctx.beginPath();
    for (let x = 0; x < w; x++) {
      const y =
        h / 2 +
        Math.sin((x + wave.offset) / wave.wavelength) * wave.amplitude *
        (1 + Math.sin((Date.now() / 1000) * 0.5));

      if (x === 0) ctx.moveTo(x, y);
      else ctx.lineTo(x, y);
    }

    const gradient = ctx.createLinearGradient(0, 0, w, h);
    gradient.addColorStop(0, "rgba(0, 179, 255, 0.21)");
    gradient.addColorStop(0.5, "rgba(255, 255, 255, 0.4)");
    gradient.addColorStop(1, "rgba(248, 247, 244, 1)");
    ctx.strokeStyle = gradient;
    ctx.lineWidth = 2.5;
    ctx.shadowBlur = 12;
    ctx.shadowColor = "rgba(255, 215, 0, 0.7)";
    ctx.stroke();

    wave.offset += wave.speed * 100;
  }

  requestAnimationFrame(draw);
}

draw();

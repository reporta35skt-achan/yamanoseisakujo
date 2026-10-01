const progress = document.getElementById('progress');
window.addEventListener('scroll', () => {
  const height = document.documentElement.scrollHeight - window.innerHeight;
  progress.style.width = height > 0 ? `${(window.scrollY / height) * 100}%` : '0%';
}, { passive: true });

const observer = new IntersectionObserver((entries) => {
  entries.forEach((entry) => {
    if (!entry.isIntersecting) return;
    entry.target.classList.add('show');
    entry.target.querySelectorAll('[data-count]').forEach((el) => {
      if (el.dataset.done) return;
      el.dataset.done = 'true';
      const target = Number(el.dataset.count);
      let value = 0;
      const timer = setInterval(() => {
        value += 1;
        el.textContent = value;
        if (value >= target) clearInterval(timer);
      }, 35);
    });
  });
}, { threshold: 0.14 });

document.querySelectorAll('.reveal').forEach((el) => observer.observe(el));

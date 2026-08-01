document.addEventListener('DOMContentLoaded', () => {
  // 1. Loader Logic
  const loader = document.getElementById('loader');
  if (loader) {
    setTimeout(() => {
      loader.classList.add('hidden');
    }, 1500); // 1.5 seconds minimum show time for the luxury feel
  }

  // 2. Sticky Header Logic
  const header = document.querySelector('.header');
  if (header) {
    window.addEventListener('scroll', () => {
      if (window.scrollY > 50) {
        header.classList.add('scrolled');
      } else {
        header.classList.remove('scrolled');
      }
    });
  }

});

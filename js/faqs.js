// Libas E Khas - FAQ Filter & Search Script
document.addEventListener('DOMContentLoaded', () => {
  const searchInput = document.getElementById('faqSearchInput');
  const catButtons = document.querySelectorAll('.faq-cat-btn');
  const faqItems = document.querySelectorAll('.faq-item');
  const noResults = document.getElementById('faqNoResults');
  let currentFilter = 'all';

  if (!searchInput || !faqItems.length) return;

  function filterFaqs() {
    const query = searchInput.value.toLowerCase().trim();
    let visibleCount = 0;

    faqItems.forEach(item => {
      const category = item.getAttribute('data-category');
      const buttonEl = item.querySelector('.accordion-button');
      const bodyEl = item.querySelector('.accordion-body');
      const title = buttonEl ? buttonEl.textContent.toLowerCase() : '';
      const body = bodyEl ? bodyEl.textContent.toLowerCase() : '';

      const matchesCategory = (currentFilter === 'all' || category === currentFilter);
      const matchesSearch = query === '' || title.includes(query) || body.includes(query);

      if (matchesCategory && matchesSearch) {
        item.style.display = 'block';
        visibleCount++;
      } else {
        item.style.display = 'none';
      }
    });

    if (noResults) {
      if (visibleCount === 0) {
        noResults.classList.remove('d-none');
      } else {
        noResults.classList.add('d-none');
      }
    }
  }

  catButtons.forEach(btn => {
    btn.addEventListener('click', () => {
      catButtons.forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      currentFilter = btn.getAttribute('data-filter');
      filterFaqs();
    });
  });

  searchInput.addEventListener('input', filterFaqs);
});

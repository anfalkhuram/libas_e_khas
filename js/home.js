/**
 * Libas E Khas - Home Page Scripts
 */

document.addEventListener('DOMContentLoaded', () => {
  const grid = document.getElementById('home-product-grid');
  if (!grid || typeof products === 'undefined') return;

  const homeProds = products.slice(0, 4);
  grid.innerHTML = '';

  homeProds.forEach((product, idx) => {
    const col = document.createElement('div');
    col.className = 'col-12 col-md-6 col-lg-3 mb-4 fade-up';
    col.dataset.delay = idx * 100;

    let priceHtml = `<div class="product-price">${formatPrice(product.price)}</div>`;
    let badgeHtml = '';

    if (product.sale) {
      priceHtml = `
        <div class="product-price">
          <span class="text-muted text-decoration-line-through me-2 fs-6">${formatPrice(product.price)}</span>
          <span class="text-accent-green">${formatPrice(product.salePrice)}</span>
        </div>
      `;
      badgeHtml = `<div class="badge-sale">Sale</div>`;
    }
    
    if (product.availability === 'Out of Stock') {
      badgeHtml += `<div class="badge-out-of-stock">Out of Stock</div>`;
    }

    col.innerHTML = `
      <div class="product-card h-100" data-id="${product.id}">
        ${badgeHtml}
        <div class="product-img-wrapper cursor-pointer" data-action="view-details">
          <img src="${product.image}" alt="${product.name}" class="product-img-main">
          <div class="product-img-overlay"></div>
          <div class="product-card-actions">
            ${product.availability === 'Out of Stock' 
              ? `<button class="action-btn text-muted" data-tooltip="Out of Stock" aria-label="Out of Stock" style="opacity: 0.5; cursor: not-allowed;">
                   <i class="fas fa-ban"></i>
                 </button>` 
              : `<button class="action-btn" data-tooltip="Add to Cart" data-action="add-cart" aria-label="Add to cart">
                   <i class="fas fa-shopping-bag"></i>
                 </button>`
            }
            <button class="action-btn" data-tooltip="View" data-action="view-details" aria-label="View product details">
              <i class="far fa-eye"></i>
            </button>
          </div>
        </div>
        <div class="product-info">
          <div class="product-category">${product.category}</div>
          <h3 class="product-title cursor-pointer" data-action="view-details">${product.name}</h3>
          ${priceHtml}
        </div>
      </div>
    `;

    // Event listeners
    const card = col.querySelector('.product-card');
    card.addEventListener('click', (e) => {
      const actionEl = e.target.closest('[data-action]');
      if (!actionEl) return;
      
      const action = actionEl.dataset.action;
      if (action === 'add-cart') {
        e.stopPropagation();
        if (typeof addToCart === 'function') {
          addToCart(product.id);
        }
      } else if (action === 'view-details') {
        e.stopPropagation();
        window.location.href = `product-details?id=${product.id}`;
      }
    });

    grid.appendChild(col);
  });
});

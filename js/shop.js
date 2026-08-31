/**
 * Libas E Khas - Shop Page Scripts
 */

document.addEventListener('DOMContentLoaded', () => {
  const productGrid = document.getElementById('product-grid');
  if (!productGrid || typeof products === 'undefined') return;

  const urlParams = new URLSearchParams(window.location.search);
  const catParam = urlParams.get('cat');
  const subcatParam = urlParams.get('subcat');

  let currentProducts = [...products];
  let currentSort = 'featured';
  let currentPage = 1;
  const itemsPerPage = 9;

  // Set initial products based on URL params
  if (subcatParam) {
    currentProducts = products.filter(p => p.category === subcatParam || p.sub_category === subcatParam);
  } else if (catParam) {
    currentProducts = products.filter(p => p.category === catParam || p.sub_category === catParam);
  }

  // Render products
  function renderProducts(productsToRender, totalItems = 0, startIndex = 0) {
    productGrid.innerHTML = '';
    
    if (productsToRender.length === 0) {
      productGrid.innerHTML = '<div class="col-12 text-center py-5"><p class="text-muted">No products found.</p></div>';
      const resultsCountEl = document.getElementById('shop-results-count');
      if (resultsCountEl) resultsCountEl.textContent = 'Showing 0 results';
      const paginationEl = document.getElementById('shop-pagination');
      if (paginationEl) paginationEl.innerHTML = '';
      return;
    }
    
    const resultsCountEl = document.getElementById('shop-results-count');
    if (resultsCountEl) {
      const end = startIndex + productsToRender.length;
      resultsCountEl.textContent = `Showing ${startIndex + 1}-${end} of ${totalItems} results`;
    }

    productsToRender.forEach(product => {
      const priceStr = formatPrice(product.price);
      let priceHtml = `<div class="product-price">${priceStr}</div>`;
      let badgeHtml = '';
      
      if (product.sale) {
        priceHtml = `
          <div class="product-price">
            <span class="text-muted text-decoration-line-through me-2 fs-6">${priceStr}</span>
            <span class="text-accent-green">${formatPrice(product.salePrice)}</span>
          </div>
        `;
        badgeHtml = `<div class="badge-sale">Sale</div>`;
      }
      
      if (product.availability === 'Out of Stock') {
        badgeHtml += `<div class="badge-out-of-stock">Out of Stock</div>`;
      }

      const col = document.createElement('div');
      col.className = 'col-12 col-md-4 col-lg-4 mb-4 fade-up visible';
      
      col.innerHTML = `
        <div class="product-card h-100" data-id="${product.id}">
          ${badgeHtml}
          <div class="product-img-wrapper cursor-pointer" data-action="view-details">
            <img src="${product.image}" alt="${product.name}" class="product-img-main" loading="lazy" decoding="async" width="400" height="500">
            <div class="product-img-overlay"></div>
            <div class="product-card-actions">
              ${product.availability === 'Out of Stock' 
                ? `<button class="action-btn text-muted" data-tooltip="Out of Stock" aria-label="Out of Stock" style="opacity: 0.5; cursor: not-allowed;">
                     <i class="fas fa-ban"></i>
                   </button>` 
                : `<button class="action-btn" data-tooltip="Add to Cart" data-action="add-cart" aria-label="Add to Cart">
                     <i class="fas fa-shopping-bag"></i>
                   </button>`
              }
              <button class="action-btn" data-tooltip="View" data-action="view-details" aria-label="View Product Details">
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

      productGrid.appendChild(col);
    });
  }

  function renderPagination(totalItems) {
    const paginationEl = document.getElementById('shop-pagination');
    if (!paginationEl) return;
    
    paginationEl.innerHTML = '';
    const totalPages = Math.ceil(totalItems / itemsPerPage);
    
    if (totalPages <= 1) return;
    
    // Prev
    const prevLi = document.createElement('li');
    prevLi.className = `page-item ${currentPage === 1 ? 'disabled' : ''}`;
    prevLi.innerHTML = `<a class="page-link rounded-0 text-dark" href="#"><i class="fas fa-chevron-left"></i></a>`;
    if (currentPage > 1) {
      prevLi.querySelector('a').addEventListener('click', (e) => {
        e.preventDefault();
        goToPage(currentPage - 1);
      });
    }
    paginationEl.appendChild(prevLi);
    
    // Pages
    for (let i = 1; i <= totalPages; i++) {
      const pageLi = document.createElement('li');
      pageLi.className = `page-item ${currentPage === i ? 'active' : ''}`;
      pageLi.innerHTML = `<a class="page-link rounded-0 ${currentPage === i ? 'bg-dark text-white border-dark' : 'text-dark'}" href="#">${i}</a>`;
      pageLi.querySelector('a').addEventListener('click', (e) => {
        e.preventDefault();
        goToPage(i);
      });
      paginationEl.appendChild(pageLi);
    }
    
    // Next
    const nextLi = document.createElement('li');
    nextLi.className = `page-item ${currentPage === totalPages ? 'disabled' : ''}`;
    nextLi.innerHTML = `<a class="page-link rounded-0 text-dark" href="#"><i class="fas fa-chevron-right"></i></a>`;
    if (currentPage < totalPages) {
      nextLi.querySelector('a').addEventListener('click', (e) => {
        e.preventDefault();
        goToPage(currentPage + 1);
      });
    }
    paginationEl.appendChild(nextLi);
  }

  window.goToPage = function(page) {
    currentPage = page;
    applySortAndRender();
    const shopHeader = document.querySelector('.shop-hero-header') || document.querySelector('.shop-header');
    const topOfGrid = shopHeader ? shopHeader.offsetHeight : 0;
    window.scrollTo({ top: topOfGrid, behavior: 'smooth' });
  };

  function applySortAndRender() {
    let sorted = [...currentProducts];
    if (currentSort === 'new') {
      sorted.reverse();
    } else if (currentSort === 'low') {
      sorted.sort((a, b) => (a.sale ? a.salePrice : a.price) - (b.sale ? b.salePrice : b.price));
    } else if (currentSort === 'high') {
      sorted.sort((a, b) => (b.sale ? b.salePrice : b.price) - (a.sale ? a.salePrice : a.price));
    }
    
    const startIndex = (currentPage - 1) * itemsPerPage;
    const paginated = sorted.slice(startIndex, startIndex + itemsPerPage);
    
    renderProducts(paginated, sorted.length, startIndex);
    renderPagination(sorted.length);
  }

  window.handleSort = function(sortValue) {
    currentSort = sortValue;
    applySortAndRender();
  };

  window.filterByCategory = function(category) {
    const tabs = document.querySelectorAll('.category-tab');
    tabs.forEach(tab => tab.classList.remove('active'));
    
    // There can be multiple tabs with the same category (e.g. mobile vs desktop)
    const activeTabs = Array.from(tabs).filter(tab => tab.dataset.category === category);
    activeTabs.forEach(tab => tab.classList.add('active'));

    if (category === 'All') {
      currentProducts = [...products];
    } else {
      currentProducts = products.filter(p => p.category === category || p.sub_category === category);
    }
    currentPage = 1;
    applySortAndRender();
  };

  window.executeSearch = function(inputId = 'shopSearchInput') {
    const searchInput = document.getElementById(inputId);
    if (!searchInput) return;
    
    const query = searchInput.value.toLowerCase().trim();
    
    const tabs = document.querySelectorAll('.category-tab');
    tabs.forEach(tab => tab.classList.remove('active'));
    const allTab = Array.from(tabs).find(tab => tab.dataset.category === 'All');
    if (allTab) allTab.classList.add('active');

    if (query === '') {
      currentProducts = [...products];
    } else {
      currentProducts = products.filter(p => 
        p.name.toLowerCase().includes(query) || 
        p.category.toLowerCase().includes(query)
      );
    }
    currentPage = 1;
    applySortAndRender();
  };

  window.applyPriceFilter = function(minId = 'minPriceInput', maxId = 'maxPriceInput') {
    const minInput = document.getElementById(minId);
    const maxInput = document.getElementById(maxId);
    if (!minInput || !maxInput) return;

    const min = parseFloat(minInput.value) || 0;
    const max = parseFloat(maxInput.value) || Infinity;

    const tabs = document.querySelectorAll('.category-tab');
    tabs.forEach(tab => tab.classList.remove('active'));
    const allTab = Array.from(tabs).find(tab => tab.dataset.category === 'All');
    if (allTab) allTab.classList.add('active');

    currentProducts = products.filter(p => {
      const actualPrice = p.sale ? p.salePrice : p.price;
      return actualPrice >= min && actualPrice <= max;
    });
    
    currentPage = 1;
    applySortAndRender();
  };

  // Bind category tabs event listeners
  const categoryTabs = document.querySelectorAll('.category-tab');
  categoryTabs.forEach(tab => {
    tab.addEventListener('click', () => {
      const cat = tab.dataset.category || 'All';
      window.filterByCategory(cat);
    });
  });

  // Bind sort dropdown
  const sortSelect = document.getElementById('shopSortSelect');
  if (sortSelect) {
    sortSelect.addEventListener('change', (e) => {
      window.handleSort(e.target.value);
    });
  }

  // Bind desktop search form
  const desktopSearchForm = document.getElementById('shopDesktopSearchForm');
  if (desktopSearchForm) {
    desktopSearchForm.addEventListener('submit', (e) => {
      e.preventDefault();
      window.executeSearch('shopSearchInput');
    });
  }

  // Bind mobile search form
  const mobileSearchForm = document.getElementById('shopMobileSearchForm');
  if (mobileSearchForm) {
    mobileSearchForm.addEventListener('submit', (e) => {
      e.preventDefault();
      window.executeSearch('shopMobileSearchInput');
    });
  }

  // Bind desktop price filter form
  const desktopPriceForm = document.getElementById('shopDesktopPriceForm');
  if (desktopPriceForm) {
    desktopPriceForm.addEventListener('submit', (e) => {
      e.preventDefault();
      window.applyPriceFilter('minPriceInput', 'maxPriceInput');
    });
  }

  // Bind mobile price filter form
  const mobilePriceForm = document.getElementById('shopMobilePriceForm');
  if (mobilePriceForm) {
    mobilePriceForm.addEventListener('submit', (e) => {
      e.preventDefault();
      window.applyPriceFilter('minPriceInputMobile', 'maxPriceInputMobile');
    });
  }

  // Render initially
  if (subcatParam || catParam) {
    // If URL has params, trigger the UI update to highlight the correct tab
    const initialCategory = subcatParam || catParam;
    window.filterByCategory(initialCategory);
  } else {
    applySortAndRender();
  }
});

// Quick View functionality
function openQuickView(productId) {
  if (typeof products === 'undefined') return;
  const product = products.find(p => p.id === productId);
  if (!product) return;

  const modalImg = document.getElementById('qv-img');
  const modalTitle = document.getElementById('qv-title');
  const modalCategory = document.getElementById('qv-category');
  const modalPrice = document.getElementById('qv-price');
  const addToCartBtn = document.getElementById('qv-add-to-cart');

  if (modalImg) modalImg.src = product.image;
  if (modalTitle) modalTitle.textContent = product.name;
  if (modalCategory) modalCategory.textContent = product.category;
  
  if (modalPrice) {
    if (product.sale) {
      modalPrice.innerHTML = `
        <span class="text-muted text-decoration-line-through me-2 fs-6">${formatPrice(product.price)}</span>
        <span class="text-accent-green">${formatPrice(product.salePrice)}</span>
      `;
    } else {
      modalPrice.textContent = formatPrice(product.price);
    }
  }

  if (addToCartBtn) {
    addToCartBtn.onclick = () => {
      const qty = parseInt(document.getElementById('qv-qty')?.value) || 1;
      if (typeof addToCart === 'function') {
        addToCart(product.id, qty);
      }
      
      const modalEl = document.getElementById('quickViewModal');
      if (modalEl && typeof bootstrap !== 'undefined') {
        const modal = bootstrap.Modal.getInstance(modalEl);
        if (modal) modal.hide();
      }
    };
  }

  const modalEl = document.getElementById('quickViewModal');
  if (modalEl && typeof bootstrap !== 'undefined') {
    const modal = new bootstrap.Modal(modalEl);
    modal.show();
  }
}

function toggleWishlist(event, productId) {
  if (event) event.stopPropagation();
  const icon = event?.currentTarget?.querySelector('i');
  if (!icon) return;

  if (icon.classList.contains('far')) {
    icon.classList.remove('far');
    icon.classList.add('fas');
    icon.classList.add('text-accent-green');
  } else {
    icon.classList.remove('fas');
    icon.classList.remove('text-accent-green');
    icon.classList.add('far');
  }
}

document.addEventListener('DOMContentLoaded', () => {
  const productGrid = document.getElementById('product-grid');
  if (!productGrid) return; // Only run on shop page/sections with a grid

  // Function to render products
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
      let priceHtml = `
        <div class="product-price">${priceStr}</div>
      `;
      let badgeHtml = '';
      
      if (product.sale) {
        priceHtml = `
          <div class="product-price">
            <span class="text-muted text-decoration-line-through me-2" style="font-size: 0.85rem">${priceStr}</span>
            <span style="color: var(--color-accent-green);">${formatPrice(product.salePrice)}</span>
          </div>
        `;
        badgeHtml = `<div class="badge-sale">Sale</div>`;
      }

      const col = document.createElement('div');
      col.className = 'col-12 col-md-4 col-lg-4 mb-4 fade-up visible';
      
      col.innerHTML = `
        <div class="product-card h-100">
          ${badgeHtml}
          <div class="product-img-wrapper" style="cursor: pointer;" onclick="window.location.href='product-details.html?id=${product.id}'">
            <img src="${product.image}" alt="${product.name}" class="product-img-main">
            <div class="product-img-overlay"></div>
            <div class="product-card-actions">
              <button class="action-btn" data-tooltip="Add to Wishlist" onclick="event.stopPropagation(); toggleWishlist(event, ${product.id})">
                <i class="far fa-heart"></i>
              </button>
              <button class="action-btn" data-tooltip="Add to Cart" onclick="event.stopPropagation(); addToCart(${product.id})">
                <i class="fas fa-shopping-bag"></i>
              </button>
              <button class="action-btn" data-tooltip="View" onclick="event.stopPropagation(); window.location.href='product-details.html?id=${product.id}'">
                <i class="far fa-eye"></i>
              </button>
            </div>
          </div>
          <div class="product-info">
            <div class="product-category">${product.category}</div>
            <h3 class="product-title" style="cursor: pointer;" onclick="window.location.href='product-details.html?id=${product.id}'">${product.name}</h3>
            ${priceHtml}
          </div>
        </div>
      `;
      productGrid.appendChild(col);
    });
  }

  let currentProducts = [...products];
  let currentSort = 'featured';
  let currentPage = 1;
  const itemsPerPage = 9;

  function renderPagination(totalItems) {
    const paginationEl = document.getElementById('shop-pagination');
    if (!paginationEl) return;
    
    paginationEl.innerHTML = '';
    const totalPages = Math.ceil(totalItems / itemsPerPage);
    
    if (totalPages <= 1) return;
    
    // Prev
    paginationEl.innerHTML += `
      <li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
        <a class="page-link rounded-0 text-dark" href="#" onclick="event.preventDefault(); goToPage(${currentPage - 1})">
          <i class="fas fa-chevron-left"></i>
        </a>
      </li>
    `;
    
    // Pages
    for (let i = 1; i <= totalPages; i++) {
      paginationEl.innerHTML += `
        <li class="page-item ${currentPage === i ? 'active' : ''}">
          <a class="page-link rounded-0 ${currentPage === i ? 'bg-dark text-white border-dark' : 'text-dark'}" href="#" onclick="event.preventDefault(); goToPage(${i})">${i}</a>
        </li>
      `;
    }
    
    // Next
    paginationEl.innerHTML += `
      <li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
        <a class="page-link rounded-0 text-dark" href="#" onclick="event.preventDefault(); goToPage(${currentPage + 1})">
          <i class="fas fa-chevron-right"></i>
        </a>
      </li>
    `;
  }

  window.goToPage = function(page) {
    currentPage = page;
    applySortAndRender();
    const topOfGrid = document.querySelector('.shop-header').offsetHeight;
    window.scrollTo({ top: topOfGrid, behavior: 'smooth' });
  };

  function applySortAndRender() {
    let sorted = [...currentProducts];
    if (currentSort === 'new') {
      sorted.reverse(); // Mock new
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

  // Render all initially
  applySortAndRender();

  // Expose filtering to global scope for the category tabs
  window.filterByCategory = function(category) {
    const tabs = document.querySelectorAll('.category-tab');
    tabs.forEach(tab => tab.classList.remove('active'));
    
    const activeTab = Array.from(tabs).find(tab => tab.dataset.category === category);
    if(activeTab) activeTab.classList.add('active');

    if (category === 'All') {
      currentProducts = [...products];
    } else {
      currentProducts = products.filter(p => p.category === category);
    }
    currentPage = 1;
    applySortAndRender();
  };

  // Search functionality
  window.executeSearch = function(inputId = 'shopSearchInput') {
    const searchInput = document.getElementById(inputId);
    if (!searchInput) return;
    
    const query = searchInput.value.toLowerCase().trim();
    
    // Reset category tabs to 'All' visually when searching
    const tabs = document.querySelectorAll('.category-tab');
    tabs.forEach(tab => tab.classList.remove('active'));
    const allTab = Array.from(tabs).find(tab => tab.dataset.category === 'All');
    if(allTab) allTab.classList.add('active');

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

  // Price Filter functionality
  window.applyPriceFilter = function(minId = 'minPriceInput', maxId = 'maxPriceInput') {
    const minInput = document.getElementById(minId);
    const maxInput = document.getElementById(maxId);
    if (!minInput || !maxInput) return;

    const min = parseFloat(minInput.value) || 0;
    const max = parseFloat(maxInput.value) || Infinity;

    // Reset category tabs to 'All' visually when filtering by price
    const tabs = document.querySelectorAll('.category-tab');
    tabs.forEach(tab => tab.classList.remove('active'));
    const allTab = Array.from(tabs).find(tab => tab.dataset.category === 'All');
    if(allTab) allTab.classList.add('active');

    currentProducts = products.filter(p => {
      const actualPrice = p.sale ? p.salePrice : p.price;
      return actualPrice >= min && actualPrice <= max;
    });
    
    currentPage = 1;
    applySortAndRender();
  };
});

// Quick View functionality
function openQuickView(productId) {
  const product = products.find(p => p.id === productId);
  if (!product) return;

  const modalImg = document.getElementById('qv-img');
  const modalTitle = document.getElementById('qv-title');
  const modalCategory = document.getElementById('qv-category');
  const modalPrice = document.getElementById('qv-price');
  const addToCartBtn = document.getElementById('qv-add-to-cart');

  modalImg.src = product.image;
  modalTitle.textContent = product.name;
  modalCategory.textContent = product.category;
  
  if (product.sale) {
    modalPrice.innerHTML = `
      <span class="text-muted text-decoration-line-through me-2 fs-6">${formatPrice(product.price)}</span>
      <span style="color: var(--color-accent-green);">${formatPrice(product.salePrice)}</span>
    `;
  } else {
    modalPrice.textContent = formatPrice(product.price);
  }

  addToCartBtn.onclick = () => {
    const qty = parseInt(document.getElementById('qv-qty').value) || 1;
    addToCart(product.id, qty);
    
    // Close modal
    const modalEl = document.getElementById('quickViewModal');
    const modal = bootstrap.Modal.getInstance(modalEl);
    modal.hide();
  };

  const modalEl = document.getElementById('quickViewModal');
  const modal = new bootstrap.Modal(modalEl);
  modal.show();
}

function toggleWishlist(event, productId) {
  event.stopPropagation();
  const icon = event.currentTarget.querySelector('i');
  if (icon.classList.contains('far')) {
    icon.classList.remove('far');
    icon.classList.add('fas');
    icon.style.color = 'var(--color-accent-green)';
  } else {
    icon.classList.remove('fas');
    icon.classList.add('far');
    icon.style.color = 'var(--color-dark)';
  }
}

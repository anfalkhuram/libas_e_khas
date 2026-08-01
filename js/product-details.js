document.addEventListener('DOMContentLoaded', () => {
  // Only run if we are on the product details page
  const pdContent = document.getElementById('product-detail-content');
  if (!pdContent) return;

  const urlParams = new URLSearchParams(window.location.search);
  const productId = parseInt(urlParams.get('id'));

  const errorContainer = document.getElementById('pd-error-container');
  const tabsSection = document.getElementById('pd-tabs-section');
  const relatedSection = document.getElementById('pd-related-section');
  
  if (!productId || isNaN(productId)) {
    showError();
    return;
  }

  const product = products.find(p => p.id === productId);
  if (!product) {
    showError();
    return;
  }

  // State
  let currentImageIndex = 0;
  let selectedSize = '';
  
  function showError() {
    pdContent.classList.add('d-none');
    if (tabsSection) tabsSection.classList.add('d-none');
    if (relatedSection) relatedSection.classList.add('d-none');
    if (errorContainer) errorContainer.classList.remove('d-none');
  }

  // Populate data
  document.title = `Libas E Khas | ${product.name}`;
  document.getElementById('bd-current').textContent = product.name;
  document.getElementById('pd-category').textContent = product.category;
  document.getElementById('pd-name').textContent = product.name;
  
  const priceStr = "PKR " + product.price.toLocaleString();
  if (product.sale) {
    const salePriceStr = "PKR " + product.salePrice.toLocaleString();
    document.getElementById('pd-price').innerHTML = `<span class="text-muted text-decoration-line-through me-2 fs-5">${priceStr}</span><span style="color: var(--color-accent-green);">${salePriceStr}</span>`;
  } else {
    document.getElementById('pd-price').textContent = priceStr;
  }

  document.getElementById('pd-short-desc').textContent = product.shortDescription;
  document.getElementById('pd-full-desc').textContent = product.description;
  document.getElementById('pd-sku').textContent = product.sku;
  
  const availEl = document.getElementById('pd-availability');
  availEl.textContent = product.availability;
  if (product.availability === 'Out of Stock') {
    availEl.classList.remove('text-success');
    availEl.classList.add('text-danger');
    const addBtn = document.getElementById('pd-add-to-cart');
    addBtn.disabled = true;
    addBtn.textContent = "OUT OF STOCK";
  }

  document.getElementById('pd-tags').textContent = product.tags.join(', ');
  document.getElementById('pd-info-fabric').textContent = product.fabric;
  document.getElementById('pd-info-collection').textContent = product.collection;
  document.getElementById('pd-info-category').textContent = product.category;
  document.getElementById('pd-info-sku').textContent = product.sku;
  document.getElementById('pd-info-avail').textContent = product.availability;
  document.getElementById('pd-info-tags').textContent = product.tags.join(', ');
  document.getElementById('pd-info-sizes').textContent = product.sizes && product.sizes.length ? product.sizes.join(', ') : 'One Size';
  document.getElementById('pd-reviews-count').textContent = product.reviews;
  document.getElementById('pd-review-tab-count').textContent = product.reviews;

  // Stars
  const starsContainer = document.getElementById('pd-stars');
  starsContainer.innerHTML = '';
  for (let i = 0; i < 5; i++) {
    if (i < product.rating) {
      starsContainer.innerHTML += '<i class="fas fa-star"></i>';
    } else {
      starsContainer.innerHTML += '<i class="far fa-star"></i>';
    }
  }

  // Reviews Mock Data
  const mockReviews = [
    { name: "Sarah", text: "Beautiful embroidery and excellent quality. Fits perfectly and looks exactly like the pictures!" },
    { name: "Ayesha", text: "Stunning dress. The colors are very vibrant and the fabric is premium." },
    { name: "Fatima", text: "Received so many compliments. Worth every penny." },
    { name: "Zainab", text: "Fast shipping and great customer service. The outfit is lovely." },
    { name: "Hira", text: "Will definitely buy again. Highly recommended!" },
    { name: "Mariam", text: "Amazing stitching and detailing. The dupatta is just gorgeous." }
  ];
  
  const reviewsContainer = document.getElementById('pd-reviews-container');
  const seeMoreBtn = document.getElementById('pd-see-more-reviews');
  let showingAllReviews = false;
  
  function renderReviews() {
    reviewsContainer.innerHTML = '';
    const numToShow = showingAllReviews ? mockReviews.length : Math.min(3, mockReviews.length);
    
    for (let i = 0; i < numToShow; i++) {
      const review = mockReviews[i];
      let starsHtml = '';
      for (let j = 0; j < 5; j++) {
        starsHtml += (j < product.rating) ? '<i class="fas fa-star"></i>' : '<i class="far fa-star"></i>';
      }
      
      reviewsContainer.innerHTML += `
        <div class="review-item mb-4">
          <div class="d-flex align-items-center gap-2 mb-2">
            <div class="text-gold" style="color: var(--color-gold); font-size: 0.8rem;">${starsHtml}</div>
            <span class="fw-medium text-dark">${review.name}</span>
            <span class="badge bg-light text-dark fw-normal border"><i class="fas fa-check text-success me-1"></i>Verified Customer</span>
          </div>
          <p class="text-muted" style="font-size: 0.95rem;">${review.text}</p>
        </div>
      `;
    }
    
    if (mockReviews.length > 3) {
      seeMoreBtn.style.display = 'inline-block';
      seeMoreBtn.textContent = showingAllReviews ? "Show Less" : "See More";
    } else {
      seeMoreBtn.style.display = 'none';
    }
  }
  
  if (reviewsContainer) {
    renderReviews();
    seeMoreBtn.onclick = () => {
      showingAllReviews = !showingAllReviews;
      renderReviews();
    };
  }

  // Images
  const mainImg = document.getElementById('pd-main-img');
  const thumbsContainer = document.getElementById('pd-thumbnails');
  
  // Use images array if available, fallback to single image
  const productImages = (product.images && product.images.length > 0) ? product.images : [product.image];
  
  mainImg.src = productImages[0];
  
  productImages.forEach((imgSrc, idx) => {
    const thumbDiv = document.createElement('div');
    thumbDiv.className = `pd-thumbnail cursor-pointer border ${idx === 0 ? 'border-dark' : 'border-light'}`;
    thumbDiv.style.width = '80px';
    thumbDiv.style.height = '100px';
    thumbDiv.style.cursor = 'pointer';
    thumbDiv.style.transition = 'all 0.3s ease';
    
    thumbDiv.innerHTML = `<img src="${imgSrc}" class="img-fluid w-100 h-100 object-fit-cover" alt="Thumbnail ${idx+1}">`;
    
    thumbDiv.onclick = () => {
      currentImageIndex = idx;
      mainImg.src = imgSrc;
      // Update borders
      document.querySelectorAll('.pd-thumbnail').forEach(el => el.classList.remove('border-dark'));
      document.querySelectorAll('.pd-thumbnail').forEach(el => el.classList.add('border-light'));
      thumbDiv.classList.remove('border-light');
      thumbDiv.classList.add('border-dark');
    };
    thumbsContainer.appendChild(thumbDiv);
  });

  // Modal Gallery Logic
  const galleryModalImg = document.getElementById('gallery-modal-img');
  window.openGalleryModal = function() {
    galleryModalImg.src = productImages[currentImageIndex];
    const myModal = new bootstrap.Modal(document.getElementById('galleryModal'));
    myModal.show();
  };
  
  window.nextGalleryImage = function() {
    currentImageIndex = (currentImageIndex + 1) % productImages.length;
    galleryModalImg.src = productImages[currentImageIndex];
  };
  
  window.prevGalleryImage = function() {
    currentImageIndex = (currentImageIndex - 1 + productImages.length) % productImages.length;
    galleryModalImg.src = productImages[currentImageIndex];
  };

  // Sizes
  const sizesContainer = document.getElementById('pd-sizes');
  if (product.sizes && product.sizes.length > 0) {
    product.sizes.forEach((size, idx) => {
      const btn = document.createElement('button');
      btn.className = 'btn border rounded-0 px-3 py-2 size-btn';
      btn.style.fontFamily = 'var(--font-body)';
      btn.style.fontSize = '0.9rem';
      btn.textContent = size;
      
      // Default to first size if in stock
      if (idx === 0 && product.availability !== 'Out of Stock') {
        selectedSize = size;
        btn.classList.add('border-dark', 'bg-dark', 'text-white');
      }
      
      btn.onclick = () => {
        document.querySelectorAll('.size-btn').forEach(el => {
          el.classList.remove('border-dark', 'bg-dark', 'text-white');
        });
        btn.classList.add('border-dark', 'bg-dark', 'text-white');
        selectedSize = size;
      };
      
      sizesContainer.appendChild(btn);
    });
  } else {
    sizesContainer.innerHTML = '<span class="text-muted">One Size</span>';
    selectedSize = 'One Size';
  }

  // Quantity
  const qtyInput = document.getElementById('pd-qty');
  window.updateQty = function(change) {
    let current = parseInt(qtyInput.value) || 1;
    current += change;
    if (current < 1) current = 1;
    qtyInput.value = current;
  };

  // Add to Cart integration
  document.getElementById('pd-add-to-cart').onclick = function() {
    if (product.availability === 'Out of Stock') return;
    const qty = parseInt(qtyInput.value) || 1;
    
    // Use the global addToCart if available, otherwise just log
    if (typeof addToCart === 'function') {
      // Temporarily store selected size to be used by addToCart if it supported it
      // For now we just call it.
      addToCart(product.id);
      
      // We should really update the cart offcanvas directly or just let addToCart handle it.
      // Assuming addToCart already opens the offcanvas or updates UI.
    } else {
      alert(`Added ${qty} of ${product.name} (Size: ${selectedSize}) to cart!`);
    }
  };

  // Wishlist toggle
  window.togglePdWishlist = function(btn) {
    const icon = btn.querySelector('i');
    if (icon.classList.contains('far')) {
      icon.classList.remove('far');
      icon.classList.add('fas', 'text-danger');
      if(typeof toggleWishlist === 'function') toggleWishlist(new Event('click'), product.id);
    } else {
      icon.classList.remove('fas', 'text-danger');
      icon.classList.add('far');
      if(typeof toggleWishlist === 'function') toggleWishlist(new Event('click'), product.id);
    }
  };

  // Related Products
  const relatedGrid = document.getElementById('pd-related-grid');
  if (relatedGrid) {
    const related = products.filter(p => p.id !== product.id && (p.category === product.category || p.collection === product.collection)).slice(0, 4);
    
    if (related.length === 0) {
      // fallback to random 4
      related.push(...products.filter(p => p.id !== product.id).slice(0, 4));
    }
    
    related.forEach(relatedProd => {
      let priceStr = "PKR " + relatedProd.price.toLocaleString();
      let priceHtml = `<div class="product-price">${priceStr}</div>`;
      let badgeHtml = '';
      if (relatedProd.sale) {
        priceHtml = `
          <div class="product-price">
            <span class="text-muted text-decoration-line-through me-2" style="font-size: 0.85rem">${priceStr}</span>
            <span style="color: var(--color-accent-green);">${"PKR " + relatedProd.salePrice.toLocaleString()}</span>
          </div>
        `;
        badgeHtml = `<div class="badge-sale">Sale</div>`;
      }

      const col = document.createElement('div');
      col.className = 'col-6 col-md-3 mb-4';
      col.innerHTML = `
        <div class="product-card h-100">
          ${badgeHtml}
          <div class="product-img-wrapper" style="cursor: pointer;" onclick="window.location.href='product-details.html?id=${relatedProd.id}'">
            <img src="${relatedProd.image}" alt="${relatedProd.name}" class="product-img-main">
            <div class="product-img-overlay"></div>
            <div class="product-card-actions">
              <button class="action-btn" data-tooltip="Add to Wishlist" onclick="event.stopPropagation(); toggleWishlist(event, ${relatedProd.id})">
                <i class="far fa-heart"></i>
              </button>
              <button class="action-btn" data-tooltip="Add to Cart" onclick="event.stopPropagation(); addToCart(${relatedProd.id})">
                <i class="fas fa-shopping-bag"></i>
              </button>
              <button class="action-btn" data-tooltip="View" onclick="event.stopPropagation(); window.location.href='product-details.html?id=${relatedProd.id}'">
                <i class="far fa-eye"></i>
              </button>
            </div>
          </div>
          <div class="product-info">
            <div class="product-category">${relatedProd.category}</div>
            <h3 class="product-title" style="cursor: pointer;" onclick="window.location.href='product-details.html?id=${relatedProd.id}'">${relatedProd.name}</h3>
            ${priceHtml}
          </div>
        </div>
      `;
      relatedGrid.appendChild(col);
    });
  }
  // Review Modal Logic
  const reviewForm = document.getElementById('review-form');
  const ratingStars = document.querySelectorAll('#reviewRatingStars .rating-star');
  const ratingValueInput = document.getElementById('reviewRatingValue');
  
  if (ratingStars.length > 0) {
    ratingStars.forEach(star => {
      star.addEventListener('click', function() {
        const rating = parseInt(this.getAttribute('data-rating'));
        ratingValueInput.value = rating;
        
        ratingStars.forEach(s => {
          if (parseInt(s.getAttribute('data-rating')) <= rating) {
            s.classList.remove('far');
            s.classList.add('fas');
          } else {
            s.classList.remove('fas');
            s.classList.add('far');
          }
        });
      });
    });
  }

  if (reviewForm) {
    reviewForm.addEventListener('submit', function(e) {
      e.preventDefault();
      const rating = ratingValueInput.value;
      if (rating === "0") {
        alert("Please select a rating.");
        return;
      }
      
      alert("Thank you for your review! It has been submitted for moderation.");
      const reviewModal = bootstrap.Modal.getInstance(document.getElementById('reviewModal'));
      if(reviewModal) reviewModal.hide();
      reviewForm.reset();
      ratingValueInput.value = "0";
      ratingStars.forEach(s => {
        s.classList.remove('fas');
        s.classList.add('far');
      });
    });
  }

});

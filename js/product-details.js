/**
 * Libas E Khas - Product Details Module
 */

document.addEventListener('DOMContentLoaded', () => {
  const pdContent = document.getElementById('product-detail-content');
  if (!pdContent || typeof products === 'undefined') return;

  const urlParams = new URLSearchParams(window.location.search);
  const productId = parseInt(urlParams.get('id'));

  const errorContainer = document.getElementById('pd-error-container');
  const tabsSection = document.getElementById('pd-tabs-section');
  const relatedSection = document.getElementById('pd-related-section');
  
  function showError() {
    pdContent.classList.add('d-none');
    if (tabsSection) tabsSection.classList.add('d-none');
    if (relatedSection) relatedSection.classList.add('d-none');
    if (errorContainer) errorContainer.classList.remove('d-none');
  }

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
  
  // Populate data
  document.title = `Libas E Khas | ${product.name}`;
  const bdCurrent = document.getElementById('bd-current');
  if (bdCurrent) bdCurrent.textContent = product.name;
  
  const catEl = document.getElementById('pd-category');
  if (catEl) catEl.textContent = product.category;
  
  const nameEl = document.getElementById('pd-name');
  if (nameEl) nameEl.textContent = product.name;
  
  const priceStr = (typeof formatPrice !== 'undefined') ? formatPrice(product.price) : `PKR ${product.price.toLocaleString()}`;
  const priceEl = document.getElementById('pd-price');
  const discountBadge = document.getElementById('pd-discount-badge');
  if (priceEl) {
    if (product.sale && product.salePrice) {
      const salePriceStr = (typeof formatPrice !== 'undefined') ? formatPrice(product.salePrice) : `PKR ${product.salePrice.toLocaleString()}`;
      priceEl.innerHTML = `<span class="text-muted text-decoration-line-through me-2 fs-5">${priceStr}</span><span class="text-accent-green">${salePriceStr}</span>`;
      if (discountBadge) discountBadge.style.display = 'inline-block';
    } else {
      priceEl.textContent = priceStr;
      if (discountBadge) discountBadge.style.display = 'none';
    }
  }

  const collectionEl = document.getElementById('pd-collection-tag');
  if (collectionEl) collectionEl.textContent = product.collection || 'Collection';

  const shortDesc = document.getElementById('pd-short-desc');
  if (shortDesc) shortDesc.textContent = product.shortDescription;
  
  const fullDesc = document.getElementById('pd-full-desc');
  if (fullDesc) fullDesc.textContent = product.description;
  
  const fabricEl = document.getElementById('pd-info-fabric');
  if (fabricEl) fabricEl.textContent = product.fabric || 'N/A';
  
  const skuEl = document.getElementById('pd-info-sku');
  if (skuEl) skuEl.textContent = product.sku || 'N/A';
  
  const availEl = document.getElementById('pd-availability');
  if (availEl) {
    availEl.textContent = product.availability || 'In Stock';
    if (product.availability === 'Out of Stock') {
      availEl.classList.remove('text-dark');
      availEl.classList.add('text-danger');
      const addBtn = document.getElementById('pd-add-to-cart');
      if (addBtn) {
        addBtn.disabled = true;
        addBtn.textContent = "OUT OF STOCK";
      }
    }
  }

  const tabFabricEl = document.getElementById('tab-info-fabric');
  if (tabFabricEl) tabFabricEl.textContent = product.fabric || 'N/A';

  const tabCollectionEl = document.getElementById('tab-info-collection');
  if (tabCollectionEl) tabCollectionEl.textContent = product.collection || 'N/A';

  const tabTagsEl = document.getElementById('tab-info-tags');
  if (tabTagsEl) tabTagsEl.textContent = product.tags ? product.tags.join(', ') : 'N/A';

  const revCount = document.getElementById('pd-reviews-count');
  const actualReviewCount = (product.reviews && Array.isArray(product.reviews)) ? product.reviews.length : 0;
  if (revCount) revCount.textContent = actualReviewCount;
  
  const revTabCount = document.getElementById('pd-review-tab-count');
  if (revTabCount) revTabCount.textContent = actualReviewCount;

  // Overview Image
  const overviewImg = document.getElementById('pd-overview-img');
  if (overviewImg) {
    // Show a different image from the gallery if available, otherwise fallback to main image
    overviewImg.src = (product.images && product.images.length > 1) ? product.images[1] : product.image;
  }

  // Stars
  const starsContainer = document.getElementById('pd-stars');
  if (starsContainer) {
    starsContainer.innerHTML = '';
    let avgRating = 0;
    if (actualReviewCount > 0) {
      const sum = product.reviews.reduce((acc, rev) => acc + rev.rating, 0);
      avgRating = Math.round(sum / actualReviewCount);
    }
    for (let i = 0; i < 5; i++) {
      if (i < avgRating) {
        starsContainer.innerHTML += '<i class="fas fa-star"></i>';
      } else {
        starsContainer.innerHTML += '<i class="far fa-star"></i>';
      }
    }
  }

  // Reviews Actual Data
  const actualReviews = (product.reviews && Array.isArray(product.reviews)) ? product.reviews : [];
  
  const reviewsContainer = document.getElementById('pd-reviews-container');
  const seeMoreBtn = document.getElementById('pd-see-more-reviews');
  let showingAllReviews = false;
  
  function renderReviews() {
    if (!reviewsContainer) return;
    reviewsContainer.innerHTML = '';
    
    if (actualReviews.length === 0) {
      reviewsContainer.innerHTML = '<p class="text-muted">No reviews yet. Be the first to review this product!</p>';
      if(seeMoreBtn) seeMoreBtn.classList.add('d-none');
      return;
    }

    const numToShow = showingAllReviews ? actualReviews.length : Math.min(3, actualReviews.length);
    
    for (let i = 0; i < numToShow; i++) {
      const review = actualReviews[i];
      let starsHtml = '';
      for (let j = 0; j < 5; j++) {
        starsHtml += (j < review.rating) ? '<i class="fas fa-star"></i>' : '<i class="far fa-star"></i>';
      }
      
      reviewsContainer.innerHTML += `
        <div class="review-item mb-4">
          <div class="d-flex align-items-center gap-2 mb-2">
            <div class="text-gold fs-6">${starsHtml}</div>
            <span class="fw-medium text-dark">${review.name}</span>
            <span class="text-muted small ms-auto">${review.date || ''}</span>
          </div>
          <p class="text-muted mb-0">${review.text}</p>
        </div>
      `;
    }
    
    if (seeMoreBtn) {
      if (actualReviews.length > 3) {
        seeMoreBtn.classList.remove('d-none');
        seeMoreBtn.textContent = showingAllReviews ? "Show Less" : "See More";
      } else {
        seeMoreBtn.classList.add('d-none');
      }
    }
  }
  
  if (reviewsContainer) {
    renderReviews();
    if (seeMoreBtn) {
      seeMoreBtn.onclick = () => {
        showingAllReviews = !showingAllReviews;
        renderReviews();
      };
    }
  }

  // Images
  const mainImg = document.getElementById('pd-main-img');
  const thumbsContainer = document.getElementById('pd-thumbnails');
  
  const productImages = (product.images && product.images.length > 0) ? product.images : [product.image];
  
  if (mainImg) {
    mainImg.src = productImages[0];
  }
  
  if (thumbsContainer) {
    thumbsContainer.innerHTML = '';
    productImages.forEach((imgSrc, idx) => {
      const thumbDiv = document.createElement('div');
      thumbDiv.className = `pd-thumbnail cursor-pointer border ${idx === 0 ? 'border-dark' : 'border-light'}`;
      thumbDiv.innerHTML = `<img src="${imgSrc}" class="pd-thumb-img w-100 h-100 object-fit-cover" alt="Thumbnail ${idx+1}">`;
      
      thumbDiv.onclick = () => {
        currentImageIndex = idx;
        if (mainImg) mainImg.src = imgSrc;
        document.querySelectorAll('.pd-thumbnail').forEach(el => el.classList.remove('border-dark'));
        document.querySelectorAll('.pd-thumbnail').forEach(el => el.classList.add('border-light'));
        thumbDiv.classList.remove('border-light');
        thumbDiv.classList.add('border-dark');
      };
      thumbsContainer.appendChild(thumbDiv);
    });
  }

  // Modal Gallery Logic
  const galleryModalImg = document.getElementById('gallery-modal-img');
  window.openGalleryModal = function() {
    if (galleryModalImg) galleryModalImg.src = productImages[currentImageIndex];
    const modalEl = document.getElementById('galleryModal');
    if (modalEl && typeof bootstrap !== 'undefined') {
      const myModal = new bootstrap.Modal(modalEl);
      myModal.show();
    }
  };
  
  window.nextGalleryImage = function() {
    currentImageIndex = (currentImageIndex + 1) % productImages.length;
    if (galleryModalImg) galleryModalImg.src = productImages[currentImageIndex];
  };
  
  window.prevGalleryImage = function() {
    currentImageIndex = (currentImageIndex - 1 + productImages.length) % productImages.length;
    if (galleryModalImg) galleryModalImg.src = productImages[currentImageIndex];
  };

  // View All Photos button
  const viewAllBtn = document.getElementById('pd-view-all-photos');
  if (viewAllBtn) {
    viewAllBtn.addEventListener('click', window.openGalleryModal);
  }

  // Bind zoom triggers
  const zoomBtn = document.querySelector('.pd-zoom-btn');
  if (zoomBtn) {
    zoomBtn.addEventListener('click', window.openGalleryModal);
  }
  const mainImgWrapper = document.getElementById('pd-main-img-container');
  if (mainImgWrapper) {
    mainImgWrapper.addEventListener('click', window.openGalleryModal);
  }
  const galleryPrevBtn = document.getElementById('gallery-prev');
  if (galleryPrevBtn) {
    galleryPrevBtn.addEventListener('click', window.prevGalleryImage);
  }
  const galleryNextBtn = document.getElementById('gallery-next');
  if (galleryNextBtn) {
    galleryNextBtn.addEventListener('click', window.nextGalleryImage);
  }

  // Fetch Variations
  let variationsData = null;
  let selectedColorId = null;
  let selectedOptionId = null;
  let selectedSizeId = null;

  async function fetchVariations() {
    try {
      const res = await fetch(`ajax/get-product-variations.php?id=${productId}`);
      const data = await res.json();
      if(data.success && data.variations && data.variations.length > 0) {
        variationsData = data;
        const legacyContainer = document.getElementById('pd-legacy-container');
        if(legacyContainer) legacyContainer.classList.add('d-none');
        
        const varContainer = document.getElementById('pd-variations-container');
        if(varContainer) varContainer.classList.remove('d-none');
        
        initVariationsUI();
      } else {
        initLegacyUI();
      }
    } catch(err) {
      console.error(err);
      initLegacyUI();
    }
  }

  function initLegacyUI() {
      // Legacy Sizes
      const sizesContainer = document.getElementById('pd-legacy-sizes');
      if (sizesContainer) {
        sizesContainer.innerHTML = '';
        if (product.sizes && product.sizes.length > 0) {
          product.sizes.forEach((size, idx) => {
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'btn border rounded-0 px-3 py-2 size-btn fw-medium fs-8';
            btn.textContent = size;
            btn.style.borderColor = '#dee2e6';
            
            if (idx === 0 && product.availability !== 'Out of Stock') {
              selectedSize = size;
              btn.classList.add('border-dark', 'bg-dark', 'text-white');
            }
            
            btn.onclick = () => {
              document.querySelectorAll('.size-btn').forEach(el => el.classList.remove('border-dark', 'bg-dark', 'text-white'));
              btn.classList.add('border-dark', 'bg-dark', 'text-white');
              selectedSize = size;
            };
            sizesContainer.appendChild(btn);
          });
        } else {
          sizesContainer.innerHTML = '<span class="text-muted">One Size</span>';
          selectedSize = 'One Size';
        }
      }

      // Legacy Colors
      const colorSelect = document.getElementById('pd-legacy-color');
      if (colorSelect) {
        colorSelect.innerHTML = ''; // clear existing options
        if (product.colors && product.colors.length > 0) {
          product.colors.forEach((color, idx) => {
            const option = document.createElement('option');
            option.value = color;
            option.textContent = color;
            if (idx === 0) option.selected = true;
            colorSelect.appendChild(option);
          });
        } else {
          const option = document.createElement('option');
          option.value = 'As Pictured';
          option.textContent = 'As Pictured';
          option.selected = true;
          colorSelect.appendChild(option);
        }
      }
  }

  function initVariationsUI() {
      if(!variationsData) return;
      
      const { colors, options, sizes, variations } = variationsData;
      
      const colorsContainer = document.getElementById('pd-colors');
      const optionsContainer = document.getElementById('pd-options');
      const sizesContainer = document.getElementById('pd-sizes');
      const colorSection = document.getElementById('pd-color-section');
      const optionSection = document.getElementById('pd-option-section');
      const sizeSection = document.getElementById('pd-size-section');

      // Colors
      if(colors && colors.length > 0) {
          colorsContainer.innerHTML = '';
          colors.forEach(c => {
              const btn = document.createElement('button');
              btn.className = 'btn border rounded-0 px-3 py-2 var-color-btn fw-medium fs-8';
              btn.textContent = c.color_name;
              btn.dataset.id = c.id;
              if (c.image) {
                // If there's a thumbnail image, we could use it, but text is fine.
              }
              btn.onclick = () => selectColor(c.id);
              colorsContainer.appendChild(btn);
          });
      } else {
          colorSection.classList.add('d-none');
      }

      // Options
      if(options && options.length > 0) {
          optionsContainer.innerHTML = '';
          options.forEach(o => {
              const btn = document.createElement('button');
              btn.className = 'btn border rounded-0 px-3 py-2 var-option-btn text-start fw-medium fs-8';
              btn.textContent = o.option_name;
              btn.dataset.id = o.id;
              btn.onclick = () => selectOption(o.id);
              optionsContainer.appendChild(btn);
          });
      } else {
          optionSection.classList.add('d-none');
      }

      // Sizes
      if(sizes && sizes.length > 0) {
          sizesContainer.innerHTML = '';
          sizes.forEach(s => {
              const btn = document.createElement('button');
              btn.className = 'btn border rounded-0 px-3 py-2 var-size-btn fw-medium fs-8';
              btn.textContent = s.name;
              btn.dataset.id = s.id;
              btn.onclick = () => selectSize(s.id);
              sizesContainer.appendChild(btn);
          });
      } else {
          sizeSection.classList.add('d-none');
      }

      // Select default configuration
      const activeVars = variations.filter(v => parseInt(v.status) === 1);
      if (activeVars.length > 0) {
          const first = activeVars[0];
          if(first.color_id) selectColor(first.color_id, false);
          if(first.option_id) selectOption(first.option_id, false);
          if(first.size_id) selectSize(first.size_id, false);
          updateVariationState();
      }
  }

  function selectColor(id, update = true) {
      selectedColorId = id;
      document.querySelectorAll('.var-color-btn').forEach(btn => {
          if(btn.dataset.id == id) {
              btn.classList.add('border-dark', 'bg-dark', 'text-white');
              document.getElementById('pd-selected-color-name').textContent = btn.textContent;
          } else {
              btn.classList.remove('border-dark', 'bg-dark', 'text-white');
          }
      });
      
      // Update Main Image if this color has an image
      const cObj = variationsData.colors.find(c => c.id == id);
      if(cObj && cObj.image) {
          const mainImg = document.getElementById('pd-main-img');
          if(mainImg) mainImg.src = cObj.image;
      }
      
      if(update) updateVariationState();
  }

  function selectOption(id, update = true) {
      selectedOptionId = id;
      document.querySelectorAll('.var-option-btn').forEach(btn => {
          if(btn.dataset.id == id) {
              btn.classList.add('border-dark', 'bg-light', 'text-dark');
              btn.style.borderWidth = '2px';
              document.getElementById('pd-selected-option-name').textContent = btn.textContent;
          } else {
              btn.classList.remove('border-dark', 'bg-light', 'text-dark');
              btn.style.borderWidth = '1px';
          }
      });
      if(update) updateVariationState();
  }

  function selectSize(id, update = true) {
      selectedSizeId = id;
      document.querySelectorAll('.var-size-btn').forEach(btn => {
          if(btn.dataset.id == id) {
              btn.classList.add('border-dark', 'bg-dark', 'text-white');
              document.getElementById('pd-selected-size-name').textContent = btn.textContent;
          } else {
              btn.classList.remove('border-dark', 'bg-dark', 'text-white');
          }
      });
      if(update) updateVariationState();
  }

  function updateVariationState() {
      if(!variationsData) return;
      
      // Find matching variation
      const match = variationsData.variations.find(v => 
          (v.color_id == selectedColorId || v.color_id === null) &&
          (v.option_id == selectedOptionId || v.option_id === null) &&
          (v.size_id == selectedSizeId || v.size_id === null) &&
          parseInt(v.status) === 1
      );

      const errBox = document.getElementById('pd-variation-error');
      const addBtn = document.getElementById('pd-add-to-cart');
      const hiddenVar = document.getElementById('pd-selected-variation-id');

      if(match) {
          hiddenVar.value = match.id;
          
          if(parseInt(match.stock_quantity) <= 0) {
              errBox.textContent = 'This combination is currently out of stock.';
              errBox.classList.remove('d-none');
              addBtn.disabled = true;
              addBtn.textContent = 'OUT OF STOCK';
          } else {
              errBox.classList.add('d-none');
              addBtn.disabled = false;
              addBtn.textContent = 'Buy Now';
          }

          // Update prices
          const priceEl = document.getElementById('pd-price');
          const discountBadge = document.getElementById('pd-discount-badge');
          if(priceEl) {
              const priceStr = (typeof formatPrice !== 'undefined') ? formatPrice(match.price) : `PKR ${parseFloat(match.price).toLocaleString()}`;
              if(match.original_price && parseFloat(match.original_price) > parseFloat(match.price)) {
                  const origStr = (typeof formatPrice !== 'undefined') ? formatPrice(match.original_price) : `PKR ${parseFloat(match.original_price).toLocaleString()}`;
                  const savings = parseFloat(match.original_price) - parseFloat(match.price);
                  const savingsStr = (typeof formatPrice !== 'undefined') ? formatPrice(savings) : `PKR ${savings.toLocaleString()}`;
                  priceEl.innerHTML = `<span class="text-muted text-decoration-line-through me-2 fs-5">${origStr}</span><span class="text-accent-green">${priceStr}</span> <span class="fs-6 text-danger ms-2 fw-bold">SAVERS.${savingsStr}</span>`;
                  if(discountBadge) discountBadge.style.display = 'inline-block';
              } else {
                  priceEl.textContent = priceStr;
                  if(discountBadge) discountBadge.style.display = 'none';
              }
          }
          
          // Availability text
          const availEl = document.getElementById('pd-availability');
          if(availEl) {
              if(parseInt(match.stock_quantity) <= 0) {
                  availEl.textContent = 'Out of Stock';
                  availEl.classList.replace('text-dark', 'text-danger');
              } else {
                  availEl.textContent = `${match.stock_quantity} In Stock`;
                  availEl.classList.replace('text-danger', 'text-dark');
              }
          }
      } else {
          hiddenVar.value = '';
          errBox.textContent = 'This combination is currently unavailable.';
          errBox.classList.remove('d-none');
          addBtn.disabled = true;
          addBtn.textContent = 'UNAVAILABLE';
      }
      
      // We could also gray out sizes/options that have 0 stock for current selections
  }

  fetchVariations();

  // Quantity
  const qtyInput = document.getElementById('pd-qty');
  window.updateQty = function(change) {
    if (!qtyInput) return;
    let current = parseInt(qtyInput.value) || 1;
    current += change;
    if (current < 1) current = 1;
    qtyInput.value = current;
  };

  const qtyMinusBtn = document.getElementById('pd-qty-minus');
  if (qtyMinusBtn) {
    qtyMinusBtn.addEventListener('click', () => window.updateQty(-1));
  }
  const qtyPlusBtn = document.getElementById('pd-qty-plus');
  if (qtyPlusBtn) {
    qtyPlusBtn.addEventListener('click', () => window.updateQty(1));
  }

  // Primary Action Button (Buy Now)
  const scheduleBtn = document.getElementById('pd-add-to-cart');
  if (scheduleBtn) {
    scheduleBtn.addEventListener('click', () => {
      const qty = qtyInput ? (parseInt(qtyInput.value) || 1) : 1;
      
      let cartColor = document.getElementById('pd-legacy-color') ? document.getElementById('pd-legacy-color').value : '';
      let cartOption = '';
      let cartSize = selectedSize || 'One Size';
      let variationId = null;

      if(variationsData && variationsData.variations.length > 0) {
          variationId = document.getElementById('pd-selected-variation-id').value;
          if(!variationId) return; // Unavailable
          cartColor = document.getElementById('pd-selected-color-name').textContent;
          cartOption = document.getElementById('pd-selected-option-name').textContent;
          cartSize = document.getElementById('pd-selected-size-name').textContent;
      }

      if (typeof addToCart === 'function') {
        addToCart(product.id, qty, {
            variationId: variationId,
            color: cartColor,
            option: cartOption,
            size: cartSize
        });
      }
    });
  }

  // Secondary Action Button (Whatsapp)
  const saveBtn = document.getElementById('pd-save-btn');
  if (saveBtn) {
    saveBtn.addEventListener('click', function() {
      const message = `Hi, I'm interested in buying ${product.name} (Size: ${selectedSize || 'One Size'}) from Libas-E-Khas.`;
      const whatsappUrl = `https://wa.me/923001234567?text=${encodeURIComponent(message)}`;
      window.open(whatsappUrl, '_blank');
    });
  }

  // Related Products
  const relatedGrid = document.getElementById('pd-related-grid');
  if (relatedGrid) {
    relatedGrid.innerHTML = '';
    const related = products.filter(p => p.id !== product.id && (p.category === product.category || p.collection === product.collection)).slice(0, 4);
    
    if (related.length === 0) {
      related.push(...products.filter(p => p.id !== product.id).slice(0, 4));
    }
    
    related.forEach(relatedProd => {
      const priceStr = (typeof formatPrice !== 'undefined') ? formatPrice(relatedProd.price) : `PKR ${relatedProd.price.toLocaleString()}`;
      let priceHtml = `<div class="product-price">${priceStr}</div>`;
      let badgeHtml = '';
      
      if (relatedProd.sale) {
        priceHtml = `
          <div class="product-price">
            <span class="text-muted text-decoration-line-through me-2 fs-6">${priceStr}</span>
            <span class="text-accent-green">${(typeof formatPrice !== 'undefined') ? formatPrice(relatedProd.salePrice) : `PKR ${relatedProd.salePrice.toLocaleString()}`}</span>
          </div>
        `;
        badgeHtml = `<div class="badge-sale">Sale</div>`;
      }

      const col = document.createElement('div');
      col.className = 'col-12 col-sm-6 col-lg-3 mb-4 fade-up visible';
      
      col.innerHTML = `
        <div class="product-card h-100" data-id="${relatedProd.id}">
          ${badgeHtml}
          <div class="product-img-wrapper cursor-pointer" data-action="view-details">
            <img src="${relatedProd.image}" alt="${relatedProd.name}" class="product-img-main">
            <div class="product-img-overlay"></div>
            <div class="product-card-actions">
              ${relatedProd.availability === 'Out of Stock' 
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
            <div class="product-category">${relatedProd.category}</div>
            <h3 class="product-title cursor-pointer" data-action="view-details">${relatedProd.name}</h3>
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
            addToCart(relatedProd.id);
          }
        } else if (action === 'view-details') {
          e.stopPropagation();
          window.location.href = `product-details.php?id=${relatedProd.id}`;
        }
      });

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
        if (ratingValueInput) ratingValueInput.value = rating;
        
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
    reviewForm.addEventListener('submit', async function(e) {
      e.preventDefault();
      const rating = ratingValueInput ? ratingValueInput.value : "0";
      if (rating === "0") {
        if (typeof Swal !== 'undefined') {
          Swal.fire({
            icon: 'warning',
            title: 'Rating Required',
            text: 'Please select a rating.',
            confirmButtonColor: '#c8a97e'
          });
        } else {
          alert("Please select a rating.");
        }
        return;
      }
      
      const submitBtn = reviewForm.querySelector('button[type="submit"]');
      const originalText = submitBtn.textContent;
      submitBtn.disabled = true;
      submitBtn.textContent = "SUBMITTING...";
      
      const name = document.getElementById('reviewName').value;
      const email = document.getElementById('reviewEmail').value;
      const text = document.getElementById('reviewText').value;

      try {
        const formData = new FormData();
        formData.append('product_id', product.id);
        formData.append('name', name);
        formData.append('email', email);
        formData.append('rating', rating);
        formData.append('review_text', text);

        const res = await fetch('ajax/submit-review.php', {
          method: 'POST',
          body: formData
        });
        
        const data = await res.json();
        
        if (data.success) {
          if (typeof Swal !== 'undefined') {
            Swal.fire({
              icon: 'success',
              title: 'Thank You!',
              text: data.message || "Thank you for your review! It has been submitted for moderation.",
              confirmButtonColor: '#c8a97e'
            });
          } else {
            alert(data.message || "Thank you for your review! It has been submitted for moderation.");
          }
          const modalEl = document.getElementById('reviewModal');
          if (modalEl && typeof bootstrap !== 'undefined') {
            const reviewModal = bootstrap.Modal.getInstance(modalEl);
            if (reviewModal) reviewModal.hide();
          }
          reviewForm.reset();
          if (ratingValueInput) ratingValueInput.value = "0";
          ratingStars.forEach(s => {
            s.classList.remove('fas');
            s.classList.add('far');
          });
        } else {
          if (typeof Swal !== 'undefined') {
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: data.error || "Failed to submit review.",
              confirmButtonColor: '#c8a97e'
            });
          } else {
            alert(data.error || "Failed to submit review.");
          }
        }
      } catch (err) {
        console.error("Error submitting review:", err);
        if (typeof Swal !== 'undefined') {
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'An error occurred. Please try again.',
            confirmButtonColor: '#c8a97e'
          });
        } else {
          alert("An error occurred. Please try again.");
        }
      } finally {
        submitBtn.disabled = false;
        submitBtn.textContent = originalText;
      }
    });
  }
});

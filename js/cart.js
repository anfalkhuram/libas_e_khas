// Cart Functionality using LocalStorage

let cart = JSON.parse(localStorage.getItem('libasCart')) || [];

function saveCart() {
  localStorage.setItem('libasCart', JSON.stringify(cart));
  updateCartUI();
}

function addToCart(productId, quantity = 1, variationData = null) {
  const product = products.find(p => p.id === productId);
  if (!product) return;

  if (product.availability === 'Out of Stock') {
    if (typeof Swal !== 'undefined') {
      Swal.fire({
        icon: 'error',
        title: 'Out of Stock',
        text: 'Sorry, this product is currently out of stock.',
        confirmButtonColor: '#c8a97e'
      });
    } else {
      alert('Sorry, this product is currently out of stock.');
    }
    return;
  }

  const cartItemId = variationData && variationData.variationId 
    ? `${productId}_${variationData.variationId}` 
    : productId.toString();

  const existingItem = cart.find(item => item.cartItemId === cartItemId);
  if (existingItem) {
    existingItem.quantity += quantity;
  } else {
    cart.push({
      ...product,
      quantity,
      cartItemId,
      variationId: variationData ? variationData.variationId : null,
      color: variationData ? variationData.color : '',
      option: variationData ? variationData.option : '',
      size: variationData ? variationData.size : 'Standard'
    });
  }
  
  saveCart();
  
  // Show Offcanvas Cart using Bootstrap API
  const cartOffcanvasEl = document.getElementById('cartOffcanvas');
  if (cartOffcanvasEl) {
    const bsOffcanvas = bootstrap.Offcanvas.getInstance(cartOffcanvasEl) || new bootstrap.Offcanvas(cartOffcanvasEl);
    bsOffcanvas.show();
  }
}

function removeFromCart(cartItemId) {
  cart = cart.filter(item => item.cartItemId !== cartItemId && item.id !== cartItemId);
  saveCart();
}

function updateQuantity(cartItemId, newQuantity) {
  if (newQuantity < 1) return;
  const item = cart.find(i => i.cartItemId === cartItemId || i.id === cartItemId);
  if (item) {
    item.quantity = newQuantity;
    saveCart();
  }
}

function calculateSubtotal() {
  return cart.reduce((total, item) => {
    const price = item.sale ? item.salePrice : item.price;
    return total + (price * item.quantity);
  }, 0);
}

function updateCartUI() {
  // Update badges
  const cartCountElements = document.querySelectorAll('.cart-count');
  const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
  cartCountElements.forEach(el => el.textContent = totalItems);

  // Update Cart Drawer content
  const cartItemsContainer = document.getElementById('cart-items');
  const cartSubtotalEl = document.getElementById('cart-subtotal');
  
  if (!cartItemsContainer || !cartSubtotalEl) return;
  
  cartItemsContainer.innerHTML = '';

  if (cart.length === 0) {
    cartItemsContainer.innerHTML = '<p class="text-center text-muted mt-5">Your bag is empty.</p>';
    cartSubtotalEl.textContent = formatPrice(0);
    return;
  }

  cart.forEach(item => {
    const price = item.sale ? item.salePrice : item.price;
    const itemEl = document.createElement('div');
    itemEl.className = 'd-flex mb-4 align-items-center';
    
    let varInfoHtml = '';
    if (item.variationId || (item.size && item.size !== 'Standard')) {
        varInfoHtml = `<div class="text-muted mb-1" style="font-size: 0.8rem; line-height: 1.2;">`;
        if(item.color) varInfoHtml += `<div>Color: ${item.color}</div>`;
        if(item.option) varInfoHtml += `<div>Option: ${item.option}</div>`;
        if(item.size) varInfoHtml += `<div>Size: ${item.size}</div>`;
        varInfoHtml += `</div>`;
    }

    const uid = item.cartItemId || item.id;

    itemEl.innerHTML = `
      <img src="${item.image}" alt="${item.name}" style="width: 80px; height: 100px; object-fit: cover; margin-right: 1rem;">
      <div class="flex-grow-1">
        <h6 class="mb-1" style="font-family: var(--font-heading);">${item.name}</h6>
        ${varInfoHtml}
        <p class="mb-2 text-muted" style="font-size: 0.9rem;">${formatPrice(price)}</p>
        <div class="d-flex align-items-center border" style="width: 100px;">
          <button class="btn btn-sm px-2 py-1" onclick="updateQuantity('${uid}', ${item.quantity - 1})">-</button>
          <span class="mx-auto" style="font-size: 0.9rem;">${item.quantity}</span>
          <button class="btn btn-sm px-2 py-1" onclick="updateQuantity('${uid}', ${item.quantity + 1})">+</button>
        </div>
      </div>
      <button class="btn text-muted" onclick="removeFromCart('${uid}')">
        <i class="fas fa-times"></i>
      </button>
    `;
    cartItemsContainer.appendChild(itemEl);
  });

  cartSubtotalEl.textContent = formatPrice(calculateSubtotal());
}

// Initialize UI on load
document.addEventListener('DOMContentLoaded', updateCartUI);

// Cart Functionality using LocalStorage

let cart = JSON.parse(localStorage.getItem('libasCart')) || [];

function saveCart() {
  localStorage.setItem('libasCart', JSON.stringify(cart));
  updateCartUI();
}

function addToCart(productId, quantity = 1) {
  const product = products.find(p => p.id === productId);
  if (!product) return;

  const existingItem = cart.find(item => item.id === productId);
  if (existingItem) {
    existingItem.quantity += quantity;
  } else {
    cart.push({
      ...product,
      quantity
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

function removeFromCart(productId) {
  cart = cart.filter(item => item.id !== productId);
  saveCart();
}

function updateQuantity(productId, newQuantity) {
  if (newQuantity < 1) return;
  const item = cart.find(i => i.id === productId);
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
    itemEl.innerHTML = `
      <img src="${item.image}" alt="${item.name}" style="width: 80px; height: 100px; object-fit: cover; margin-right: 1rem;">
      <div class="flex-grow-1">
        <h6 class="mb-1" style="font-family: var(--font-heading);">${item.name}</h6>
        <p class="mb-2 text-muted" style="font-size: 0.9rem;">${formatPrice(price)}</p>
        <div class="d-flex align-items-center border" style="width: 100px;">
          <button class="btn btn-sm px-2 py-1" onclick="updateQuantity(${item.id}, ${item.quantity - 1})">-</button>
          <span class="mx-auto" style="font-size: 0.9rem;">${item.quantity}</span>
          <button class="btn btn-sm px-2 py-1" onclick="updateQuantity(${item.id}, ${item.quantity + 1})">+</button>
        </div>
      </div>
      <button class="btn text-muted" onclick="removeFromCart(${item.id})">
        <i class="fas fa-times"></i>
      </button>
    `;
    cartItemsContainer.appendChild(itemEl);
  });

  cartSubtotalEl.textContent = formatPrice(calculateSubtotal());
}

// Initialize UI on load
document.addEventListener('DOMContentLoaded', updateCartUI);

document.addEventListener('DOMContentLoaded', () => {
    let cart = [];
    let totalAmount = 0;

    const productList = document.getElementById('productList');
    const cartItems = document.getElementById('cartItems');
    const totalPrice = document.getElementById('totalPrice');
    const cartSection = document.getElementById('cartSection');
    const productListSection = document.getElementById('productListSection');
// Sign Out functionality
document.getElementById('signOutBtn').addEventListener('click', () => {
    // Redirect to the login page
    window.location.href = 'login.html'; // Change this to the actual login page file name
});

    
    const searchInput = document.getElementById('searchInput');

    
    // Display Products
    function displayProducts(filteredProducts) {
        productList.innerHTML = '';
        filteredProducts.forEach(product => {
            const productCard = document.createElement('div');
            productCard.classList.add('product-card');
            productCard.innerHTML = `
                <img src="${product.image}" alt="${product.name}">
                <h3>${product.name}</h3>
                <p>₹${product.price.toFixed(2)}</p>
                <button onclick="addToCart(${product.id})">Add to Cart</button>
            `;
            productList.appendChild(productCard);
        });
    }
   // Add to Cart
window.addToCart = function (productId) {
    const product = products.find(p => p.id === productId);
    const existingProduct = cart.find(p => p.id === productId);
    if (existingProduct) {
        existingProduct.quantity++;
    } else {
        cart.push({ ...product, quantity: 1 });
    }
    updateCart();
    showPopup(`${product.name} has been added to your cart!`);
};

function showPopup(message) {
    const popup = document.getElementById('popup');
    const popupMessage = document.getElementById('popupMessage');
    popupMessage.textContent = message;
    popup.classList.remove('hidden');
    setTimeout(hidePopup, 3000); // Automatically hide after 3 seconds
}
// Save cart to localStorage
function saveCartToLocalStorage() {
    localStorage.setItem('cart', JSON.stringify(cart));
}

function hidePopup() {
    const popup = document.getElementById('popup');
    popup.classList.add('hidden');
}
// Update Cart function (also save to localStorage)
function updateCart() {
    cartItems.innerHTML = '';
    totalAmount = 0;
    cart.forEach(item => {
        totalAmount += item.price * item.quantity;
        const li = document.createElement('li');
        li.innerHTML = `
            ${item.name} - ₹${item.price.toFixed(2)} x ${item.quantity}
            <button onclick="decreaseQuantity(${item.id})">-</button>
            <button onclick="increaseQuantity(${item.id})">+</button>
            <button onclick="removeFromCart(${item.id})">Remove</button>
        `;
        cartItems.appendChild(li);
    });
    totalPrice.textContent = totalAmount.toFixed(2);
    saveCartToLocalStorage(); // Save the cart to localStorage after updating
}

// Cart Button Click - Redirect to Cart Page
// Show the Cart Section
document.getElementById('cartBtn').addEventListener('click', () => {
    // Hide other sections
    productListSection.style.display = 'none';
       
    // Show cart section
    cartSection.style.display = 'block';
    
    // Update the cart view
    updateCart();
});

// Increase Quantity
window.increaseQuantity = function (productId) {
    const product = cart.find(item => item.id === productId);
    if (product) {
        product.quantity++;
        updateCart();
    }
};

// Decrease Quantity
window.decreaseQuantity = function (productId) {
    const product = cart.find(item => item.id === productId);
    if (product) {
        product.quantity--;
        if (product.quantity <= 0) {
            removeFromCart(productId);
        } else {
            updateCart();
        }
    }
};

// Remove from Cart
window.removeFromCart = function (productId) {
    cart = cart.filter(item => item.id !== productId);
    updateCart();
};
  
    // Navigation
    document.getElementById('ProductsBtn').addEventListener('click', () => {
        productListSection.style.display = 'block';
        cartSection.style.display = 'none';
        displayProducts(products);
    });

    document.getElementById('cartBtn').addEventListener('click', () => {
        productListSection.style.display = 'none';
        cartSection.style.display = 'block';
        });

    // Search Functionality
    searchInput.addEventListener('input', (e) => {
        const query = e.target.value.toLowerCase();
        const filteredProducts = products.filter(product =>
            product.name.toLowerCase().includes(query)
        );
        displayProducts(filteredProducts);
    });

    // Initialize Product Display
    displayProducts(products);
});

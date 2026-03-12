// Size selection functionality
document.querySelectorAll('.size-btn').forEach(button => {
    button.addEventListener('click', function() {
        // Remove selected class from all buttons in the same group
        this.parentElement.querySelectorAll('.size-btn').forEach(btn => {
            btn.classList.remove('selected');
        });
        // Add selected class to clicked button
        this.classList.add('selected');
    });
});

// Search functionality
const searchInput = document.querySelector('.search-bar input');
const searchButton = document.querySelector('.search-bar button');

searchButton.addEventListener('click', performSearch);
searchInput.addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        performSearch();
    }
});

function performSearch() {
    const searchTerm = searchInput.value.trim();
    if (searchTerm) {
        window.location.href = `search.php?q=${encodeURIComponent(searchTerm)}`;
    }
}

// Cart functionality
let cart = JSON.parse(localStorage.getItem('cart')) || [];

function addToCart(productId) {
    const sizeBtn = document.querySelector('.size-btn.selected');
    if (!sizeBtn) {
        alert('Please select a size');
        return;
    }

    const size = sizeBtn.textContent;
    const product = {
        id: productId,
        size: size,
        quantity: 1
    };

    // Check if product already exists in cart
    const existingItem = cart.find(item => item.id === productId && item.size === size);
    if (existingItem) {
        existingItem.quantity += 1;
    } else {
        cart.push(product);
    }

    localStorage.setItem('cart', JSON.stringify(cart));
    updateCartCount();
    alert('Product added to cart!');
}

function updateCartCount() {
    const cartCount = document.querySelector('.cart-count');
    if (cartCount) {
        const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
        cartCount.textContent = totalItems;
    }
}

// Initialize cart count on page load
document.addEventListener('DOMContentLoaded', updateCartCount);

// Payment functionality
function processPayment() {
    const uid = document.getElementById('payment-uid').value;
    if (!uid) {
        alert('Please enter your UID');
        return;
    }

    // Here you would typically send the payment details to your server
    // For demo purposes, we'll just show a success message
    alert('Payment successful! Your order has been placed.');
    localStorage.removeItem('cart');
    window.location.href = 'index.php';
}

// Responsive menu toggle
const menuToggle = document.querySelector('.menu-toggle');
const navLinks = document.querySelector('.nav-links');

if (menuToggle) {
    menuToggle.addEventListener('click', () => {
        navLinks.classList.toggle('active');
    });
}

// Product filtering
document.querySelectorAll('.category-filters a').forEach(link => {
    link.addEventListener('click', function(e) {
        e.preventDefault();
        const category = this.getAttribute('href').split('=')[1];
        window.location.href = `men.php?category=${category}`;
    });
}); 
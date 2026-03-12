<?php
session_start();
include 'config/db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Babies Collection - Kumar Brothers</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .navbar {
            background-color: #333;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
        }
        .logo {
            color: white;
            font-size: 1.5rem;
            font-weight: bold;
            text-decoration: none;
        }
        .nav-links {
            display: flex;
            gap: 2rem;
            align-items: center;
        }
        .nav-links a {
            color: white;
            text-decoration: none;
            transition: color 0.3s;
        }
        .nav-links a:hover {
            color: #007bff;
        }
        .main-content {
            padding-top: 80px;
        }
        .category-hero {
            position: relative;
            height: 400px;
            overflow: hidden;
        }
        .hero-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .hero-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            color: white;
            z-index: 1;
        }
        .hero-content h1 {
            font-size: 3rem;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }
        .search-container {
            padding: 2rem;
            background-color: #f8f9fa;
        }
        .search-bar {
            display: flex;
            max-width: 600px;
            margin: 0 auto;
        }
        .search-bar input {
            flex: 1;
            padding: 0.5rem 1rem;
            border: 1px solid #ddd;
            border-radius: 4px 0 0 4px;
        }
        .search-bar button {
            padding: 0.5rem 1rem;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 0 4px 4px 0;
            cursor: pointer;
        }
        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 2rem;
            padding: 2rem;
        }
        .product-card {
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            transition: transform 0.3s;
        }
        .product-card:hover {
            transform: translateY(-5px);
        }
        .product-image {
            width: 100%;
            height: 300px;
            object-fit: cover;
        }
        .product-info {
            padding: 1rem;
        }
        .product-title {
            font-size: 1.2rem;
            margin-bottom: 0.5rem;
        }
        .product-brand {
            color: #666;
            margin-bottom: 0.5rem;
        }
        .product-price {
            font-weight: bold;
            color: #007bff;
            margin-bottom: 1rem;
        }
        .size-options {
            display: flex;
            gap: 0.5rem;
            margin-bottom: 1rem;
        }
        .size-btn {
            padding: 0.5rem;
            border: 1px solid #ddd;
            background: none;
            cursor: pointer;
            border-radius: 4px;
            transition: all 0.3s;
        }
        .size-btn:hover, .size-btn.selected {
            background-color: #007bff;
            color: white;
            border-color: #007bff;
        }
        .add-to-cart {
            width: 100%;
            padding: 0.5rem;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .add-to-cart:hover {
            background-color: #0056b3;
        }
        .profile-dropdown {
            position: relative;
            display: flex;
            align-items: center;
        }
        .profile-icon {
            color: white;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .profile-icon i {
            font-size: 1.5rem;
        }
        .dropdown-content {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-left: 1rem;
        }
        .dropdown-content a {
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .dropdown-content a:hover {
            color: #007bff;
        }
        .dropdown-content a i {
            font-size: 1rem;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <a href="index.php" class="logo">Kumar Brothers</a>
        <div class="nav-links">
            <a href="index.php">Home</a>
            <a href="men.php">Men</a>
            <a href="women.php">Women</a>
            <a href="kids.php">Kids</a>
            <a href="cart.php"><i class="fas fa-shopping-cart"></i> Cart</a>
            <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']): ?>
                <div class="profile-dropdown">
                    <a href="profile.php" class="profile-icon" style="text-decoration: none;">
                        <i class="fas fa-user-circle"></i>
                        <span>My Profile</span>
                    </a>
                </div>
            <?php else: ?>
                <a href="login.php">Login</a>
                <a href="register.php">Register</a>
            <?php endif; ?>
        </div>
    </nav>

    <main class="main-content">
        <section class="category-hero">
            <img src="kid_img/b1.jpeg" alt="Babies Collection" class="hero-image">
            <div class="hero-content">
                <h1>Babies Collection</h1>
                <p>Soft and comfortable clothing for your little ones</p>
            </div>
        </section>

        <section class="search-container">
            <div class="search-bar">
                <input type="text" id="searchInput" placeholder="Search baby clothing...">
                <button onclick="searchProducts()"><i class="fas fa-search"></i> Search</button>
            </div>
        </section>

        <section class="products-grid">
            <div class="product-card">
                <img src="kid_img/b1.jpeg" alt="Baby Bodysuit" class="product-image">
                <div class="product-info">
                    <h3 class="product-title">Cotton Bodysuit</h3>
                    <p class="product-brand">Baby Comfort</p>
                    <p class="product-price">₹299</p>
                    <div class="size-options">
                        <button class="size-btn" onclick="selectSize(this)">0-3M</button>
                        <button class="size-btn" onclick="selectSize(this)">3-6M</button>
                        <button class="size-btn" onclick="selectSize(this)">6-12M</button>
                        <button class="size-btn" onclick="selectSize(this)">12-18M</button>
                    </div>
                    <button class="add-to-cart" onclick="addToCart('Cotton Bodysuit', 299, 'kid_img/bb1.jpeg', 1)">Add to Cart</button>
                </div>
            </div>

            <div class="product-card">
                <img src="kid_img/b2.jpeg" alt="Baby Romper" class="product-image">
                <div class="product-info">
                    <h3 class="product-title">Printed Romper</h3>
                    <p class="product-brand">Baby Style</p>
                    <p class="product-price">₹399</p>
                    <div class="size-options">
                        <button class="size-btn" onclick="selectSize(this)">0-3M</button>
                        <button class="size-btn" onclick="selectSize(this)">3-6M</button>
                        <button class="size-btn" onclick="selectSize(this)">6-12M</button>
                        <button class="size-btn" onclick="selectSize(this)">12-18M</button>
                    </div>
                    <button class="add-to-cart" onclick="addToCart('Printed Romper', 399, 'kid_img/bb2.jpeg', 2)">Add to Cart</button>
                </div>
            </div>

            <div class="product-card">
                <img src="kid_img/b3.jpeg" alt="Baby Sleepsuit" class="product-image">
                <div class="product-info">
                    <h3 class="product-title">Fleece Sleepsuit</h3>
                    <p class="product-brand">Baby Warmth</p>
                    <p class="product-price">₹499</p>
                    <div class="size-options">
                        <button class="size-btn" onclick="selectSize(this)">0-3M</button>
                        <button class="size-btn" onclick="selectSize(this)">3-6M</button>
                        <button class="size-btn" onclick="selectSize(this)">6-12M</button>
                        <button class="size-btn" onclick="selectSize(this)">12-18M</button>
                    </div>
                    <button class="add-to-cart" onclick="addToCart('Fleece Sleepsuit', 499, 'kid_img/bb3.jpeg', 3)">Add to Cart</button>
                </div>
            </div>

            <div class="product-card">
                <img src="kid_img/b4.jpeg" alt="Baby Hat" class="product-image">
                <div class="product-info">
                    <h3 class="product-title">Knit Hat</h3>
                    <p class="product-brand">Baby Accessories</p>
                    <p class="product-price">₹199</p>
                    <div class="size-options">
                        <button class="size-btn" onclick="selectSize(this)">0-3M</button>
                        <button class="size-btn" onclick="selectSize(this)">3-6M</button>
                        <button class="size-btn" onclick="selectSize(this)">6-12M</button>
                        <button class="size-btn" onclick="selectSize(this)">12-18M</button>
                    </div>
                    <button class="add-to-cart" onclick="addToCart('Knit Hat', 199, 'kid_img/bb4.jpeg', 4)">Add to Cart</button>
                </div>
            </div>

            <div class="product-card">
                <img src="kid_img/b5.jpeg" alt="Baby Mittens" class="product-image">
                <div class="product-info">
                    <h3 class="product-title">Soft Mittens</h3>
                    <p class="product-brand">Baby Essentials</p>
                    <p class="product-price">₹149</p>
                    <div class="size-options">
                        <button class="size-btn" onclick="selectSize(this)">0-3M</button>
                        <button class="size-btn" onclick="selectSize(this)">3-6M</button>
                        <button class="size-btn" onclick="selectSize(this)">6-12M</button>
                        <button class="size-btn" onclick="selectSize(this)">12-18M</button>
                    </div>
                    <button class="add-to-cart" onclick="addToCart('Soft Mittens', 149, 'kid_img/bb5.jpeg', 5)">Add to Cart</button>
                </div>
            </div>
        </section>
    </main>

    <footer>
        <div class="footer-content">
            <div class="footer-section">
                <h3>About Us</h3>
                <p>Kumar Brothers - Your trusted fashion partner since 1990</p>
            </div>
            <div class="footer-section">
                <h3>Contact Us</h3>
                <p>Email: info@kumarbrothers.com</p>
                <p>Phone: +91 1234567890</p>
            </div>
            <div class="footer-section">
                <h3>Follow Us</h3>
                <div class="social-links">
                    <a href="#"><i class="fab fa-facebook"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2024 Kumar Brothers. All rights reserved.</p>
        </div>
    </footer>

    <script>
        function selectSize(button) {
            // Remove selected class from all buttons in the same group
            const parent = button.parentElement;
            parent.querySelectorAll('.size-btn').forEach(btn => btn.classList.remove('selected'));
            // Add selected class to clicked button
            button.classList.add('selected');
        }

        function addToCart(productName, price, imagePath, productId) {
            if (!<?php echo isset($_SESSION['logged_in']) ? 'true' : 'false'; ?>) {
                alert('Please login to add items to cart');
                window.location.href = 'login.php';
                return;
            }

            // Find the product card containing the product name
            const productCards = document.querySelectorAll('.product-card');
            let selectedSizeBtn = null;

            for (const card of productCards) {
                const title = card.querySelector('.product-title').textContent;
                if (title === productName) {
                    selectedSizeBtn = card.querySelector('.size-btn.selected');
                    break;
                }
            }

            if (!selectedSizeBtn) {
                alert('Please select a size');
                return;
            }

            const size = selectedSizeBtn.textContent;
            const cart = JSON.parse(localStorage.getItem('cart')) || [];
            
            // Check if product already exists in cart with same size and product ID
            const existingItem = cart.find(item => 
                item.name === productName && 
                item.size === size && 
                item.product_id === productId
            );
            
            if (existingItem) {
                existingItem.quantity += 1;
            } else {
                cart.push({
                    product_id: productId,  // Make sure product_id is first and properly set
                    name: productName,
                    price: price,
                    quantity: 1,
                    size: size,
                    image: imagePath
                });
            }
            
            localStorage.setItem('cart', JSON.stringify(cart));
            alert('Added to cart successfully!');
        }

        function searchProducts() {
            const searchTerm = document.getElementById('searchInput').value;
            alert(`Searching for: ${searchTerm}`);
        }
    </script>
</body>
</html> 
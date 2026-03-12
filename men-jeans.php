<?php
session_start();
include 'config/db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Men's Jeans - Kumar Brothers</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Reusing the same styles as men-shirts.php */
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
        .profile-dropdown {
            position: relative;
        }
        .profile-icon {
            color: white;
            font-size: 1.5rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .profile-icon i {
            font-size: 1.5rem;
        }
        .dropdown-content {
            display: none;
            position: absolute;
            right: 0;
            background: white;
            min-width: 200px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.1);
            border-radius: 4px;
            z-index: 1;
        }
        .profile-dropdown:hover .dropdown-content {
            display: block;
        }
        .dropdown-content a {
            color: #333;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            transition: background-color 0.3s;
        }
        .dropdown-content a:hover {
            background-color: #f8f9fa;
            color: #007bff;
        }
        .dropdown-content a i {
            margin-right: 8px;
            width: 20px;
            text-align: center;
        }
        .main-content {
            margin-top: 80px;
            padding: 2rem;
        }
        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }
        .product-card {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
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
            padding: 1.5rem;
        }
        .product-title {
            font-size: 1.2rem;
            margin-bottom: 0.5rem;
            color: #333;
        }
        .product-brand {
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }
        .product-price {
            font-size: 1.3rem;
            font-weight: bold;
            color: #007bff;
            margin-bottom: 1rem;
        }
        .add-to-cart {
            background: #007bff;
            color: white;
            border: none;
            padding: 0.8rem 1.5rem;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            transition: background 0.3s;
        }
        .add-to-cart:hover {
            background: #0056b3;
        }
        .search-container {
            max-width: 600px;
            margin: 2rem auto;
            padding: 0 1rem;
        }
        .search-bar {
            display: flex;
            gap: 1rem;
        }
        .search-bar input {
            flex: 1;
            padding: 1rem;
            border: 2px solid #ddd;
            border-radius: 8px;
            font-size: 1rem;
        }
        .search-bar button {
            padding: 0 2rem;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.3s;
        }
        .search-bar button:hover {
            background: #0056b3;
        }
        .category-hero {
            position: relative;
            width: 100%;
            height: 400px;
            overflow: hidden;
            margin-bottom: 2rem;
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
            background: rgba(0, 0, 0, 0.5);
            padding: 2rem;
            border-radius: 10px;
        }
        .hero-content h1 {
            font-size: 3rem;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }
        .hero-content p {
            font-size: 1.2rem;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
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
                    <div class="profile-icon">
                        <i class="fas fa-user-circle"></i>
                        <span>My Profile</span>
                    </div>
                    <div class="dropdown-content">
                        <a href="profile.php"><i class="fas fa-user"></i> My Profile</a>
                        <a href="edit_profile.php"><i class="fas fa-edit"></i> Edit Profile</a>
                        <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
                    </div>
                </div>
            <?php else: ?>
                <a href="login.php">Login</a>
                <a href="register.php">Register</a>
            <?php endif; ?>
        </div>
    </nav>

    <main class="main-content">
        <section class="category-hero">
            <img src="img2/jeans.jpg" alt="Men's Jeans Collection" class="hero-image">
            <div class="hero-content">
                <h1>Men's Jeans Collection</h1>
                <p>Browse our stylish collection of premium denim jeans</p>
            </div>
        </section>

        <section class="search-container">
            <div class="search-bar">
                <input type="text" id="searchInput" placeholder="Search for jeans...">
                <button onclick="searchProducts()"><i class="fas fa-search"></i> Search</button>
            </div>
        </section>

        <section class="products-grid">
            <div class="product-card">
                <img src="img2/jeans1m.jpg" alt="Levi's Jeans" class="product-image">
                <div class="product-info">
                    <h3 class="product-title">Slim Fit Jeans</h3>
                    <p class="product-brand">Levi's</p>
                    <p class="product-price">₹2,999</p>
                    <div class="size-buttons">
                        <button class="size-btn" onclick="selectSize(this)">28</button>
                        <button class="size-btn" onclick="selectSize(this)">30</button>
                        <button class="size-btn" onclick="selectSize(this)">32</button>
                        <button class="size-btn" onclick="selectSize(this)">34</button>
                    </div>
                    <button class="add-to-cart" onclick="addToCart('Slim Fit Jeans', 2999, 'img2/jeans1m.jpg')">Add to Cart</button>
                </div>
            </div>
            <div class="product-card">
                <img src="img2/jeans2m.jpg" alt="Wrangler Jeans" class="product-image">
                <div class="product-info">
                    <h3 class="product-title">Regular Fit Jeans</h3>
                    <p class="product-brand">Wrangler</p>
                    <p class="product-price">₹2,499</p>
                    <div class="size-buttons">
                        <button class="size-btn" onclick="selectSize(this)">28</button>
                        <button class="size-btn" onclick="selectSize(this)">30</button>
                        <button class="size-btn" onclick="selectSize(this)">32</button>
                        <button class="size-btn" onclick="selectSize(this)">34</button>
                    </div>
                    <button class="add-to-cart" onclick="addToCart('Regular Fit Jeans', 2499, 'img2/jeans2m.jpg')">Add to Cart</button>
                </div>
            </div>
            <div class="product-card">
                <img src="img2/jeans3m.jpg" alt="Lee Jeans" class="product-image">
                <div class="product-info">
                    <h3 class="product-title">Relaxed Fit Jeans</h3>
                    <p class="product-brand">Lee</p>
                    <p class="product-price">₹2,799</p>
                    <div class="size-buttons">
                        <button class="size-btn" onclick="selectSize(this)">28</button>
                        <button class="size-btn" onclick="selectSize(this)">30</button>
                        <button class="size-btn" onclick="selectSize(this)">32</button>
                        <button class="size-btn" onclick="selectSize(this)">34</button>
                    </div>
                    <button class="add-to-cart" onclick="addToCart('Relaxed Fit Jeans', 2799, 'img2/jeans3m.jpg')">Add to Cart</button>
                </div>
            </div>
            <div class="product-card">
                <img src="img2/jeans4m.jpg" alt="Pepe Jeans" class="product-image">
                <div class="product-info">
                    <h3 class="product-title">Skinny Fit Jeans</h3>
                    <p class="product-brand">Pepe Jeans</p>
                    <p class="product-price">₹2,599</p>
                    <div class="size-buttons">
                        <button class="size-btn" onclick="selectSize(this)">28</button>
                        <button class="size-btn" onclick="selectSize(this)">30</button>
                        <button class="size-btn" onclick="selectSize(this)">32</button>
                        <button class="size-btn" onclick="selectSize(this)">34</button>
                    </div>
                    <button class="add-to-cart" onclick="addToCart('Skinny Fit Jeans', 2599, 'img2/jeans4m.jpg')">Add to Cart</button>
                </div>
            </div>
            <div class="product-card">
                <img src="img2/jeans5m.jpg" alt="US Polo Jeans" class="product-image">
                <div class="product-info">
                    <h3 class="product-title">Straight Fit Jeans</h3>
                    <p class="product-brand">US Polo</p>
                    <p class="product-price">₹2,399</p>
                    <div class="size-buttons">
                        <button class="size-btn" onclick="selectSize(this)">28</button>
                        <button class="size-btn" onclick="selectSize(this)">30</button>
                        <button class="size-btn" onclick="selectSize(this)">32</button>
                        <button class="size-btn" onclick="selectSize(this)">34</button>
                    </div>
                    <button class="add-to-cart" onclick="addToCart('Straight Fit Jeans', 2399, 'img2/jeans5m.jpg')">Add to Cart</button>
                </div>
            </div>
            <div class="product-card">
                <img src="img2/jeans6m.jpg" alt="Jack & Jones Jeans" class="product-image">
                <div class="product-info">
                    <h3 class="product-title">Tapered Fit Jeans</h3>
                    <p class="product-brand">Jack & Jones</p>
                    <p class="product-price">₹2,599</p>
                    <div class="size-buttons">
                        <button class="size-btn" onclick="selectSize(this)">28</button>
                        <button class="size-btn" onclick="selectSize(this)">30</button>
                        <button class="size-btn" onclick="selectSize(this)">32</button>
                        <button class="size-btn" onclick="selectSize(this)">34</button>
                    </div>
                    <button class="add-to-cart" onclick="addToCart('Tapered Fit Jeans', 2599, 'img2/jeans6m.jpg')">Add to Cart</button>
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
        function searchProducts() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const products = document.querySelectorAll('.product-card');
            
            products.forEach(product => {
                const title = product.querySelector('.product-title').textContent.toLowerCase();
                const brand = product.querySelector('.product-brand').textContent.toLowerCase();
                
                if (title.includes(searchTerm) || brand.includes(searchTerm)) {
                    product.style.display = 'block';
                } else {
                    product.style.display = 'none';
                }
            });
        }

        function selectSize(button) {
            // Remove selected class from all buttons in the same container
            const container = button.parentElement;
            container.querySelectorAll('.size-btn').forEach(btn => {
                btn.classList.remove('selected');
            });
            // Add selected class to clicked button
            button.classList.add('selected');
        }

        function addToCart(productName, price, imagePath) {
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
            
            // Check if product already exists in cart
            const existingItem = cart.find(item => item.name === productName && item.size === size);
            if (existingItem) {
                existingItem.quantity += 1;
            } else {
                cart.push({
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

        // Add event listener for Enter key
        document.getElementById('searchInput').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                searchProducts();
            }
        });
    </script>
</body>
</html> 
<?php
session_start();
include 'config/db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Men's Accessories - Kumar Brothers</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Reusing the same styles */
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
        .hero-content p {
            font-size: 1.2rem;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
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
            <img src="img2/a1.jpeg" alt="Men's Accessories Collection" class="hero-image">
            <div class="hero-content">
                <h1>Men's Accessories Collection</h1>
                <p>Discover our premium collection of stylish accessories</p>
            </div>
        </section>

        <section class="search-container">
            <div class="search-bar">
                <input type="text" id="searchInput" placeholder="Search for accessories...">
                <button onclick="searchProducts()"><i class="fas fa-search"></i> Search</button>
            </div>
        </section>

        <section class="products-grid">
            <div class="product-card">
                <img src="img2/a1.jpeg" alt="Premium Watch" class="product-image">
                <div class="product-info">
                    <h3 class="product-title">Premium Smart Watch</h3>
                    <p class="product-brand">Fossil</p>
                    <p class="product-price">₹12,999</p>
                    <button class="add-to-cart" onclick="addToCart('Premium Smart Watch', 12999, 'img2/a1.jpeg', 1)">Add to Cart</button>
                </div>
            </div>
            <div class="product-card">
                <img src="img2/a2.jpeg" alt="Sunglasses" class="product-image">
                <div class="product-info">
                    <h3 class="product-title">Designer Sunglasses</h3>
                    <p class="product-brand">Ray-Ban</p>
                    <p class="product-price">₹8,999</p>
                    <button class="add-to-cart" onclick="addToCart('Designer Sunglasses', 8999, 'img2/a2.jpeg', 2)">Add to Cart</button>
                </div>
            </div>
            <div class="product-card">
                <img src="img2/a3.jpeg" alt="Wallet" class="product-image">
                <div class="product-info">
                    <h3 class="product-title">Leather Wallet</h3>
                    <p class="product-brand">Tommy Hilfiger</p>
                    <p class="product-price">₹3,999</p>
                    <button class="add-to-cart" onclick="addToCart('Leather Wallet', 3999, 'img2/a3.jpeg', 3)">Add to Cart</button>
                </div>
            </div>
            <div class="product-card">
                <img src="img2/a4.jpeg" alt="Belt" class="product-image">
                <div class="product-info">
                    <h3 class="product-title">Premium Belt</h3>
                    <p class="product-brand">Gucci</p>
                    <p class="product-price">₹6,999</p>
                    <button class="add-to-cart" onclick="addToCart('Premium Belt', 6999, 'img2/a4.jpeg', 4)">Add to Cart</button>
                </div>
            </div>
            <div class="product-card">
                <img src="img2/a5.jpeg" alt="Cap" class="product-image">
                <div class="product-info">
                    <h3 class="product-title">Designer Cap</h3>
                    <p class="product-brand">Nike</p>
                    <p class="product-price">₹1,999</p>
                    <button class="add-to-cart" onclick="addToCart('Designer Cap', 1999, 'img2/a5.jpeg', 5)">Add to Cart</button>
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
        function addToCart(productName, price, imagePath, productId) {
            if (!<?php echo isset($_SESSION['logged_in']) ? 'true' : 'false'; ?>) {
                alert('Please login to add items to cart');
                window.location.href = 'login.php';
                return;
            }

            const cart = JSON.parse(localStorage.getItem('cart')) || [];
            
            // Check if product already exists in cart
            const existingItem = cart.find(item => 
                item.name === productName && 
                item.product_id === productId
            );
            
            if (existingItem) {
                existingItem.quantity += 1;
            } else {
                cart.push({
                    product_id: productId,
                    name: productName,
                    price: price,
                    quantity: 1,
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
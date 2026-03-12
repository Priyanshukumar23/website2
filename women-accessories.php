<?php
session_start();
include 'config/db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Women's Accessories - Kumar Brothers</title>
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
            display: inline-block;
        }
        .profile-icon {
            color: white;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem;
        }
        .profile-icon i {
            font-size: 1.2rem;
            margin-right: 0.3rem;
        }
        .dropdown-content {
            display: none;
            position: absolute;
            right: 0;
            background: white;
            min-width: 200px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            border-radius: 4px;
            z-index: 1000;
        }
        .dropdown-content a {
            color: #333;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            transition: background-color 0.3s;
        }
        .dropdown-content a:hover {
            background-color: #f1f1f1;
            color: #007bff;
        }
        .profile-dropdown:hover .dropdown-content {
            display: block;
        }
        .dropdown-content a i {
            margin-right: 8px;
            width: 16px;
            text-align: center;
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
                        My Profile
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
            <img src="img2/neck.jpeg" alt="Women's Accessories Collection" class="hero-image">
            <div class="hero-content">
                <h1>Women's Accessories Collection</h1>
                <p>Complete your look with our stunning accessories</p>
            </div>
        </section>

        <section class="search-container">
            <div class="search-bar">
                <input type="text" id="searchInput" placeholder="Search accessories...">
                <button onclick="searchProducts()"><i class="fas fa-search"></i> Search</button>
            </div>
        </section>

        <section class="products-grid">
            <div class="product-card">
                <img src="img2/hbw.jpeg" alt="Designer Handbag" class="product-image">
                <div class="product-info">
                    <h3 class="product-title">Designer Handbag</h3>
                    <p class="product-brand">Michael Kors</p>
                    <p class="product-price">₹12,999</p>
                    <button class="add-to-cart" onclick="addToCart('Designer Handbag', 12999, 'img2/hbw.jpeg')">Add to Cart</button>
                </div>
            </div>

            <div class="product-card">
                <img src="img2/neck.jpeg" alt="Statement Necklace" class="product-image">
                <div class="product-info">
                    <h3 class="product-title">Statement Necklace</h3>
                    <p class="product-brand">Swarovski</p>
                    <p class="product-price">₹4,999</p>
                    <button class="add-to-cart" onclick="addToCart('Statement Necklace', 4999, 'img2/neck.jpeg')">Add to Cart</button>
                </div>
            </div>

            <div class="product-card">
                <img src="img2/scw.jpeg" alt="Silk Scarf" class="product-image">
                <div class="product-info">
                    <h3 class="product-title">Silk Scarf</h3>
                    <p class="product-brand">Hermès</p>
                    <p class="product-price">₹8,999</p>
                    <button class="add-to-cart" onclick="addToCart('Silk Scarf', 8999, 'img2/scw.jpeg')">Add to Cart</button>
                </div>
            </div>

            <div class="product-card">
                <img src="img2/snw.jpeg" alt="Designer Sunglasses" class="product-image">
                <div class="product-info">
                    <h3 class="product-title">Designer Sunglasses</h3>
                    <p class="product-brand">Ray-Ban</p>
                    <p class="product-price">₹6,999</p>
                    <button class="add-to-cart" onclick="addToCart('Designer Sunglasses', 6999, 'img2/snw.jpeg')">Add to Cart</button>
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
        function addToCart(productName, price, imagePath) {
            if (!<?php echo isset($_SESSION['logged_in']) ? 'true' : 'false'; ?>) {
                alert('Please login to add items to cart');
                window.location.href = 'login.php';
                return;
            }

            const cart = JSON.parse(localStorage.getItem('cart')) || [];
            
            // Check if product already exists in cart
            const existingItem = cart.find(item => item.name === productName);
            if (existingItem) {
                existingItem.quantity += 1;
            } else {
                cart.push({
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
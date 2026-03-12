<?php
session_start();
include 'config/db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Men's Footwear - Kumar Brothers</title>
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
            <img src="img2/f1.jpeg" alt="Men's Footwear Collection" class="hero-image">
            <div class="hero-content">
                <h1>Men's Footwear Collection</h1>
                <p>Discover our premium collection of stylish footwear</p>
            </div>
        </section>

        <section class="products-grid">
            <div class="product-card">
                <img src="img2/f1.jpeg" alt="Casual Shoes" class="product-image">
                <div class="product-info">
                    <h3 class="product-title">Premium Casual Shoes</h3>
                    <p class="product-brand">Nike</p>
                    <p class="product-price">₹5,999</p>
                    <div class="size-buttons">
                        <button class="size-btn" onclick="selectSize(this)">7</button>
                        <button class="size-btn" onclick="selectSize(this)">8</button>
                        <button class="size-btn" onclick="selectSize(this)">9</button>
                        <button class="size-btn" onclick="selectSize(this)">10</button>
                    </div>
                    <button class="add-to-cart" onclick="addToCart('Premium Casual Shoes', 5999)">Add to Cart</button>
                </div>
            </div>
            <div class="product-card">
                <img src="img2/f2.jpeg" alt="Sports Shoes" class="product-image">
                <div class="product-info">
                    <h3 class="product-title">Sports Running Shoes</h3>
                    <p class="product-brand">Adidas</p>
                    <p class="product-price">₹6,999</p>
                    <div class="size-buttons">
                        <button class="size-btn" onclick="selectSize(this)">7</button>
                        <button class="size-btn" onclick="selectSize(this)">8</button>
                        <button class="size-btn" onclick="selectSize(this)">9</button>
                        <button class="size-btn" onclick="selectSize(this)">10</button>
                    </div>
                    <button class="add-to-cart" onclick="addToCart('Sports Running Shoes', 6999)">Add to Cart</button>
                </div>
            </div>
            <div class="product-card">
                <img src="img2/f3.jpeg" alt="Sneakers" class="product-image">
                <div class="product-info">
                    <h3 class="product-title">Designer Sneakers</h3>
                    <p class="product-brand">Puma</p>
                    <p class="product-price">₹4,999</p>
                    <div class="size-buttons">
                        <button class="size-btn" onclick="selectSize(this)">7</button>
                        <button class="size-btn" onclick="selectSize(this)">8</button>
                        <button class="size-btn" onclick="selectSize(this)">9</button>
                        <button class="size-btn" onclick="selectSize(this)">10</button>
                    </div>
                    <button class="add-to-cart" onclick="addToCart('Designer Sneakers', 4999)">Add to Cart</button>
                </div>
            </div>
            <div class="product-card">
                <img src="img2/f4.jpeg" alt="Formal Shoes" class="product-image">
                <div class="product-info">
                    <h3 class="product-title">Premium Formal Shoes</h3>
                    <p class="product-brand">Bata</p>
                    <p class="product-price">₹3,999</p>
                    <div class="size-buttons">
                        <button class="size-btn" onclick="selectSize(this)">7</button>
                        <button class="size-btn" onclick="selectSize(this)">8</button>
                        <button class="size-btn" onclick="selectSize(this)">9</button>
                        <button class="size-btn" onclick="selectSize(this)">10</button>
                    </div>
                    <button class="add-to-cart" onclick="addToCart('Premium Formal Shoes', 3999)">Add to Cart</button>
                </div>
            </div>
            <div class="product-card">
                <img src="img2/f5.jpeg" alt="Sandals" class="product-image">
                <div class="product-info">
                    <h3 class="product-title">Casual Sandals</h3>
                    <p class="product-brand">Woodland</p>
                    <p class="product-price">₹2,999</p>
                    <div class="size-buttons">
                        <button class="size-btn" onclick="selectSize(this)">7</button>
                        <button class="size-btn" onclick="selectSize(this)">8</button>
                        <button class="size-btn" onclick="selectSize(this)">9</button>
                        <button class="size-btn" onclick="selectSize(this)">10</button>
                    </div>
                    <button class="add-to-cart" onclick="addToCart('Casual Sandals', 2999)">Add to Cart</button>
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
        function selectSize(button, size) {
            // Remove selected class from all buttons in the same group
            const parent = button.parentElement;
            parent.querySelectorAll('.size-btn').forEach(btn => btn.classList.remove('selected'));
            // Add selected class to clicked button
            button.classList.add('selected');
        }

        function addToCart(productName, price) {
            if (!<?php echo isset($_SESSION['logged_in']) ? 'true' : 'false'; ?>) {
                alert('Please login to add items to cart');
                window.location.href = 'login.php';
                return;
            }

            // Find the product card containing the product name
            const productCards = document.querySelectorAll('.product-card');
            let selectedSizeBtn = null;
            let productImage = null;

            for (const card of productCards) {
                const title = card.querySelector('.product-title').textContent;
                if (title === productName) {
                    selectedSizeBtn = card.querySelector('.size-btn.selected');
                    const imgElement = card.querySelector('.product-image');
                    // Get the full image path
                    productImage = imgElement.src;
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
                    image: productImage
                });
            }
            
            localStorage.setItem('cart', JSON.stringify(cart));
            alert('Added to cart successfully!');
        }
    </script>
</body>
</html> 
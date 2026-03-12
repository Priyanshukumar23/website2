<?php
session_start();
include 'config/db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kumar Brothers - Fashion Store</title>
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
        .search-bar {
            display: flex;
            align-items: center;
            background: white;
            border-radius: 25px;
            padding: 0.5rem 1rem;
            width: 300px;
        }
        .search-bar input {
            border: none;
            outline: none;
            width: 100%;
            padding: 0.5rem;
            font-size: 1rem;
        }
        .search-bar button {
            background: none;
            border: none;
            color: #333;
            cursor: pointer;
            padding: 0.5rem;
        }
        .search-bar button:hover {
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
        }
        .hero-section {
            position: relative;
            height: 600px;
            overflow: hidden;
        }
        .hero-slider {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }
        .hero-slide {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            transition: opacity 1s ease-in-out;
            background-size: cover;
            background-position: center;
        }
        .hero-slide.active {
            opacity: 1;
        }
        .hero-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            color: white;
            z-index: 2;
            background-color: rgba(0, 0, 0, 0.5);
            padding: 2rem;
            border-radius: 10px;
        }
        .hero-content h1 {
            font-size: 3rem;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }
        .hero-content p {
            font-size: 1.5rem;
            margin-bottom: 2rem;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
        }
        .shop-now-btn {
            display: inline-block;
            padding: 1rem 2rem;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .shop-now-btn:hover {
            background-color: #0056b3;
        }
        .categories-section {
            padding: 4rem 2rem;
            background: #f8f9fa;
        }
        .section-title {
            text-align: center;
            margin-bottom: 3rem;
        }
        .section-title h2 {
            font-size: 2.5rem;
            color: #333;
        }
        .categories-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
            max-width: 1400px;
            margin: 0 auto;
        }
        .category-card {
            position: relative;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
            cursor: pointer;
            height: 500px;
        }
        .category-card:hover {
            transform: translateY(-5px);
        }
        .category-card img,
        .category-card video {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .category-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(transparent, rgba(0, 0, 0, 0.8));
            padding: 2rem;
            color: white;
            z-index: 2;
        }
        .category-overlay h3 {
            margin: 0;
            font-size: 2rem;
            font-weight: bold;
        }
        .category-overlay p {
            margin: 1rem 0 0;
            opacity: 0.9;
            font-size: 1.2rem;
        }
        .video-section {
            position: relative;
            height: 100vh;
            width: 100%;
            overflow: hidden;
        }
        .video-container {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
        }
        .video-container video {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .video-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 2;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            text-align: center;
        }
        .video-content {
            max-width: 800px;
            padding: 2rem;
        }
        .video-content h2 {
            font-size: 3rem;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }
        .video-content p {
            font-size: 1.5rem;
            margin-bottom: 2rem;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
        }
        .featured-section {
            padding: 4rem 2rem;
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
        .product-price {
            font-size: 1.3rem;
            font-weight: bold;
            color: #007bff;
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
            <div class="search-bar">
                <input type="text" placeholder="Search products...">
                <button><i class="fas fa-search"></i></button>
            </div>
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

    <?php if (isset($_SESSION['success_message'])): ?>
        <div class="success-message" style="background: #d4edda; color: #155724; padding: 1rem; margin: 1rem; border-radius: 5px; text-align: center;">
            <?php 
                echo $_SESSION['success_message'];
                unset($_SESSION['success_message']);
            ?>
        </div>
    <?php endif; ?>

    <main class="main-content">
        <section class="video-section">
            <div class="video-container">
                <video autoplay muted loop playsinline>
                    <source src="video/mv.mp4" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
            <div class="video-overlay">
                <div class="video-content">
                    <h2>Style is a way to say who you are without having to speak</h2>
                    <p>Discover your unique fashion statement with Kumar Brothers</p>
                </div>
            </div>
        </section>

        <section class="categories-section">
            <div class="section-title">
                <h2>Shop by Category</h2>
            </div>
            <div class="categories-grid">
                <div class="category-card" onclick="window.location.href='men.php'">
                <video autoplay muted loop playsinline>
                        <source src="video/mv.mp4" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                    <div class="category-overlay">
                        <h3>Men's Collection</h3>
                        <p>Explore our latest men's fashion</p>
                    </div>
                </div>
                <div class="category-card" onclick="window.location.href='women.php'">
                    <video autoplay muted loop playsinline>
                        <source src="video/wv.mp4" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                    <div class="category-overlay">
                        <h3>Women's Collection</h3>
                        <p>Discover trendy women's wear</p>
                    </div>
                </div>
                <div class="category-card" onclick="window.location.href='kids.php'">
                    <img src="img2/Boys Ethnic Wear Dresses.jpeg" alt="Kids Collection">
                    <div class="category-overlay">
                        <h3>Kids Collection</h3>
                        <p>Find adorable kids' clothing</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="hero-section">
            <div class="hero-slider">
                <div class="hero-slide active" style="background-image: url('img2/Boys Ethnic Wear Dresses.jpeg');"></div>
                <div class="hero-slide" style="background-image: url('img2/Hrithik Roshan.jpeg');"></div>
                <div class="hero-slide" style="background-image: url('img2/elizabeth hd.jpg');"></div>
            </div>
            <div class="hero-content">
                <h1>Welcome to Kumar Brothers</h1>
                <p>Your one-stop destination for trendy fashion</p>
                <a href="men.php" class="shop-now-btn">Shop Now</a>
            </div>
        </section>

        <section class="featured-section">
            <div class="section-title">
                <h2>Featured Products</h2>
            </div>
            <div class="products-grid">
                <div class="product-card" onclick="window.location.href='men-shirts.php'">
                    <img src="img2/shirt.jpg" alt="Men's Shirt" class="product-image">
                    <div class="product-info">
                        <h3 class="product-title">Classic Fit Shirt</h3>
                        <p class="product-price">₹1,299</p>
                    </div>
                </div>
                <div class="product-card" onclick="window.location.href='men-tshirts.php'">
                    <img src="img2/tshirt2m.jpg" alt="Men's T-Shirt" class="product-image">
                    <div class="product-info">
                        <h3 class="product-title">Sports T-Shirt</h3>
                        <p class="product-price">₹999</p>
                    </div>
                </div>
                <div class="product-card" onclick="window.location.href='men-jeans.php'">
                    <img src="img2/jeans1m.jpg" alt="Men's Jeans" class="product-image">
                    <div class="product-info">
                        <h3 class="product-title">Slim Fit Jeans</h3>
                        <p class="product-price">₹2,999</p>
                    </div>
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
                <p>Phone: +91 7006417651</p>
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
        // Search functionality
        document.querySelector('.search-bar input').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            
            // Search in featured products
            const featuredProducts = document.querySelectorAll('.product-card');
            featuredProducts.forEach(product => {
                const title = product.querySelector('.product-title').textContent.toLowerCase();
                if (title.includes(searchTerm)) {
                    product.style.display = 'block';
                } else {
                    product.style.display = 'none';
                }
            });

            // Search in category cards
            const categoryCards = document.querySelectorAll('.category-card');
            categoryCards.forEach(card => {
                const title = card.querySelector('.category-overlay h3').textContent.toLowerCase();
                if (title.includes(searchTerm)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });

            // If search term is empty, show all products
            if (searchTerm === '') {
                featuredProducts.forEach(product => product.style.display = 'block');
                categoryCards.forEach(card => card.style.display = 'block');
            }
        });

        // Add event listener for search button
        document.querySelector('.search-bar button').addEventListener('click', function() {
            const searchInput = document.querySelector('.search-bar input');
            const searchTerm = searchInput.value.toLowerCase();
            
            // Define product categories and their corresponding pages
            const categories = {
                'men': 'men.php',
                'shirt': 'men-shirts.php',
                't-shirt': 'men-tshirts.php',
                'jeans': 'men-jeans.php',
                'formal': 'men-formal.php',
                'jacket': 'men-jackets.php',
                'accessories': 'men-accessories.php',
                'women': 'women.php',
                'kurti': 'women-kurtis.php',
                'saree': 'women-sarees.php',
                'lehenga': 'women-lehengas.php',
                'tops': 'women-tops.php',
                'kids': 'kids.php',
                'boys': 'kids-boys.php',
                'girls': 'kids-girls.php',
                'babies': 'kids-babies.php'
            };

            // Check if the search term matches any category
            for (const [category, page] of Object.entries(categories)) {
                if (searchTerm.includes(category)) {
                    window.location.href = page;
                    return;
                }
            }

            // If no specific category is found, show all products
            window.location.href = 'products.php?search=' + encodeURIComponent(searchTerm);
        });

        // Add event listener for Enter key
        document.querySelector('.search-bar input').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                const searchTerm = this.value.toLowerCase();
                
                // Define product categories and their corresponding pages
                const categories = {
                    'men': 'men.php',
                    'shirt': 'men-shirts.php',
                    't-shirt': 'men-tshirts.php',
                    'jeans': 'men-jeans.php',
                    'formal': 'men-formal.php',
                    'jacket': 'men-jackets.php',
                    'accessories': 'men-accessories.php',
                    'women': 'women.php',
                    'kurti': 'women-kurtis.php',
                    'saree': 'women-sarees.php',
                    'lehenga': 'women-lehengas.php',
                    'tops': 'women-tops.php',
                    'kids': 'kids.php',
                    'boys': 'kids-boys.php',
                    'girls': 'kids-girls.php',
                    'babies': 'kids-babies.php'
                };

                // Check if the search term matches any category
                for (const [category, page] of Object.entries(categories)) {
                    if (searchTerm.includes(category)) {
                        window.location.href = page;
                        return;
                    }
                }

                // If no specific category is found, show all products
                window.location.href = 'products.php?search=' + encodeURIComponent(searchTerm);
            }
        });

        // Background image slider
        const slides = document.querySelectorAll('.hero-slide');
        let currentSlide = 0;

        function showSlide(index) {
            slides.forEach(slide => slide.classList.remove('active'));
            slides[index].classList.add('active');
        }

        function nextSlide() {
            currentSlide = (currentSlide + 1) % slides.length;
            showSlide(currentSlide);
        }

        // Change slide every 2 seconds
        setInterval(nextSlide, 2000);
    </script>
</body>
</html> 
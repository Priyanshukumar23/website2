<?php
session_start();
include 'config/db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Men's Collection - Kumar Brothers</title>
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
            margin-top: 8px;
        }
        .categories-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
            padding: 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }
        .category-card {
            position: relative;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
            cursor: pointer;
        }
        .category-card:hover {
            transform: translateY(-5px);
        }
        .category-card img {
            width: 100%;
            height: 300px;
            object-fit: cover;
        }
        .category-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(transparent, rgba(0, 0, 0, 0.8));
            padding: 1.5rem;
            color: white;
        }
        .category-overlay h2 {
            margin: 0;
            font-size: 1.5rem;
        }
        .category-overlay p {
            margin: 0.5rem 0 0;
            opacity: 0.9;
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
            height: 500px;
            overflow: hidden;
            background: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4));
        }
        .hero-video {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -1;
        }
        .hero-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            color: white;
            background: rgba(0, 0, 0, 0.3);
            padding: 2rem 3rem;
            border-radius: 10px;
            width: 80%;
            max-width: 800px;
            backdrop-filter: blur(5px);
            z-index: 1;
        }
        .hero-content h1 {
            font-size: 2.5rem;
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
            <video autoplay muted loop playsinline>
                <source src="video/mv.mp4" type="video/mp4">
                Your browser does not support the video tag.
            </video>
            <div class="hero-content">
                <h1>Men's Collection</h1>
                <p>Discover our premium collection of men's fashion</p>
            </div>
        </section>

        <section class="search-container">
            <div class="search-bar">
                <input type="text" id="searchInput" placeholder="Search for products...">
                <button onclick="searchProducts()"><i class="fas fa-search"></i> Search</button>
            </div>
        </section>

        <section class="categories-grid">
            <div class="category-card" onclick="window.location.href='men-shirts.php'">
                <img src="img2/shirt1m.jpg" alt="Shirts">
                <div class="category-overlay">
                    <h2>Shirts</h2>
                    <p>Explore our collection of formal and casual shirts</p>
                </div>
            </div>
            <div class="category-card" onclick="window.location.href='men-tshirts.php'">
                <img src="img2/tshirt1m.jpg" alt="T-Shirts">
                <div class="category-overlay">
                    <h2>T-Shirts</h2>
                    <p>Comfortable and stylish t-shirts for every occasion</p>
                </div>
            </div>
            <div class="category-card" onclick="window.location.href='men-jeans.php'">
                <img src="img2/jeans1m.jpg" alt="Jeans">
                <div class="category-overlay">
                    <h2>Jeans</h2>
                    <p>Trendy jeans in various fits and styles</p>
                </div>
            </div>
            <div class="category-card" onclick="window.location.href='men-formal.php'">
                <img src="img2/jensen formal 1.jpg" alt="Formal Wear">
                <div class="category-overlay">
                    <h2>Formal Wear</h2>
                    <p>Elegant formal wear for special occasions</p>
                </div>
            </div>
            <div class="category-card" onclick="window.location.href='men-jackets.php'">
                <img src="img2/hrithik jacket.jpeg" alt="Jackets">
                <div class="category-overlay">
                    <h2>Jackets</h2>
                    <p>Stylish jackets for all seasons</p>
                </div>
            </div>
            <div class="category-card" onclick="window.location.href='men-shorts.php'">
                <img src="img2/short2k.jpg" alt="Shorts">
                <div class="category-overlay">
                    <h2>Shorts</h2>
                    <p>Comfortable shorts for casual wear</p>
                </div>
            </div>
            <div class="category-card" onclick="window.location.href='men-accessories.php'">
                <img src="img2/access men.jpeg" alt="Accessories">
                <div class="category-overlay">
                    <h2>Accessories</h2>
                    <p>Complete your look with our accessories</p>
                </div>
            </div>
            <div class="category-card" onclick="window.location.href='men-footwear.php'">
                <img src="img2/footwear chris hems.jpeg" alt="Footwear">
                <div class="category-overlay">
                    <h2>Footwear</h2>
                    <p>Stylish footwear for every occasion</p>
                </div>
            </div>
            <div class="category-card" onclick="window.location.href='men-winter.php'">
                <img src="img2/jensen winter.jpg" alt="Winter Wear">
                <div class="category-overlay">
                    <h2>Winter Wear</h2>
                    <p>Stay warm and stylish in winter</p>
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
            const categories = document.querySelectorAll('.category-card');
            
            categories.forEach(category => {
                const title = category.querySelector('h2').textContent.toLowerCase();
                const description = category.querySelector('p').textContent.toLowerCase();
                
                if (title.includes(searchTerm) || description.includes(searchTerm)) {
                    category.style.display = 'block';
                } else {
                    category.style.display = 'none';
                }
            });
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
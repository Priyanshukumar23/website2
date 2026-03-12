<?php
session_start();
include 'config/db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Women's Kurtis - Kumar Brothers</title>
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
            <img src="women_img/kurti.jpg" alt="Women's Kurtis Collection" class="hero-image">
            <div class="hero-content">
                <h1>Women's Kurtis Collection</h1>
                <p>Discover our latest collection of stylish and comfortable kurtis</p>
            </div>
        </section>

        <section class="search-container">
            <div class="search-bar">
                <input type="text" id="searchInput" placeholder="Search for kurtis...">
                <button onclick="searchProducts()"><i class="fas fa-search"></i> Search</button>
            </div>
        </section>

        <section class="products-grid">
            <div class="product-card">
                <img src="women_img/kurti.jpg" alt="Floral Print Kurti" class="product-image">
                <div class="product-info">
                    <h3 class="product-title">Floral Print Kurti</h3>
                    <p class="product-brand">FabIndia</p>
                    <p class="product-price">₹1,999</p>
                    <div class="size-buttons">
                        <button class="size-btn" onclick="selectSize(this)">S</button>
                        <button class="size-btn" onclick="selectSize(this)">M</button>
                        <button class="size-btn" onclick="selectSize(this)">L</button>
                        <button class="size-btn" onclick="selectSize(this)">XL</button>
                    </div>
                    <button class="add-to-cart" onclick="addToCart('Floral Print Kurti', 1999, 'women_img/kurti.jpg', 1)">Add to Cart</button>
                </div>
            </div>
            <div class="product-card">
                <img src="women_img/kurti2.jpg" alt="Embroidered Kurti" class="product-image">
                <div class="product-info">
                    <h3 class="product-title">Embroidered Kurti</h3>
                    <p class="product-brand">W for Woman</p>
                    <p class="product-price">₹1,499</p>
                    <div class="size-buttons">
                        <button class="size-btn" onclick="selectSize(this)">S</button>
                        <button class="size-btn" onclick="selectSize(this)">M</button>
                        <button class="size-btn" onclick="selectSize(this)">L</button>
                        <button class="size-btn" onclick="selectSize(this)">XL</button>
                    </div>
                    <button class="add-to-cart" onclick="addToCart('Embroidered Kurti', 1499, 'women_img/kurti2.jpg', 2)">Add to Cart</button>
                </div>
            </div>
            <div class="product-card">
                <img src="women_img/kurti3.jpg" alt="Printed Kurti" class="product-image">
                <div class="product-info">
                    <h3 class="product-title">Printed Kurti</h3>
                    <p class="product-brand">Biba</p>
                    <p class="product-price">₹1,299</p>
                    <div class="size-buttons">
                        <button class="size-btn" onclick="selectSize(this)">S</button>
                        <button class="size-btn" onclick="selectSize(this)">M</button>
                        <button class="size-btn" onclick="selectSize(this)">L</button>
                        <button class="size-btn" onclick="selectSize(this)">XL</button>
                    </div>
                    <button class="add-to-cart" onclick="addToCart('Printed Kurti', 1299, 'women_img/kurti3.jpg', 3)">Add to Cart</button>
                </div>
            </div>
            <div class="product-card">
                <img src="women_img/kurti4.jpg" alt="Designer Kurti" class="product-image">
                <div class="product-info">
                    <h3 class="product-title">Designer Kurti</h3>
                    <p class="product-brand">Global Desi</p>
                    <p class="product-price">₹1,799</p>
                    <div class="size-buttons">
                        <button class="size-btn" onclick="selectSize(this)">S</button>
                        <button class="size-btn" onclick="selectSize(this)">M</button>
                        <button class="size-btn" onclick="selectSize(this)">L</button>
                        <button class="size-btn" onclick="selectSize(this)">XL</button>
                    </div>
                    <button class="add-to-cart" onclick="addToCart('Designer Kurti', 1799, 'women_img/kurti4.jpg', 4)">Add to Cart</button>
                </div>
            </div>
            <div class="product-card">
                <img src="women_img/kurti5.jpg" alt="Casual Kurti" class="product-image">
                <div class="product-info">
                    <h3 class="product-title">Casual Kurti</h3>
                    <p class="product-brand">W</p>
                    <p class="product-price">₹999</p>
                    <div class="size-buttons">
                        <button class="size-btn" onclick="selectSize(this)">S</button>
                        <button class="size-btn" onclick="selectSize(this)">M</button>
                        <button class="size-btn" onclick="selectSize(this)">L</button>
                        <button class="size-btn" onclick="selectSize(this)">XL</button>
                    </div>
                    <button class="add-to-cart" onclick="addToCart('Casual Kurti', 999, 'women_img/kurti5.jpg', 5)">Add to Cart</button>
                </div>
            </div>
            <div class="product-card">
                <img src="women_img/kurti6.jpg" alt="Traditional Kurti" class="product-image">
                <div class="product-info">
                    <h3 class="product-title">Traditional Kurti</h3>
                    <p class="product-brand">Inddus</p>
                    <p class="product-price">₹1,599</p>
                    <div class="size-buttons">
                        <button class="size-btn" onclick="selectSize(this)">S</button>
                        <button class="size-btn" onclick="selectSize(this)">M</button>
                        <button class="size-btn" onclick="selectSize(this)">L</button>
                        <button class="size-btn" onclick="selectSize(this)">XL</button>
                    </div>
                    <button class="add-to-cart" onclick="addToCart('Traditional Kurti', 1599, 'women_img/kurti6.jpg', 6)">Add to Cart</button>
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
            
            // Check if product already exists in cart with same size
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

        // Add event listener for Enter key
        document.getElementById('searchInput').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                searchProducts();
            }
        });
    </script>
</body>
</html> 
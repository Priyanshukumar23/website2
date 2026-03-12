<?php
include 'config/db.php';
session_start();

// Check if user is logged in
$isLoggedIn = isset($_SESSION['user_id']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart - Kumar Brothers</title>
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
            padding: 20px;
        }
        .cart-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .cart-item {
            display: flex;
            align-items: center;
            padding: 20px;
            border-bottom: 1px solid #eee;
            margin-bottom: 20px;
        }
        .cart-item img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            margin-right: 20px;
            border-radius: 4px;
        }
        .cart-item-details {
            flex: 1;
        }
        .cart-item-title {
            font-size: 18px;
            margin-bottom: 5px;
        }
        .cart-item-price {
            color: #007bff;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .cart-item-size {
            color: #666;
            margin-bottom: 10px;
        }
        .cart-item-quantity {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .quantity-btn {
            padding: 5px 10px;
            border: 1px solid #ddd;
            background: white;
            cursor: pointer;
        }
        .remove-btn {
            padding: 5px 10px;
            background: #dc3545;
            color: white;
            border: none;
            cursor: pointer;
            margin-left: 10px;
        }
        .cart-summary {
            margin-top: 20px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 8px;
        }
        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }
        .checkout-btn {
            width: 100%;
            padding: 10px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 10px;
        }
        .empty-cart {
            text-align: center;
            padding: 40px;
        }
        .empty-cart i {
            font-size: 48px;
            color: #ddd;
            margin-bottom: 20px;
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
        <div class="cart-container">
            <h1>Your Cart</h1>
            <div id="cart-items"></div>
            <div id="cart-summary"></div>
        </div>
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
        function loadCart() {
            const cartItems = document.getElementById('cart-items');
            const cartSummary = document.getElementById('cart-summary');
            const cart = JSON.parse(localStorage.getItem('cart')) || [];

            if (cart.length === 0) {
                cartItems.innerHTML = `
                    <div class="empty-cart">
                        <i class="fas fa-shopping-cart"></i>
                        <h2>Your cart is empty</h2>
                        <p>Looks like you haven't added any items to your cart yet.</p>
                        <a href="index.php" style="display: inline-block; padding: 10px 20px; background: #007bff; color: white; text-decoration: none; border-radius: 4px; margin-top: 20px;">Continue Shopping</a>
                    </div>
                `;
                cartSummary.style.display = 'none';
                return;
            }

            let total = 0;
            let cartHTML = '';

            cart.forEach((item, index) => {
                let imagePath = item.image;
                // Fix women section images
                if (imagePath.startsWith('img2/')) {
                    // List of known women product image filenames (add more as needed)
                    const womenImages = [
                        'elizabeth hd.jpg', 'w1.jpeg', 'w2.jpeg', 'w3.jpeg', 'w4.jpeg', 'w5.jpeg', 'w6.jpeg', 'w7.jpeg', 'w8.jpeg', 'w9.jpeg', 'w10.jpeg', 'w11.jpeg', 'w12.jpeg', 'w13.jpeg', 'w14.jpeg', 'w15.jpeg', 'w16.jpeg', 'w17.jpeg', 'w18.jpeg', 'w19.jpeg', 'w20.jpeg', 'w21.jpeg', 'w22.jpeg', 'w23.jpeg', 'w24.jpeg', 'w25.jpeg', 'w26.jpeg', 'w27.jpeg', 'w28.jpeg', 'w29.jpeg', 'w30.jpeg', 'w31.jpeg', 'w32.jpeg', 'w33.jpeg', 'w34.jpeg', 'w35.jpeg', 'w36.jpeg', 'w37.jpeg', 'w38.jpeg', 'w39.jpeg', 'w40.jpeg', 'w41.jpeg', 'w42.jpeg', 'w43.jpeg', 'w44.jpeg', 'w45.jpeg', 'w46.jpeg', 'w47.jpeg', 'w48.jpeg', 'w49.jpeg', 'w50.jpeg', 'w51.jpeg', 'w52.jpeg', 'w53.jpeg', 'w54.jpeg', 'w55.jpeg', 'w56.jpeg', 'w57.jpeg', 'w58.jpeg', 'w59.jpeg', 'w60.jpeg', 'w61.jpeg', 'w62.jpeg', 'w63.jpeg', 'w64.jpeg', 'w65.jpeg', 'w66.jpeg', 'w67.jpeg', 'w68.jpeg', 'w69.jpeg', 'w70.jpeg', 'w71.jpeg', 'w72.jpeg', 'w73.jpeg', 'w74.jpeg', 'w75.jpeg', 'w76.jpeg', 'w77.jpeg', 'w78.jpeg', 'w79.jpeg', 'w80.jpeg', 'w81.jpeg', 'w82.jpeg', 'w83.jpeg', 'w84.jpeg', 'w85.jpeg', 'w86.jpeg', 'w87.jpeg', 'w88.jpeg', 'w89.jpeg', 'w90.jpeg', 'w91.jpeg', 'w92.jpeg', 'w93.jpeg', 'w94.jpeg', 'w95.jpeg', 'w96.jpeg', 'w97.jpeg', 'w98.jpeg', 'w99.jpeg', 'w100.jpeg', 'w101.jpeg', 'w102.jpeg', 'w103.jpeg', 'w104.jpeg', 'w105.jpeg', 'w106.jpeg', 'w107.jpeg', 'w108.jpeg', 'w109.jpeg', 'w110.jpeg', 'w111.jpeg', 'w112.jpeg', 'w113.jpeg', 'w114.jpeg', 'w115.jpeg', 'w116.jpeg', 'w117.jpeg', 'w118.jpeg', 'w119.jpeg', 'w120.jpeg', 'w121.jpeg', 'w122.jpeg', 'w123.jpeg', 'w124.jpeg', 'w125.jpeg', 'w126.jpeg', 'w127.jpeg', 'w128.jpeg', 'w129.jpeg', 'w130.jpeg', 'w131.jpeg', 'w132.jpeg', 'w133.jpeg', 'w134.jpeg', 'w135.jpeg', 'w136.jpeg', 'w137.jpeg', 'w138.jpeg', 'w139.jpeg', 'w140.jpeg', 'w141.jpeg', 'w142.jpeg', 'w143.jpeg', 'w144.jpeg', 'w145.jpeg', 'w146.jpeg', 'w147.jpeg', 'w148.jpeg', 'w149.jpeg', 'w150.jpeg', 'w151.jpeg', 'w152.jpeg', 'w153.jpeg', 'w154.jpeg', 'w155.jpeg', 'w156.jpeg', 'w157.jpeg', 'w158.jpeg', 'w159.jpeg', 'w160.jpeg', 'w161.jpeg', 'w162.jpeg', 'w163.jpeg', 'w164.jpeg', 'w165.jpeg', 'w166.jpeg', 'w167.jpeg', 'w168.jpeg', 'w169.jpeg', 'w170.jpeg', 'w171.jpeg', 'w172.jpeg', 'w173.jpeg', 'w174.jpeg', 'w175.jpeg', 'w176.jpeg', 'w177.jpeg', 'w178.jpeg', 'w179.jpeg', 'w180.jpeg', 'w181.jpeg', 'w182.jpeg', 'w183.jpeg', 'w184.jpeg', 'w185.jpeg', 'w186.jpeg', 'w187.jpeg', 'w188.jpeg', 'w189.jpeg', 'w190.jpeg', 'w191.jpeg', 'w192.jpeg', 'w193.jpeg', 'w194.jpeg', 'w195.jpeg', 'w196.jpeg', 'w197.jpeg', 'w198.jpeg', 'w199.jpeg', 'w200.jpeg', 'w201.jpeg', 'w202.jpeg', 'w203.jpeg', 'w204.jpeg', 'w205.jpeg', 'w206.jpeg', 'w207.jpeg', 'w208.jpeg', 'w209.jpeg', 'w210.jpeg', 'w211.jpeg', 'w212.jpeg', 'w213.jpeg', 'w214.jpeg', 'w215.jpeg', 'w216.jpeg', 'w217.jpeg', 'w218.jpeg', 'w219.jpeg', 'w220.jpeg', 'w221.jpeg', 'w222.jpeg', 'w223.jpeg', 'w224.jpeg', 'w225.jpeg', 'w226.jpeg', 'w227.jpeg', 'w228.jpeg', 'w229.jpeg', 'w230.jpeg', 'w231.jpeg', 'w232.jpeg', 'w233.jpeg', 'w234.jpeg', 'w235.jpeg', 'w236.jpeg', 'w237.jpeg', 'w238.jpeg', 'w239.jpeg', 'w240.jpeg', 'w241.jpeg', 'w242.jpeg', 'w243.jpeg', 'w244.jpeg', 'w245.jpeg', 'w246.jpeg', 'w247.jpeg', 'w248.jpeg', 'w249.jpeg', 'w250.jpeg', 'w251.jpeg', 'w252.jpeg', 'w253.jpeg', 'w254.jpeg', 'w255.jpeg', 'w256.jpeg', 'w257.jpeg', 'w258.jpeg', 'w259.jpeg', 'w260.jpeg', 'w261.jpeg', 'w262.jpeg', 'w263.jpeg', 'w264.jpeg', 'w265.jpeg', 'w266.jpeg', 'w267.jpeg', 'w268.jpeg', 'w269.jpeg', 'w270.jpeg', 'w271.jpeg', 'w272.jpeg', 'w273.jpeg', 'w274.jpeg', 'w275.jpeg', 'w276.jpeg', 'w277.jpeg', 'w278.jpeg', 'w279.jpeg', 'w280.jpeg', 'w281.jpeg', 'w282.jpeg', 'w283.jpeg', 'w284.jpeg', 'w285.jpeg', 'w286.jpeg', 'w287.jpeg', 'w288.jpeg', 'w289.jpeg', 'w290.jpeg', 'w291.jpeg', 'w292.jpeg', 'w293.jpeg', 'w294.jpeg', 'w295.jpeg', 'w296.jpeg', 'w297.jpeg', 'w298.jpeg', 'w299.jpeg', 'w300.jpeg', 'w301.jpeg', 'w302.jpeg', 'w303.jpeg', 'w304.jpeg', 'w305.jpeg', 'w306.jpeg', 'w307.jpeg', 'w308.jpeg', 'w309.jpeg', 'w310.jpeg', 'w311.jpeg', 'w312.jpeg', 'w313.jpeg', 'w314.jpeg', 'w315.jpeg', 'w316.jpeg', 'w317.jpeg', 'w318.jpeg', 'w319.jpeg', 'w320.jpeg', 'w321.jpeg', 'w322.jpeg', 'w323.jpeg', 'w324.jpeg', 'w325.jpeg', 'w326.jpeg', 'w327.jpeg', 'w328.jpeg', 'w329.jpeg', 'w330.jpeg', 'w331.jpeg', 'w332.jpeg', 'w333.jpeg', 'w334.jpeg', 'w335.jpeg', 'w336.jpeg', 'w337.jpeg', 'w338.jpeg', 'w339.jpeg', 'w340.jpeg', 'w341.jpeg', 'w342.jpeg', 'w343.jpeg', 'w344.jpeg', 'w345.jpeg', 'w346.jpeg', 'w347.jpeg', 'w348.jpeg', 'w349.jpeg', 'w350.jpeg', 'w351.jpeg', 'w352.jpeg', 'w353.jpeg', 'w354.jpeg', 'w355.jpeg', 'w356.jpeg', 'w357.jpeg', 'w358.jpeg', 'w359.jpeg', 'w360.jpeg', 'w361.jpeg', 'w362.jpeg', 'w363.jpeg', 'w364.jpeg', 'w365.jpeg', 'w366.jpeg', 'w367.jpeg', 'w368.jpeg', 'w369.jpeg', 'w370.jpeg', 'w371.jpeg', 'w372.jpeg', 'w373.jpeg', 'w374.jpeg', 'w375.jpeg', 'w376.jpeg', 'w377.jpeg', 'w378.jpeg', 'w379.jpeg', 'w380.jpeg', 'w381.jpeg', 'w382.jpeg', 'w383.jpeg', 'w384.jpeg', 'w385.jpeg', 'w386.jpeg', 'w387.jpeg', 'w388.jpeg', 'w389.jpeg', 'w390.jpeg', 'w391.jpeg', 'w392.jpeg', 'w393.jpeg', 'w394.jpeg', 'w395.jpeg', 'w396.jpeg', 'w397.jpeg', 'w398.jpeg', 'w399.jpeg', 'w400.jpeg'
                    ];
                    // List of known kids product image filenames (add more as needed)
                    const kidsImages = [
                        'Boys Ethnic Wear Dresses.jpeg', 'kb1.jpeg', 'kb2.jpeg', 'kb3.jpeg', 'kb4.jpeg', 'kb5.jpeg', 'kg1.jpeg', 'kg2.jpeg', 'kg3.jpeg', 'kg4.jpeg', 'kg5.jpeg', 'b1.jpeg', 'b2.jpeg', 'b3.jpeg', 'b4.jpeg', 'b5.jpeg', 'bb1.jpeg', 'bb2.jpeg', 'bb3.jpeg', 'bb4.jpeg', 'bb5.jpeg', 'gg.jpeg'
                    ];
                    const fileName = imagePath.substring(5); // remove 'img2/'
                    if (womenImages.includes(fileName)) {
                        imagePath = 'women_img/' + fileName;
                    } else if (kidsImages.includes(fileName)) {
                        imagePath = 'kid_img/' + fileName;
                    }
                }
                total += item.price * item.quantity;
                cartHTML += `
                    <div class="cart-item">
                        <img src="${imagePath}" alt="${item.name}" style="width: 100px; height: 100px; object-fit: cover; border-radius: 4px;">
                        <div class="cart-item-details">
                            <h3 class="cart-item-title">${item.name}</h3>
                            <p class="cart-item-price">₹${item.price}</p>
                            <p class="cart-item-size">Size: ${item.size}</p>
                            <div class="cart-item-quantity">
                                <button class="quantity-btn" onclick="updateQuantity(${index}, -1)">-</button>
                                <span>${item.quantity}</span>
                                <button class="quantity-btn" onclick="updateQuantity(${index}, 1)">+</button>
                                <button class="remove-btn" onclick="removeItem(${index})">Remove</button>
                            </div>
                        </div>
                    </div>
                `;
            });

            cartItems.innerHTML = cartHTML;
            cartSummary.innerHTML = `
                <div class="cart-summary">
                    <div class="summary-row">
                        <span>Subtotal:</span>
                        <span>₹${total}</span>
                    </div>
                    <div class="summary-row">
                        <span>Shipping:</span>
                        <span>Free</span>
                    </div>
                    <div class="summary-row">
                        <span><strong>Total:</strong></span>
                        <span><strong>₹${total}</strong></span>
                    </div>
                    <button class="checkout-btn" onclick="checkout()">Proceed to Checkout</button>
                </div>
            `;
        }

        function updateQuantity(index, change) {
            const cart = JSON.parse(localStorage.getItem('cart')) || [];
            cart[index].quantity += change;
            
            if (cart[index].quantity <= 0) {
                if (confirm('Do you want to remove this item from cart?')) {
                    cart.splice(index, 1);
                } else {
                    cart[index].quantity = 1;
                }
            }
            
            localStorage.setItem('cart', JSON.stringify(cart));
            loadCart();
        }

        function removeItem(index) {
            if (confirm('Are you sure you want to remove this item from cart?')) {
                const cart = JSON.parse(localStorage.getItem('cart')) || [];
                cart.splice(index, 1);
                localStorage.setItem('cart', JSON.stringify(cart));
                loadCart();
            }
        }

        function checkout() {
            if (!<?php echo isset($_SESSION['logged_in']) ? 'true' : 'false'; ?>) {
                alert('Please login to proceed with checkout');
                window.location.href = 'login.php';
                return;
            }
            
            const cart = JSON.parse(localStorage.getItem('cart')) || [];
            if (cart.length === 0) {
                alert('Your cart is empty');
                return;
            }

            const form = document.createElement('form');
            form.method = 'POST';
            form.action = 'checkout.php';
            
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'cart';
            input.value = JSON.stringify(cart);
            
            form.appendChild(input);
            document.body.appendChild(form);
            form.submit();
        }

        // Load cart when page loads
        document.addEventListener('DOMContentLoaded', loadCart);
    </script>
</body>
</html> 
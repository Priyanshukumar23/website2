<?php
session_start();
include 'config/db.php';

if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    header('Location: login.php');
    exit();
}

// Get user details from database
$user_id = $_SESSION['user_id'];
$query = "SELECT name, email FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Get cart items from localStorage
$cart = isset($_POST['cart']) ? json_decode($_POST['cart'], true) : [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Kumar Brothers</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .checkout-container {
            max-width: 1200px;
            margin: 100px auto;
            padding: 20px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
        }
        .address-section, .payment-section {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .form-group input, .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
            transition: border-color 0.3s;
        }
        .form-group input:focus, .form-group textarea:focus {
            border-color: #007bff;
            outline: none;
            box-shadow: 0 0 0 2px rgba(0,123,255,0.25);
        }
        .form-group textarea {
            min-height: 100px;
            resize: vertical;
        }
        .pincode-group {
            position: relative;
        }
        .pincode-group input {
            padding-right: 100px;
        }
        .check-pincode {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            background: #007bff;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
        }
        .check-pincode:hover {
            background: #0056b3;
        }
        .pincode-check {
            margin-top: 10px;
            padding: 10px;
            border-radius: 4px;
            font-size: 14px;
        }
        .pincode-check.success {
            background-color: #d4edda;
            color: #155724;
        }
        .pincode-check.error {
            background-color: #f8d7da;
            color: #721c24;
        }
        .payment-options {
            display: grid;
            gap: 15px;
        }
        .payment-option {
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.3s;
        }
        .payment-option:hover {
            border-color: #007bff;
            background-color: #f8f9fa;
        }
        .payment-option.selected {
            border-color: #007bff;
            background-color: #e7f1ff;
        }
        .upi-qr {
            text-align: center;
            margin-top: 20px;
        }
        .upi-qr img {
            max-width: 200px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 10px;
            background: white;
        }
        .card-details {
            display: none;
        }
        .card-details.active {
            display: block;
        }
        .place-order-btn {
            width: 100%;
            padding: 12px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 20px;
        }
        .place-order-btn:hover {
            background-color: #0056b3;
        }
        .place-order-btn:disabled {
            background-color: #ccc;
            cursor: not-allowed;
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
                        <span><?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
                    </div>
                </div>
            <?php else: ?>
                <a href="login.php">Login</a>
                <a href="register.php">Register</a>
            <?php endif; ?>
        </div>
    </nav>

    <div class="checkout-container">
        <div class="address-section">
            <h2>Delivery Address</h2>
            <div class="form-group">
                <label>Name</label>
                <input type="text" value="<?php echo htmlspecialchars($user['name']); ?>" readonly>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="text" value="<?php echo htmlspecialchars($user['email']); ?>" readonly>
            </div>
            <div class="form-group">
                <label>Phone Number</label>
                <input type="text" id="phone" placeholder="Enter your phone number" required>
            </div>
            <div class="form-group">
                <label>Address</label>
                <textarea id="address" placeholder="Enter your complete delivery address including street, locality, and landmark" required></textarea>
            </div>
            <div class="form-group pincode-group">
                <label>Pincode</label>
                <input type="text" id="pincode" placeholder="Enter your 6-digit pincode" maxlength="6">
                <button type="button" class="check-pincode" onclick="checkPincode()">Check</button>
                <div id="pincode-check" class="pincode-check"></div>
            </div>
        </div>

        <div class="payment-section">
            <h2>Payment Options</h2>
            <div class="payment-options">
                <div class="payment-option" onclick="selectPayment('card')">
                    <i class="fas fa-credit-card"></i> Credit/Debit Card
                    <div class="card-details" id="card-details">
                        <div class="form-group">
                            <label>Card Number</label>
                            <input type="text" placeholder="1234 5678 9012 3456">
                        </div>
                        <div class="form-group">
                            <label>Expiry Date</label>
                            <input type="text" placeholder="MM/YY">
                        </div>
                        <div class="form-group">
                            <label>CVV</label>
                            <input type="text" placeholder="123">
                        </div>
                    </div>
                </div>
                <div class="payment-option" onclick="selectPayment('upi')">
                    <i class="fas fa-mobile-alt"></i> UPI
                    <div class="upi-qr" id="upi-qr">
                        <p>Scan QR Code to Pay</p>
                        <img src="img2/qr.jpeg" alt="UPI QR Code">
                        <p>OR</p>
                        <div class="form-group">
                            <label>Enter UPI ID</label>
                            <input type="text" placeholder="username@upi">
                        </div>
                    </div>
                </div>
            </div>
            <button class="place-order-btn" id="place-order-btn" disabled>Place Order</button>
        </div>
    </div>

    <script>
        const jammuPincodes = ['180001', '180002', '180003', '180004', '180005', '180006', '180007', '180008', '180009', '180010'];
        
        function checkPincode() {
            const pincode = document.getElementById('pincode').value;
            const pincodeCheck = document.getElementById('pincode-check');
            const placeOrderBtn = document.getElementById('place-order-btn');
            
            if (pincode.length === 6) {
                if (pincode === '182222') {
                    pincodeCheck.className = 'pincode-check success';
                    pincodeCheck.textContent = 'Delivery available in your area';
                    placeOrderBtn.disabled = false;
                } else if (jammuPincodes.includes(pincode)) {
                    pincodeCheck.className = 'pincode-check error';
                    pincodeCheck.textContent = 'Coming soon in your area';
                    placeOrderBtn.disabled = true;
                } else {
                    pincodeCheck.className = 'pincode-check error';
                    pincodeCheck.textContent = 'Delivery not available in your area';
                    placeOrderBtn.disabled = true;
                }
            } else {
                pincodeCheck.className = 'pincode-check error';
                pincodeCheck.textContent = 'Please enter a valid 6-digit pincode';
                placeOrderBtn.disabled = true;
            }
        }

        document.getElementById('pincode').addEventListener('input', function(e) {
            // Only allow numbers
            this.value = this.value.replace(/[^0-9]/g, '');
            // Clear the pincode check message when user starts typing
            document.getElementById('pincode-check').textContent = '';
        });

        function selectPayment(method) {
            document.querySelectorAll('.payment-option').forEach(option => {
                option.classList.remove('selected');
            });
            event.currentTarget.classList.add('selected');
            
            if (method === 'card') {
                document.getElementById('card-details').classList.add('active');
                document.getElementById('upi-qr').style.display = 'none';
            } else {
                document.getElementById('card-details').classList.remove('active');
                document.getElementById('upi-qr').style.display = 'block';
            }
        }

        document.getElementById('place-order-btn').addEventListener('click', function() {
            const phone = document.getElementById('phone').value;
            const address = document.getElementById('address').value;
            const pincode = document.getElementById('pincode').value;
            const selectedPayment = document.querySelector('.payment-option.selected');
            
            if (!phone || !address || !pincode || !selectedPayment) {
                alert('Please fill in all required fields and select a payment method');
                return;
            }

            const paymentMethod = selectedPayment.querySelector('i').classList.contains('fa-credit-card') ? 'card' : 'upi';
            const cart = JSON.parse(localStorage.getItem('cart')) || [];

            // Send order to server
            fetch('process_order.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    cart: JSON.stringify(cart),
                    payment_method: paymentMethod,
                    address: address,
                    phone: phone,
                    pincode: pincode
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Clear cart and redirect to order confirmation
                    localStorage.removeItem('cart');
                    window.location.href = 'order_confirmation.php?order_id=' + data.order_id;
                } else {
                    alert('Error placing order: ' + data.error);
                }
            })
            .catch(error => {
                alert('Error placing order. Please try again.');
                console.error('Error:', error);
            });
        });
    </script>
</body>
</html> 
<?php
session_start();
include 'config/db.php';

if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    header('Location: login.php');
    exit();
}

if (!isset($_GET['order_id'])) {
    header('Location: index.php');
    exit();
}

$order_id = $_GET['order_id'];
$user_id = $_SESSION['user_id'];

// Get order details
$order_sql = "SELECT o.*, u.name as user_name, u.email 
              FROM orders o 
              JOIN users u ON o.user_id = u.id 
              WHERE o.id = ? AND o.user_id = ?";
$order_stmt = mysqli_prepare($conn, $order_sql);
mysqli_stmt_bind_param($order_stmt, "ii", $order_id, $user_id);
mysqli_stmt_execute($order_stmt);
$order_result = mysqli_stmt_get_result($order_stmt);
$order = mysqli_fetch_assoc($order_result);

if (!$order) {
    header('Location: index.php');
    exit();
}

// Get order items
$items_sql = "SELECT oi.*, p.name as product_name, p.image_url 
              FROM order_items oi 
              JOIN products p ON oi.product_id = p.id 
              WHERE oi.order_id = ?";
$items_stmt = mysqli_prepare($conn, $items_sql);
mysqli_stmt_bind_param($items_stmt, "i", $order_id);
mysqli_stmt_execute($items_stmt);
$items_result = mysqli_stmt_get_result($items_stmt);
$order_items = [];
while ($item = mysqli_fetch_assoc($items_result)) {
    $order_items[] = $item;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation - Kumar Brothers</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .confirmation-container {
            max-width: 800px;
            margin: 100px auto;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .success-message {
            text-align: center;
            color: #28a745;
            margin-bottom: 30px;
        }
        .success-message i {
            font-size: 48px;
            margin-bottom: 20px;
        }
        .order-details {
            margin-bottom: 30px;
        }
        .order-details h2 {
            margin-bottom: 20px;
            color: #333;
        }
        .detail-group {
            margin-bottom: 15px;
        }
        .detail-group label {
            font-weight: bold;
            color: #666;
        }
        .detail-group p {
            margin: 5px 0;
            color: #333;
        }
        .order-items {
            margin-top: 30px;
        }
        .order-item {
            display: flex;
            align-items: center;
            padding: 15px;
            border-bottom: 1px solid #eee;
        }
        .order-item img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 4px;
            margin-right: 15px;
        }
        .item-details {
            flex-grow: 1;
        }
        .item-details h3 {
            margin: 0 0 5px 0;
            color: #333;
        }
        .item-details p {
            margin: 5px 0;
            color: #666;
        }
        .continue-shopping {
            text-align: center;
            margin-top: 30px;
        }
        .continue-shopping a {
            display: inline-block;
            padding: 12px 30px;
            background: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            transition: background 0.3s;
        }
        .continue-shopping a:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <div class="confirmation-container">
        <div class="success-message">
            <i class="fas fa-check-circle"></i>
            <h1>Order Placed Successfully!</h1>
            <p>Thank you for shopping with us.</p>
        </div>

        <div class="order-details">
            <h2>Order Details</h2>
            <div class="detail-group">
                <label>Order Number:</label>
                <p>#<?php echo $order['id']; ?></p>
            </div>
            <div class="detail-group">
                <label>Order Date:</label>
                <p><?php echo date('F d, Y', strtotime($order['created_at'])); ?></p>
            </div>
            <div class="detail-group">
                <label>Total Amount:</label>
                <p>₹<?php echo number_format($order['total_amount'], 2); ?></p>
            </div>
            <div class="detail-group">
                <label>Payment Method:</label>
                <p><?php echo ucfirst($order['payment_method']); ?></p>
            </div>
            <div class="detail-group">
                <label>Shipping Address:</label>
                <p><?php echo nl2br(htmlspecialchars($order['shipping_address'])); ?></p>
            </div>
        </div>

        <div class="order-items">
            <h2>Ordered Items</h2>
            <?php foreach ($order_items as $item): ?>
                <div class="order-item">
                    <img src="<?php echo htmlspecialchars($item['image_url']); ?>" alt="<?php echo htmlspecialchars($item['product_name']); ?>">
                    <div class="item-details">
                        <h3><?php echo htmlspecialchars($item['product_name']); ?></h3>
                        <p>Size: <?php echo htmlspecialchars($item['size']); ?></p>
                        <p>Quantity: <?php echo $item['quantity']; ?></p>
                        <p>Price: ₹<?php echo number_format($item['price'], 2); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="continue-shopping">
            <a href="index.php">Continue Shopping</a>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>
</body>
</html> 
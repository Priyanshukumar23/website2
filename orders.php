<?php
session_start();
include 'config/db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Get all orders for the user
$sql = "SELECT o.*, 
        GROUP_CONCAT(CONCAT(p.name, ' (Qty: ', oi.quantity, ')') SEPARATOR ', ') as items
        FROM orders o
        LEFT JOIN order_items oi ON o.id = oi.order_id
        LEFT JOIN products p ON oi.product_id = p.id
        WHERE o.user_id = ?
        GROUP BY o.id
        ORDER BY o.created_at DESC";
        
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$orders = [];
while ($order = mysqli_fetch_assoc($result)) {
    $orders[] = $order;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders - Kumar Brothers</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .orders-container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1rem;
        }
        .order-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
            overflow: hidden;
        }
        .order-header {
            background: #f8f9fa;
            padding: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #eee;
        }
        .order-header h2 {
            margin: 0;
            color: #333;
            font-size: 1.2rem;
        }
        .order-date {
            color: #666;
        }
        .order-body {
            padding: 1.5rem;
        }
        .order-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }
        .detail-group h3 {
            margin: 0 0 0.5rem 0;
            color: #333;
            font-size: 1rem;
        }
        .detail-group p {
            margin: 0;
            color: #666;
        }
        .order-items {
            margin-top: 1.5rem;
        }
        .order-items h3 {
            margin: 0 0 1rem 0;
            color: #333;
        }
        .order-items p {
            margin: 0;
            color: #666;
            line-height: 1.6;
        }
        .order-status {
            display: inline-block;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 500;
        }
        .status-pending {
            background: #fff3cd;
            color: #856404;
        }
        .status-processing {
            background: #cce5ff;
            color: #004085;
        }
        .status-shipped {
            background: #d4edda;
            color: #155724;
        }
        .status-delivered {
            background: #d4edda;
            color: #155724;
        }
        .status-cancelled {
            background: #f8d7da;
            color: #721c24;
        }
        .no-orders {
            text-align: center;
            padding: 3rem;
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .no-orders i {
            font-size: 3rem;
            color: #ddd;
            margin-bottom: 1rem;
        }
        .no-orders h2 {
            color: #333;
            margin-bottom: 1rem;
        }
        .no-orders p {
            color: #666;
            margin-bottom: 1.5rem;
        }
        .btn-shop {
            display: inline-block;
            padding: 0.8rem 2rem;
            background: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background 0.3s;
        }
        .btn-shop:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <div class="orders-container">
        <h1>My Orders</h1>
        
        <?php if (empty($orders)): ?>
            <div class="no-orders">
                <i class="fas fa-shopping-bag"></i>
                <h2>No Orders Yet</h2>
                <p>You haven't placed any orders yet. Start shopping now!</p>
                <a href="index.php" class="btn-shop">Start Shopping</a>
            </div>
        <?php else: ?>
            <?php foreach ($orders as $order): ?>
                <div class="order-card">
                    <div class="order-header">
                        <h2>Order #<?php echo $order['id']; ?></h2>
                        <div class="order-status status-<?php echo strtolower($order['status']); ?>">
                            <?php echo ucfirst($order['status']); ?>
                        </div>
                    </div>
                    
                    <div class="order-body">
                        <div class="order-details">
                            <div class="detail-group">
                                <h3>Order Date</h3>
                                <p><?php echo date('M d, Y', strtotime($order['created_at'])); ?></p>
                            </div>
                            
                            <div class="detail-group">
                                <h3>Total Amount</h3>
                                <p>₹<?php echo number_format($order['total_amount'], 2); ?></p>
                            </div>
                            
                            <div class="detail-group">
                                <h3>Payment Method</h3>
                                <p><?php echo ucfirst($order['payment_method']); ?></p>
                            </div>
                            
                            <div class="detail-group">
                                <h3>Delivery Address</h3>
                                <p><?php echo nl2br(htmlspecialchars($order['shipping_address'])); ?></p>
                            </div>

                            <div class="detail-group">
                                <h3>Phone Number</h3>
                                <p><?php echo htmlspecialchars($order['phone']); ?></p>
                            </div>

                            <div class="detail-group">
                                <h3>Pincode</h3>
                                <p><?php echo htmlspecialchars($order['pincode']); ?></p>
                            </div>
                        </div>
                        
                        <div class="order-items">
                            <h3>Ordered Items</h3>
                            <p><?php echo htmlspecialchars($order['items']); ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
    
    <?php include 'includes/footer.php'; ?>
</body>
</html> 
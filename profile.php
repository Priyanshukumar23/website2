<?php
session_start();
include 'config/db.php';

// Check if user is logged in
if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    header('Location: login.php');
    exit();
}

// Get user information
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (!$user = mysqli_fetch_assoc($result)) {
    // If user not found in database, log them out
    session_destroy();
    header('Location: login.php');
    exit();
}

// Get user's recent orders
$order_sql = "SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC LIMIT 5";
$order_stmt = mysqli_prepare($conn, $order_sql);
mysqli_stmt_bind_param($order_stmt, "i", $user_id);
mysqli_stmt_execute($order_stmt);
$orders_result = mysqli_stmt_get_result($order_stmt);
$recent_orders = [];
while ($order = mysqli_fetch_assoc($orders_result)) {
    $recent_orders[] = $order;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile - Kumar Brothers</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .profile-container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1rem;
        }
        .profile-header {
            display: flex;
            align-items: center;
            margin-bottom: 2rem;
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .profile-avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: #f0f0f0;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 2rem;
        }
        .profile-avatar i {
            font-size: 3rem;
            color: #666;
        }
        .profile-info h1 {
            margin: 0;
            color: #333;
            font-size: 2rem;
        }
        .profile-info p {
            color: #666;
            margin: 0.5rem 0;
        }
        .profile-nav {
            display: flex;
            gap: 1rem;
            margin-bottom: 2rem;
            flex-wrap: wrap;
        }
        .profile-nav a {
            padding: 0.8rem 1.5rem;
            background: #f8f9fa;
            border-radius: 5px;
            text-decoration: none;
            color: #333;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .profile-nav a:hover {
            background: #007bff;
            color: white;
        }
        .profile-nav a i {
            font-size: 1.2rem;
        }
        .profile-section {
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
        }
        .profile-section h2 {
            color: #333;
            margin-bottom: 1.5rem;
            font-size: 1.5rem;
        }
        .order-list {
            list-style: none;
            padding: 0;
        }
        .order-item {
            padding: 1rem;
            border-bottom: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .order-item:last-child {
            border-bottom: none;
        }
        .order-info {
            flex: 1;
        }
        .order-info h3 {
            margin: 0 0 0.5rem 0;
            color: #333;
        }
        .order-info p {
            margin: 0;
            color: #666;
        }
        .order-status {
            display: inline-block;
            padding: 0.3rem 0.8rem;
            border-radius: 15px;
            font-size: 0.85rem;
            font-weight: 500;
            margin-left: 0.5rem;
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
        .welcome-message {
            text-align: center;
            margin-bottom: 2rem;
            color: #333;
        }
        .btn-view-order {
            padding: 0.5rem 1rem;
            background: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background 0.3s;
            font-size: 0.9rem;
        }
        .btn-view-order:hover {
            background: #0056b3;
        }
        .btn-view-all {
            display: inline-block;
            padding: 0.8rem 2rem;
            background: #28a745;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background 0.3s;
            margin-top: 1rem;
        }
        .btn-view-all:hover {
            background: #218838;
        }
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <div class="profile-container">
        <div class="welcome-message">
            <h1>Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</h1>
        </div>
        
        <div class="profile-header">
            <div class="profile-avatar">
                <i class="fas fa-user"></i>
            </div>
            <div class="profile-info">
                <h1><?php echo htmlspecialchars($user['name']); ?></h1>
                <p><i class="fas fa-envelope"></i> <?php echo htmlspecialchars($user['email']); ?></p>
                <?php if (!empty($user['phone'])): ?>
                    <p><i class="fas fa-phone"></i> <?php echo htmlspecialchars($user['phone']); ?></p>
                <?php endif; ?>
                <p><i class="fas fa-calendar"></i> Member since: <?php echo date('F Y', strtotime($user['created_at'])); ?></p>
            </div>
        </div>
        
        <div class="profile-nav">
            <a href="edit_profile.php"><i class="fas fa-edit"></i> Edit Profile</a>
            <a href="orders.php"><i class="fas fa-shopping-bag"></i> Track Orders</a>
            <a href="settings.php"><i class="fas fa-cog"></i> Settings</a>
            <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
        
        <div class="profile-section">
            <h2>Recent Orders</h2>
            <?php if (!empty($recent_orders)): ?>
                <ul class="order-list">
                    <?php foreach ($recent_orders as $order): ?>
                        <li class="order-item">
                            <div class="order-info">
                                <h3>Order #<?php echo $order['id']; ?></h3>
                                <p>Date: <?php echo date('M d, Y', strtotime($order['created_at'])); ?></p>
                                <p>Total: ₹<?php echo number_format($order['total_amount'], 2); ?></p>
                                <p>Status: <span class="order-status status-<?php echo strtolower($order['status']); ?>"><?php echo ucfirst($order['status']); ?></span></p>
                            </div>
                            <a href="orders.php" class="btn-view-order">View Details</a>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <div style="text-align: center; margin-top: 1rem;">
                    <a href="orders.php" class="btn-view-all">View All Orders</a>
                </div>
            <?php else: ?>
                <p>No recent orders found.</p>
            <?php endif; ?>
        </div>
    </div>
    
    <?php include 'includes/footer.php'; ?>
</body>
</html> 
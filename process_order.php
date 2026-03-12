<?php
session_start();
include 'config/db.php';

if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $cart = json_decode($_POST['cart'], true);
    $total_amount = 0;
    $payment_method = $_POST['payment_method'];
    $shipping_address = $_POST['address'];
    $phone = $_POST['phone'];
    $pincode = $_POST['pincode'];

    // Calculate total amount
    foreach ($cart as $item) {
        $total_amount += $item['price'] * $item['quantity'];
    }

    try {
        // Start transaction
        mysqli_begin_transaction($conn);

        // Insert into orders table
        $order_sql = "INSERT INTO orders (user_id, total_amount, status, shipping_address, phone, pincode, payment_method) 
                     VALUES (?, ?, 'pending', ?, ?, ?, ?)";
        $order_stmt = mysqli_prepare($conn, $order_sql);
        mysqli_stmt_bind_param($order_stmt, "idssss", $user_id, $total_amount, $shipping_address, $phone, $pincode, $payment_method);
        
        if (!mysqli_stmt_execute($order_stmt)) {
            throw new Exception("Error creating order: " . mysqli_error($conn));
        }
        
        $order_id = mysqli_insert_id($conn);

        // Insert order items
        foreach ($cart as $item) {
            if (!isset($item['product_id'])) {
                throw new Exception("Product ID is missing for item: " . $item['name']);
            }
            
            $item_sql = "INSERT INTO order_items (order_id, product_id, quantity, size, price) 
                        VALUES (?, ?, ?, ?, ?)";
            $item_stmt = mysqli_prepare($conn, $item_sql);
            mysqli_stmt_bind_param($item_stmt, "iiiss", $order_id, $item['product_id'], $item['quantity'], $item['size'], $item['price']);
            
            if (!mysqli_stmt_execute($item_stmt)) {
                throw new Exception("Error adding order items: " . mysqli_error($conn));
            }
        }

        // Commit transaction
        mysqli_commit($conn);
        
        // Return success response
        echo json_encode(['success' => true, 'order_id' => $order_id]);
    } catch (Exception $e) {
        // Rollback transaction on error
        mysqli_rollback($conn);
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request method']);
}
?> 
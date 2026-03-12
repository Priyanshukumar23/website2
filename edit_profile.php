<?php
session_start();
include 'config/db.php';

// Check if user is logged in
if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    header('Location: login.php');
    exit();
}

// Select the database
if (!mysqli_select_db($conn, 'kumar_brothers')) {
    die("Could not select database: " . mysqli_error($conn));
}

$user_id = $_SESSION['user_id'];
$message = '';
$error = '';

// Get user information
$sql = "SELECT id, name, email FROM users WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);
    
    // Validate input
    if (empty($name)) {
        $error = "Name is required";
    } elseif (!empty($phone) && !preg_match('/^[0-9]{10}$/', $phone)) {
        $error = "Please enter a valid 10-digit phone number";
    } else {
        // Check if phone and address columns exist
        $columns_check = mysqli_query($conn, "SHOW COLUMNS FROM users LIKE 'phone'");
        if (mysqli_num_rows($columns_check) == 0) {
            // Redirect to update database page if columns don't exist
            header('Location: update_database.php');
            exit();
        }

        // Update user information
        $sql = "UPDATE users SET name = ?, phone = ?, address = ? WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sssi", $name, $phone, $address, $user_id);
        
        if (mysqli_stmt_execute($stmt)) {
            $message = "Profile updated successfully!";
            // Update session name
            $_SESSION['user_name'] = $name;
            // Refresh user data
            $sql = "SELECT * FROM users WHERE id = ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "i", $user_id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $user = mysqli_fetch_assoc($result);
        } else {
            $error = "Error updating profile. Please try again.";
        }
        mysqli_stmt_close($stmt);
    }
}

// Get phone and address if they exist
$phone = '';
$address = '';
$columns_check = mysqli_query($conn, "SHOW COLUMNS FROM users LIKE 'phone'");
if (mysqli_num_rows($columns_check) > 0) {
    $sql = "SELECT phone, address FROM users WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user_data = mysqli_fetch_assoc($result);
    if ($user_data) {
        $phone = $user_data['phone'] ?? '';
        $address = $user_data['address'] ?? '';
    }
    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile - Kumar Brothers</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .edit-profile-container {
            max-width: 800px;
            margin: 2rem auto;
            padding: 2rem;
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .edit-profile-title {
            font-size: 2rem;
            color: #333;
            margin-bottom: 2rem;
        }
        .form-group {
            margin-bottom: 1.5rem;
        }
        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: bold;
            color: #666;
        }
        .form-input {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
        }
        .form-input:focus {
            outline: none;
            border-color: #007bff;
            box-shadow: 0 0 0 2px rgba(0,123,255,0.25);
        }
        .form-input[disabled] {
            background-color: #f8f9fa;
            cursor: not-allowed;
        }
        .btn {
            background: #007bff;
            color: white;
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
            transition: background 0.3s;
        }
        .btn:hover {
            background: #0056b3;
        }
        .message {
            padding: 1rem;
            margin-bottom: 1rem;
            border-radius: 5px;
        }
        .success {
            background: #d4edda;
            color: #155724;
        }
        .error {
            background: #f8d7da;
            color: #721c24;
        }
        .help-text {
            font-size: 0.875rem;
            color: #666;
            margin-top: 0.25rem;
        }
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <div class="edit-profile-container">
        <h1 class="edit-profile-title">Edit Profile</h1>
        
        <?php if ($message): ?>
            <div class="message success"><?php echo $message; ?></div>
        <?php endif; ?>
        
        <?php if ($error): ?>
            <div class="message error"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="form-group">
                <label class="form-label" for="name">Full Name</label>
                <input type="text" id="name" name="name" class="form-input" 
                       value="<?php echo htmlspecialchars($user['name']); ?>" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="email">Email</label>
                <input type="email" id="email" class="form-input" 
                       value="<?php echo htmlspecialchars($user['email']); ?>" disabled>
                <div class="help-text">Email cannot be changed</div>
            </div>

            <div class="form-group">
                <label class="form-label" for="phone">Phone Number</label>
                <input type="tel" id="phone" name="phone" class="form-input" 
                       value="<?php echo htmlspecialchars($phone); ?>"
                       pattern="[0-9]{10}" maxlength="10">
                <div class="help-text">Enter 10-digit phone number (optional)</div>
            </div>

            <div class="form-group">
                <label class="form-label" for="address">Address</label>
                <textarea id="address" name="address" class="form-input" rows="4"><?php 
                    echo htmlspecialchars($address); 
                ?></textarea>
                <div class="help-text">Enter your complete address (optional)</div>
            </div>

            <button type="submit" class="btn">Save Changes</button>
        </form>
    </div>

    <?php include 'includes/footer.php'; ?>
</body>
</html> 
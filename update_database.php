<?php
// Include database connection
include 'config/db.php';

// Function to check if a column exists
function columnExists($conn, $table, $column) {
    $result = mysqli_query($conn, "SHOW COLUMNS FROM $table LIKE '$column'");
    return mysqli_num_rows($result) > 0;
}

// Select the database
if (!mysqli_select_db($conn, 'kumar_brothers')) {
    die("Could not select database: " . mysqli_error($conn));
}

// Check if users table exists
$table_check = mysqli_query($conn, "SHOW TABLES LIKE 'users'");
if (mysqli_num_rows($table_check) == 0) {
    die("Users table does not exist. Please run the database.sql file first.");
}

// Check and add phone column if it doesn't exist
if (!columnExists($conn, 'users', 'phone')) {
    $sql = "ALTER TABLE users ADD COLUMN phone VARCHAR(10)";
    if (mysqli_query($conn, $sql)) {
        echo "Phone column added successfully.<br>";
    } else {
        echo "Error adding phone column: " . mysqli_error($conn) . "<br>";
    }
} else {
    echo "Phone column already exists.<br>";
}

// Check and add address column if it doesn't exist
if (!columnExists($conn, 'users', 'address')) {
    $sql = "ALTER TABLE users ADD COLUMN address TEXT";
    if (mysqli_query($conn, $sql)) {
        echo "Address column added successfully.<br>";
    } else {
        echo "Error adding address column: " . mysqli_error($conn) . "<br>";
    }
} else {
    echo "Address column already exists.<br>";
}

// Update phone column length if it exists
$sql = "ALTER TABLE users MODIFY COLUMN phone VARCHAR(10)";
if (mysqli_query($conn, $sql)) {
    echo "Phone column length updated to 10 characters.<br>";
} else {
    echo "Error updating phone column length: " . mysqli_error($conn) . "<br>";
}

echo "Database update completed. You can now use the edit profile functionality.<br>";
echo '<a href="edit_profile.php">Go to Edit Profile</a>';

// Close connection
mysqli_close($conn);
?> 
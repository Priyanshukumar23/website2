<?php
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'web';

// Function to establish database connection with retry logic 
function connectDB() {
    global $host, $username, $password, $database;
    
    $maxRetries = 3;
    $retryDelay = 2; // seconds
    
    for ($i = 0; $i < $maxRetries; $i++) {
        try {
            $conn = mysqli_connect($host, $username, $password, $database);
            
            if ($conn) {
                // Set charset to utf8mb4
                mysqli_set_charset($conn, "utf8mb4");
                return $conn;
            }
            
            if ($i < $maxRetries - 1) {
                sleep($retryDelay);
            }
        } catch (Exception $e) {
            if ($i < $maxRetries - 1) {
                sleep($retryDelay);
                continue;
            }
            throw $e;
        }
    }
    
    throw new Exception("Could not connect to MySQL server after $maxRetries attempts. Please make sure MySQL is running in XAMPP.");
}

// Function to check connection and reconnect if needed
function checkConnection($conn) {
    if (!mysqli_ping($conn)) {
        mysqli_close($conn);
        return connectDB();
    }
    return $conn;
}

try {
    // Create connection
    $conn = connectDB();
} catch (Exception $e) {
    die("Database Connection Error: " . $e->getMessage() . 
        "<br>Please make sure:<br>" .
        "1. XAMPP is running<br>" .
        "2. MySQL service is started in XAMPP Control Panel<br>" .
        "3. The database 'kumar_brothers' exists<br>" .
        "4. The username and password are correct");
}
?> 
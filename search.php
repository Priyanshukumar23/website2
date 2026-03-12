<?php
include 'config/db.php';

$search_results = [];
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['query'])) {
    $search_query = trim($_GET['query']);
    
    if (!empty($search_query)) {
        // Prepare the search query with wildcards
        $search_term = '%' . $search_query . '%';
        
        // Search in products table
        $sql = "SELECT * FROM products WHERE 
                name LIKE ? OR 
                description LIKE ? OR 
                category LIKE ?";
                
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sss", $search_term, $search_term, $search_term);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $search_results[] = $row;
            }
        } else {
            $error = "No products found matching your search.";
        }
    } else {
        $error = "Please enter a search term.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search - Kumar Brothers</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <div class="container">
        <div class="search-container">
            <h1>Search Products</h1>
            
            <form action="search.php" method="GET" class="search-form">
                <div class="search-box">
                    <input type="text" name="query" placeholder="Search products..." value="<?php echo isset($_GET['query']) ? htmlspecialchars($_GET['query']) : ''; ?>">
                    <button type="submit"><i class="fas fa-search"></i></button>
                </div>
            </form>
            
            <?php if (!empty($error)): ?>
                <div class="error-message"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <?php if (!empty($search_results)): ?>
                <div class="search-results">
                    <h2>Search Results</h2>
                    <div class="product-grid">
                        <?php foreach ($search_results as $product): ?>
                            <div class="product-card">
                                <img src="<?php echo htmlspecialchars($product['image_url']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                                <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                                <p class="price">₹<?php echo number_format($product['price'], 2); ?></p>
                                <p class="description"><?php echo htmlspecialchars($product['description']); ?></p>
                                <a href="product.php?id=<?php echo $product['id']; ?>" class="btn">View Details</a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <?php include 'includes/footer.php'; ?>
</body>
</html> 
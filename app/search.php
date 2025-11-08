<?php
session_start();

$results = [];
$search = '';

if (isset($_GET['q'])) {
    $search = $_GET['q'];
    
    $conn = new mysqli(getenv('MYSQL_HOST'), getenv('MYSQL_USER'), getenv('MYSQL_PASSWORD'), getenv('MYSQL_DATABASE'));
    
    // SQL Injection in search - no sanitization
    $query = "SELECT * FROM products WHERE name LIKE '%$search%' OR description LIKE '%$search%'";
    $result = $conn->query($query);
    
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $results[] = $row;
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Search - VulnShop</title>
    <style>
        body { font-family: Arial; max-width: 1200px; margin: 0 auto; padding: 20px; background: #f5f5f5; }
        .header { background: #333; color: white; padding: 20px; margin-bottom: 20px; }
        .nav { background: #444; padding: 10px; margin-bottom: 20px; }
        .nav a { color: white; margin-right: 20px; text-decoration: none; }
        .content { background: white; padding: 20px; border-radius: 5px; }
        input { padding: 10px; width: 60%; }
        button { background: #333; color: white; padding: 10px 20px; border: none; cursor: pointer; }
        .product { border: 1px solid #ddd; padding: 15px; margin: 10px 0; border-radius: 5px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>🛒 VulnShop</h1>
    </div>
    
    <div class="nav">
        <a href="index.php">Home</a>
        <a href="login.php">Login</a>
        <a href="search.php">Search</a>
        <a href="profile.php">Profile</a>
        <a href="upload.php">Upload</a>
        <a href="admin.php">Admin</a>
    </div>
    
    <div class="content">
        <h2>Search Products</h2>
        <form method="GET">
            <input type="text" name="q" value="<?php echo htmlspecialchars($search); ?>" placeholder="Search for products...">
            <button type="submit">Search</button>
        </form>
        
        <?php if ($search): ?>
            <h3>Results for: "<?php echo $search; ?>"</h3>
            <!-- XSS vulnerability - unescaped output -->
            
            <?php if (count($results) > 0): ?>
                <?php foreach ($results as $product): ?>
                    <div class="product">
                        <h4><?php echo $product['name']; ?></h4>
                        <p><?php echo $product['description']; ?></p>
                        <p><strong>Price: $<?php echo $product['price']; ?></strong></p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No products found.</p>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</body>
</html>
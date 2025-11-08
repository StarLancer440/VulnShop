<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>VulnShop - Training Platform</title>
    <style>
        body { font-family: Arial; max-width: 1200px; margin: 0 auto; padding: 20px; background: #f5f5f5; }
        .header { background: #333; color: white; padding: 20px; margin-bottom: 20px; }
        .nav { background: #444; padding: 10px; margin-bottom: 20px; }
        .nav a { color: white; margin-right: 20px; text-decoration: none; }
        .content { background: white; padding: 20px; border-radius: 5px; }
        .login-form { max-width: 400px; margin: 0 auto; }
        input, textarea { width: 100%; padding: 8px; margin: 5px 0; }
        button { background: #333; color: white; padding: 10px 20px; border: none; cursor: pointer; }
        .footer { margin-top: 20px; padding: 10px; text-align: center; font-size: 12px; color: #666; }
    </style>
</head>
<body>
    <div class="header">
        <h1>🛒 VulnShop - Cybersecurity Training Lab</h1>
        <p>A deliberately vulnerable web application for penetration testing practice</p>
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
        <h2>Welcome to VulnShop</h2>
        <p>This is a training environment containing multiple web vulnerabilities.</p>
        <p><strong>⚠️ WARNING:</strong> This application is intentionally vulnerable. Never deploy this on a public network!</p>
        
        <h3>Available Features:</h3>
        <ul>
            <li>User Authentication</li>
            <li>Product Search</li>
            <li>User Profiles</li>
            <li>File Upload</li>
            <li>Admin Panel</li>
        </ul>
        
        <h3>Getting Started:</h3>
        <p>Try logging in with username: <code>admin</code> and explore the application!</p>
    </div>
    
    <div class="footer">
        <!-- Debug info: <?php echo $_SERVER['REMOTE_ADDR']; ?> -->
        VulnShop v1.0 | For educational purposes only
    </div>
</body>
</html>
<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    try {
        // SQL Injection vulnerability - no input sanitization
        $conn = new mysqli(getenv('MYSQL_HOST'), getenv('MYSQL_USER'), getenv('MYSQL_PASSWORD'), getenv('MYSQL_DATABASE'));
        
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        
        $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
        $result = $conn->query($query);
        
        if ($result && $result->num_rows > 0) {
            $user = $result->fetch_assoc();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            header('Location: profile.php');
            exit();
        } else {
            $error = 'Invalid credentials';
        }
        $conn->close();
    } catch (Exception $e) {
        $error = 'Database error: ' . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login - VulnShop</title>
    <style>
        body { font-family: Arial; max-width: 1200px; margin: 0 auto; padding: 20px; background: #f5f5f5; }
        .header { background: #333; color: white; padding: 20px; margin-bottom: 20px; }
        .nav { background: #444; padding: 10px; margin-bottom: 20px; }
        .nav a { color: white; margin-right: 20px; text-decoration: none; }
        .content { background: white; padding: 20px; border-radius: 5px; max-width: 400px; margin: 0 auto; }
        input { width: 100%; padding: 8px; margin: 5px 0; box-sizing: border-box; }
        button { background: #333; color: white; padding: 10px 20px; border: none; cursor: pointer; width: 100%; }
        .error { color: red; padding: 10px; background: #ffe0e0; margin-bottom: 10px; }
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
        <h2>Login</h2>
        <?php if ($error): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <form method="POST">
            <label>Username:</label>
            <input type="text" name="username" required>
            
            <label>Password:</label>
            <input type="password" name="password" required>
            
            <br><br>
            <button type="submit">Login</button>
        </form>
        
        <p style="margin-top: 20px; font-size: 12px; color: #666;">
            Hint: Try some default credentials!
        </p>
    </div>
</body>
</html>
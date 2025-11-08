<?php
session_start();

// Insecure Direct Object Reference vulnerability
$user_id = isset($_GET['id']) ? $_GET['id'] : (isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null);

if (!$user_id) {
    header('Location: login.php');
    exit();
}

$conn = new mysqli(getenv('MYSQL_HOST'), getenv('MYSQL_USER'), getenv('MYSQL_PASSWORD'), getenv('MYSQL_DATABASE'));

// SQL Injection vulnerability
$query = "SELECT * FROM users WHERE id = $user_id";
$result = $conn->query($query);
$user = $result->fetch_assoc();

// Handle profile update
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['bio'])) {
    $bio = $_POST['bio'];
    // Stored XSS vulnerability - no sanitization
    $update = "UPDATE users SET bio = '$bio' WHERE id = $user_id";
    $conn->query($update);
    header("Location: profile.php?id=$user_id");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Profile - VulnShop</title>
    <style>
        body { font-family: Arial; max-width: 1200px; margin: 0 auto; padding: 20px; background: #f5f5f5; }
        .header { background: #333; color: white; padding: 20px; margin-bottom: 20px; }
        .nav { background: #444; padding: 10px; margin-bottom: 20px; }
        .nav a { color: white; margin-right: 20px; text-decoration: none; }
        .content { background: white; padding: 20px; border-radius: 5px; }
        textarea { width: 100%; padding: 10px; margin: 10px 0; box-sizing: border-box; }
        button { background: #333; color: white; padding: 10px 20px; border: none; cursor: pointer; }
        .profile-info { background: #f9f9f9; padding: 15px; border-radius: 5px; margin-bottom: 20px; }
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
        <h2>User Profile</h2>

        <?php if ($user): ?>
            <div class="profile-info">
                <p><strong>Username:</strong> <?php echo $user['username']; ?></p>
                <p><strong>Email:</strong> <?php echo $user['email']; ?></p>
                <p><strong>Role:</strong> <?php echo $user['role']; ?></p>
                <p><strong>User ID:</strong> <?php echo $user['id']; ?></p>
            </div>

            <h3>Bio</h3>
            <!-- Stored XSS vulnerability - unescaped output -->
            <div style="border: 1px solid #ddd; padding: 10px; min-height: 50px;">
                <?php echo $user['bio'] ? $user['bio'] : 'No bio yet.'; ?>
            </div>

            <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $user_id): ?>
                <h3>Update Bio</h3>
                <form method="POST">
                    <textarea name="bio" rows="5" placeholder="Tell us about yourself..."><?php echo $user['bio']; ?></textarea>
                    <button type="submit">Update Bio</button>
                </form>
            <?php endif; ?>

        <?php else: ?>
            <p>User not found.</p>
        <?php endif; ?>
    </div>
</body>
</html>

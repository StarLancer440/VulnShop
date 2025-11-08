<?php
session_start();

// Broken access control - only checks session, no CSRF protection
$is_admin = isset($_SESSION['role']) && $_SESSION['role'] == 'admin';

$conn = new mysqli(getenv('MYSQL_HOST'), getenv('MYSQL_USER'), getenv('MYSQL_PASSWORD'), getenv('MYSQL_DATABASE'));

// Handle user deletion (no CSRF token)
if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $conn->query("DELETE FROM users WHERE id = $delete_id");
    header('Location: admin.php');
    exit();
}

// Get all users
$users = [];
$result = $conn->query("SELECT id, username, email, role FROM users");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel - VulnShop</title>
    <style>
        body { font-family: Arial; max-width: 1200px; margin: 0 auto; padding: 20px; background: #f5f5f5; }
        .header { background: #333; color: white; padding: 20px; margin-bottom: 20px; }
        .nav { background: #444; padding: 10px; margin-bottom: 20px; }
        .nav a { color: white; margin-right: 20px; text-decoration: none; }
        .content { background: white; padding: 20px; border-radius: 5px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 10px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background: #333; color: white; }
        .delete-btn { color: red; text-decoration: none; }
        .warning { background: #fff3cd; padding: 15px; border-left: 4px solid #ffc107; margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>🛒 VulnShop - Admin Panel</h1>
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
        <?php if (!$is_admin): ?>
            <div class="warning">
                ⚠️ Access Denied. Admin privileges required.
            </div>
            <p>You need to be an administrator to access this page.</p>
        <?php else: ?>
            <h2>User Management</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?php echo $user['id']; ?></td>
                            <td><?php echo htmlspecialchars($user['username']); ?></td>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                            <td><?php echo htmlspecialchars($user['role']); ?></td>
                            <td>
                                <a href="profile.php?id=<?php echo $user['id']; ?>">View</a> |
                                <a href="admin.php?delete=<?php echo $user['id']; ?>" class="delete-btn" onclick="return confirm('Delete this user?')">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>

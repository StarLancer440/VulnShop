<?php
session_start();

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['file'])) {
    $target_dir = "uploads/";
    
    // Create uploads directory if it doesn't exist
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    
    // Unrestricted file upload vulnerability - no validation
    $target_file = $target_dir . basename($_FILES["file"]["name"]);
    
    if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
        $message = "File uploaded successfully: <a href='$target_file'>" . htmlspecialchars(basename($_FILES["file"]["name"])) . "</a>";
    } else {
        $message = "Error uploading file.";
    }
}

// List uploaded files
$files = [];
if (file_exists("uploads/")) {
    $files = array_diff(scandir("uploads/"), array('.', '..'));
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Upload - VulnShop</title>
    <style>
        body { font-family: Arial; max-width: 1200px; margin: 0 auto; padding: 20px; background: #f5f5f5; }
        .header { background: #333; color: white; padding: 20px; margin-bottom: 20px; }
        .nav { background: #444; padding: 10px; margin-bottom: 20px; }
        .nav a { color: white; margin-right: 20px; text-decoration: none; }
        .content { background: white; padding: 20px; border-radius: 5px; }
        button { background: #333; color: white; padding: 10px 20px; border: none; cursor: pointer; }
        .message { padding: 10px; background: #d4edda; color: #155724; margin-bottom: 20px; border-radius: 5px; }
        .file-list { margin-top: 20px; }
        .file-item { padding: 8px; border-bottom: 1px solid #eee; }
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
        <h2>File Upload</h2>
        
        <?php if ($message): ?>
            <div class="message"><?php echo $message; ?></div>
        <?php endif; ?>
        
        <form method="POST" enctype="multipart/form-data">
            <input type="file" name="file" required>
            <button type="submit">Upload File</button>
        </form>
        
        <div class="file-list">
            <h3>Uploaded Files</h3>
            <?php if (count($files) > 0): ?>
                <?php foreach ($files as $file): ?>
                    <div class="file-item">
                        <a href="uploads/<?php echo $file; ?>"><?php echo htmlspecialchars($file); ?></a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No files uploaded yet.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
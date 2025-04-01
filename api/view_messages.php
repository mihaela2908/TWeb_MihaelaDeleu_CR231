<?php
// Include database connection
require_once 'config.php';

// Check if ID is provided
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: admin.php");
    exit;
}

$id = $_GET['id'];

// Get the message from database
try {
    // Mark as read
    $updateStmt = $conn->prepare("UPDATE contact_messages SET is_read = 1 WHERE id = :id");
    $updateStmt->bindParam(':id', $id);
    $updateStmt->execute();
    
    // Get message details
    $stmt = $conn->prepare("SELECT * FROM contact_messages WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    
    $message = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$message) {
        header("Location: admin.php");
        exit;
    }
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Message - Contact Form</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .message-container {
            max-width: 800px;
            margin: 2rem auto;
            padding: 0 1rem;
        }
        
        .message-box {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            margin-bottom: 2rem;
        }
        
        .message-header {
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #eee;
        }
        
        .message-header h2 {
            margin-bottom: 0.5rem;
            color: #f44336;
        }
        
        .message-meta {
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }
        
        .message-content {
            line-height: 1.6;
            white-space: pre-wrap;
        }
        
        .back-button {
            display: inline-block;
            padding: 0.5rem 1rem;
            background-color: #f44336;
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }
        
        .back-button:hover {
            background-color: #d32f2f;
        }
    </style>
</head>
<body>
    <header>
        <div class="header-content">
            <div class="logo">
                <a href="index.html">M<span>Software</span></a>
            </div>
            <nav>
                <ul>
                    <li><a href="index.html">Home</a></li>
                    <li><a href="about.html">About</a></li>
                    <li><a href="services.html">Services</a></li>
                    <li><a href="portfolio.html">Portfolio</a></li>
                    <li><a href="contact.html">Contact</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="message-container">
        <div class="message-box">
            <div class="message-header">
                <h2><?php echo htmlspecialchars($message['subject'] ?: 'No Subject'); ?></h2>
                <div class="message-meta">
                    <p><strong>From:</strong> <?php echo htmlspecialchars($message['name']); ?></p>
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($message['email']); ?></p>
                    <p><strong>Date:</strong> <?php echo date('F d, Y H:i', strtotime($message['submission_date'])); ?></p>
                </div>
            </div>
            <div class="message-content">
                <?php echo nl2br(htmlspecialchars($message['message'])); ?>
            </div>
        </div>
        
        <a href="admin.php" class="back-button">Back to All Messages</a>
    </main>

    <footer>
        <div class="footer-content">
            <p>&copy; 2023 MSoftware. All Rights Reserved.</p>
        </div>
    </footer>
</body>
</html>
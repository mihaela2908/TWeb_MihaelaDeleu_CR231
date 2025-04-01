<?php
// Include database connection
require_once 'config.php';

// Get all messages from the database
try {
    $stmt = $conn->prepare("SELECT * FROM contact_messages ORDER BY submission_date DESC");
    $stmt->execute();
    $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    <title>Admin - Contact Messages</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .admin-container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1rem;
        }
        
        .admin-header {
            margin-bottom: 2rem;
            text-align: center;
        }
        
        .message-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 2rem;
        }
        
        .message-table th, 
        .message-table td {
            padding: 0.75rem;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        
        .message-table th {
            background-color: #f44336;
            color: white;
        }
        
        .message-table tr:hover {
            background-color: #f5f5f5;
        }
        
        .message-table tr.unread {
            font-weight: bold;
            background-color: #ffebee;
        }
        
        .button {
            display: inline-block;
            padding: 0.5rem 1rem;
            background-color: #f44336;
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }
        
        .button:hover {
            background-color: #d32f2f;
        }
        
        .no-messages {
            text-align: center;
            padding: 2rem;
            background-color: #f5f5f5;
            border-radius: 4px;
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

    <main class="admin-container">
        <div class="admin-header">
            <h1>Contact Form Messages</h1>
        </div>
        
        <?php if (count($messages) > 0): ?>
            <table class="message-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Subject</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($messages as $index => $message): ?>
                        <tr class="<?php echo $message['is_read'] ? '' : 'unread'; ?>">
                            <td><?php echo $index + 1; ?></td>
                            <td><?php echo htmlspecialchars($message['name']); ?></td>
                            <td><?php echo htmlspecialchars($message['email']); ?></td>
                            <td><?php echo htmlspecialchars($message['subject'] ?: 'No Subject'); ?></td>
                            <td><?php echo date('M d, Y H:i', strtotime($message['submission_date'])); ?></td>
                            <td>
                                <a href="view_message.php?id=<?php echo $message['id']; ?>" class="button">View</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="no-messages">
                <p>No messages have been received yet.</p>
            </div>
        <?php endif; ?>
    </main>

    <footer>
        <div class="footer-content">
            <p>&copy; 2023 MSoftware. All Rights Reserved.</p>
        </div>
    </footer>
</body>
</html>
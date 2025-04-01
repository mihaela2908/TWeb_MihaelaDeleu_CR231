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

// Count total messages
$totalMessages = count($messages);

// Count unread messages
$unreadMessages = 0;
foreach ($messages as $message) {
    if ($message['is_read'] == 0) {
        $unreadMessages++;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Form Dashboard</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .dashboard-container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1rem;
        }
        
        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }
        
        .dashboard-title {
            margin: 0;
        }
        
        .stats-container {
            display: flex;
            gap: 1rem;
            margin-bottom: 2rem;
        }
        
        .stat-card {
            flex: 1;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 1.5rem;
            text-align: center;
        }
        
        .stat-card h3 {
            margin: 0 0 0.5rem;
            color: #333;
        }
        
        .stat-card .stat-value {
            font-size: 2.5rem;
            font-weight: bold;
            color: #f44336;
            margin: 0;
        }
        
        .message-table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        
        .message-table th, 
        .message-table td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid #eee;
        }
        
        .message-table th {
            background-color: #f44336;
            color: white;
            font-weight: 500;
        }
        
        .message-table tr:last-child td {
            border-bottom: none;
        }
        
        .message-table tr:hover {
            background-color: #f9f9f9;
        }
        
        .unread {
            font-weight: bold;
            background-color: #ffebee;
        }
        
        .action-button {
            display: inline-block;
            padding: 0.5rem 1rem;
            background-color: #f44336;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            transition: background-color 0.3s;
        }
        
        .action-button:hover {
            background-color: #d32f2f;
        }
        
        .no-messages {
            padding: 2rem;
            text-align: center;
            background-color: #f5f5f5;
            border-radius: 8px;
        }
        
        /* Status indicator */
        .status {
            display: inline-block;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            margin-right: 5px;
        }
        
        .status.read {
            background-color: #4CAF50;
        }
        
        .status.unread {
            background-color: #FFC107;
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

    <main class="dashboard-container">
        <div class="dashboard-header">
            <h1 class="dashboard-title">Contact Form Dashboard</h1>
            <a href="contact.html" class="action-button">Back to Contact Form</a>
        </div>
        
        <div class="stats-container">
            <div class="stat-card">
                <h3>Total Messages</h3>
                <p class="stat-value"><?php echo $totalMessages; ?></p>
            </div>
            <div class="stat-card">
                <h3>Unread Messages</h3>
                <p class="stat-value"><?php echo $unreadMessages; ?></p>
            </div>
        </div>
        
        <?php if ($totalMessages > 0): ?>
            <table class="message-table">
                <thead>
                    <tr>
                        <th>Status</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Subject</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($messages as $message): ?>
                        <tr class="<?php echo $message['is_read'] ? '' : 'unread'; ?>">
                            <td>
                                <span class="status <?php echo $message['is_read'] ? 'read' : 'unread'; ?>"></span>
                                <?php echo $message['is_read'] ? 'Read' : 'Unread'; ?>
                            </td>
                            <td><?php echo htmlspecialchars($message['name']); ?></td>
                            <td><?php echo htmlspecialchars($message['email']); ?></td>
                            <td><?php echo htmlspecialchars($message['subject'] ?: 'No Subject'); ?></td>
                            <td><?php echo date('M d, Y H:i', strtotime($message['submission_date'])); ?></td>
                            <td>
                                <a href="view_message.php?id=<?php echo $message['id']; ?>" class="action-button">View</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="no-messages">
                <p>No contact form submissions yet.</p>
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
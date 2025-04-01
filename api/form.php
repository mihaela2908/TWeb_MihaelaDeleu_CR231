<?php
// Include database connection
require_once 'config.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $subject = $_POST['subject'] ?? '';
    $message = $_POST['message'] ?? '';
    $date = date('Y-m-d H:i:s');
    
    // Validate inputs
    if (empty($name) || empty($email) || empty($message)) {
        // Redirect back to contact page with error
        header("Location: contact.html?error=missing_fields");
        exit;
    }
    
    try {
        // Prepare SQL statement
        $stmt = $conn->prepare("INSERT INTO contact_messages (name, email, subject, message, submission_date) 
                               VALUES (:name, :email, :subject, :message, :date)");
        
        // Bind parameters
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':subject', $subject);
        $stmt->bindParam(':message', $message);
        $stmt->bindParam(':date', $date);
        
        // Execute statement
        $stmt->execute();
        
        // Redirect back to contact page with success message
        header("Location: contact.html?status=success");
        exit;
    } catch(PDOException $e) {
        // Log error and redirect with error message
        error_log("Database error: " . $e->getMessage());
        header("Location: contact.html?error=database");
        exit;
    }
}
?>
<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: auth.html");
    exit;
}

// Connect to the database
$mysqli = new mysqli("localhost", "root", "", "pet");
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Check if adoption request ID is provided
if (isset($_POST['adoption_id'])) {
    $adoption_id = intval($_POST['adoption_id']);
    
    // Update the adoption request status to 'approved'
    $stmt = $mysqli->prepare("UPDATE adoption_requests SET approval_status = 'approved' WHERE id = ?");
    $stmt->bind_param("i", $adoption_id);
    
    if ($stmt->execute()) {
        echo "Adoption request approved successfully.";
        header("Location: admin_product.html"); // Redirect back to the admin page
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$mysqli->close();
?>

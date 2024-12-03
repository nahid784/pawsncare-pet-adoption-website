<?php
// Start session to check if the user is logged in
session_start();

// Check if user is logged in via session or cookies
if (isset($_SESSION['user_id']) || isset($_COOKIE['user_id'])) {
    // User is logged in
    header("Location: index.html"); // Redirect to homepage (index.html)
    exit;
} else {
    // User is not logged in, redirect to login page (auth.html)
    header("Location: auth.html");
    exit;
}
?>

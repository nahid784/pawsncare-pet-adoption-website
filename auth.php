<?php
// Database configuration
$host = "localhost"; // Update if needed
$username = "root"; // Your MySQL username
$password = ""; // Your MySQL password
$dbname = "pet"; // Your database name

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Start session for login management
session_start();

// Determine action (login or register)
$action = $_POST['action'];

if ($action === "register") {
    // Registration logic
    $user_id = $_POST['user_id'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $role = $_POST['role'];

    // Validate password match
    if ($password !== $confirm_password) {
        echo "<script>alert('Passwords do not match!'); window.history.back();</script>";
        exit;
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Insert user into database
    $stmt = $conn->prepare("INSERT INTO users (user_id, email, password, role) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $user_id, $email, $hashed_password, $role);

    if ($stmt->execute()) {
        echo "<script>alert('Registration successful!'); window.location.href = 'auth.html';</script>";
    } else {
        echo "<script>alert('Registration failed: " . $stmt->error . "'); window.history.back();</script>";
    }

    $stmt->close();
} elseif ($action === "login") {
    // Login logic
    $user_id = $_POST['user_id'];
    $password = $_POST['password'];
    $remember = isset($_POST['remember']) ? $_POST['remember'] : false;

    // Check user in database
    $stmt = $conn->prepare("SELECT user_id, password, role FROM users WHERE user_id = ?");
    $stmt->bind_param("s", $user_id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($db_user_id, $db_password, $db_role);
        $stmt->fetch();

        // Verify password
        if (password_verify($password, $db_password)) {
            // Set session variables
            $_SESSION['user_id'] = $db_user_id;
            $_SESSION['role'] = $db_role;

            // Handle "Remember Password" feature
            if ($remember) {
                setcookie("user_id", $user_id, time() + (30 * 24 * 60 * 60), "/"); // Store for 30 days
                setcookie("role", $db_role, time() + (30 * 24 * 60 * 60), "/"); // Store for 30 days
            }

              // Role-based redirection logic
              if ($db_role === "admin") {
                header("Location: admin_product.html"); // Redirect admin to admin dashboard
            } elseif ($db_role === "user") {
                header("Location: user_product.html"); // Redirect normal users to their dashboard
            } else {
                header("Location: index.html"); // Default redirection
            }
        } else {
            echo "<script>alert('Invalid credentials!'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('User not found!'); window.history.back();</script>";
    }

    $stmt->close();
}

// Close the database connection
$conn->close();
?>

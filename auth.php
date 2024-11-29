<?php
// Connect to MySQL
$conn = new mysqli("localhost", "root", "", "pet");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle Registration and Login
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $action = $_POST['action']; // Determine whether it's login or register

    if ($action === "register") {
        $user_id = $_POST['user_id'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Check if user already exists
        $checkQuery = $conn->prepare("SELECT * FROM users WHERE user_id = ? OR email = ?");
        $checkQuery->bind_param("ss", $user_id, $email);
        $checkQuery->execute();
        $result = $checkQuery->get_result();

        if ($result->num_rows > 0) {
            // User already exists
            echo json_encode(["status" => "error", "message" => "User ID or email already exists!"]);
        } else {
            // Register new user
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $insertQuery = $conn->prepare("INSERT INTO users (user_id, email, password) VALUES (?, ?, ?)");
            $insertQuery->bind_param("sss", $user_id, $email, $hashed_password);

            if ($insertQuery->execute()) {
                echo json_encode(["status" => "success", "message" => "Registration successful!"]);
            } else {
                echo json_encode(["status" => "error", "message" => "Registration failed. Please try again!"]);
            }
        }
    } elseif ($action === "login") {
        $user_id = $_POST['user_id'];
        $password = $_POST['password'];

        // Verify user credentials
        $query = $conn->prepare("SELECT * FROM users WHERE user_id = ?");
        $query->bind_param("s", $user_id);
        $query->execute();
        $result = $query->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();

            if (password_verify($password, $user['password'])) {
                // Successful login
                echo json_encode(["status" => "success", "message" => "Login successful!"]);
            } else {
                // Wrong password
                echo json_encode(["status" => "error", "message" => "Wrong credentials!"]);
            }
        } else {
            // User not found
            echo json_encode(["status" => "error", "message" => "Wrong credentials!"]);
        }
    }
}

// Close the database connection
$conn->close();
?>

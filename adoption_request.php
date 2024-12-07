<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header("Location: auth.html");
    exit;
}

// Connect to the database
$mysqli = new mysqli("localhost", "root", "", "pet");
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Sanitize and store form data
$animal_id = intval($_POST['animal_id']);
$user_id = intval($_POST['user_id']);
$firstname = $mysqli->real_escape_string($_POST['firstname']);
$lastname = $mysqli->real_escape_string($_POST['lastname']);
$email = $mysqli->real_escape_string($_POST['email']);
$contact_no = $mysqli->real_escape_string($_POST['contact_no']);
$location = $mysqli->real_escape_string($_POST['location']);

// Insert adoption request into the database
$stmt = $mysqli->prepare("INSERT INTO adoption_requests (user_id, animal_id, firstname, lastname, email, contact_no, location) VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("iisssss", $user_id, $animal_id, $firstname, $lastname, $email, $contact_no, $location);

if ($stmt->execute()) {
    echo "We have collected your info. Soon we will contact with you";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$mysqli->close();

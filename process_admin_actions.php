<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: auth.html"); // Redirect to login if not admin
    exit;
}

$mysqli = new mysqli("localhost", "root", "", "pet");

// Get search query if any
$search = $_GET['search'] ?? ''; // Default to empty if not set

// Handle actions: add, update, delete
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    // Add animal action
    if ($action === 'add') {
        $name = $_POST['name'];
        $type = $_POST['animal_type'];
        $location = $_POST['location'];
        $contact = $_POST['contact_no'];
        $image_url = $_POST['image_url'];

        // Handle file upload
        $image = $image_url; // Default to the URL
        if (!empty($_FILES['image_file']['name'])) {
            $target_dir = "uploads/";
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0777, true);
            }
            $target_file = $target_dir . basename($_FILES['image_file']['name']);
            if (move_uploaded_file($_FILES['image_file']['tmp_name'], $target_file)) {
                $image = $target_file; // Use the uploaded file path
            } else {
                echo "Error: There was a problem uploading your file.";
            }
        }

        $stmt = $mysqli->prepare("INSERT INTO animals (name, animal_type, location, contact_no, image) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $name, $type, $location, $contact, $image);
        $stmt->execute();
    }

    // Delete animal action
    elseif ($action === 'delete') {
        $id = $_POST['id'];
        $stmt = $mysqli->prepare("DELETE FROM animals WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }

    // Update animal action
    elseif ($action === 'update') {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $type = $_POST['animal_type'];
        $location = $_POST['location'];
        $contact = $_POST['contact_no'];
        $image_url = $_POST['image_url'];

        // Handle file upload
        $image = $image_url; // Default to the URL
        if (!empty($_FILES['image_file']['name'])) {
            $target_dir = "uploads/";
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0777, true);
            }
            $target_file = $target_dir . basename($_FILES['image_file']['name']);
            if (move_uploaded_file($_FILES['image_file']['tmp_name'], $target_file)) {
                $image = $target_file; // Use the uploaded file path
            } else {
                echo "Error: There was a problem uploading your file.";
            }
        }

        $stmt = $mysqli->prepare("UPDATE animals SET name = ?, animal_type = ?, location = ?, contact_no = ?, image = ? WHERE id = ?");
        $stmt->bind_param("sssssi", $name, $type, $location, $contact, $image, $id);
        $stmt->execute();
    }
}

// Search Query
$query = "SELECT * FROM animals";
if ($search) {
    $search = "%" . $search . "%"; // Add wildcards for partial matches
    $query .= " WHERE name LIKE ? OR animal_type LIKE ? OR id LIKE ?";
}

$stmt = $mysqli->prepare($query);
if ($search) {
    $stmt->bind_param("sss", $search, $search, $search);
}
$stmt->execute();
$result = $stmt->get_result();
?>

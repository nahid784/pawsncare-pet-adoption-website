<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: auth.html"); // Redirect to login if not admin
    exit;
}

$mysqli = new mysqli("localhost", "root", "", "pet");
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'add') {
        $name = $_POST['name'];
        $type = $_POST['animal_type'];
        $location = $_POST['location'];
        $contact = $_POST['contact_no'];
        $image = $_POST['image'];

        $stmt = $mysqli->prepare("INSERT INTO animals (name, animal_type, location, contact_no, image) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $name, $type, $location, $contact, $image);
        $stmt->execute();
    } elseif ($action === 'delete') {
        $id = $_POST['id'];
        $stmt = $mysqli->prepare("DELETE FROM animals WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
    } elseif ($action === 'update') {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $type = $_POST['animal_type'];
        $location = $_POST['location'];
        $contact = $_POST['contact_no'];
        $image = $_POST['image'];

        $stmt = $mysqli->prepare("UPDATE animals SET name = ?, animal_type = ?, location = ?, contact_no = ?, image = ? WHERE id = ?");
        $stmt->bind_param("sssssi", $name, $type, $location, $contact, $image, $id);
        $stmt->execute();
    }
}
?>

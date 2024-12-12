<?php
// get_keywords.php

$mysqli = new mysqli("localhost", "root", "", "pet");

// Get the search query from the GET request
$search_query = $_GET['search_query'] ?? '';

// Only perform a search if the query is not empty
if ($search_query) {
    // Search animals by name, type, or ID
    $search_query = "%" . $mysqli->real_escape_string($search_query) . "%"; // Add wildcards for partial matching

    // Query to fetch animal names, types, and IDs
    $query = "SELECT id, name, animal_type FROM animals WHERE name LIKE ? OR animal_type LIKE ? OR id LIKE ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("sss", $search_query, $search_query, $search_query);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if any results are found
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<div class="suggestion">' . $row['name'] . ' (' . $row['animal_type'] . ')</div>'; // Display name and type as suggestion
        }
    } else {
        echo '<div>No suggestions found.</div>'; // Display message if no suggestions
    }
}

$mysqli->close();
?>

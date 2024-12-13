<?php
// Fetch the number of adoption requests for each animal
$mysqli = new mysqli("localhost", "root", "", "pet");
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Query to get the number of adoption requests for each animal
$query = "SELECT animal_id, COUNT(*) AS adoption_count, MAX(approval_status) AS adoption_status
          FROM adoption_requests
          GROUP BY animal_id";
$result = $mysqli->query($query);

$adoptionStatus = [];
while ($row = $result->fetch_assoc()) {
    $adoptionStatus[$row['animal_id']] = $row;
}

$mysqli->close();
?>

<!-- HTML code to display the adoption status for each animal -->


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
<table>
    <thead>
        <tr>
            <th>Animal Name</th>
            <th>Adoption Status</th>
            <th>Number of Applications</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Fetch all animals and check adoption status
        $mysqli = new mysqli("localhost", "root", "", "pet");
        $animals = $mysqli->query("SELECT * FROM animals");
        while ($animal = $animals->fetch_assoc()) {
            $status = isset($adoptionStatus[$animal['id']]) ? $adoptionStatus[$animal['id']] : null;
            $adoptionCount = $status ? $status['adoption_count'] : 0;
            $adoptionMessage = ($status && $status['adoption_status'] === 'pending') ? 'Adoption Ongoing' : 'No Adoption Ongoing';
            echo "<tr>
                    <td>" . htmlspecialchars($animal['name']) . "</td>
                    <td>" . $adoptionMessage . "</td>
                    <td>" . $adoptionCount . "</td>
                  </tr>";
        }
        $mysqli->close();
        ?>
    </tbody>
</table>

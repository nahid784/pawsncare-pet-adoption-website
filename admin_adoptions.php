<?php
// Start the session only if it's not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: auth.html");
    exit;
};

// Connect to the database
$mysqli = new mysqli("localhost", "root", "", "pet");
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Fetch all pending adoption requests
$stmt = $mysqli->prepare("SELECT ar.*, a.name AS animal_name
                          FROM adoption_requests ar
                          JOIN animals a ON ar.animal_id = a.id
                          WHERE ar.approval_status = 'pending'");
$stmt->execute();
$result = $stmt->get_result();

// Store the fetched data in an array for later use in the HTML
$adoptionRequests = [];
while ($row = $result->fetch_assoc()) {
    $adoptionRequests[] = $row;
}

$stmt->close();
$mysqli->close();
?>

<!-- HTML content for admin_product.html -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Adoption Requests</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Pending Adoption Requests</h1>

    <!-- Display the adoption requests -->
    <table>
        <thead>
            <tr>
                <th>Animal Name</th>
                <th>User Name</th>
                <th>Email</th>
                <th>Contact No</th>
                <th>Location</th>
                <th>Approval</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($adoptionRequests as $request): ?>
                <tr>
                    <td><?php echo htmlspecialchars($request['animal_name']); ?></td>
                    <td><?php echo htmlspecialchars($request['firstname']) . ' ' . htmlspecialchars($request['lastname']); ?></td>
                    <td><?php echo htmlspecialchars($request['email']); ?></td>
                    <td><?php echo htmlspecialchars($request['contact_no']); ?></td>
                    <td><?php echo htmlspecialchars($request['location']); ?></td>
                    <td>
                        <form action="approve_adoption.php" method="POST">
                            <input type="hidden" name="adoption_id" value="<?php echo $request['id']; ?>">
                            <button type="submit" name="approve">Approve</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>

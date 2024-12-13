<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header("Location: auth.html"); // Redirect to login if not logged in
    exit;
}

$mysqli = new mysqli("localhost", "root", "", "pet");
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Fetch animals with adoption status and adoption count
$query = "SELECT a.id AS animal_id, a.name, a.image, a.animal_type, a.location, a.contact_no,
                 IFNULL(ar.adoption_count, 0) AS adoption_count, 
                 IFNULL(ar.adoption_status, 'No Adoption Ongoing') AS adoption_status
          FROM animals a
          LEFT JOIN (
              SELECT animal_id, COUNT(*) AS adoption_count, MAX(approval_status) AS adoption_status
              FROM adoption_requests
              GROUP BY animal_id
          ) ar ON a.id = ar.animal_id";
$result = $mysqli->query($query);

// Loop through the result and display the animal details
while ($row = $result->fetch_assoc()) : ?>
    <div class="product">
        <img src="<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>" />
        <h2><?php echo $row['name']; ?></h2>
        <p>Type: <?php echo $row['animal_type']; ?></p>
        <p>Location: <?php echo $row['location']; ?></p>
        <p>Contact: <?php echo $row['contact_no']; ?></p>
        <p><b>Adoption Status:</b> <?php echo $row['adoption_status']; ?></p>
        <p><b>Applications:</b> <?php echo $row['adoption_count']; ?></p>
        <p><button type="button" onclick="window.location.href='adoption_process.html?animal_id=<?php echo $row['animal_id']; ?>'">Adopt <?php echo $row['name']; ?></button></p>
    </div>
<?php endwhile;

$mysqli->close();
?>

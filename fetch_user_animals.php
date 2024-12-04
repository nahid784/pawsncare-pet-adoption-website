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

$result = $mysqli->query("SELECT * FROM animals");
while ($row = $result->fetch_assoc()) : ?>
    <div class="product">
        <img src="<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>" />
        <h2><?php echo $row['name']; ?></h2>
        <p>Type: <?php echo $row['animal_type']; ?></p>
        <p>Location: <?php echo $row['location']; ?></p>
        <p>Contact: <?php echo $row['contact_no']; ?></p>
    </div>
<?php endwhile;

$mysqli->close();
?>

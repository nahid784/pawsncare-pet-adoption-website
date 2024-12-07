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
        <h2> For <?php echo $row['name']; ?></h2>
    </div>
<?php endwhile;

$mysqli->close();
?>

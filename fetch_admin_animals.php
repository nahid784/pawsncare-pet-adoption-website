<?php
$result = $mysqli->query("SELECT * FROM animals");
while ($row = $result->fetch_assoc()) : ?>
    <form method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $row['id']; ?>" />
        <input type="text" name="name" value="<?php echo $row['name']; ?>" />
        <input type="text" name="animal_type" value="<?php echo $row['animal_type']; ?>" />
        <input type="text" name="location" value="<?php echo $row['location']; ?>" />
        <input type="text" name="contact_no" value="<?php echo $row['contact_no']; ?>" />
        <img src="<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>" />
        <input type="file" name="image_file" accept="image/*" />
        <input type="text" name="image_url" placeholder="Image URL" value="<?php echo $row['image']; ?>" />
        <button type="submit" name="action" value="update">Update</button>
        <button type="submit" name="action" value="delete">Delete</button>
    </form>
<?php endwhile;

$mysqli->close();
?>

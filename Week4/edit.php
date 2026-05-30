<?php

$conn = new mysqli("localhost", "root", "", "carshop");

$id = $_GET['id'];

$result = $conn->query("SELECT * FROM car WHERE id=$id");

$row = $result->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Page</title>
    <link rel="stylesheet" href="./css/edit.css">
</head>
<body>
    <form action="update.php" method="POST" class="form-container">
        <img 
    src="http://localhost/CARSHOW/uploads/<?php echo $row['image']; ?>" 
    alt="car" >

    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

    <input type="text" name="car_name" value="<?php echo $row['car_name']; ?>" placeholder="Car Name">

    <textarea name="description" placeholder="Description"><?php echo $row['description']; ?></textarea>

    <input type="number" name="price" value="<?php echo $row['price']; ?>" placeholder="Price">

    <button type="submit">Update</button>

</form>
</body>
</html>
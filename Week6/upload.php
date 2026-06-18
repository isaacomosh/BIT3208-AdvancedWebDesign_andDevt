<?php
session_start();
include 'db.php';

if(isset($_POST['name'])){

    $car_name = $_POST['car_name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];

    // Image
    $image = $_FILES['image']['name'];
    $tmp_name = $_FILES['image']['tmp_name'];

    // Unique image name
    $new_image_name = time() . "_" . $image;

    // Upload folder
    $folder = "uploads/" . $new_image_name;

    move_uploaded_file($tmp_name, $folder);

    $sql = "INSERT INTO car(car_name,price,image,description)
            VALUES('$name','$price','$new_image_name','$description')";

    $result = mysqli_query($conn, $sql);

    if($result) {

        $_SESSION['message'] = "Car uploaded successfully!";
        $_SESSION['type'] = "success";

    } else {

        $_SESSION['message'] = "Upload failed!";
        $_SESSION['type'] = "danger";

    }

    header("Location: dashboard.php");
    exit();

}
?>
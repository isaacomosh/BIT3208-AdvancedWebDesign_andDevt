<?php
session_start();

$conn = new mysqli("localhost", "root", "", "Week6db");

$id = $_POST['id'];
$car_name = $_POST['car_name'];
$description = $_POST['description'];
$price = $_POST['price'];

$sql = "UPDATE car
        SET car_name='$car_name',
            description='$description',
            price='$price'
        WHERE id=$id";

if($conn->query($sql) === TRUE){

    $_SESSION['message'] = "Car updated successfully!";
    $_SESSION['type'] = "success";

    header("Location: dashboard.php");
    exit();

}else{

    $_SESSION['message'] = "Failed to update car!";
    $_SESSION['type'] = "danger";

    header("Location: dashboard.php");
    exit();

}
?>
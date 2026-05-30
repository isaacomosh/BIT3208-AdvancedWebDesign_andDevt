<?php

$conn = new mysqli("localhost", "root", "", "carshop");

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
    header("Location: dashboard.php");
} else {
    echo "Update failed";
}

?>
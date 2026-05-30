<?php

$conn = new mysqli("localhost", "root", "", "carshop");

$id = $_GET['id'];

$sql = "DELETE FROM car WHERE id=$id";

if($conn->query($sql) === TRUE){
    header("Location: dashboard.php");
} else {
    echo "Error deleting record";
}

?>
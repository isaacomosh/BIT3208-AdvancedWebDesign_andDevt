<?php
//database conection syntax
$conn = mysqli_connect("localhost", "root", "", "Week7db");

if($conn){
    echo "Connected Successfully";
} else {
    echo "Connection Failed";
}

?>
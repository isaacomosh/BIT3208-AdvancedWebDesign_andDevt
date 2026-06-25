<?php
session_start();

$conn = new mysqli("localhost", "root", "", "Week8db");

$id = $_GET['id'];

$stmt = $conn->prepare("DELETE FROM car WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {

    $_SESSION['message'] = "Car deleted successfully!";
    $_SESSION['type'] = "success";

} else {

    $_SESSION['message'] = "Failed to delete car!";
    $_SESSION['type'] = "danger";

}

$stmt->close();
$conn->close();

header("Location: dashboard.php");
exit();
?>
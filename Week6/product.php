<?php
$conn = mysqli_connect("localhost", "root", "", "Week5db");

if(!$conn){
    die("Connection failed");
}

$sql = "SELECT * FROM car";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cars Products</title>

    <link rel="stylesheet" href="./css/products.css">
</head>
<body>

<h1 class="title">Cars</h1>

<div class="container">

<?php while($row = mysqli_fetch_assoc($result)) { ?>

    <div class="card">

        
        <img 
    src="http://localhost/CAR_DEALERSHIP/Week5/uploads/<?php echo $row['image']; ?>" 
    alt="car"
>        
        <div class="card-body">

            <h5 class="fw-bold" style="font-size: 20px;">
                <?php echo $row['car_name']; ?>
            </h5>

            <h6 class="price">
                KES<?php echo $row['price']; ?>
            </h6>

            <div class="small-text">
                <p><?php echo $row['description']; ?></p>
               
            </div>
            <button class="buy-btn">Buy Now</button>
        </div>

    </div>

<?php } ?>

</div>

<script src="script.js"></script>

</body>
</html>
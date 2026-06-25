<?php
$conn = mysqli_connect("localhost", "root", "", "Week8db");

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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cars Products</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body{
            background:#f5f5f5;
        }

        .title{
            text-align:center;
            margin:40px 0;
            font-size:3rem;
            font-weight:700;
        }

        .car-card{
            border:none;
            border-radius:15px;
            overflow:hidden;
            box-shadow:0 5px 15px rgba(0,0,0,0.1);
            transition:.3s;
            height:100%;
        }

        .car-card:hover{
            transform:translateY(-8px);
        }

        .car-card img{
            width:100%;
            height:250px;
            object-fit:cover;
        }

        .price{
            color:#198754;
            font-size:1.3rem;
            font-weight:700;
        }

        .description{
            color:#666;
            font-size:.95rem;
            display:-webkit-box;
            -webkit-line-clamp:3;
            -webkit-box-orient:vertical;
            overflow:hidden;
        }

        .buy-btn{
            width:100%;
            border:none;
            background:#000;
            color:#fff;
            padding:12px;
            border-radius:8px;
            transition:.3s;
        }

        .buy-btn:hover{
            background:#333;
        }

        @media(max-width:768px){
            .title{
                font-size:2.2rem;
            }

            .car-card img{
                height:220px;
            }
        }

        @media(max-width:576px){
            .car-card img{
                height:200px;
            }
        }
    </style>
</head>
<body>

<div class="container py-4">

    <h1 class="title">Cars</h1>

    <div class="row g-4">

        <?php while($row = mysqli_fetch_assoc($result)) { ?>

            <div class="col-lg-3 col-md-4 col-sm-6">

                <div class="card car-card">

                    <img
                        src="http://localhost/CAR_DEALERSHIP/Week8/uploads/<?php echo $row['image']; ?>"
                        alt="Car Image"
                    >

                    <div class="card-body d-flex flex-column">

                        <h5 class="fw-bold">
                            <?php echo $row['car_name']; ?>
                        </h5>

                        <div class="price mb-2">
                            KES <?php echo number_format($row['price']); ?>
                        </div>

                        <p class="description flex-grow-1">
                            <?php echo $row['description']; ?>
                        </p>

                        <button class="buy-btn mt-3">
                            Buy Now
                        </button>

                    </div>

                </div>

            </div>

        <?php } ?>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Car Dashboard</title>

    <link rel="stylesheet" href="./css/dashboard.css">

    <!-- Bootstrap -->
   <link rel="stylesheet" href="./css/bootstrap.min.css">
</head>
<body>
<?php if(isset($_SESSION['message'])): ?>

<div id="popupAlert"
     class="alert alert-<?php echo $_SESSION['type']; ?> popup-alert">

    <?php
        echo $_SESSION['message'];

        unset($_SESSION['message']);
        unset($_SESSION['type']);
    ?>

</div>

<?php endif; ?>
<div class="container-fluid">
    <div class="row dashboard-container">

        <!-- Sidebar -->
        <div class="col-md-2 sidebar">

           <?php if(isset($_SESSION["full_name"])): ?>
    <p>Welcome, <?php echo $_SESSION["full_name"]; ?></p>
<?php else: ?>
    
<?php endif; ?>

            <ul class="menu">
                <li>Products</li>
                <li>Users</li>
            </ul>

            <div class="logout">
                Logout
            </div>
            
                

        </div>

       <!-- Products Section -->
<div class="col-md-7 products-section">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4>Products</h4>
    </div>

    <?php

    // database connection
    $conn = new mysqli("localhost", "root", "", "carshop");

    // check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // fetch cars
    $sql = "SELECT * FROM car ORDER BY id DESC";
    $result = $conn->query($sql);

    ?>

    <!-- Table Header -->
    <div class="cars-table-header d-none d-md-flex">

        <div class="header-product">Product</div>
        <div class="header-price">Price</div>
        <div class="header-actions">Actions</div>

    </div>

    <?php

    if ($result->num_rows > 0) {

        while($row = $result->fetch_assoc()) {

    ?>

    <!-- Car Card -->
    <div class="car-row">

        <!-- Left -->
        <div class="car-product">

            <img 
    src="http://localhost/CARSHOW/uploads/<?php echo $row['image']; ?>" 
    alt="car"
>

            <div class="car-info">
                <h5><?php echo $row['car_name']; ?></h5>
                <p><?php echo $row['description']; ?></p>
            </div>

        </div>

        <!-- Price -->
        <div class="car-price">
            KES <?php echo number_format($row['price']); ?>
        </div>
        
        <!-- Actions -->
        <div class="car-actions">

            <!-- Update -->
            <a href="edit.php?id=<?php echo $row['id']; ?>" class="edit-btn">

                <svg xmlns="http://www.w3.org/2000/svg"
                    width="18"
                    height="18"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    viewBox="0 0 24 24">

                    <path d="M12 20h9"/>
                    <path d="M16.5 3.5a2.1 2.1 0 013 3L7 19l-4 1 1-4 12.5-12.5z"/>

                </svg>

            </a>

            <!-- Delete -->
            <a href="delete.php?id=<?php echo $row['id']; ?>"
                class="delete-btn"
                onclick="return confirm('Delete this car?')">

                <svg xmlns="http://www.w3.org/2000/svg"
                    width="18"
                    height="18"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    viewBox="0 0 24 24">

                    <polyline points="3 6 5 6 21 6"/>
                    <path d="M19 6l-1 14H6L5 6"/>
                    <path d="M10 11v6"/>
                    <path d="M14 11v6"/>
                    <path d="M9 6V4h6v2"/>

                </svg>

            </a>

        </div>

    </div>

    <?php
        }
    } else {
        echo "<p>No cars found.</p>";
    }

    $conn->close();

    ?>

</div>

        <!-- Upload Section -->
        <div class="col-md-3 upload-section">

            <h5 class="mb-3">Add New Product</h5>

            <form action="upload.php" method="POST" enctype="multipart/form-data" id="productForm">

                <!-- Upload Box -->
                <label for="imageInput" class="upload-box">

                    <div>
                        <h6>Click to Upload</h6>
                        <small>Upload Product Image</small>
                    </div>

                    <!-- Small Preview Image -->
                    <img id="preview"
                        src=""
                        alt="preview">

                </label>

                <input type="file"
                    name="image"
                    id="imageInput"
                    hidden>

                <small class="error" id="imageError"></small>

                <!-- Name -->
                <div class="mb-3 mt-3">
                    <label>Name</label>
                    <input type="text"
                        name="name"
                        id="name"
                        class="form-control">

                    <small class="error" id="nameError"></small>
                </div>

                <!-- Description -->
                <div class="mb-3">
                    <label>Description</label>
                    <textarea name="description"
                        id="description"
                        class="form-control"></textarea>

                    <small class="error" id="descriptionError"></small>
                </div>

                <!-- Price -->
                <div class="mb-3">
                    <label>Price</label>
                    <input type="number"
                        name="price"
                        id="price"
                        class="form-control">

                    <small class="error" id="priceError"></small>
                </div>

                <!-- Stock -->
                <div class="mb-3">
                    <label>Stock</label>
                    <input type="number"
                        name="stock"
                        id="stock"
                        class="form-control">

                    <small class="error" id="stockError"></small>
                </div>

                <div class="d-flex gap-2">

                    <button type="submit" class="btn btn-dark w-50">
                        Save
                    </button>

                    <button type="reset" class="btn btn-outline-dark w-50">
                        Cancel
                    </button>

                </div>

            </form>

        </div>

    </div>
</div>
<script src="./js/bootstrap.bundle.min.js"></script>
<script src="./js/dashboard.js"></script>

</body>
</html>
<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Car Homepage</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- CSS -->
    <link rel="stylesheet" href="./css/index.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body>

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg bg-white shadow-sm py-3">
        <div class="container">

            <a class="navbar-brand fw-bold d-flex align-items-center gap-2" href="#">
                 CARS
            </a>

            

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarContent">

                <ul class="navbar-nav mx-auto gap-4">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Home</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="about.php">About Us</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="contact.php">Contact</a>
                    </li>
                </ul>

                

                <?php if(isset($_SESSION["full_name"])): ?>
    <h3>Welcome, <?php echo $_SESSION["full_name"]; ?></h3>
<?php else: ?>
    <div class="d-flex align-items-center gap-3">
                    <a href="login.php" style="color: black;"><img src="./images/icn.png" alt="" width="20px" height="20px"></a>
                </div>
<?php endif; ?>

            </div>
        </div>
    </nav>


    <!-- HERO SECTION -->
    <section class="hero">

    <!-- LEFT CONTENT -->
    <div class="hero-content">

        <h1 style="color: black">Find Your Perfect Car</h1>

        <p>
            Explore new and used cars from trusted sellers.
            <br>
            Drive what moves you.
        </p>

    </div>

    <!-- RIGHT CONTENT -->
    <div class="hero-right">

        <img
            src="./images/urus.png"
            alt="Luxury Car"
            class="hero-car-img"
        >

    </div>

</section>


    <!-- FEATURED CARS -->
    <section class="pb-5">
        <div class="container">

            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="fw-bold">Featured Cars</h3>

                <a href="product.php" class="text-decoration-none">
                    View All
                </a>
            </div>

            <div class="row g-4">

                <!-- CARD 1 -->
                <div class="col-md-6 col-lg-3">

                    <div class="card border-0 shadow-sm car-card">

                        <img
                            src="https://images.unsplash.com/photo-1494976388531-d1058494cdd8?q=80&w=1200&auto=format&fit=crop"
                            class="card-img-top"
                            alt="Toyota"
                        >

                        <div class="card-body">

                            <h5 class="fw-bold">
                                2023 Toyota Camry
                            </h5>

                            <h6 class="text-dark fw-bold">
                                $24,500
                            </h6>

                            <div class="small text-muted d-flex justify-content-between mt-3">
                                <span>32,000 km</span>
                                <span>Automatic</span>
                            </div>

                        </div>

                    </div>

                </div>


                <!-- CARD 2 -->
                <div class="col-md-6 col-lg-3">

                    <div class="card border-0 shadow-sm car-card">

                        <img
                            src="https://images.unsplash.com/photo-1553440569-bcc63803a83d?q=80&w=1200&auto=format&fit=crop"
                            class="card-img-top"
                            alt="Honda"
                        >

                        <div class="card-body">

                            <h5 class="fw-bold">
                                2022 Honda CR-V
                            </h5>

                            <h6 class="text-dark fw-bold">
                                $28,200
                            </h6>

                            <div class="small text-muted d-flex justify-content-between mt-3">
                                <span>18,000 km</span>
                                <span>Automatic</span>
                            </div>

                        </div>

                    </div>

                </div>


                <!-- CARD 3 -->
                <div class="col-md-6 col-lg-3">

                    <div class="card border-0 shadow-sm car-card">

                        <img
                            src="https://images.unsplash.com/photo-1555215695-3004980ad54e?q=80&w=1200&auto=format&fit=crop"
                            class="card-img-top"
                            alt="BMW"
                        >

                        <div class="card-body">

                            <h5 class="fw-bold">
                                2021 BMW 3 Series
                            </h5>

                            <h6 class="text-dark fw-bold">
                                $33,200
                            </h6>

                            <div class="small text-muted d-flex justify-content-between mt-3">
                                <span>12,000 km</span>
                                <span>Automatic</span>
                            </div>

                        </div>

                    </div>

                </div>


                <!-- CARD 4 -->
                <div class="col-md-6 col-lg-3">

                    <div class="card border-0 shadow-sm car-card">

                        <img
                            src="https://images.unsplash.com/photo-1617788138017-80ad40651399?q=80&w=1200&auto=format&fit=crop"
                            class="card-img-top"
                            alt="Tesla"
                        >

                        <div class="card-body">

                            <h5 class="fw-bold">
                                2023 Tesla Model 3
                            </h5>

                            <h6 class="text-dark fw-bold">
                                $46,500
                            </h6>

                            <div class="small text-muted d-flex justify-content-between mt-3">
                                <span>5,000 km</span>
                                <span>Automatic</span>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>
    </section>


    <!-- FEATURES -->
    <section class="pb-5">
        <div class="container">

            <div class="row g-4">

                <div class="col-md-4">
                    <div class="feature-box shadow-sm">
                        <h5>Trusted Sellers</h5>
                        <p class="text-muted">
                            Verified and trusted car sellers.
                        </p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="feature-box shadow-sm">
                        <h5>Best Prices</h5>
                        <p class="text-muted">
                            Get the best prices in the market.
                        </p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="feature-box shadow-sm">
                        <h5>Easy & Secure</h5>
                        <p class="text-muted">
                            100% safe and secure buying experience.
                        </p>
                    </div>
                </div>

            </div>

        </div>
    </section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
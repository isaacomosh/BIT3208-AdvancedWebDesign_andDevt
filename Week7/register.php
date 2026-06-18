<?php

// Database connection
$host = "localhost";
$user = "root";
$password = "";
$database = "Week5db";

$conn = mysqli_connect($host, $user, $password, $database);

if(!$conn){
    die("Connection failed: " . mysqli_connect_error());
}

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $full_name = $_POST["fullname"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Hash password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert user
    $sql = "INSERT INTO users(full_name, email, password)
            VALUES('$full_name', '$email', '$hashedPassword')";

    if(mysqli_query($conn, $sql)){

        header("Location: login.php");
        exit();

    }else{

        echo "Registration failed: " . mysqli_error($conn);

    }
}

?>

<!-- register.html -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register Page</title>

  <!-- Bootstrap CSS -->
  <link 
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
    rel="stylesheet"
  >

  <!-- Custom CSS -->
  <link rel="stylesheet" href="./css/register.css">
</head>
<body>

<div class="container-fluid register-container">
  <div class="row h-100">

    <!-- Left Side Image -->
    <div class="col-md-8 col-lg-9 image-section p-0">
      <img 
        src="./images/greyurus.webp"
        alt="Register Image"
        class="main-image"
      >
    </div>

    <!-- Right Side Form -->
    <div class="col-md-4 col-lg-3 form-section d-flex align-items-center">
      
      <div class="register-form w-100">

        <h2 class="mb-2">Create Account</h2>
        <p class="text-muted mb-4">Register your new account</p>

        <form id="registerForm" action="register.php" method="POST">

          <!-- Full Name -->
          <div class="mb-3">
            <label class="form-label">Full Name</label>
            <input 
              type="text"
              class="form-control"
              id="fullname"
              name="fullname"
              placeholder="Enter full name"
              required
            >
            <div class="invalid-feedback">
              Full name is required.
            </div>
          </div>

          <!-- Email -->
          <div class="mb-3">
            <label class="form-label">Email Address</label>
            <input 
              type="email"
              class="form-control"
              id="email"
              name="email"
              placeholder="Enter email"
              required
            >
            <div class="invalid-feedback">
              Enter a valid email.
            </div>
          </div>

          <!-- Password -->
          <div class="mb-3">
            <label class="form-label">Password</label>
            <input 
              type="password"
              class="form-control"
              id="password"
              name="password"
              placeholder="Enter password"
              required
            >
            <small id="passwordStrength"></small>
            <div class="invalid-feedback">
              Password must be at least 6 characters.
            </div>
          </div>

          <!-- Confirm Password -->
          <div class="mb-4">
            <label class="form-label">Confirm Password</label>
            <input 
              type="password"
              class="form-control"
              id="confirmPassword"
              name="confirmPassword"
              placeholder="Confirm password"
              required
            >
            <div class="invalid-feedback">
              Passwords do not match.
            </div>
          </div>

          <!-- Register Button -->
          <button type="submit" class="btn btn-dark w-100">
            Register
          </button>

          <!-- Login Link -->
          <div class="text-center mt-3">
            <p>
              Already have an account?
              <a href="login.php">Login</a>
            </p>
          </div>

        </form>

      </div>

    </div>

  </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Custom JS -->
<script src="./js/register.js"></script>

</body>
</html>
<?php
session_start();
// Database connection
$host = "localhost";
$user = "root";
$password = "";
$database = "Week7db";
$conn = mysqli_connect($host, $user, $password, $database);
if(!$conn){
    die("Connection failed: " . mysqli_connect_error());
}
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $email = $_POST["email"];
    $password = $_POST["password"];
    // Check user by email
    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) > 0){
        $user = mysqli_fetch_assoc($result);
        if(password_verify($password, $user["password"])){

            $_SESSION["user_id"] = $user["id"];
            $_SESSION["full_name"] = $user["full_name"];
            $_SESSION["email"] = $user["email"];
            // Admin routing
            if($user["email"] == "admin@gmail.com"){
                header("Location: dashboard.php");
            }else{
                header("Location: index.php");
            }
            exit();
        }else{
            echo "Invalid password";
        }
    }else{
        echo "User not found";
    }
}
?>
<!-- index.html -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login Page</title>

  <!-- Bootstrap CSS -->
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
    rel="stylesheet"
  />

  <!-- Custom CSS -->
  <link rel="stylesheet" href="./css/login.css">
</head>
<body>

  <div class="container-fluid login-container">
    <div class="row h-100">

      <!-- Left Side -->
<div class="col-md-8 col-lg-9 image-section p-0">
  <img 
    src="./images/greyurus.webp" 
    alt="Image"
    class="main-image"
  >
</div>

      <!-- Right Side -->
      <div class="col-md-4 col-lg-3 form-section d-flex align-items-center">
        <div class="login-form w-100">

          <h2 class="mb-2">Welcome</h2>
          <p class="text-muted mb-4">Login to your account</p>

          <form id="loginForm" action="login.php" method="POST">

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
                Please enter a valid email.
              </div>
            </div>

            <!-- Password -->
            <div class="mb-2">
              <label class="form-label">Password</label>
              <input
                type="password"
                class="form-control"
                id="password"
                name="password"
                placeholder="Enter password"
                required
              >
              <div class="invalid-feedback">
                Password is required.
              </div>
            </div>

            <!-- Forgot Password -->
            <div class="text-end mb-3">
              <a href="#" class="forgot-link">Forgot password?</a>
            </div>

            <!-- Button -->
            <button type="submit" class="btn btn-dark w-100">
              Login
            </button>

            <div class="text-center mt-3">
            <p>
              Don't have have an account?
              <a href="register.php">Register</a>
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
  <script src="./js/login.js"></script>

</body>
</html>
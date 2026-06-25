<?php
session_start();

// Redirect if already logged in
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}

$host = "localhost";
$db_user = "root";
$password = "";
$database = "Week8db";

$conn = mysqli_connect($host, $db_user, $password, $database);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $raw_password = $_POST["password"];

    $stmt = $conn->prepare("SELECT id, full_name, password, role FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();

        if (password_verify($raw_password, $row["password"])) {
            $_SESSION["user_id"]   = $row["id"];
            $_SESSION["full_name"] = $row["full_name"];
            $_SESSION["role"]      = $row["role"];  // 'user' or 'superadmin'

            $_SESSION["message"] = "Welcome back, " . htmlspecialchars($row["full_name"]) . "!";
            $_SESSION["type"]    = "success";

            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Incorrect password.";
        }
    } else {
        $error = "No account found with that email.";
    }

    $stmt->close();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login — Car Dealership</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="./css/register.css">
</head>
<body>

<div class="container-fluid register-container">
  <div class="row h-100">

    <div class="col-md-8 col-lg-9 image-section p-0">
      <img src="./images/greyurus.webp" alt="Login Image" class="main-image">
    </div>

    <div class="col-md-4 col-lg-3 form-section d-flex align-items-center">
      <div class="register-form w-100">

        <h2 class="mb-2">Welcome Back</h2>
        <p class="text-muted mb-4">Sign in to your account</p>

        <?php if ($error): ?>
          <div class="alert alert-danger py-2 px-3" style="font-size:14px;"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <?php if (isset($_GET['registered'])): ?>
          <div class="alert alert-success py-2 px-3" style="font-size:14px;">Account created! Please log in.</div>
        <?php endif; ?>

        <form action="login.php" method="POST">

          <div class="mb-3">
            <label class="form-label">Email Address</label>
            <input type="email" class="form-control" name="email" placeholder="Enter email" required>
          </div>

          <div class="mb-4">
            <label class="form-label">Password</label>
            <input type="password" class="form-control" name="password" placeholder="Enter password" required>
          </div>

          <button type="submit" class="btn btn-dark w-100">Login</button>

          <div class="text-center mt-3">
            <p>Don't have an account? <a href="register.php">Register</a></p>
          </div>

        </form>
      </div>
    </div>

  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
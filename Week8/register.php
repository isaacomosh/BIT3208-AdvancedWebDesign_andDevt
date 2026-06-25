<?php

$host = "localhost";
$user = "root";
$password = "";
$database = "Week8db";

$conn = mysqli_connect($host, $user, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $full_name = trim($_POST["fullname"]);
    $email = trim($_POST["email"]);
    $raw_password = $_POST["password"];
    $confirm = $_POST["confirmPassword"];
    $role = isset($_POST["role"]) ? $_POST["role"] : "user";

    // Only allow known roles
    if (!in_array($role, ["user", "superadmin"])) {
        $role = "user";
    }

    if ($raw_password !== $confirm) {
        $error = "Passwords do not match.";
    } elseif (strlen($raw_password) < 6) {
        $error = "Password must be at least 6 characters.";
    } else {
        $hashedPassword = password_hash($raw_password, PASSWORD_DEFAULT);

        // Use prepared statement to prevent SQL injection
        $stmt = $conn->prepare("INSERT INTO users (full_name, email, password, role) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $full_name, $email, $hashedPassword, $role);

        if ($stmt->execute()) {
            header("Location: login.php?registered=1");
            exit();
        } else {
            // Check for duplicate email
            if ($conn->errno === 1062) {
                $error = "An account with that email already exists.";
            } else {
                $error = "Registration failed. Please try again.";
            }
        }
        $stmt->close();
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register — Car Dealership</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="./css/register.css">
  <style>
    .role-toggle {
      display: flex;
      gap: 0;
      border: 1px solid #dee2e6;
      border-radius: 8px;
      overflow: hidden;
    }
    .role-toggle input[type="radio"] { display: none; }
    .role-toggle label {
      flex: 1;
      text-align: center;
      padding: 8px 0;
      font-size: 14px;
      cursor: pointer;
      background: #fff;
      color: #6c757d;
      transition: background 0.15s, color 0.15s;
      margin: 0;
    }
    .role-toggle input[type="radio"]:checked + label {
      background: #212529;
      color: #fff;
      font-weight: 500;
    }
    .superadmin-note {
      font-size: 12px;
      color: #6c757d;
      margin-top: 4px;
    }
  </style>
</head>
<body>

<div class="container-fluid register-container">
  <div class="row h-100">

    <!-- Left Side Image -->
    <div class="col-md-8 col-lg-9 image-section p-0">
      <img src="./images/greyurus.webp" alt="Register Image" class="main-image">
    </div>

    <!-- Right Side Form -->
    <div class="col-md-4 col-lg-3 form-section d-flex align-items-center">
      <div class="register-form w-100">

        <h2 class="mb-2">Create Account</h2>
        <p class="text-muted mb-4">Register your new account</p>

        <?php if ($error): ?>
          <div class="alert alert-danger py-2 px-3" style="font-size:14px;"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form id="registerForm" action="register.php" method="POST" novalidate>

          <!-- Account Role -->
          <div class="mb-3">
            <label class="form-label">Account Type</label>
            <div class="role-toggle">
              <input type="radio" name="role" id="role_user" value="user" checked>
              <label for="role_user">User</label>
              <input type="radio" name="role" id="role_superadmin" value="superadmin">
              <label for="role_superadmin">Super Admin</label>
            </div>
            <p class="superadmin-note">Super admins can manage all users and products.</p>
          </div>

          <!-- Full Name -->
          <div class="mb-3">
            <label class="form-label">Full Name</label>
            <input type="text" class="form-control" id="fullname" name="fullname"
              placeholder="Enter full name" required
              value="<?php echo isset($_POST['fullname']) ? htmlspecialchars($_POST['fullname']) : ''; ?>">
            <div class="invalid-feedback">Full name is required.</div>
          </div>

          <!-- Email -->
          <div class="mb-3">
            <label class="form-label">Email Address</label>
            <input type="email" class="form-control" id="email" name="email"
              placeholder="Enter email" required
              value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
            <div class="invalid-feedback">Enter a valid email.</div>
          </div>

          <!-- Password -->
          <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password"
              placeholder="Enter password" required>
            <small id="passwordStrength"></small>
            <div class="invalid-feedback">Password must be at least 6 characters.</div>
          </div>

          <!-- Confirm Password -->
          <div class="mb-4">
            <label class="form-label">Confirm Password</label>
            <input type="password" class="form-control" id="confirmPassword" name="confirmPassword"
              placeholder="Confirm password" required>
            <div class="invalid-feedback">Passwords do not match.</div>
          </div>

          <button type="submit" class="btn btn-dark w-100">Register</button>

          <div class="text-center mt-3">
            <p>Already have an account? <a href="login.php">Login</a></p>
          </div>

        </form>
      </div>
    </div>

  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="./js/register.js"></script>
</body>
</html>
<?php
session_start();

// Auth guard — must be logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$role      = $_SESSION['role'] ?? 'user';        // 'user' or 'superadmin'
$full_name = $_SESSION['full_name'] ?? 'Guest';
$isSuperAdmin = ($role === 'superadmin');

// DB connection for products
$conn = new mysqli("localhost", "root", "", "Week5db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// DB connection for users (Week7db)
$conn7 = new mysqli("localhost", "root", "", "Week8db");
if ($conn7->connect_error) {
    die("Connection failed: " . $conn7->connect_error);
}

// Fetch cars
$carResult = $conn->query("SELECT * FROM car ORDER BY id DESC");

// Fetch users (superadmin only)
$userResult = null;
if ($isSuperAdmin) {
    $userResult = $conn7->query("SELECT id, full_name, email, role, created_at FROM users ORDER BY id DESC");
}

// Stats for superadmin
$totalCars   = $conn->query("SELECT COUNT(*) AS c FROM car")->fetch_assoc()['c'] ?? 0;
$totalUsers  = $isSuperAdmin ? ($conn7->query("SELECT COUNT(*) AS c FROM users")->fetch_assoc()['c'] ?? 0) : 0;
$totalAdmins = $isSuperAdmin ? ($conn7->query("SELECT COUNT(*) AS c FROM users WHERE role='superadmin'")->fetch_assoc()['c'] ?? 0) : 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard — Car Dealership</title>
  <link rel="stylesheet" href="./css/bootstrap.min.css">
  <link rel="stylesheet" href="./css/dashboard.css">
  <style>
    /* ── Layout ── */
    body { background: #f5f5f3; margin: 0; font-family: system-ui, sans-serif; }
    .dashboard-wrapper { display: flex; min-height: 100vh; }

    /* ── Sidebar ── */
    .sidebar {
      width: 220px;
      min-width: 220px;
      background: white;
      color: #fff;
      display: flex;
      flex-direction: column;
      padding: 0;
      position: fixed;
      top: 0; left: 0;
      height: 100vh;
      z-index: 100;
    }
    .sidebar-brand {
      padding: 20px 20px 16px;
      border-bottom: 1px solid #2a2a2a;
    }
    .sidebar-brand h6 { color: #fff; margin: 0; font-size: 15px; font-weight: 600; }
    .sidebar-brand p  { color: #888; margin: 2px 0 0; font-size: 12px; }

    .sidebar-user {
      padding: 16px 20px;
      border-bottom: 1px solid #2a2a2a;
    }
    .user-avatar {
      width: 36px; height: 36px;
      border-radius: 50%;
      display: flex; align-items: center; justify-content: center;
      font-size: 13px; font-weight: 600;
      flex-shrink: 0;
    }
    .avatar-superadmin { background: #ffd700; color: #111; }
    .avatar-user        { background: #333; color: #ccc; }
    .user-info { display: flex; align-items: center; gap: 10px; }
    .user-name  { font-size: 13px; font-weight: 500; color: #fff; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .user-badge {
      display: inline-block;
      font-size: 10px;
      padding: 1px 7px;
      border-radius: 20px;
      margin-top: 2px;
      font-weight: 600;
      letter-spacing: 0.5px;
      text-transform: uppercase;
    }
    .badge-superadmin { background: #ffd700; color: #111; }
    .badge-user       { background: #333; color: #aaa; }

    .sidebar-nav { flex: 1; padding: 12px 0; }
    .nav-item {
      display: flex; align-items: center; gap: 10px;
      padding: 10px 20px;
      font-size: 14px;
      color: #aaa;
      cursor: pointer;
      border-left: 3px solid transparent;
      transition: background 0.15s, color 0.15s, border-color 0.15s;
      user-select: none;
    }
    .nav-item:hover { background: #1a1a1a; color: #fff; }
    .nav-item.active { background: #1a1a1a; color: #fff; border-left-color: #ffd700; }
    .nav-item svg { flex-shrink: 0; opacity: 0.7; }
    .nav-item.active svg, .nav-item:hover svg { opacity: 1; }

    .sidebar-footer {
      padding: 16px 20px;
      border-top: 1px solid #2a2a2a;
    }
    .logout-btn {
      display: flex; align-items: center; gap: 8px;
      color: #ff6b6b;
      font-size: 14px;
      cursor: pointer;
      text-decoration: none;
      transition: color 0.15s;
    }
    .logout-btn:hover { color: #ff4444; }

    /* ── Main ── */
    .main-content {
      margin-left: 220px;
      flex: 1;
      padding: 28px;
      min-height: 100vh;
    }

    /* ── Section toggle ── */
    .section-panel { display: none; }
    .section-panel.active { display: block; }

    /* ── Stats bar (superadmin only) ── */
    .stats-bar {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 14px;
      margin-bottom: 24px;
    }
    .stat-card {
      background: #fff;
      border: 0.5px solid #e0e0e0;
      border-radius: 10px;
      padding: 16px 18px;
    }
    .stat-card .label { font-size: 12px; color: #888; text-transform: uppercase; letter-spacing: 0.5px; }
    .stat-card .value { font-size: 26px; font-weight: 600; color: #111; margin-top: 4px; }
    .stat-card.gold .value { color: #b8860b; }

    /* ── Section header ── */
    .section-header {
      display: flex; align-items: center; justify-content: space-between;
      margin-bottom: 20px;
    }
    .section-header h4 { margin: 0; font-size: 18px; font-weight: 600; }

    /* ── Car table ── */
    .cars-table-header {
      display: flex;
      padding: 8px 16px;
      font-size: 12px;
      color: #888;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      font-weight: 500;
      border-bottom: 1px solid #eee;
    }
    .header-product { flex: 3; }
    .header-price   { flex: 1.5; }
    .header-actions { flex: 1; text-align: right; }

    .car-row {
      display: flex;
      align-items: center;
      padding: 14px 16px;
      background: #fff;
      border: 0.5px solid #e8e8e8;
      border-radius: 10px;
      margin-bottom: 10px;
      gap: 12px;
    }
    .car-product { display: flex; align-items: center; gap: 12px; flex: 3; }
    .car-product img { width: 60px; height: 44px; object-fit: cover; border-radius: 6px; background: #f0f0f0; }
    .car-info h5 { margin: 0; font-size: 14px; font-weight: 600; }
    .car-info p  { margin: 0; font-size: 12px; color: #888; }
    .car-price   { flex: 1.5; font-size: 14px; font-weight: 500; }
    .car-actions { flex: 1; display: flex; gap: 10px; justify-content: flex-end; }

    .edit-btn, .delete-btn {
      display: flex; align-items: center; justify-content: center;
      width: 32px; height: 32px;
      border-radius: 8px;
      border: 0.5px solid #e0e0e0;
      color: #555;
      text-decoration: none;
      transition: background 0.15s;
    }
    .edit-btn:hover   { background: #f0f0f0; color: #111; }
    .delete-btn:hover { background: #fff0f0; color: #dc3545; border-color: #ffcccc; }

    /* ── Upload form ── */
    .upload-card {
      background: #fff;
      border: 0.5px solid #e0e0e0;
      border-radius: 12px;
      padding: 20px;
    }
    .upload-box {
      display: flex; flex-direction: column; align-items: center; justify-content: center;
      border: 1.5px dashed #ccc;
      border-radius: 10px;
      padding: 24px 16px;
      cursor: pointer;
      text-align: center;
      margin-bottom: 16px;
      transition: border-color 0.15s;
    }
    .upload-box:hover { border-color: #111; }
    .upload-box h6 { font-size: 13px; font-weight: 600; margin: 0 0 2px; }
    .upload-box small { color: #888; font-size: 12px; }
    #preview { max-width: 100%; max-height: 80px; display: none; margin-top: 10px; border-radius: 6px; }

    /* ── Users table ── */
    .users-table {
      width: 100%;
      border-collapse: separate;
      border-spacing: 0 8px;
      font-size: 14px;
    }
    .users-table thead th {
      padding: 8px 14px;
      font-size: 12px;
      color: #888;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      font-weight: 500;
      background: transparent;
    }
    .users-table tbody tr td {
      background: #fff;
      padding: 14px 14px;
      border-top: 0.5px solid #e8e8e8;
      border-bottom: 0.5px solid #e8e8e8;
    }
    .users-table tbody tr td:first-child {
      border-left: 0.5px solid #e8e8e8;
      border-radius: 10px 0 0 10px;
    }
    .users-table tbody tr td:last-child {
      border-right: 0.5px solid #e8e8e8;
      border-radius: 0 10px 10px 0;
    }
    .role-pill {
      display: inline-block;
      padding: 2px 10px;
      border-radius: 20px;
      font-size: 11px;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.4px;
    }
    .role-superadmin { background: #fff8dc; color: #8a6d0b; border: 1px solid #f5d96b; }
    .role-user       { background: #f0f0f0; color: #555; border: 1px solid #ddd; }

    .delete-user-btn {
      font-size: 12px;
      color: #dc3545;
      border: 0.5px solid #ffcccc;
      background: #fff0f0;
      padding: 3px 10px;
      border-radius: 6px;
      text-decoration: none;
      transition: background 0.15s;
    }
    .delete-user-btn:hover { background: #ffdddd; }

    /* ── Alert popup ── */
    .popup-alert {
      position: fixed;
      top: 18px; right: 18px;
      z-index: 9999;
      min-width: 280px;
      max-width: 380px;
      box-shadow: 0 4px 20px rgba(0,0,0,0.12);
    }

    /* ── Error text ── */
    small.error { color: #dc3545; font-size: 12px; }
  </style>
</head>
<body>

<?php if (isset($_SESSION['message'])): ?>
<div id="popupAlert"
     class="alert alert-<?php echo $_SESSION['type']; ?> alert-dismissible fade show popup-alert"
     role="alert">
  <?php echo $_SESSION['message']; ?>
  <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php
unset($_SESSION['message']);
unset($_SESSION['type']);
?>
<?php endif; ?>

<div class="dashboard-wrapper">

  <!-- ── Sidebar ── -->
  <aside class="sidebar">

    <div class="sidebar-brand">
      <h6>Car Dealership</h6>
      <p>Management Portal</p>
    </div>

    <div class="sidebar-user">
      <div class="user-info">
        <div class="user-avatar <?php echo $isSuperAdmin ? 'avatar-superadmin' : 'avatar-user'; ?>">
          <?php echo strtoupper(substr($full_name, 0, 1)); ?>
        </div>
        <div style="min-width:0;">
          <div class="user-name"><?php echo htmlspecialchars($full_name); ?></div>
          <span class="user-badge <?php echo $isSuperAdmin ? 'badge-superadmin' : 'badge-user'; ?>">
            <?php echo $isSuperAdmin ? 'Super Admin' : 'User'; ?>
          </span>
        </div>
      </div>
    </div>

    <nav class="sidebar-nav">
      <div class="nav-item active" onclick="showSection('products')" id="nav-products">
        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
          <rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/>
        </svg>
        Products
      </div>

      <?php if ($isSuperAdmin): ?>
      <div class="nav-item" onclick="showSection('users')" id="nav-users">
        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
          <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
          <circle cx="9" cy="7" r="4"/>
          <path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/>
        </svg>
        Users
      </div>
      <?php endif; ?>
    </nav>

    <div class="sidebar-footer">
      <a href="logout.php" class="logout-btn"
         onclick="return confirm('Are you sure you want to log out?')">
        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
          <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
          <polyline points="16 17 21 12 16 7"/>
          <line x1="21" y1="12" x2="9" y2="12"/>
        </svg>
        Logout
      </a>
    </div>

  </aside>

  <!-- ── Main Content ── -->
  <main class="main-content">

    <!-- ── PRODUCTS SECTION ── -->
    <div class="section-panel active" id="section-products">

     

      <div class="row">
        <!-- Product list -->
        <div class="col-md-8">
          <div class="section-header">
            <h4>Products</h4>
          </div>

          <div class="cars-table-header d-none d-md-flex">
            <div class="header-product">Product</div>
            <div class="header-price">Price</div>
            <div class="header-actions">Actions</div>
          </div>

          <?php
          if ($carResult && $carResult->num_rows > 0) {
            while ($row = $carResult->fetch_assoc()):
          ?>
          <div class="car-row">
            <div class="car-product">
              <img src="http://localhost/CAR_DEALERSHIP/Week6/uploads/<?php echo htmlspecialchars($row['image']); ?>" alt="car">
              <div class="car-info">
                <h5><?php echo htmlspecialchars($row['car_name']); ?></h5>
                <p><?php echo htmlspecialchars($row['description']); ?></p>
              </div>
            </div>
            <div class="car-price">KES <?php echo number_format($row['price']); ?></div>
            <div class="car-actions">
              <a href="edit.php?id=<?php echo $row['id']; ?>" class="edit-btn" title="Edit">
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                  <path d="M12 20h9"/>
                  <path d="M16.5 3.5a2.1 2.1 0 013 3L7 19l-4 1 1-4 12.5-12.5z"/>
                </svg>
              </a>
              <?php if ($isSuperAdmin): ?>
              <a href="delete.php?id=<?php echo $row['id']; ?>"
                 class="delete-btn" title="Delete"
                 onclick="return confirm('Delete this car?')">
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                  <polyline points="3 6 5 6 21 6"/>
                  <path d="M19 6l-1 14H6L5 6"/>
                  <path d="M10 11v6"/><path d="M14 11v6"/>
                  <path d="M9 6V4h6v2"/>
                </svg>
              </a>
              <?php endif; ?>
            </div>
          </div>
          <?php
            endwhile;
          } else {
            echo '<p style="color:#888;font-size:14px;">No cars found.</p>';
          }
          ?>
        </div>

        <!-- Upload form -->
        <div class="col-md-4">
          <div class="section-header">
            <h4>Add Product</h4>
          </div>
          <div class="upload-card">
            <form action="upload.php" method="POST" enctype="multipart/form-data" id="productForm">

              <label for="imageInput" class="upload-box">
                <div>
                  <h6>Click to Upload</h6>
                  <small>Upload product image</small>
                </div>
                <img id="preview" src="" alt="preview">
              </label>
              <input type="file" name="image" id="imageInput" hidden>
              <small class="error" id="imageError"></small>

              <div class="mb-3 mt-2">
                <label class="form-label" style="font-size:13px;">Name</label>
                <input type="text" name="name" id="name" class="form-control form-control-sm">
                <small class="error" id="nameError"></small>
              </div>

              <div class="mb-3">
                <label class="form-label" style="font-size:13px;">Description</label>
                <textarea name="description" id="description" class="form-control form-control-sm" rows="2"></textarea>
                <small class="error" id="descriptionError"></small>
              </div>

              <div class="mb-3">
                <label class="form-label" style="font-size:13px;">Price</label>
                <input type="number" name="price" id="price" class="form-control form-control-sm">
                <small class="error" id="priceError"></small>
              </div>

              <div class="mb-3">
                <label class="form-label" style="font-size:13px;">Stock</label>
                <input type="number" name="stock" id="stock" class="form-control form-control-sm">
                <small class="error" id="stockError"></small>
              </div>

              <div class="d-flex gap-2">
                <button type="submit" class="btn btn-dark btn-sm w-50">Save</button>
                <button type="reset" class="btn btn-outline-dark btn-sm w-50">Cancel</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div><!-- /products -->

    <!-- ── USERS SECTION (superadmin only) ── -->
    <?php if ($isSuperAdmin): ?>
    <div class="section-panel" id="section-users">
      <div class="section-header">
        <h4>All Users</h4>
        <span style="font-size:13px;color:#888;"><?php echo $totalUsers; ?> registered</span>
      </div>

      <table class="users-table">
        <thead>
          <tr>
            <th>#</th>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Joined</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $n = 1;
          if ($userResult && $userResult->num_rows > 0):
            while ($u = $userResult->fetch_assoc()):
          ?>
          <tr>
            <td style="color:#aaa;font-size:12px;"><?php echo $n++; ?></td>
            <td style="font-weight:500;"><?php echo htmlspecialchars($u['full_name']); ?></td>
            <td style="color:#555;"><?php echo htmlspecialchars($u['email']); ?></td>
            <td>
              <span class="role-pill <?php echo $u['role'] === 'superadmin' ? 'role-superadmin' : 'role-user'; ?>">
                <?php echo $u['role'] === 'superadmin' ? 'Super Admin' : 'User'; ?>
              </span>
            </td>
            <td style="color:#aaa;font-size:12px;">
              <?php echo isset($u['created_at']) ? date('M j, Y', strtotime($u['created_at'])) : '—'; ?>
            </td>
            <td>
              <?php
              // Don't allow deleting yourself
              if ($u['id'] != $_SESSION['user_id']):
              ?>
              <a href="delete_user.php?id=<?php echo $u['id']; ?>"
                 class="delete-user-btn"
                 onclick="return confirm('Delete user <?php echo htmlspecialchars($u['full_name']); ?>?')">
                Delete
              </a>
              <?php else: ?>
              <span style="font-size:12px;color:#ccc;">You</span>
              <?php endif; ?>
            </td>
          </tr>
          <?php
            endwhile;
          else:
          ?>
          <tr><td colspan="6" style="color:#aaa;font-size:13px;">No users found.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div><!-- /users -->
    <?php endif; ?>

  </main>
</div>

<script src="./js/bootstrap.bundle.min.js"></script>
<script>
function showSection(name) {
  // Hide all panels
  document.querySelectorAll('.section-panel').forEach(p => p.classList.remove('active'));
  // Remove active from all nav items
  document.querySelectorAll('.nav-item').forEach(n => n.classList.remove('active'));

  // Show target panel
  const panel = document.getElementById('section-' + name);
  if (panel) panel.classList.add('active');

  // Activate nav item
  const nav = document.getElementById('nav-' + name);
  if (nav) nav.classList.add('active');
}

// Image preview
const imageInput = document.getElementById('imageInput');
if (imageInput) {
  imageInput.addEventListener('change', function () {
    const preview = document.getElementById('preview');
    if (this.files && this.files[0]) {
      preview.src = URL.createObjectURL(this.files[0]);
      preview.style.display = 'block';
    }
  });
}

// Auto-dismiss alert after 4s
const popupAlert = document.getElementById('popupAlert');
if (popupAlert) {
  setTimeout(() => {
    popupAlert.classList.remove('show');
    popupAlert.addEventListener('transitionend', () => popupAlert.remove(), { once: true });
  }, 4000);
}
</script>
<script src="./js/dashboard.js"></script>
</body>
</html>
<?php
$conn->close();
$conn7->close();
?>
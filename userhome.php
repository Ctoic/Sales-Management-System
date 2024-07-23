<?php 
session_start();

$host = "localhost";
$user = "root";
$password = "MyStrongPassword1234$";
$db = "user";

$data = mysqli_connect($host, $user, $password, $db);

if (!$data) {
    die("Connection failed: " . mysqli_connect_error());
}

if (!isset($_SESSION['username'])) {
    header("location:login.php");
    exit();
}

// Fetch activities
$activity_results = mysqli_query($data, "SELECT * FROM activity ORDER BY created_at DESC");
$activities = mysqli_fetch_all($activity_results, MYSQLI_ASSOC);

mysqli_close($data);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Home</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#">Sales Management</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" href="#">Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Sales Dashboard</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Profile</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="logout.php">Logout</a>
      </li>
    </ul>
  </div>
</nav>

<div class="container mt-5">
  <h1 class="text-center">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>

  <div class="row mt-4">
    <div class="col-md-6">
      <div class="card">
        <div class="card-header">
          <h4>Sales Summary</h4>
        </div>
        <div class="card-body">
          <p>Total Sales: $<span id="total-sales">0</span></p>
          <p>Number of Transactions: <span id="num-transactions">0</span></p>
          <p>Top Product: <span id="top-product">N/A</span></p>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="card">
        <div class="card-header">
          <h4>Recent Transactions</h4>
        </div>
        <div class="card-body">
          <ul class="list-group" id="recent-transactions">
            <!-- Transaction items will be added here dynamically -->
          </ul>
        </div>
      </div>
    </div>
  </div>

  <div class="row mt-4">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <h4>Activities</h4>
        </div>
        <div class="card-body">
          <ul class="list-group">
            <?php foreach ($activities as $activity): ?>
            <li class="list-group-item">
              <h5><?php echo htmlspecialchars($activity['title']); ?></h5>
              <p><?php echo htmlspecialchars($activity['description']); ?></p>
              <small>Created at: <?php echo htmlspecialchars($activity['created_at']); ?></small>
            </li>
            <?php endforeach; ?>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

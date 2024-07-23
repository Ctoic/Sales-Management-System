<?php

session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$host = "localhost";
$user = "root";
$password = "MyStrongPassword1234$";
$db = "user"; 

$conn = mysqli_connect($host, $user, $password, $db);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $usertype = $_POST["usertype"];
    $email = $_POST["email"];
    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];
    $hashed_password = password_hash($password, PASSWORD_DEFAULT); // Hash the password for security

    // Check if username or email already exists
    $check_user = mysqli_prepare($conn, "SELECT id FROM user WHERE username = ? OR email = ?");
    mysqli_stmt_bind_param($check_user, 'ss', $username, $email);
    mysqli_stmt_execute($check_user);
    mysqli_stmt_store_result($check_user);

    if (mysqli_stmt_num_rows($check_user) > 0) {
        echo "Username or email already taken";
    } else {
        $stmt = mysqli_prepare($conn, "INSERT INTO user (username, password, usertype, email, first_name, last_name) VALUES (?, ?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, 'ssssss', $username, $hashed_password, $usertype, $email, $first_name, $last_name);
        
        if (mysqli_stmt_execute($stmt)) {
            echo "Account created successfully. You can now <a href='login.php'>login</a>.";
        } else {
            echo "Error: " . mysqli_stmt_error($stmt);
        }

        mysqli_stmt_close($stmt);
    }

    mysqli_stmt_close($check_user);
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card mt-5">
                <div class="card-header text-center">
                    <h3>Signup</h3>
                </div>
                <div class="card-body">
                    <form action="signup.php" method="post" class="form-horizontal">
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="first_name">First Name</label>
                            <input type="text" class="form-control" id="first_name" name="first_name" required>
                        </div>
                        <div class="form-group">
                            <label for="last_name">Last Name</label>
                            <input type="text" class="form-control" id="last_name" name="last_name" required>
                        </div>
                        <div class="form-group">
                            <label for="usertype">User Type</label>
                            <input type="text" class="form-control" id="usertype" name="usertype" required>
                        </div>
                        <div class="form-group text-center">
                            <input type="submit" class="btn btn-primary" value="Signup">
                        </div>
                    </form>
                    <div class="text-center">
                        <p>Already have an account? <a href="login.php">Login here</a>.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>

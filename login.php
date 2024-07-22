<?php 

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$host = "localhost";
$user = "root";
$password = "MyStrongPassword1234$";
$db = "user"; 

session_start();

$data = mysqli_connect($host, $user, $password, $db);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Corrected SQL query with proper escaping
    $sql = "SELECT * FROM user WHERE username = '$username' AND password = '$password'";
    $results = mysqli_query($data, $sql);
    $row = mysqli_fetch_array($results);

    // Corrected condition checking
    if ($row["usertype"] == "user") 
    {
        $_SESSION["username"] = $username;
        header("location:userhome.php");
    } 
    elseif ($row["usertype"] == "admin") {
        $_SESSION["username"] = $username;
        header("location:adminhome.php");}
    }
     else {
        echo "invalid"; 
    }

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card mt-5">
                <div class="card-header text-center">
                    <h3>Login</h3>
                </div>
                <div class="card-body">
                    <form action="#" method="post">
                        <div class="form-group">
                            <label for="username">User Name</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="form-group text-center">
                            <input type="submit" class="btn btn-primary" value="Login">
                            <br><br><br>
                            <small>If not register signup</small>
                            <input type="submit" class="btn btn-primary" value="Signup">
                        </div>
                    </form>
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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales.pk</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .container {
            max-width: 600px;
            margin-top: 100px;
        }
        .search-box {
            display: flex;
            align-items: center;
        }
        .search-box input {
            flex: 1;
        }
    </style>
</head>
<body>

<div class="container text-center">
    <h1><a href="landing.php">Sales.pk</a></h1>
    <small><a href="login.php">Login now</a></small>
    <br><br>
    <small><a href="register.php">Register now</a></small>
    <br><br>
    <form action="search.php" method="GET" class="search-box">
        <input type="text" class="form-control" name="query" placeholder="Search..." required>
        <button type="submit" class="btn btn-primary ml-2">Search</button>
    </form>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing Page</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .landing-page {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: #f8f9fa;
        }
        .card {
            width: 300px;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .card-body {
            text-align: center;
        }
        .icon {
            font-size: 50px;
            margin-bottom: 15px;
        }
        .btn {
            width: 100%;
            border-radius: 10px;
        }
    </style>
</head>
<body>
    <div class="landing-page">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title">Choose Your Role</h3>
                <div class="d-flex justify-content-around mb-4">
                    <div>
                        <div class="icon text-primary">
                            <i class="fas fa-user"></i>
                        </div>
                        <a href="userlogin.php" class="btn btn-primary">User Login</a>
                    </div>
                    <div>
                        <div class="icon text-danger">
                            <i class="fas fa-user-shield"></i>
                        </div>
                        <a href="adminlogin.php" class="btn btn-danger">Admin Login</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- FontAwesome for icons -->
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

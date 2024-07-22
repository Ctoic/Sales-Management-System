<?php
session_start();

$host = "localhost";
$user = "root";
$password = "MyStrongPassword1234$";
$db = "user"; 

// Database connection
$data = mysqli_connect($host, $user, $password, $db);

if (!$data) {
    die("Connection failed: " . mysqli_connect_error());
}

if (!isset($_SESSION['username'])) {
    header("location:login.php");
    exit();
}

// Handle user update
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $usertype = $_POST['usertype'];
    // Update query
    $stmt = mysqli_prepare($data, "UPDATE user SET name = ?, usertype = ? WHERE id = ?");
    mysqli_stmt_bind_param($stmt, 'ssi', $name, $usertype, $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: adminhome.php");
}

// Handle user deletion
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    // Delete query
    $stmt = mysqli_prepare($data, "DELETE FROM user WHERE id = ?");
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: adminhome.php");
}

// Fetch all users
$results = mysqli_query($data, "SELECT * FROM user");
$users = mysqli_fetch_all($results, MYSQLI_ASSOC);

mysqli_close($data);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Home</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Admin Home</h1>
        <p>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</p>
        <a href="logout.php" class="btn btn-danger">Logout</a>

        <h2 class="mt-5">Users List</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>User Type</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                <tr>
                    <td><?php echo htmlspecialchars($user['id']); ?></td>
                    <td><?php echo htmlspecialchars($user['username']); ?></td>
                    <td><?php echo htmlspecialchars($user['usertype']); ?></td>
                    <td>
                        <!-- Update button triggers modal -->
                        <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#updateModal-<?php echo $user['id']; ?>">Update</button>
                        <a href="?delete=<?php echo $user['id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                    </td>
                </tr>

                <!-- Update User Modal -->
                <div class="modal fade" id="updateModal-<?php echo $user['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel-<?php echo $user['id']; ?>" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="updateModalLabel-<?php echo $user['id']; ?>">Update User</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form method="post" action="">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="name-<?php echo $user['id']; ?>">Name</label>
                                        <input type="text" class="form-control" id="name-<?php echo $user['id']; ?>" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="usertype-<?php echo $user['id']; ?>">User Type</label>
                                        <input type="text" class="form-control" id="usertype-<?php echo $user['id']; ?>" name="usertype" value="<?php echo htmlspecialchars($user['usertype']); ?>" required>
                                    </div>
                                    <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary" name="update">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

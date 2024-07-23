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

// Handle user update
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $username = $_POST['username'];
    $usertype = $_POST['usertype'];
    $stmt = mysqli_prepare($data, "UPDATE user SET username = ?, usertype = ? WHERE id = ?");
    mysqli_stmt_bind_param($stmt, 'ssi', $username, $usertype, $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: adminhome.php");
}

// Handle user deletion
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = mysqli_prepare($data, "DELETE FROM user WHERE id = ?");
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: adminhome.php");
}

// Handle activity creation
if (isset($_POST['create_activity'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $stmt = mysqli_prepare($data, "INSERT INTO activity (title, description) VALUES (?, ?)");
    mysqli_stmt_bind_param($stmt, 'ss', $title, $description);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: adminhome.php");
}

// Fetch activities
$activity_results = mysqli_query($data, "SELECT * FROM activity ORDER BY created_at DESC");
$activities = mysqli_fetch_all($activity_results, MYSQLI_ASSOC);

// Fetch users based on search query
$searchQuery = "";
if (isset($_GET['query'])) {
    $searchQuery = $_GET['query'];
    $stmt = mysqli_prepare($data, "SELECT * FROM user WHERE username LIKE ?");
    $searchTerm = "%" . $searchQuery . "%";
    mysqli_stmt_bind_param($stmt, 's', $searchTerm);
    mysqli_stmt_execute($stmt);
    $results = mysqli_stmt_get_result($stmt);
    $users = mysqli_fetch_all($results, MYSQLI_ASSOC);
    mysqli_stmt_close($stmt);
} else {
    $results = mysqli_query($data, "SELECT * FROM user");
    $users = mysqli_fetch_all($results, MYSQLI_ASSOC);
}

mysqli_close($data);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Home</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .search-bar {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Admin Home</h1>
        <p>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</p>
        <a href="logout.php" class="btn btn-danger">Logout</a>

        <h2 class="mt-5">Create Activity</h2>
        <form method="post" action="">
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary" name="create_activity">Create Activity</button>
        </form>

        <h2 class="mt-5">Activities</h2>
        <ul class="list-group">
            <?php foreach ($activities as $activity): ?>
            <li class="list-group-item">
                <h5><?php echo htmlspecialchars($activity['title']); ?></h5>
                <p><?php echo htmlspecialchars($activity['description']); ?></p>
                <small>Created at: <?php echo htmlspecialchars($activity['created_at']); ?></small>
            </li>
            <?php endforeach; ?>
        </ul>

        <h2 class="mt-5">Users List</h2>

        <form class="form-inline search-bar" method="GET" action="">
            <input class="form-control mr-sm-2" type="search" placeholder="Search by username" aria-label="Search" name="query" value="<?php echo htmlspecialchars($searchQuery); ?>">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
        </form>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>User Type</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($users)): ?>
                <tr>
                    <td colspan="4" class="text-center">No users found</td>
                </tr>
                <?php else: ?>
                <?php foreach ($users as $user): ?>
                <tr>
                    <td><?php echo htmlspecialchars($user['id']); ?></td>
                    <td><?php echo htmlspecialchars($user['username']); ?></td>
                    <td><?php echo htmlspecialchars($user['usertype']); ?></td>
                    <td>
                        <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#updateModal-<?php echo $user['id']; ?>">Update</button>
                        <a href="?delete=<?php echo $user['id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                    </td>
                </tr>

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
                                        <label for="username-<?php echo $user['id']; ?>">Username</label>
                                        <input type="text" class="form-control" id="username-<?php echo $user['id']; ?>" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
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
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

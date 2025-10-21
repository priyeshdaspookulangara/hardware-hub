<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // Since header.php is not included, we need to add the HTML boilerplate
    echo '
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin Login</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
        <div class="container mt-5">
            <h2 class="text-center mb-4">Admin Login</h2>
            <form action="login.php" method="post">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary">Login</button>
            </form>
        </div>
    </body>
    </html>
    ';
    exit;
}

include 'products.php';
include 'header.php';

// Handle form submissions for categories
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_category'])) {
        $new_category_name = trim($_POST['category_name']);
        if (!empty($new_category_name)) {
            $category_names = array_column($categories, 'name');
            if (!in_array($new_category_name, $category_names)) {
                // Sanitize input
                $name = mysqli_real_escape_string($link, $new_category_name);

                $sql = "INSERT INTO categories (name) VALUES ('$name')";

                if (mysqli_query($link, $sql)) {
                    echo '<div class="alert alert-success">Category added successfully.</div>';
                    // Refresh categories
                    $categories = get_categories();
                } else {
                    echo '<div class="alert alert-danger">Error adding category.</div>';
                }
            } else {
                echo '<div class="alert alert-warning">Category already exists.</div>';
            }
        } else {
            echo '<div class="alert alert-danger">Category name cannot be empty.</div>';
        }
    }
}

?>

<div class="container mt-5">
    <h2 class="text-center mb-4">Admin Panel - Manage Categories</h2>
    <div class="row">
        <div class="col-md-6">
            <h3>Add Category</h3>
            <form method="POST">
                <div class="mb-3">
                    <label for="category_name" class="form-label">Category Name</label>
                    <input type="text" class="form-control" id="category_name" name="category_name" required>
                </div>
                <button type="submit" name="add_category" class="btn btn-primary">Add Category</button>
            </form>
        </div>
        <div class="col-md-6">
            <h3>Existing Categories</h3>
            <ul class="list-group">
                <?php
                foreach ($categories as $category) {
                    echo '<li class="list-group-item">' . htmlspecialchars($category['name']) . '</li>';
                }
                ?>
            </ul>
        </div>
    </div>
</div>

</body>
</html>

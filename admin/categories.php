<?php
$page_title = "Manage Categories";
include 'includes/header.php';

// Handle form submission for adding a new category
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_category'])) {
    $category_name = trim($_POST['category_name']);
    if (!empty($category_name)) {
        $name = mysqli_real_escape_string($link, $category_name);
        $sql = "INSERT INTO categories (name) VALUES ('$name')";
        if (mysqli_query($link, $sql)) {
            echo '<div class="alert alert-success">Category added successfully.</div>';
        } else {
            echo '<div class="alert alert-danger">Error: ' . mysqli_error($link) . '</div>';
        }
    } else {
        echo '<div class="alert alert-danger">Category name cannot be empty.</div>';
    }
}

// Fetch all categories to display
$sql_fetch = "SELECT * FROM categories ORDER BY name ASC";
$result = mysqli_query($link, $sql_fetch);
$categories = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $categories[] = $row;
    }
}
?>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page"><?php echo $page_title; ?></li>
    </ol>
</nav>

<h1 class="mt-4"><?php echo $page_title; ?></h1>

<div class="row">
    <div class="col-md-5">
        <div class="card">
            <div class="card-header">
                Add New Category
            </div>
            <div class="card-body">
                <form method="POST" action="categories.php">
                    <div class="mb-3">
                        <label for="category_name" class="form-label">Category Name</label>
                        <input type="text" class="form-control" id="category_name" name="category_name" required>
                    </div>
                    <button type="submit" name="add_category" class="btn btn-primary">Add Category</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-7">
        <div class="card">
            <div class="card-header">
                Existing Categories
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($categories)): ?>
                            <?php foreach ($categories as $category): ?>
                                <tr>
                                    <td><?php echo $category['id']; ?></td>
                                    <td><?php echo htmlspecialchars($category['name']); ?></td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-warning">Edit</a>
                                        <a href="#" class="btn btn-sm btn-danger">Delete</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3" class="text-center">No categories found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>

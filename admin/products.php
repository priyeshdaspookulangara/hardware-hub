<?php
$page_title = "Manage Products";
include 'includes/header.php';

// Fetch all products with their category names
$sql = "
    SELECT p.*, c.name as category_name
    FROM products p
    LEFT JOIN categories c ON p.category_id = c.id
    ORDER BY p.id DESC
";
$result = mysqli_query($link, $sql);
$products = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $products[] = $row;
    }
}
?>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page"><?php echo $page_title; ?></li>
    </ol>
</nav>

<div class="d-flex justify-content-between align-items-center">
    <h1 class="mt-4"><?php echo $page_title; ?></h1>
    <a href="product_form.php" class="btn btn-primary">Add New Product</a>
</div>

<div class="card mt-4">
    <div class="card-header">
        All Products
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($products)): ?>
                    <?php foreach ($products as $product): ?>
                        <tr>
                            <td><?php echo $product['id']; ?></td>
                            <td>
                                <img src="<?php echo htmlspecialchars($product['image'] ? $product['image'] : 'https://via.placeholder.com/50'); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" style="width: 50px; height: auto;">
                            </td>
                            <td><?php echo htmlspecialchars($product['name']); ?></td>
                            <td><?php echo htmlspecialchars($product['category_name']); ?></td>
                            <td>$<?php echo htmlspecialchars($product['price']); ?></td>
                            <td>
                                <a href="product_form.php?edit_id=<?php echo $product['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                                <a href="#" class="btn btn-sm btn-danger">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center">No products found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'includes/footer.php'; ?>

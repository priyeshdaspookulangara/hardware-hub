<?php
include '../db_connect.php';
include '../header.php';

// Fetch all products to populate the dropdown
$products = [];
$result = $conn->query("SELECT id, name FROM products ORDER BY name ASC");
while ($row = $result->fetch_assoc()) {
    $products[] = $row;
}

// Handle form submission feedback
$message = '';
if (isset($_GET['success']) && $_GET['success'] == 1) {
    $product_id = isset($_GET['product_id']) ? intval($_GET['product_id']) : 0;
    $message = "<div class='alert alert-success'>Successfully assigned NEW ARRIVAL label to product ID: $product_id.</div>";
} elseif (isset($_GET['error'])) {
    $message = "<div class='alert alert-danger'>Error: " . htmlspecialchars($_GET['error']) . "</div>";
}

?>

<div class="container mt-5">
    <h2 class="mb-4">Manage New Arrivals</h2>

    <?php echo $message; ?>

    <div class="card">
        <div class="card-header">
            <h3>Assign 'New Arrival' Label</h3>
        </div>
        <div class="card-body">
            <form action="assign_new_arrival.php" method="post">
                <div class="mb-3">
                    <label for="product_id" class="form-label">Select Product</label>
                    <select class="form-select" id="product_id" name="product_id" required>
                        <option value="">Choose a product...</option>
                        <?php foreach ($products as $product) { ?>
                            <option value="<?php echo $product['id']; ?>"><?php echo htmlspecialchars($product['name']); ?></option>
                        <?php } ?>
                    </select>
                </div>
                <button type="submit" name="assign_label" class="btn btn-primary">Assign 'New Arrival' Label</button>
            </form>
        </div>
    </div>
</div>

</body>
</html>

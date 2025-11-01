<?php
include '../db_connect.php';
include '../header.php';

// Handle form submission for adding/editing a product
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_product'])) {
    // Basic product details
    $name = $_POST['name'];
    $brand = $_POST['brand'];
    $price = $_POST['price'];
    $original_price = $_POST['original_price'];
    $description = $_POST['description'];
    $categoryId = $_POST['category_id'];
    $images = json_encode(array_filter(explode("\n", $_POST['images'])));
    $sizes = json_encode(array_filter(explode(",", $_POST['sizes'])));
    $colors = json_encode(array_filter(explode(",", $_POST['colors'])));

    // Insert new product
    $stmt = $conn->prepare("INSERT INTO products (name, brand, price, original_price, description, category_id, images, sizes, colors) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssddsisss", $name, $brand, $price, $original_price, $description, $categoryId, $images, $sizes, $colors);
    $stmt->execute();
    $productId = $stmt->insert_id;

    // Handle custom properties
    if (isset($_POST['properties'])) {
        foreach ($_POST['properties'] as $propertyId => $value) {
            if (!empty($value)) {
                $stmt = $conn->prepare("INSERT INTO product_property_values (product_id, property_id, value) VALUES (?, ?, ?)");
                $stmt->bind_param("iis", $productId, $propertyId, $value);
                $stmt->execute();
            }
        }
    }
}

// Fetch categories for the dropdown
$categories = [];
$result = $conn->query("SELECT * FROM categories");
while ($row = $result->fetch_assoc()) {
    $categories[] = $row;
}
?>

<div class="container mt-5">
    <h2 class="mb-4">Manage Products</h2>

    <div class="card">
        <div class="card-header">
            <h3>Add New Product</h3>
        </div>
        <div class="card-body">
            <form action="manage_products.php" method="post">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label">Product Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="brand" class="form-label">Brand</label>
                        <input type="text" class="form-control" id="brand" name="brand" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="price" class="form-label">Price</label>
                        <input type="number" step="0.01" class="form-control" id="price" name="price" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="original_price" class="form-label">Original Price</label>
                        <input type="number" step="0.01" class="form-control" id="original_price" name="original_price" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="images" class="form-label">Images (one URL per line)</label>
                    <textarea class="form-control" id="images" name="images" rows="3" required></textarea>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="sizes" class="form-label">Sizes (comma-separated)</label>
                        <input type="text" class="form-control" id="sizes" name="sizes">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="colors" class="form-label">Colors (comma-separated)</label>
                        <input type="text" class="form-control" id="colors" name="colors">
                    </div>
                </div>
                <div class="mb-3">
                    <label for="category_id" class="form-label">Category</label>
                    <select class="form-select" id="category_id" name="category_id" required>
                        <option value="">Select a category</option>
                        <?php foreach ($categories as $category) { ?>
                            <option value="<?php echo $category['id']; ?>"><?php echo htmlspecialchars($category['name']); ?></option>
                        <?php } ?>
                    </select>
                </div>

                <!-- Dynamic properties will be loaded here -->
                <div id="dynamic-properties"></div>

                <button type="submit" name="save_product" class="btn btn-primary">Save Product</button>
            </form>
        </div>
    </div>
</div>

<!-- Existing Products List -->
<div class="card mt-5">
    <div class="card-header">
        <h3>Existing Products</h3>
    </div>
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Featured</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Fetch products with their category names
                $products_result = $conn->query("
                    SELECT p.id, p.name, p.category_id, p.is_featured, c.name AS category_name
                    FROM products p
                    JOIN categories c ON p.category_id = c.id
                    ORDER BY c.name, p.name
                ");
                while ($product = $products_result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($product['name']) . "</td>";
                    echo "<td>" . htmlspecialchars($product['category_name']) . "</td>";
                    echo "<td>" . ($product['is_featured'] ? '<span class="badge bg-success">Yes</span>' : 'No') . "</td>";
                    echo "<td>";
                    if (!$product['is_featured']) {
                        echo "<a href='set_featured_product.php?product_id=" . $product['id'] . "&category_id=" . $product['category_id'] . "' class='btn btn-sm btn-primary'>Set as Featured</a>";
                    }
                    echo "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#category_id').on('change', function() {
        var categoryId = $(this).val();
        if (categoryId) {
            // Use AJAX to fetch properties for the selected category
            $.ajax({
                url: 'ajax_get_properties.php',
                type: 'GET',
                data: { category_id: categoryId },
                success: function(response) {
                    $('#dynamic-properties').html(response);
                }
            });
        } else {
            $('#dynamic-properties').html('');
        }
    });
});
</script>

</body>
</html>

<?php
include '../db_connect.php';
include '../header.php';

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
            <form action="save_product.php" method="post" enctype="multipart/form-data">
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
                    <label for="images" class="form-label">Product Images</label>
                    <input type="file" class="form-control" id="images" name="images[]" multiple required>
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

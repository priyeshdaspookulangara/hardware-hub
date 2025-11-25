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
    $sizes = json_encode(array_filter(explode(",", $_POST['sizes'])));
    $colors = json_encode(array_filter(explode(",", $_POST['colors'])));

    // Insert new product (without images first)
    $stmt = $conn->prepare("INSERT INTO products (name, brand, price, original_price, description, category_id, sizes, colors) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssddisss", $name, $brand, $price, $original_price, $description, $categoryId, $sizes, $colors);
    $stmt->execute();
    $productId = $stmt->insert_id;

    // Handle image uploads
    if (isset($_FILES['images'])) {
        $uploadDir = '../uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $primaryImageFilename = $_POST['primary_image'];

        foreach ($_FILES['images']['name'] as $key => $filename) {
            $tmpName = $_FILES['images']['tmp_name'][$key];
            $imagePath = $uploadDir . basename($filename);

            if (move_uploaded_file($tmpName, $imagePath)) {
                $isPrimary = ($filename === $primaryImageFilename);
                $stmt = $conn->prepare("INSERT INTO product_images (product_id, image_path, is_primary) VALUES (?, ?, ?)");
                // Adjust path for web access
                $webPath = 'uploads/' . basename($filename);
                $stmt->bind_param("isi", $productId, $webPath, $isPrimary);
                $stmt->execute();
            }
        }
    }


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
            <form action="manage_products.php" method="post" enctype="multipart/form-data">
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
                    <div id="image-preview" class="mt-3"></div>
                    <input type="hidden" name="primary_image" id="primary_image">
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

    $('#images').on('change', function() {
        var previewContainer = $('#image-preview');
        previewContainer.html(''); // Clear previous previews
        var files = $(this)[0].files;

        if (files.length > 0) {
            // Set the first image as primary by default
            $('#primary_image').val(files[0].name);
        }

        for (var i = 0; i < files.length; i++) {
            var file = files[i];
            var reader = new FileReader();

            reader.onload = (function(file, index) {
                return function(e) {
                    var isChecked = (index === 0) ? 'checked' : '';
                    var preview = `
                        <div class="d-inline-block p-2">
                            <img src="${e.target.result}" style="width: 100px; height: 100px; object-fit: cover;">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="primary_image_radio" id="primary_${index}" value="${file.name}" ${isChecked}>
                                <label class="form-check-label" for="primary_${index}">Primary</label>
                            </div>
                        </div>
                    `;
                    previewContainer.append(preview);
                };
            })(file, i);

            reader.readAsDataURL(file);
        }
    });

    $(document).on('change', 'input[name="primary_image_radio"]', function() {
        $('#primary_image').val($(this).val());
    });
});
</script>

</body>
</html>

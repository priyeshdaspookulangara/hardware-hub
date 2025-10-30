<?php
// This form handles both ADD and EDIT
$edit_mode = false;
$product = null;
$page_title = "Add New Product";

include 'includes/header.php';

// Check if we are in EDIT mode
if (isset($_GET['edit_id'])) {
    $edit_mode = true;
    $product_id = mysqli_real_escape_string($link, $_GET['edit_id']);
    $sql = "SELECT * FROM products WHERE id = '$product_id'";
    $result = mysqli_query($link, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        $product = mysqli_fetch_assoc($result);
        $page_title = "Edit Product: " . htmlspecialchars($product['name']);
    } else {
        echo '<div class="alert alert-danger">Product not found.</div>';
        exit;
    }
}

// Fetch categories for the dropdown
$sql_cats = "SELECT * FROM categories ORDER BY name ASC";
$result_cats = mysqli_query($link, $sql_cats);
$categories = [];
if ($result_cats) {
    while ($row = mysqli_fetch_assoc($result_cats)) {
        $categories[] = $row;
    }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_product'])) {
    // Sanitize all inputs
    $name = mysqli_real_escape_string($link, $_POST['product_name']);
    $brand = mysqli_real_escape_string($link, $_POST['brand']);
    $category_id = mysqli_real_escape_string($link, $_POST['category_id']);
    $price = mysqli_real_escape_string($link, $_POST['price']);
    $original_price = mysqli_real_escape_string($link, $_POST['original_price']);
    $image = mysqli_real_escape_string($link, $_POST['image']);
    $description = mysqli_real_escape_string($link, $_POST['description']);
    $sizes = mysqli_real_escape_string($link, $_POST['sizes']);
    $colors = mysqli_real_escape_string($link, $_POST['colors']);

    if ($edit_mode) {
        // UPDATE query
        $sql_save = "UPDATE products SET name='$name', brand='$brand', category_id='$category_id', price='$price', original_price='$original_price', image='$image', description='$description', sizes='$sizes', colors='$colors' WHERE id='$product_id'";
    } else {
        // INSERT query
        $sql_save = "INSERT INTO products (name, brand, category_id, price, original_price, image, description, sizes, colors) VALUES ('$name', '$brand', '$category_id', '$price', '$original_price', '$image', '$description', '$sizes', '$colors')";
    }

    if (mysqli_query($link, $sql_save)) {
        $new_product_id = $edit_mode ? $product_id : mysqli_insert_id($link);
        // Handle custom properties
        if (isset($_POST['properties'])) {
            foreach ($_POST['properties'] as $prop_id => $prop_value) {
                $prop_id_safe = mysqli_real_escape_string($link, $prop_id);
                $prop_value_safe = mysqli_real_escape_string($link, $prop_value);

                // Check if a value for this property already exists
                $sql_check = "SELECT id FROM product_properties WHERE product_id = '$new_product_id' AND category_property_id = '$prop_id_safe'";
                $result_check = mysqli_query($link, $sql_check);

                if ($result_check && mysqli_num_rows($result_check) > 0) {
                    // UPDATE existing property value
                    $sql_prop_save = "UPDATE product_properties SET value = '$prop_value_safe' WHERE product_id = '$new_product_id' AND category_property_id = '$prop_id_safe'";
                } else {
                    // INSERT new property value
                    $sql_prop_save = "INSERT INTO product_properties (product_id, category_property_id, value) VALUES ('$new_product_id', '$prop_id_safe', '$prop_value_safe')";
                }

                if (!mysqli_query($link, $sql_prop_save)) {
                    echo '<div class="alert alert-danger">Error saving property: ' . mysqli_error($link) . '</div>';
                }
            }
        }
        echo '<div class="alert alert-success">Product saved successfully. <a href="products.php">View all products</a></div>';
    } else {
        echo '<div class="alert alert-danger">Error: ' . mysqli_error($link) . '</div>';
    }
}
?>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="products.php">Products</a></li>
        <li class="breadcrumb-item active" aria-current="page"><?php echo $page_title; ?></li>
    </ol>
</nav>

<h1 class="mt-4"><?php echo $page_title; ?></h1>

<div class="card">
    <div class="card-body">
        <form method="POST" action="product_form.php<?php echo $edit_mode ? '?edit_id=' . $product['id'] : ''; ?>">
            <div class="mb-3">
                <label for="product_name" class="form-label">Product Name</label>
                <input type="text" class="form-control" id="product_name" name="product_name" required value="<?php echo htmlspecialchars($product['name'] ?? ''); ?>">
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="brand" class="form-label">Brand</label>
                    <input type="text" class="form-control" id="brand" name="brand" required value="<?php echo htmlspecialchars($product['brand'] ?? ''); ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="product_category" class="form-label">Category</label>
                    <select class="form-select" id="product_category" name="category_id" onchange="this.form.submit()">
                        <option value="">Select a category</option>
                        <?php
                        $selected_cat_id = $product['category_id'] ?? ($_POST['category_id'] ?? null);
                        foreach ($categories as $category): ?>
                            <option value="<?php echo $category['id']; ?>" <?php echo ($selected_cat_id == $category['id']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($category['name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="price" class="form-label">Price</label>
                    <input type="number" class="form-control" id="price" name="price" step="0.01" required value="<?php echo htmlspecialchars($product['price'] ?? ''); ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="original_price" class="form-label">Original Price</label>
                    <input type="number" class="form-control" id="original_price" name="original_price" step="0.01" required value="<?php echo htmlspecialchars($product['original_price'] ?? ''); ?>">
                </div>
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Image URL</label>
                <input type="text" class="form-control" id="image" name="image" required value="<?php echo htmlspecialchars($product['image'] ?? ''); ?>">
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3" required><?php echo htmlspecialchars($product['description'] ?? ''); ?></textarea>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="sizes" class="form-label">Sizes (comma-separated)</label>
                    <input type="text" class="form-control" id="sizes" name="sizes" required value="<?php echo htmlspecialchars($product['sizes'] ?? ''); ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="colors" class="form-label">Colors (comma-separated)</label>
                    <input type="text" class="form-control" id="colors" name="colors" required value="<?php echo htmlspecialchars($product['colors'] ?? ''); ?>">
                </div>
            </div>

            <div id="custom_properties">
                <?php
                if (!empty($selected_cat_id)) {
                    echo '<h5 class="mt-4">Custom Properties</h5>';
                    $sql_props_def = "SELECT * FROM category_properties WHERE category_id = '$selected_cat_id'";
                    $result_props_def = mysqli_query($link, $sql_props_def);
                    if ($result_props_def && mysqli_num_rows($result_props_def) > 0) {
                        while ($prop_def = mysqli_fetch_assoc($result_props_def)) {
                            $prop_id = $prop_def['id'];
                            $prop_value = '';
                            if ($edit_mode) {
                                // Fetch existing value for this property
                                $sql_val = "SELECT value FROM product_properties WHERE product_id = '$product_id' AND category_property_id = '$prop_id'";
                                $result_val = mysqli_query($link, $sql_val);
                                if ($result_val && mysqli_num_rows($result_val) > 0) {
                                    $prop_value = mysqli_fetch_assoc($result_val)['value'];
                                }
                            }
                            echo '<div class="mb-3">';
                            echo '<label for="prop_' . $prop_id . '" class="form-label">' . htmlspecialchars($prop_def['property_name']) . '</label>';
                            echo '<input type="text" class="form-control" id="prop_' . $prop_id . '" name="properties[' . $prop_id . ']" value="' . htmlspecialchars($prop_value) . '">';
                            echo '</div>';
                        }
                    } else {
                        echo '<p>No custom properties defined for this category.</p>';
                    }
                }
                ?>
            </div>

            <button type="submit" name="save_product" class="btn btn-primary">Save Product</button>
            <a href="products.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

<?php include 'includes/footer.php'; ?>

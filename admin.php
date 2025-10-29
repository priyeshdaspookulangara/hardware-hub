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

// Handle form submissions for categories and properties
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Add Category
    if (isset($_POST['add_category'])) {
        $new_category_name = trim($_POST['category_name']);
        if (!empty($new_category_name)) {
            // Sanitize input
            $name = mysqli_real_escape_string($link, $new_category_name);
            $sql = "INSERT INTO categories (name) VALUES ('$name')";

            if (mysqli_query($link, $sql)) {
                echo '<div class="alert alert-success">Category added successfully.</div>';
                // Refresh categories
                $categories = get_categories();
            } else {
                echo '<div class="alert alert-danger">Error adding category: ' . mysqli_error($link) . '</div>';
            }
        } else {
            echo '<div class="alert alert-danger">Category name cannot be empty.</div>';
        }
    }

    // Add Property
    if (isset($_POST['add_property'])) {
        $category_id = $_POST['category_id'];
        $property_name = trim($_POST['property_name']);

        if (!empty($category_id) && !empty($property_name)) {
            // Sanitize input
            $category_id = mysqli_real_escape_string($link, $category_id);
            $property_name = mysqli_real_escape_string($link, $property_name);

            $sql = "INSERT INTO category_properties (category_id, property_name) VALUES ('$category_id', '$property_name')";

            if (mysqli_query($link, $sql)) {
                echo '<div class="alert alert-success">Property added successfully.</div>';
            } else {
                echo '<div class="alert alert-danger">Error adding property: ' . mysqli_error($link) . '</div>';
            }
        } else {
            echo '<div class="alert alert-danger">Category and property name are required.</div>';
        }
    }

    // Add Product
    if (isset($_POST['add_product'])) {
        // Retrieve and sanitize all form fields
        $product_name = mysqli_real_escape_string($link, trim($_POST['product_name']));
        $category_id = mysqli_real_escape_string($link, $_POST['product_category']);
        $brand = mysqli_real_escape_string($link, trim($_POST['brand']));
        $price = mysqli_real_escape_string($link, $_POST['price']);
        $original_price = mysqli_real_escape_string($link, $_POST['original_price']);
        $image = mysqli_real_escape_string($link, trim($_POST['image']));
        $description = mysqli_real_escape_string($link, trim($_POST['description']));
        $sizes = mysqli_real_escape_string($link, trim($_POST['sizes']));
        $colors = mysqli_real_escape_string($link, trim($_POST['colors']));

        // Basic validation
        if (!empty($product_name) && !empty($category_id) && !empty($brand) && !empty($price)) {
            $sql = "INSERT INTO products (name, category_id, brand, price, original_price, image, description, sizes, colors) VALUES ('$product_name', '$category_id', '$brand', '$price', '$original_price', '$image', '$description', '$sizes', '$colors')";

            if (mysqli_query($link, $sql)) {
                $product_id = mysqli_insert_id($link);

                // Insert into product_properties
                if (isset($_POST['properties']) && is_array($_POST['properties'])) {
                    foreach ($_POST['properties'] as $property_id => $value) {
                        if (!empty($value)) {
                            $property_id = mysqli_real_escape_string($link, $property_id);
                            $value = mysqli_real_escape_string($link, trim($value));
                            $sql_prop = "INSERT INTO product_properties (product_id, category_property_id, value) VALUES ('$product_id', '$property_id', '$value')";
                            if (!mysqli_query($link, $sql_prop)) {
                                echo '<div class="alert alert-danger">Error adding product property: ' . mysqli_error($link) . '</div>';
                            }
                        }
                    }
                }
                echo '<div class="alert alert-success">Product added successfully.</div>';
            } else {
                echo '<div class="alert alert-danger">Error adding product: ' . mysqli_error($link) . '</div>';
            }
        } else {
            echo '<div class="alert alert-danger">Please fill in all required fields.</div>';
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

<div class="container mt-5">
    <h2 class="text-center mb-4">Manage Custom Properties</h2>
    <div class="row">
        <div class="col-md-6">
            <h3>Add Property to Category</h3>
            <form method="POST">
                <div class="mb-3">
                    <label for="category_select" class="form-label">Category</label>
                    <select class="form-select" id="category_select" name="category_id">
                        <?php foreach ($categories as $category): ?>
                            <option value="<?php echo $category['id']; ?>"><?php echo htmlspecialchars($category['name']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="property_name" class="form-label">Property Name</label>
                    <input type="text" class="form-control" id="property_name" name="property_name" required>
                </div>
                <button type="submit" name="add_property" class="btn btn-primary">Add Property</button>
            </form>
        </div>
        <div class="col-md-6">
            <h3>Existing Properties by Category</h3>
            <form method="GET" action="admin.php">
                <div class="input-group mb-3">
                    <select class="form-select" name="category_id_view">
                        <option value="">Select a category</option>
                        <?php
                        foreach ($categories as $category) {
                            $selected = (isset($_GET['category_id_view']) && $_GET['category_id_view'] == $category['id']) ? 'selected' : '';
                            echo '<option value="' . $category['id'] . '" ' . $selected . '>' . htmlspecialchars($category['name']) . '</option>';
                        }
                        ?>
                    </select>
                    <button class="btn btn-outline-secondary" type="submit">View Properties</button>
                </div>
            </form>
            <?php
            if (isset($_GET['category_id_view']) && !empty($_GET['category_id_view'])) {
                $view_category_id = mysqli_real_escape_string($link, $_GET['category_id_view']);
                $sql = "SELECT property_name FROM category_properties WHERE category_id = '$view_category_id'";
                $result = mysqli_query($link, $sql);
                if ($result && mysqli_num_rows($result) > 0) {
                    echo '<ul class="list-group">';
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<li class="list-group-item">' . htmlspecialchars($row['property_name']) . '</li>';
                    }
                    echo '</ul>';
                } else {
                    echo '<p>No properties found for this category.</p>';
                }
            }
            ?>
        </div>
    </div>
</div>

<div class="container mt-5">
    <h2 class="text-center mb-4">Add Product</h2>
    <?php
    $product_name_value = isset($_POST['product_name']) ? htmlspecialchars($_POST['product_name']) : '';
    $brand_value = isset($_POST['brand']) ? htmlspecialchars($_POST['brand']) : '';
    $price_value = isset($_POST['price']) ? htmlspecialchars($_POST['price']) : '';
    $original_price_value = isset($_POST['original_price']) ? htmlspecialchars($_POST['original_price']) : '';
    $image_value = isset($_POST['image']) ? htmlspecialchars($_POST['image']) : '';
    $description_value = isset($_POST['description']) ? htmlspecialchars($_POST['description']) : '';
    $sizes_value = isset($_POST['sizes']) ? htmlspecialchars($_POST['sizes']) : '';
    $colors_value = isset($_POST['colors']) ? htmlspecialchars($_POST['colors']) : '';
    $selected_category_id = isset($_POST['product_category']) ? $_POST['product_category'] : '';
    ?>
    <form method="POST">
        <div class="mb-3">
            <label for="product_name" class="form-label">Product Name</label>
            <input type="text" class="form-control" id="product_name" name="product_name" required value="<?php echo $product_name_value; ?>">
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="brand" class="form-label">Brand</label>
                <input type="text" class="form-control" id="brand" name="brand" required value="<?php echo $brand_value; ?>">
            </div>
            <div class="col-md-6 mb-3">
                <label for="product_category" class="form-label">Category</label>
                <select class="form-select" id="product_category" name="product_category" onchange="this.form.submit()">
                    <option value="">Select a category</option>
                    <?php foreach ($categories as $category): ?>
                        <?php $selected = ($category['id'] == $selected_category_id) ? 'selected' : ''; ?>
                        <option value="<?php echo $category['id']; ?>" <?php echo $selected; ?>><?php echo htmlspecialchars($category['name']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="number" class="form-control" id="price" name="price" step="0.01" required value="<?php echo $price_value; ?>">
            </div>
            <div class="col-md-6 mb-3">
                <label for="original_price" class="form-label">Original Price</label>
                <input type="number" class="form-control" id="original_price" name="original_price" step="0.01" required value="<?php echo $original_price_value; ?>">
            </div>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Image URL</label>
            <input type="text" class="form-control" id="image" name="image" required value="<?php echo $image_value; ?>">
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3" required><?php echo $description_value; ?></textarea>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="sizes" class="form-label">Sizes (comma-separated)</label>
                <input type="text" class="form-control" id="sizes" name="sizes" required value="<?php echo $sizes_value; ?>">
            </div>
            <div class="col-md-6 mb-3">
                <label for="colors" class="form-label">Colors (comma-separated)</label>
                <input type="text" class="form-control" id="colors" name="colors" required value="<?php echo $colors_value; ?>">
            </div>
        </div>

        <div id="custom_properties">
            <?php
            if (!empty($selected_category_id)) {
                echo '<h5>Custom Properties</h5>';
                $category_id = mysqli_real_escape_string($link, $selected_category_id);
                $sql = "SELECT id, property_name FROM category_properties WHERE category_id = '$category_id'";
                $result = mysqli_query($link, $sql);
                if ($result && mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $property_value = isset($_POST['properties'][$row['id']]) ? htmlspecialchars($_POST['properties'][$row['id']]) : '';
                        echo '<div class="mb-3">';
                        echo '<label for="prop_' . $row['id'] . '" class="form-label">' . htmlspecialchars($row['property_name']) . '</label>';
                        echo '<input type="text" class="form-control" id="prop_' . $row['id'] . '" name="properties[' . $row['id'] . ']" value="' . $property_value . '">';
                        echo '</div>';
                    }
                } else {
                    echo '<p>No custom properties for this category.</p>';
                }
            }
            ?>
        </div>

        <button type="submit" name="add_product" class="btn btn-primary">Add Product</button>
    </form>
</div>

</body>
</html>

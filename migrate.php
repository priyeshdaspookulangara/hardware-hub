<?php
// Include the database connection file
include_once 'database.php';

// SQL to create categories table
$sql_create_categories_table = "
CREATE TABLE IF NOT EXISTS categories (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL UNIQUE
)";

// SQL to create products table
$sql_create_products_table = "
CREATE TABLE IF NOT EXISTS products (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    brand VARCHAR(255) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    original_price DECIMAL(10, 2) NOT NULL,
    image VARCHAR(255) NOT NULL,
    category_id INT(11) UNSIGNED NOT NULL,
    description TEXT NOT NULL,
    sizes VARCHAR(255) NULL,
    colors VARCHAR(255) NULL,
    FOREIGN KEY (category_id) REFERENCES categories(id)
)";

// SQL to create users table
$sql_create_users_table = "
CREATE TABLE IF NOT EXISTS users (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
)";

// SQL to create category_properties table
$sql_create_category_properties_table = "
CREATE TABLE IF NOT EXISTS category_properties (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    category_id INT(11) UNSIGNED NOT NULL,
    property_name VARCHAR(255) NOT NULL,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE,
    UNIQUE KEY (category_id, property_name)
)";

// SQL to create product_properties table
$sql_create_product_properties_table = "
CREATE TABLE IF NOT EXISTS product_properties (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    product_id INT(11) UNSIGNED NOT NULL,
    category_property_id INT(11) UNSIGNED NOT NULL,
    value VARCHAR(255) NOT NULL,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    FOREIGN KEY (category_property_id) REFERENCES category_properties(id) ON DELETE CASCADE
)";


// Execute create tables queries
if (mysqli_query($link, $sql_create_categories_table)) {
    echo "Table 'categories' created successfully.\n";
} else {
    echo "ERROR: Could not able to execute $sql_create_categories_table. " . mysqli_error($link) . "\n";
}

if (mysqli_query($link, $sql_create_products_table)) {
    echo "Table 'products' created successfully.\n";
} else {
    echo "ERROR: Could not able to execute $sql_create_products_table. " . mysqli_error($link) . "\n";
}

// SQL to alter products table to make sizes and colors nullable
$sql_alter_products_sizes = "ALTER TABLE products MODIFY sizes VARCHAR(255) NULL";
$sql_alter_products_colors = "ALTER TABLE products MODIFY colors VARCHAR(255) NULL";

if (mysqli_query($link, $sql_alter_products_sizes)) {
    echo "Table 'products' modified successfully: sizes is now nullable.\n";
} else {
    echo "ERROR: Could not able to execute $sql_alter_products_sizes. " . mysqli_error($link) . "\n";
}

if (mysqli_query($link, $sql_alter_products_colors)) {
    echo "Table 'products' modified successfully: colors is now nullable.\n";
} else {
    echo "ERROR: Could not able to execute $sql_alter_products_colors. " . mysqli_error($link) . "\n";
}

if (mysqli_query($link, $sql_create_users_table)) {
    echo "Table 'users' created successfully.\n";
} else {
    echo "ERROR: Could not able to execute $sql_create_users_table. " . mysqli_error($link) . "\n";
}

if (mysqli_query($link, $sql_create_category_properties_table)) {
    echo "Table 'category_properties' created successfully.\n";
} else {
    echo "ERROR: Could not able to execute $sql_create_category_properties_table. " . mysqli_error($link) . "\n";
}

if (mysqli_query($link, $sql_create_product_properties_table)) {
    echo "Table 'product_properties' created successfully.\n";
} else {
    echo "ERROR: Could not able to execute $sql_create_product_properties_table. " . mysqli_error($link) . "\n";
}

// Populate products and categories tables only if products.json exists and products table is empty
if (file_exists('products.json')) {
    $result = mysqli_query($link, "SELECT COUNT(*) as count FROM products");
    $row = mysqli_fetch_assoc($result);
    if ($row['count'] == 0) {
        $products_json = file_get_contents('products.json');
        $products_data = json_decode($products_json, true);

        $categories = [];
        foreach ($products_data as $product) {
            $category_name = mysqli_real_escape_string($link, $product['category']);
            if (!isset($categories[$category_name])) {
                $sql_insert_category = "INSERT INTO categories (name) VALUES ('$category_name')";
                if (mysqli_query($link, $sql_insert_category)) {
                    $categories[$category_name] = mysqli_insert_id($link);
                } else {
                    echo "ERROR: Could not able to execute $sql_insert_category. " . mysqli_error($link) . "\n";
                }
            }

            $name = mysqli_real_escape_string($link, $product['name']);
            $brand = mysqli_real_escape_string($link, $product['brand']);
            $price = $product['price'];
            $original_price = $product['original_price'];
            $image = mysqli_real_escape_string($link, $product['image']);
            $category_id = $categories[$category_name];
            $description = mysqli_real_escape_string($link, $product['description']);
            $sizes = mysqli_real_escape_string($link, implode(',', $product['sizes']));
            $colors = mysqli_real_escape_string($link, implode(',', $product['colors']));

            $sql_insert_product = "INSERT INTO products (name, brand, price, original_price, image, category_id, description, sizes, colors) VALUES ('$name', '$brand', '$price', '$original_price', '$image', '$category_id', '$description', '$sizes', '$colors')";

            if (!mysqli_query($link, $sql_insert_product)) {
                echo "ERROR: Could not able to execute $sql_insert_product. " . mysqli_error($link) . "\n";
            }
        }
        echo "Products and categories tables populated successfully.\n";
    } else {
        echo "Products table is not empty. Skipping population.\n";
    }
} else {
    echo "products.json not found. Skipping population of products and categories.\n";
}


// Populate users table with a default admin user if it doesn't exist
$username = 'admin';
$result = mysqli_query($link, "SELECT id FROM users WHERE username = '$username'");
if (mysqli_num_rows($result) == 0) {
    $password = password_hash('admin', PASSWORD_DEFAULT);
    $sql_insert_user = "INSERT INTO users (username, password) VALUES ('$username', '$password')";

    if (mysqli_query($link, $sql_insert_user)) {
        echo "User 'admin' inserted successfully.\n";
    } else {
        echo "ERROR: Could not able to execute $sql_insert_user. " . mysqli_error($link) . "\n";
    }
} else {
    echo "User 'admin' already exists. Skipping insertion.\n";
}

// Close connection
mysqli_close($link);

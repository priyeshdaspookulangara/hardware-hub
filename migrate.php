<?php
// Include the database connection file
include 'database.php';

// SQL to create categories table
$sql_create_categories_table = "
CREATE TABLE categories (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL UNIQUE
)";

// SQL to create products table
$sql_create_products_table = "
CREATE TABLE products (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    brand VARCHAR(255) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    original_price DECIMAL(10, 2) NOT NULL,
    image VARCHAR(255) NOT NULL,
    category_id INT(11) UNSIGNED NOT NULL,
    description TEXT NOT NULL,
    sizes VARCHAR(255) NOT NULL,
    colors VARCHAR(255) NOT NULL,
    FOREIGN KEY (category_id) REFERENCES categories(id)
)";

// SQL to create users table
$sql_create_users_table = "
CREATE TABLE users (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
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

if (mysqli_query($link, $sql_create_users_table)) {
    echo "Table 'users' created successfully.\n";
} else {
    echo "ERROR: Could not able to execute $sql_create_users_table. " . mysqli_error($link) . "\n";
}

// Get product data from JSON file
$products_json = file_get_contents('products.json');
$products_data = json_decode($products_json, true);

// Populate categories and products tables
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

// Populate users table with a default admin user
$username = 'admin';
$password = password_hash('admin', PASSWORD_DEFAULT);

$sql_insert_user = "INSERT INTO users (username, password) VALUES ('$username', '$password')";

if (mysqli_query($link, $sql_insert_user)) {
    echo "User 'admin' inserted successfully.\n";
} else {
    echo "ERROR: Could not able to execute $sql_insert_user. " . mysqli_error($link) . "\n";
}

// Close connection
mysqli_close($link);

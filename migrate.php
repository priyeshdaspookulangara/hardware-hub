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

// SQL to create admins table
$sql_create_admins_table = "
CREATE TABLE IF NOT EXISTS admins (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
)";

// SQL to create customers table
$sql_create_customers_table = "
CREATE TABLE IF NOT EXISTS customers (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(255) NOT NULL UNIQUE,
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

// Rename users to admins if it exists
$result = mysqli_query($link, "SHOW TABLES LIKE 'users'");
if ($result && mysqli_num_rows($result) > 0) {
    if (mysqli_query($link, "RENAME TABLE users TO admins")) {
        echo "Table 'users' renamed to 'admins' successfully.\n";
    } else {
        echo "ERROR: Could not rename table 'users' to 'admins'. " . mysqli_error($link) . "\n";
    }
} else {
    // Check if the query itself failed
    if (!$result) {
        echo "ERROR: Could not check if 'users' table exists. " . mysqli_error($link) . "\n";
    } else {
        echo "Table 'users' not found, skipping rename.\n";
    }
}

if (mysqli_query($link, $sql_create_admins_table)) {
    echo "Table 'admins' created successfully.\n";
} else {
    echo "ERROR: Could not able to execute $sql_create_admins_table. " . mysqli_error($link) . "\n";
}

if (mysqli_query($link, $sql_create_customers_table)) {
    echo "Table 'customers' created successfully.\n";
} else {
    echo "ERROR: Could not able to execute $sql_create_customers_table. " . mysqli_error($link) . "\n";
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


// Populate admins table with a default admin user if it doesn't exist
$username = 'admin';
$result = mysqli_query($link, "SELECT id FROM admins WHERE username = '$username'");
if ($result && mysqli_num_rows($result) == 0) {
    $password = password_hash('admin', PASSWORD_DEFAULT);
    $sql_insert_admin = "INSERT INTO admins (username, password) VALUES ('$username', '$password')";

    if (mysqli_query($link, $sql_insert_admin)) {
        echo "Admin 'admin' inserted successfully.\n";
    } else {
        echo "ERROR: Could not able to execute $sql_insert_admin. " . mysqli_error($link) . "\n";
    }
} else if (!$result) {
    echo "ERROR: Could not check for admin user. " . mysqli_error($link) . "\n";
}
else {
    echo "Admin 'admin' already exists. Skipping insertion.\n";
}

// Close connection
mysqli_close($link);

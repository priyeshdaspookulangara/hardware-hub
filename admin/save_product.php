<?php
include '../db_connect.php';

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

    // Insert new product
    $stmt = $conn->prepare("INSERT INTO products (name, brand, price, original_price, description, category_id, sizes, colors) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssddisss", $name, $brand, $price, $original_price, $description, $categoryId, $sizes, $colors);
    $stmt->execute();
    $productId = $stmt->insert_id;

    // Handle image uploads
    if (isset($_FILES['images'])) {
        $upload_dir = '../uploads/';
        foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
            $file_name = uniqid() . '-' . basename($_FILES['images']['name'][$key]);
            $target_file = $upload_dir . $file_name;

            if (move_uploaded_file($tmp_name, $target_file)) {
                $image_path = '/uploads/' . $file_name;
                $stmt = $conn->prepare("INSERT INTO product_images (product_id, image_path) VALUES (?, ?)");
                $stmt->bind_param("is", $productId, $image_path);
                $stmt->execute();
            }
        }
    }

    header("Location: manage_products.php?success=1");
    exit();
}
?>

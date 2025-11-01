<?php
include '../db_connect.php';

if (isset($_GET['product_id']) && isset($_GET['category_id'])) {
    $productId = intval($_GET['product_id']);
    $categoryId = intval($_GET['category_id']);

    // Start a transaction to ensure atomicity
    $conn->begin_transaction();

    try {
        // 1. Unset any currently featured product in this category
        $stmt = $conn->prepare("UPDATE products SET is_featured = 0 WHERE category_id = ?");
        $stmt->bind_param("i", $categoryId);
        $stmt->execute();

        // 2. Set the new product as featured
        $stmt = $conn->prepare("UPDATE products SET is_featured = 1 WHERE id = ?");
        $stmt->bind_param("i", $productId);
        $stmt->execute();

        // Commit the transaction
        $conn->commit();

        header("Location: manage_products.php?success=1");
        exit();

    } catch (mysqli_sql_exception $exception) {
        $conn->rollback();
        // Redirect with an error message
        header("Location: manage_products.php?error=" . urlencode($exception->getMessage()));
        exit();
    }
} else {
    // Redirect if parameters are not set
    header("Location: manage_products.php");
    exit();
}
?>

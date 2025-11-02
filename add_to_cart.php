<?php
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $productId = intval($_POST['product_id']);
    $size = isset($_POST['size']) ? $_POST['size'] : null;
    $color = isset($_POST['color']) ? $_POST['color'] : null;

    // Initialize cart if not set
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Create a unique key for the product based on id, size, and color
    $cart_item_key = $productId . '_' . $size . '_' . $color;

    // Add product to cart or update quantity
    if (isset($_SESSION['cart'][$cart_item_key])) {
        $_SESSION['cart'][$cart_item_key]['quantity']++;
    } else {
        $_SESSION['cart'][$cart_item_key] = [
            'product_id' => $productId,
            'quantity' => 1,
            'size' => $size,
            'color' => $color
        ];
    }

    // Return success response with cart count
    echo json_encode([
        'success' => true,
        'cart_count' => count($_SESSION['cart'])
    ]);
} else {
    // Return error response
    echo json_encode(['success' => false]);
}
?>

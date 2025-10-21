<?php
session_start();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if (isset($_POST['product_id']) && isset($_POST['size']) && isset($_POST['color'])) {
    $productId = $_POST['product_id'];
    $size = $_POST['size'];
    $color = $_POST['color'];

    $cartItem = [
        'product_id' => $productId,
        'size' => $size,
        'color' => $color,
        'quantity' => 1 // Default quantity to 1
    ];

    // For simplicity, we'll just add the item. A real application would check for duplicates and update quantity.
    $_SESSION['cart'][] = $cartItem;

    echo json_encode(['success' => true, 'cart_count' => count($_SESSION['cart'])]);
} else {
    echo json_encode(['success' => false]);
}

<?php
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_SESSION['cart'])) {
    // Basic validation
    if (empty($_POST['fullName']) || empty($_POST['email']) || empty($_POST['address'])) {
        header("Location: checkout.php?error=Missing required fields.");
        exit();
    }

    $customerName = $_POST['fullName'];
    $customerEmail = $_POST['email'];
    $shippingAddress = $_POST['address'];
    // For simplicity, billing and shipping are the same
    $billingAddress = $shippingAddress;

    // Re-calculate total server-side to ensure data integrity
    $cart_items = [];
    $total = 0;
    $product_ids = array_map(function($item) { return $item['product_id']; }, $_SESSION['cart']);
    $stmt = $conn->prepare("SELECT * FROM products WHERE id IN (" . implode(',', array_fill(0, count($product_ids), '?')) . ")");
    $stmt->bind_param(str_repeat('i', count($product_ids)), ...$product_ids);
    $stmt->execute();
    $result = $stmt->get_result();
    $products_by_id = [];
    while ($product = $result->fetch_assoc()) {
        $products_by_id[$product['id']] = $product;
    }

    foreach ($_SESSION['cart'] as $cart_item_key => $item) {
        $product = $products_by_id[$item['product_id']];
        $price = getProductPrice($conn, $product['id'], $product['price'], $product['category_id']);
        $cart_items[] = [
            'product_id' => $product['id'],
            'quantity' => $item['quantity'],
            'price' => $price
        ];
        $total += $price * $item['quantity'];
    }

    // Start a transaction
    $conn->begin_transaction();

    try {
        // 1. Create the order
        $stmt = $conn->prepare("INSERT INTO orders (customer_name, customer_email, shipping_address, billing_address, total_price) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssd", $customerName, $customerEmail, $shippingAddress, $billingAddress, $total);
        $stmt->execute();
        $orderId = $stmt->insert_id;

        // 2. Insert order items
        $stmt = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
        foreach ($cart_items as $item) {
            $stmt->bind_param("iiid", $orderId, $item['product_id'], $item['quantity'], $item['price']);
            $stmt->execute();
        }

        // Commit the transaction
        $conn->commit();

        // 3. Clear the cart and redirect to confirmation
        unset($_SESSION['cart']);
        unset($_SESSION['coupon']);
        header("Location: order_confirmation.php?order_id=" . $orderId);
        exit();

    } catch (mysqli_sql_exception $exception) {
        $conn->rollback();
        header("Location: checkout.php?error=" . urlencode($exception->getMessage()));
        exit();
    }
} else {
    header("Location: checkout.php");
    exit();
}
?>

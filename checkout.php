<?php
include 'db_connect.php';
include 'header.php';

// Redirect to cart if the cart is empty
if (empty($_SESSION['cart'])) {
    header("Location: cart.php");
    exit();
}

// Most of the logic from cart.php is needed here to calculate totals
$cart_items = [];
$subtotal = 0;
// (Copy and adapt the cart calculation logic from cart.php)
// This is a simplified version for brevity
if (!empty($_SESSION['cart'])) {
    $product_ids = array_keys($_SESSION['cart']);
    // This is a simplified query and needs to be adapted for composite keys
    $product_ids_from_cart = array_map(function($item) { return $item['product_id']; }, $_SESSION['cart']);
    $stmt = $conn->prepare("SELECT * FROM products WHERE id IN (" . implode(',', array_fill(0, count($product_ids_from_cart), '?')) . ")");
    $stmt->bind_param(str_repeat('i', count($product_ids_from_cart)), ...$product_ids_from_cart);
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
            'name' => $product['name'],
            'price' => $price,
            'quantity' => $item['quantity'],
        ];
        $subtotal += $price * $item['quantity'];
    }
}
$total = $subtotal; // Simplified total
?>

<div class="container mt-5">
    <h2 class="mb-4">Checkout</h2>
    <div class="row">
        <!-- Order Summary -->
        <div class="col-md-5 order-md-2 mb-4">
            <h4 class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-muted">Your cart</span>
                <span class="badge bg-secondary rounded-pill"><?php echo count($cart_items); ?></span>
            </h4>
            <ul class="list-group mb-3">
                <?php foreach ($cart_items as $item): ?>
                <li class="list-group-item d-flex justify-content-between lh-condensed">
                    <div>
                        <h6 class="my-0"><?php echo htmlspecialchars($item['name']); ?></h6>
                        <small class="text-muted">Quantity: <?php echo $item['quantity']; ?></small>
                    </div>
                    <span class="text-muted">$<?php echo number_format($item['price'] * $item['quantity'], 2); ?></span>
                </li>
                <?php endforeach; ?>
                <li class="list-group-item d-flex justify-content-between">
                    <span>Total (USD)</span>
                    <strong>$<?php echo number_format($total, 2); ?></strong>
                </li>
            </ul>
        </div>

        <!-- Billing Address -->
        <div class="col-md-7 order-md-1">
            <h4 class="mb-3">Billing address</h4>
            <form action="place_order.php" method="post">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="fullName" class="form-label">Full name</label>
                        <input type="text" class="form-control" id="fullName" name="fullName" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="address" class="form-label">Address</label>
                    <input type="text" class="form-control" id="address" name="address" required>
                </div>
                <hr class="mb-4">
                <button class="btn btn-primary btn-lg btn-block" type="submit">Place Order</button>
            </form>
        </div>
    </div>
</div>

</body>
</html>

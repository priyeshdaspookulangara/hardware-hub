<?php
include 'db_connect.php';
include 'header.php';

// Initialize cart if not set
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$cart_items = [];
$subtotal = 0;

if (!empty($_SESSION['cart'])) {
    // Extract product IDs from the composite keys in the cart
    $product_ids = [];
    foreach ($_SESSION['cart'] as $cart_item_key => $item) {
        $product_ids[] = $item['product_id'];
    }
    $product_ids = array_unique($product_ids);

    // Fetch all relevant products in a single query
    $products_by_id = [];
    if (!empty($product_ids)) {
        $stmt = $conn->prepare("SELECT * FROM products WHERE id IN (" . implode(',', array_fill(0, count($product_ids), '?')) . ")");
        $stmt->bind_param(str_repeat('i', count($product_ids)), ...$product_ids);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($product = $result->fetch_assoc()) {
            $products_by_id[$product['id']] = $product;
        }
    }

    // Build the cart items array
    foreach ($_SESSION['cart'] as $cart_item_key => $item) {
        $product = $products_by_id[$item['product_id']] ?? null;
        if ($product) {
            $cart_items[] = [
                'id' => $item['product_id'],
                'name' => $product['name'],
                'price' => $product['price'],
                'original_price' => $product['original_price'],
                'quantity' => $item['quantity'],
                'category_id' => $product['category_id'],
                'image' => json_decode($product['images'], true)[0] ?? 'https://via.placeholder.com/150',
                'size' => $item['size'],
                'color' => $item['color']
            ];
            $subtotal += $product['price'] * $item['quantity'];
        }
    }
}

// Apply discounts
$discount = 0;
$coupon_applied = null;

// Apply non-coupon discounts first
$subtotal_after_offers = 0;
foreach ($cart_items as &$item) {
    $item['final_price'] = getProductPrice($conn, $item['id'], $item['price'], $item['category_id']);
    $subtotal_after_offers += $item['final_price'] * $item['quantity'];
}
unset($item); // Unset reference

$discount = $subtotal - $subtotal_after_offers;
$total = $subtotal_after_offers;

// Apply coupon discount if one is active in the session
if (isset($_SESSION['coupon'])) {
    $coupon = $_SESSION['coupon'];
    $coupon_applied = $coupon;

    if ($coupon['scope'] === 'global') {
        if ($coupon['offer_type'] === 'percentage') {
            $discount += $total * ($coupon['discount_value'] / 100);
        } elseif ($coupon['offer_type'] === 'fixed_amount') {
            $discount += $coupon['discount_value'];
            // Prevent discount from exceeding total
            if ($discount > $total) {
                $discount = $total;
            }
        }
    } else { // Category or Product scope
        $applied_to_items = 0;
        foreach ($cart_items as $item) {
            $is_applicable = ($coupon['scope'] === 'category' && $item['category_id'] == $coupon['applicable_id']) ||
                             ($coupon['scope'] === 'product' && $item['id'] == $coupon['applicable_id']);

            if ($is_applicable) {
                if ($coupon['offer_type'] === 'percentage') {
                    $discount += ($item['final_price'] * $item['quantity']) * ($coupon['discount_value'] / 100);
                } elseif ($coupon['offer_type'] === 'fixed_amount') {
                    // Apply fixed amount discount only once for the first matching item found
                    if ($applied_to_items === 0) {
                        $discount += $coupon['discount_value'];
                        $applied_to_items++;
                    }
                }
            }
        }
    }
}

// BOGO logic
$now = date('Y-m-d H:i:s');
$bogo_offers = $conn->query("
    SELECT * FROM offers
    WHERE is_active = 1 AND offer_type = 'bogo'
    AND start_date <= '$now' AND end_date >= '$now'
")->fetch_all(MYSQLI_ASSOC);

foreach ($cart_items as $item) {
    if ($item['quantity'] >= 2) {
        foreach ($bogo_offers as $offer) {
            if (
                ($offer['scope'] === 'global') ||
                ($offer['scope'] === 'category' && $offer['applicable_id'] == $item['category_id']) ||
                ($offer['scope'] === 'product' && $offer['applicable_id'] == $item['id'])
            ) {
                $free_items = floor($item['quantity'] / 2);
                $discount += $free_items * $item['final_price'];
                break; // Move to the next cart item once an offer is applied
            }
        }
    }
}

$total = $subtotal - $discount;

?>

<div class="container mt-5">
    <h2 class="mb-4">Shopping Cart</h2>

    <?php if (empty($cart_items)): ?>
        <div class="alert alert-info">Your cart is empty.</div>
    <?php else: ?>
        <table class="table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cart_items as $item): ?>
                <tr>
                    <td>
                        <img src="<?php echo $item['image']; ?>" width="50" class="me-2">
                        <?php echo htmlspecialchars($item['name']); ?>
                    </td>
                    <td>$<?php echo number_format($item['final_price'], 2); ?></td>
                    <td><?php echo $item['quantity']; ?></td>
                    <td>$<?php echo number_format($item['final_price'] * $item['quantity'], 2); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="row justify-content-end">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Cart Summary</h5>
                        <p>Subtotal: $<?php echo number_format($subtotal, 2); ?></p>
                        <p>Discount: -$<?php echo number_format($discount, 2); ?></p>
                        <hr>
                        <p><strong>Total: $<?php echo number_format($total, 2); ?></strong></p>
                    </div>
                </div>
                <form action="apply_coupon.php" method="post" class="mt-3">
                    <div class="input-group">
                        <input type="text" class="form-control" name="coupon_code" placeholder="Enter coupon code" value="<?php echo $coupon_applied ? htmlspecialchars($coupon_applied['coupon_code']) : ''; ?>">
                        <button class="btn btn-primary" type="submit">Apply</button>
                    </div>
                </form>
                <?php if ($coupon_applied): ?>
                    <div class="alert alert-success mt-2">
                        Coupon "<?php echo htmlspecialchars($coupon_applied['name']); ?>" applied.
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>
</div>

</body>
</html>

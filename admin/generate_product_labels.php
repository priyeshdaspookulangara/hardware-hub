<?php
include '../db_connect.php';
include '../header.php';

function assignLabel($conn, $productId, $labelName) {
    $stmt = $conn->prepare("INSERT INTO product_labels (product_id, label_name) VALUES (?, ?)");
    if ($stmt) {
        $stmt->bind_param("is", $productId, $labelName);
        $stmt->execute();
        $stmt->close();
    }
}

$log_messages = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['generate_labels'])) {
    // 1. Clear existing automatically generated labels
    $conn->query("DELETE FROM product_labels WHERE label_name IN ('POPULAR', 'DOMBO DEAL')");
    $log_messages[] = "Cleared existing 'POPULAR' and 'DOMBO DEAL' labels.";

    // 2. Fetch all products
    $productsResult = $conn->query("SELECT * FROM products");
    $products = [];
    while ($row = $productsResult->fetch_assoc()) {
        $products[$row['id']] = $row;
    }
    $log_messages[] = "Fetched " . count($products) . " products.";

    // 3. Assign 'POPULAR' Label
    $productsByCategory = [];
    foreach ($products as $product) {
        $productsByCategory[$product['category_id']][] = $product;
    }

    $popular_count = 0;
    foreach ($productsByCategory as $categoryProducts) {
        usort($categoryProducts, function($a, $b) {
            return $b['units_sold_last_30_days'] - $a['units_sold_last_30_days'];
        });

        $top10PercentCount = ceil(count($categoryProducts) * 0.1);
        $popularProducts = array_slice($categoryProducts, 0, $top10PercentCount);

        foreach ($popularProducts as $product) {
            if ($product['inventory_level'] > 50) {
                assignLabel($conn, $product['id'], 'POPULAR');
                $popular_count++;
            }
        }
    }
    $log_messages[] = "Assigned 'POPULAR' label to $popular_count products.";

    // 4. Assign 'DOMBO DEAL' Label
    $dombo_deal_count = 0;
    foreach ($products as $product) {
        if ($product['original_price'] > 0) {
            $discount = (($product['original_price'] - $product['price']) / $product['original_price']) * 100;
            if ($discount >= 30) {
                assignLabel($conn, $product['id'], 'DOMBO DEAL');
                $dombo_deal_count++;
            }
        }
    }
    $log_messages[] = "Assigned 'DOMBO DEAL' label to $dombo_deal_count products.";
    $log_messages[] = "Label generation complete.";
}
?>

<div class="container mt-5">
    <h2 class="mb-4">Generate Product Labels</h2>
    <div class="card">
        <div class="card-header">
            <h3>Automated Label Generation</h3>
        </div>
        <div class="card-body">
            <p>This tool will automatically assign 'POPULAR' and 'DOMBO DEAL' labels to products based on the predefined criteria. This process will remove any existing 'POPULAR' and 'DOMBO DEAL' labels before running.</p>
            <form action="generate_product_labels.php" method="post">
                <button type="submit" name="generate_labels" class="btn btn-primary">Generate Labels</button>
            </form>
        </div>
    </div>

    <?php if (!empty($log_messages)): ?>
    <div class="card mt-4">
        <div class="card-header">
            <h3>Generation Log</h3>
        </div>
        <div class="card-body">
            <ul>
                <?php foreach ($log_messages as $message): ?>
                    <li><?php echo $message; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
    <?php endif; ?>
</div>

</body>
</html>

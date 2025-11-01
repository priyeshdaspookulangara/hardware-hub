<?php
header('Content-Type: application/json');
include '../db_connect.php';

// --- Helper Functions ---

/**
 * Inserts a label for a given product into the database.
 * @param mysqli $conn The database connection.
 * @param int $productId The ID of the product.
 * @param string $labelName The name of the label to assign.
 */
function assignLabel($conn, $productId, $labelName) {
    $stmt = $conn->prepare("INSERT INTO product_labels (product_id, label_name) VALUES (?, ?)");
    if ($stmt) {
        $stmt->bind_param("is", $productId, $labelName);
        $stmt->execute();
        $stmt->close();
    } else {
        // Handle error, e.g., log it
        error_log("Failed to prepare statement for assigning label: " . $conn->error);
    }
}

// --- Main Logic ---

// 1. Clear existing automatically generated labels for a fresh run
$conn->query("DELETE FROM product_labels WHERE label_name IN ('POPULAR', 'DOMBO DEAL')");

// 2. Fetch all products with necessary data
$productsResult = $conn->query("SELECT * FROM products");
$products = [];
while ($row = $productsResult->fetch_assoc()) {
    $products[$row['id']] = $row;
}

$labeledProducts = [
    'POPULAR' => [],
    'DOMBO DEAL' => [],
    'NEW ARRIVAL' => []
];

// --- Label Assignment ---

// 3. Assign 'POPULAR' Label
// Group products by category
$productsByCategory = [];
foreach ($products as $product) {
    $productsByCategory[$product['category_id']][] = $product;
}

foreach ($productsByCategory as $categoryId => $categoryProducts) {
    // Sort products in the category by units sold
    usort($categoryProducts, function($a, $b) {
        return $b['units_sold_last_30_days'] - $a['units_sold_last_30_days'];
    });

    // Determine the top 10%
    $top10PercentCount = ceil(count($categoryProducts) * 0.1);
    $popularProducts = array_slice($categoryProducts, 0, $top10PercentCount);

    foreach ($popularProducts as $product) {
        // Secondary constraint: Inventory level must be greater than 50
        if ($product['inventory_level'] > 50) {
            assignLabel($conn, $product['id'], 'POPULAR');
            $labeledProducts['POPULAR'][] = [
                'ProductID' => $product['id'],
                'Category' => $categoryId, // In a real app, you'd join to get the category name
                'KeyMetricValue' => 'Units Sold: ' . $product['units_sold_last_30_days'],
                'Justification' => 'In the top 10% of its category by sales and has sufficient stock.'
            ];
        }
    }
}


// 4. Assign 'DOMBO DEAL' and 'NEW ARRIVAL' Labels
$today = new DateTime();
foreach ($products as $product) {
    // 'DOMBO DEAL' Logic
    if ($product['original_price'] > 0) {
        $discount = (($product['original_price'] - $product['price']) / $product['original_price']) * 100;
        if ($discount >= 30) {
            assignLabel($conn, $product['id'], 'DOMBO DEAL');
             $labeledProducts['DOMBO DEAL'][] = [
                'ProductID' => $product['id'],
                'Category' => $product['category_id'],
                'KeyMetricValue' => 'Discount: ' . round($discount, 2) . '%',
                'Justification' => 'Product has a discount of 30% or more.'
            ];
        }
    }

}

// 5. Output the results as JSON
echo json_encode($labeledProducts, JSON_PRETTY_PRINT);

$conn->close();
?>
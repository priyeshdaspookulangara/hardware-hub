<?php
include 'db_connect.php';

if (isset($_GET['category_name'])) {
    $categoryName = $_GET['category_name'];

    $stmt = $conn->prepare("
        SELECT p.*
        FROM products p
        JOIN categories c ON p.category_id = c.id
        WHERE c.name = ? AND p.is_featured = 1
        LIMIT 1
    ");
    $stmt->bind_param("s", $categoryName);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $images = json_decode($row['images'], true);
        $first_image = !empty($images) ? $images[0] : 'https://via.placeholder.com/300';

        echo '
        <div class="card mb-4">
            <div class="row g-0">
                <div class="col-md-4">
                    <img src="' . $first_image . '" class="img-fluid rounded-start" alt="' . htmlspecialchars($row['name']) . '">
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title">' . htmlspecialchars($row['name']) . '</h5>
                        <p class="card-text">' . htmlspecialchars($row['description']) . '</p>
                        <p class="card-text"><strong>$' . $row['price'] . '</strong> <s class="text-muted">$' . $row['original_price'] . '</s></p>
                        <a href="product.php?id=' . $row['id'] . '" class="btn btn-primary">View Details</a>
                    </div>
                </div>
            </div>
        </div>
        ';
    }
}
?>

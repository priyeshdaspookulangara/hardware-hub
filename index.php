<?php
include 'database.php';
include 'header.php';
?>

<div class="container-fluid hero-section">
    <div class="row">
        <div class="col-12 text-center p-5">
            <h1>End of Season Sale</h1>
            <p>Up to 50% off on selected items</p>
            <a href="category.php" class="btn btn-primary">Shop Now</a>
        </div>
    </div>
</div>

<div class="container mt-5">
    <h2 class="text-center mb-4">Featured Products</h2>
    <div class="row">
        <?php
        $sql = "SELECT * FROM products ORDER BY id DESC LIMIT 6";
        $result = mysqli_query($link, $sql);
        if ($result && mysqli_num_rows($result) > 0) {
            while ($product = mysqli_fetch_assoc($result)) {
                echo '
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="' . htmlspecialchars($product['image']) . '" class="card-img-top" alt="' . htmlspecialchars($product['name']) . '">
                        <div class="card-body">
                            <h5 class="card-title">' . htmlspecialchars($product['name']) . '</h5>
                            <p class="card-text">' . htmlspecialchars($product['brand']) . '</p>
                            <p class="card-text"><strong>$' . htmlspecialchars($product['price']) . '</strong> <s class="text-muted">$' . htmlspecialchars($product['original_price']) . '</s></p>
                            <a href="product.php?id=' . $product['id'] . '" class="btn btn-primary">View Details</a>
                        </div>
                    </div>
                </div>
                ';
            }
        } else {
            echo '<p class="text-center">No featured products available at the moment.</p>';
        }
        ?>
    </div>
</div>

</body>
</html>

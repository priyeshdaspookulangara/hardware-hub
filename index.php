<?php
include 'products.php';
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
        $featured_products = array_slice($products, 0, 6, true);
        foreach ($featured_products as $id => $product) {
            echo '
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="' . $product['image'] . '" class="card-img-top" alt="' . $product['name'] . '">
                    <div class="card-body">
                        <h5 class="card-title">' . $product['name'] . '</h5>
                        <p class="card-text">' . $product['brand'] . '</p>
                        <p class="card-text"><strong>$' . $product['price'] . '</strong> <s class="text-muted">$' . $product['original_price'] . '</s></p>
                        <a href="product.php?id=' . $id . '" class="btn btn-primary">View Details</a>
                    </div>
                </div>
            </div>
            ';
        }
        ?>
    </div>
</div>

</body>
</html>

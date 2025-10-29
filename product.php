<?php
include 'database.php'; // Changed from products.php to database.php
include 'header.php';

$product_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$product = null;

if ($product_id > 0) {
    // Sanitize the input
    $id = mysqli_real_escape_string($link, $product_id);

    // Fetch product from the database
    $sql = "SELECT * FROM products WHERE id = '$id'";
    $result = mysqli_query($link, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $product = mysqli_fetch_assoc($result);
        // Convert sizes and colors from comma-separated strings to arrays
        $product['sizes'] = explode(',', $product['sizes']);
        $product['colors'] = explode(',', $product['colors']);
    }
}

if (!$product) {
    echo '<div class="container mt-5"><div class="alert alert-danger">Product not found.</div></div>';
    // Optionally, you can include the footer and exit more gracefully
    // include 'footer.php';
    exit;
}
?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-6">
            <div class="position-relative">
                <img src="<?php echo $product['image']; ?>" class="img-fluid" alt="<?php echo $product['name']; ?>">
                <span class="badge bg-primary position-absolute top-0 start-0 m-3">New Arrival</span>
            </div>
            <div class="text-center mt-3">
                <span class="dot"></span>
                <span class="dot"></span>
                <span class="dot"></span>
            </div>
        </div>
        <div class="col-md-6">
            <h2><?php echo $product['name']; ?></h2>
            <p class="text-muted"><?php echo $product['brand']; ?></p>
            <h3>
                <strong>$<?php echo $product['price']; ?></strong>
                <s class="text-muted">$<?php echo $product['original_price']; ?></s>
            </h3>
            <div class="d-flex align-items-center mb-3">
                <div class="text-warning">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="far fa-star"></i>
                </div>
                <span class="ms-2 text-muted">(123 reviews)</span>
            </div>

            <div class="mb-3">
                <h5>Size</h5>
                <?php foreach ($product['sizes'] as $size) {
                    echo '<button type="button" class="btn btn-outline-secondary size-btn">' . $size . '</button>';
                } ?>
            </div>

            <div class="mb-3">
                <h5>Color</h5>
                <?php foreach ($product['colors'] as $color) {
                    echo '<div class="color-swatch" style="background-color:' . strtolower($color) . ';" data-color="' . $color . '"></div>';
                } ?>
            </div>

            <div class="d-grid gap-2">
                <button class="btn btn-primary btn-lg" id="add-to-cart-btn" data-product-id="<?php echo $product_id; ?>">Add to Cart</button>
                <button class="btn btn-outline-secondary btn-lg">
                    <i class="far fa-heart"></i> Add to Wishlist
                </button>
            </div>

            <div class="mt-4">
                <p><i class="fas fa-shipping-fast"></i> Free Shipping on orders over $50</p>
                <p><i class="fas fa-undo"></i> Free 30-day returns</p>
            </div>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col">
            <h3>Product Specifications</h3>
            <table class="table table-striped">
                <tbody>
                    <?php
                    $sql_props = "
                        SELECT cp.property_name, pp.value
                        FROM product_properties pp
                        JOIN category_properties cp ON pp.category_property_id = cp.id
                        WHERE pp.product_id = '{$product['id']}'
                    ";
                    $result_props = mysqli_query($link, $sql_props);
                    if ($result_props && mysqli_num_rows($result_props) > 0) {
                        while ($row = mysqli_fetch_assoc($result_props)) {
                            echo '<tr>';
                            echo '<td><strong>' . htmlspecialchars($row['property_name']) . '</strong></td>';
                            echo '<td>' . htmlspecialchars($row['value']) . '</td>';
                            echo '</tr>';
                        }
                    } else {
                        echo '<tr><td colspan="2">No additional specifications available.</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    var selectedSize = null;
    var selectedColor = null;

    $('.size-btn').on('click', function() {
        $('.size-btn').removeClass('btn-secondary').addClass('btn-outline-secondary');
        $(this).removeClass('btn-outline-secondary').addClass('btn-secondary');
        selectedSize = $(this).text();
    });

    $('.color-swatch').on('click', function() {
        $('.color-swatch').removeClass('selected');
        $(this).addClass('selected');
        selectedColor = $(this).data('color');
    });

    $('#add-to-cart-btn').on('click', function() {
        if (!selectedSize || !selectedColor) {
            alert('Please select a size and color.');
            return;
        }

        var productId = $(this).data('productId');

        $.ajax({
            url: 'add_to_cart.php',
            method: 'POST',
            data: {
                product_id: productId,
                size: selectedSize,
                color: selectedColor
            },
            success: function(response) {
                var data = JSON.parse(response);
                if (data.success) {
                    $('#cart-count').text(data.cart_count);
                    alert('Product added to cart!');
                } else {
                    alert('Failed to add product to cart.');
                }
            }
        });
    });
});
</script>

</body>
</html>

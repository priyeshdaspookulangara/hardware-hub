<?php
include 'products.php';
include 'header.php';
?>

<div class="container mt-5">
    <h2 class="text-center mb-4">All Products</h2>

    <div class="row">
        <div class="col-md-3">
            <div class="list-group">
                <a href="#" class="list-group-item list-group-item-action active" id="filter-all">All</a>
                <?php
                foreach ($categories as $category) {
                    echo '<a href="#" class="list-group-item list-group-item-action" data-category="' . htmlspecialchars($category['name']) . '">' . htmlspecialchars($category['name']) . '</a>';
                }
                ?>
            </div>
        </div>

        <div class="col-md-9">
            <div class="row" id="product-grid">
                <?php
                foreach ($products as $id => $product) {
                    echo '
                    <div class="col-md-4 mb-4 product-item" data-category="' . $product['category_name'] . '">
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
    </div>
</div>

<script>
$(document).ready(function() {
    $('.list-group-item').on('click', function(e) {
        e.preventDefault();

        $('.list-group-item').removeClass('active');
        $(this).addClass('active');

        var category = $(this).data('category');

        if (category) {
            $('.product-item').hide();
            $('.product-item[data-category="' + category + '"]').show();
        } else {
            $('.product-item').show();
        }
    });
});
</script>

</body>
</html>

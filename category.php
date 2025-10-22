<?php
include 'db_connect.php';
include 'header.php';
?>

<div class="container mt-5">
    <h2 class="text-center mb-4">All Products</h2>

    <div class="row">
        <div class_name="col-md-3">
            <div class_name="list-group">
                <a href="#" class_name="list-group-item list-group-item-action active" id="filter-all">All</a>
                <?php
                $stmt = $conn->prepare("SELECT * FROM categories");
                $stmt->execute();
                $result = $stmt->get_result();
                while ($row = $result->fetch_assoc()) {
                    echo '<a href="#" class="list-group-item list-group-item-action" data-category="' . $row['name'] . '">' . $row['name'] . '</a>';
                }
                ?>
            </div>
        </div>

        <div class_name="col-md-9">
            <div class_name="row" id="product-grid">
                <?php
                $stmt = $conn->prepare("SELECT p.*, c.name as category_name FROM products p JOIN categories c ON p.category_id = c.id");
                $stmt->execute();
                $result = $stmt->get_result();
                while ($row = $result->fetch_assoc()) {
                    $images = json_decode($row['images'], true);
                    $first_image = !empty($images) ? $images[0] : 'https://via.placeholder.com/300';
                    echo '
                    <div class="col-md-4 mb-4 product-item" data-category="' . $row['category_name'] . '">
                        <div class="card">
                            <img src="' . $first_image . '" class="card-img-top" alt="' . $row['name'] . '">
                            <div class="card-body">
                                <h5 class="card-title">' . $row['name'] . '</h5>
                                <p class="card-text">' . $row['brand'] . '</p>
                                <p class="card-text"><strong>$' . $row['price'] . '</strong> <s class="text-muted">$' . $row['original_price'] . '</s></p>
                                <a href="product.php?id=' . $row['id'] . '" class="btn btn-primary">View Details</a>
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

    $('#filter-all').on('click', function(e) {
        e.preventDefault();
        $('.list-group-item').removeClass('active');
        $(this).addClass('active');
        $('.product-item').show();
    });
});
</script>

</body>
</html>

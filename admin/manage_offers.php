<?php
include '../db_connect.php';
include '../header.php';

// Fetch products and categories for the dropdowns
$products = $conn->query("SELECT id, name FROM products ORDER BY name ASC")->fetch_all(MYSQLI_ASSOC);
$categories = $conn->query("SELECT id, name FROM categories ORDER BY name ASC")->fetch_all(MYSQLI_ASSOC);
$offers = $conn->query("SELECT * FROM offers ORDER BY end_date DESC")->fetch_all(MYSQLI_ASSOC);
?>

<div class="container mt-5">
    <h2 class="mb-4">Manage Offers</h2>

    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($_GET['error']); ?></div>
    <?php endif; ?>
    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success">Offer saved successfully.</div>
    <?php endif; ?>

    <!-- Create New Offer Form -->
    <div class="card mb-4">
        <div class="card-header">
            <h3>Create New Offer</h3>
        </div>
        <div class="card-body">
            <form action="save_offer.php" method="post">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label">Offer Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="offer_type" class="form-label">Offer Type</label>
                        <select class="form-select" id="offer_type" name="offer_type" required>
                            <option value="percentage">Percentage</option>
                            <option value="fixed_amount">Fixed Amount</option>
                            <option value="bogo">Buy One, Get One Free</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="discount_value" class="form-label">Discount Value</label>
                        <input type="number" step="0.01" class="form-control" id="discount_value" name="discount_value" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="scope" class="form-label">Scope</label>
                        <select class="form-select" id="scope" name="scope" required>
                            <option value="global">Global</option>
                            <option value="category">Category</option>
                            <option value="product">Product</option>
                        </select>
                    </div>
                </div>
                <div class="mb-3" id="applicable_id_container" style="display: none;">
                    <label for="applicable_id" class="form-label">Applicable To</label>
                    <select class="form-select" id="applicable_id" name="applicable_id">
                        <!-- Options will be populated by JavaScript -->
                    </select>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="coupon_code" class="form-label">Coupon Code (Optional)</label>
                        <input type="text" class="form-control" id="coupon_code" name="coupon_code">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="start_date" class="form-label">Start Date</label>
                        <input type="datetime-local" class="form-control" id="start_date" name="start_date" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="end_date" class="form-label">End Date</label>
                        <input type="datetime-local" class="form-control" id="end_date" name="end_date" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Save Offer</button>
            </form>
        </div>
    </div>

    <!-- Existing Offers Table -->
    <div class="card">
        <div class="card-header">
            <h3>Existing Offers</h3>
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Value</th>
                        <th>Scope</th>
                        <th>Coupon</th>
                        <th>Active</th>
                        <th>Expires</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($offers as $offer): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($offer['name']); ?></td>
                        <td><?php echo $offer['offer_type']; ?></td>
                        <td><?php echo $offer['discount_value']; ?></td>
                        <td><?php echo $offer['scope']; ?></td>
                        <td><?php echo htmlspecialchars($offer['coupon_code']); ?></td>
                        <td><?php echo $offer['is_active'] ? 'Yes' : 'No'; ?></td>
                        <td><?php echo $offer['end_date']; ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    var categories = <?php echo json_encode($categories); ?>;
    var products = <?php echo json_encode($products); ?>;

    $('#scope').on('change', function() {
        var scope = $(this).val();
        var applicableIdContainer = $('#applicable_id_container');
        var applicableIdSelect = $('#applicable_id');
        applicableIdSelect.empty();

        if (scope === 'category') {
            applicableIdContainer.show();
            categories.forEach(function(category) {
                applicableIdSelect.append('<option value="' + category.id + '">' + category.name + '</option>');
            });
        } else if (scope === 'product') {
            applicableIdContainer.show();
            products.forEach(function(product) {
                applicableIdSelect.append('<option value="' + product.id + '">' + product.name + '</option>');
            });
        } else {
            applicableIdContainer.hide();
        }
    });
});
</script>

</body>
</html>

<?php
include '../db_connect.php';
include '../header.php'; // Using the main site header for simplicity

// Handle form submission for adding a new property
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_property'])) {
    $categoryId = $_POST['category_id'];
    $propertyName = $_POST['property_name'];

    if (!empty($categoryId) && !empty($propertyName)) {
        $stmt = $conn->prepare("INSERT INTO category_properties (category_id, property_name) VALUES (?, ?)");
        $stmt->bind_param("is", $categoryId, $propertyName);
        $stmt->execute();
    }
}

// Fetch all categories and their properties
$categories = [];
$categoryResult = $conn->query("SELECT * FROM categories");
while ($row = $categoryResult->fetch_assoc()) {
    $categories[$row['id']] = [
        'name' => $row['name'],
        'properties' => []
    ];
}

$propertyResult = $conn->query("SELECT * FROM category_properties");
while ($row = $propertyResult->fetch_assoc()) {
    if (isset($categories[$row['category_id']])) {
        $categories[$row['category_id']]['properties'][] = $row['property_name'];
    }
}
?>

<div class="container mt-5">
    <h2 class="mb-4">Manage Category Properties</h2>

    <div class="row">
        <!-- Add Property Form -->
        <div class="col-md-4">
            <h3>Add New Property</h3>
            <form action="manage_categories.php" method="post">
                <div class="mb-3">
                    <label for="category_id" class="form-label">Category</label>
                    <select class="form-select" id="category_id" name="category_id" required>
                        <?php foreach ($categories as $id => $category) { ?>
                            <option value="<?php echo $id; ?>"><?php echo htmlspecialchars($category['name']); ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="property_name" class="form-label">Property Name</label>
                    <input type="text" class="form-control" id="property_name" name="property_name" placeholder="e.g., CPU, RAM, Screen Size" required>
                </div>
                <button type="submit" name="add_property" class="btn btn-primary">Add Property</button>
            </form>
        </div>

        <!-- Display Categories and Properties -->
        <div class="col-md-8">
            <h3>Existing Categories & Properties</h3>
            <ul class="list-group">
                <?php foreach ($categories as $category) { ?>
                    <li class="list-group-item">
                        <h5><?php echo htmlspecialchars($category['name']); ?></h5>
                        <?php if (!empty($category['properties'])) { ?>
                            <ul class="list-unstyled mt-2">
                                <?php foreach ($category['properties'] as $property) { ?>
                                    <li><span class="badge bg-secondary"><?php echo htmlspecialchars($property); ?></span></li>
                                <?php } ?>
                            </ul>
                        <?php } else { ?>
                            <p class="text-muted">No custom properties defined.</p>
                        <?php } ?>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>
</div>

</body>
</html>

<?php
include '../db_connect.php';

if (isset($_GET['category_id'])) {
    $categoryId = (int)$_GET['category_id'];

    $stmt = $conn->prepare("SELECT * FROM category_properties WHERE category_id = ?");
    $stmt->bind_param("i", $categoryId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo '<h4>Custom Properties</h4>';
        while ($row = $result->fetch_assoc()) {
            echo '<div class="mb-3">';
            echo '<label for="prop_' . $row['id'] . '" class="form-label">' . htmlspecialchars($row['property_name']) . '</label>';
            echo '<input type="text" class="form-control" id="prop_' . $row['id'] . '" name="properties[' . $row['id'] . ']">';
            echo '</div>';
        }
    }
}

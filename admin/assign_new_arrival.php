<?php
include '../db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['assign_label'])) {
    $productId = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;

    if ($productId > 0) {
        // Check if the label is already assigned to this product to avoid duplicates
        $checkStmt = $conn->prepare("SELECT id FROM product_labels WHERE product_id = ? AND label_name = 'NEW ARRIVAL'");
        $checkStmt->bind_param("i", $productId);
        $checkStmt->execute();
        $checkResult = $checkStmt->get_result();

        if ($checkResult->num_rows === 0) {
            // Insert the new label
            $stmt = $conn->prepare("INSERT INTO product_labels (product_id, label_name) VALUES (?, 'NEW ARRIVAL')");
            if ($stmt) {
                $stmt->bind_param("i", $productId);
                if ($stmt->execute()) {
                    header("Location: manage_new_arrivals.php?success=1&product_id=" . $productId);
                    exit();
                }
                $stmt->close();
            }
        } else {
            // Label already exists, redirect with an error or info message
             header("Location: manage_new_arrivals.php?error=Label already assigned to this product.");
             exit();
        }
        $checkStmt->close();
    } else {
        header("Location: manage_new_arrivals.php?error=Invalid product selected.");
        exit();
    }
}

// Redirect back if accessed directly or without proper data
header("Location: manage_new_arrivals.php");
exit();
?>

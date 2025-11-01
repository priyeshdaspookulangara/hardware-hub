<?php
include '../db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Basic validation
    if (empty($_POST['name']) || empty($_POST['offer_type']) || empty($_POST['discount_value']) || empty($_POST['scope']) || empty($_POST['start_date']) || empty($_POST['end_date'])) {
        header("Location: manage_offers.php?error=Missing required fields.");
        exit();
    }

    $name = $_POST['name'];
    $offer_type = $_POST['offer_type'];
    $discount_value = $_POST['discount_value'];
    $scope = $_POST['scope'];
    $applicable_id = ($_POST['scope'] !== 'global') ? intval($_POST['applicable_id']) : null;
    $coupon_code = !empty($_POST['coupon_code']) ? $_POST['coupon_code'] : null;
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    // Server-side validation for coupon uniqueness if provided
    if ($coupon_code) {
        $stmt = $conn->prepare("SELECT id FROM offers WHERE coupon_code = ?");
        $stmt->bind_param("s", $coupon_code);
        $stmt->execute();
        if ($stmt->get_result()->num_rows > 0) {
            header("Location: manage_offers.php?error=Coupon code already exists.");
            exit();
        }
    }

    $stmt = $conn->prepare("INSERT INTO offers (name, offer_type, discount_value, scope, applicable_id, coupon_code, start_date, end_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    if ($stmt) {
        $stmt->bind_param("ssdsisss", $name, $offer_type, $discount_value, $scope, $applicable_id, $coupon_code, $start_date, $end_date);

        if ($stmt->execute()) {
            header("Location: manage_offers.php?success=1");
        } else {
            header("Location: manage_offers.php?error=" . urlencode($stmt->error));
        }
        $stmt->close();
    } else {
        header("Location: manage_offers.php?error=Database error.");
    }

    $conn->close();
    exit();
}

// Redirect back if accessed directly
header("Location: manage_offers.php");
exit();
?>

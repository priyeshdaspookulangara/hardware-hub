<?php
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['coupon_code'])) {
    $couponCode = $_POST['coupon_code'];

    $now = date('Y-m-d H:i:s');
    $stmt = $conn->prepare("
        SELECT * FROM offers
        WHERE coupon_code = ? AND is_active = 1
        AND start_date <= ? AND end_date >= ?
    ");
    $stmt->bind_param("sss", $couponCode, $now, $now);
    $stmt->execute();
    $offer = $stmt->get_result()->fetch_assoc();

    if ($offer) {
        $_SESSION['coupon'] = $offer;
    } else {
        unset($_SESSION['coupon']);
    }
}

header("Location: cart.php");
exit();
?>

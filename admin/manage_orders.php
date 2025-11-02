<?php
include '../db_connect.php';
include '../header.php';

// Fetch all orders
$orders = $conn->query("SELECT * FROM orders ORDER BY order_date DESC")->fetch_all(MYSQLI_ASSOC);
?>

<div class="container mt-5">
    <h2 class="mb-4">Manage Orders</h2>

    <div class="card">
        <div class="card-header">
            <h3>All Orders</h3>
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                    <tr>
                        <td>#<?php echo $order['id']; ?></td>
                        <td><?php echo htmlspecialchars($order['customer_name']); ?></td>
                        <td>$<?php echo number_format($order['total_price'], 2); ?></td>
                        <td>
                            <span class="badge
                                <?php
                                    switch ($order['order_status']) {
                                        case 'pending': echo 'bg-warning'; break;
                                        case 'processing': echo 'bg-info'; break;
                                        case 'shipped': echo 'bg-primary'; break;
                                        case 'delivered': echo 'bg-success'; break;
                                        case 'cancelled': echo 'bg-danger'; break;
                                    }
                                ?>">
                                <?php echo ucfirst($order['order_status']); ?>
                            </span>
                        </td>
                        <td><?php echo $order['order_date']; ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>

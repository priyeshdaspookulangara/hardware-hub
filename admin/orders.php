<?php
$page_title = "Manage Orders";
include 'includes/header.php';

// Mockup data for orders
$mock_orders = [
    ['id' => 1, 'customer' => 'John Doe', 'date' => '2023-10-28', 'total' => 150.75, 'status' => 'Shipped'],
    ['id' => 2, 'customer' => 'Jane Smith', 'date' => '2023-10-28', 'total' => 89.99, 'status' => 'Processing'],
    ['id' => 3, 'customer' => 'Peter Jones', 'date' => '2023-10-27', 'total' => 24.50, 'status' => 'Delivered'],
    ['id' => 4, 'customer' => 'Mary Johnson', 'date' => '2023-10-26', 'total' => 300.00, 'status' => 'Shipped'],
    ['id' => 5, 'customer' => 'Chris Lee', 'date' => '2023-10-25', 'total' => 75.20, 'status' => 'Cancelled'],
];
?>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page"><?php echo $page_title; ?></li>
    </ol>
</nav>

<h1 class="mt-4"><?php echo $page_title; ?></h1>

<div class="card mt-4">
    <div class="card-header">
        All Customer Orders
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer</th>
                    <th>Date</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($mock_orders as $order): ?>
                    <tr>
                        <td><?php echo $order['id']; ?></td>
                        <td><?php echo htmlspecialchars($order['customer']); ?></td>
                        <td><?php echo $order['date']; ?></td>
                        <td>$<?php echo number_format($order['total'], 2); ?></td>
                        <td>
                            <span class="badge bg-<?php
                                switch ($order['status']) {
                                    case 'Shipped': echo 'info'; break;
                                    case 'Processing': echo 'primary'; break;
                                    case 'Delivered': echo 'success'; break;
                                    case 'Cancelled': echo 'danger'; break;
                                    default: echo 'secondary';
                                }
                            ?>"><?php echo htmlspecialchars($order['status']); ?></span>
                        </td>
                        <td>
                            <a href="#" class="btn btn-sm btn-info">View Details</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'includes/footer.php'; ?>

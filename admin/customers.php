<?php
include 'includes/header.php';

// Fetch customers from the database
$sql = "SELECT id, username, email FROM customers ORDER BY id DESC";
$result = mysqli_query($link, $sql);
$customers = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $customers[] = $row;
    }
} else {
    echo '<div class="alert alert-danger">Error fetching customers: ' . mysqli_error($link) . '</div>';
}
?>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Customers</li>
    </ol>
</nav>

<h1 class="mt-4">Manage Customers</h1>

<div class="card">
    <div class="card-header">
        <i class="fas fa-users me-1"></i>
        All Registered Customers
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($customers)): ?>
                    <?php foreach ($customers as $customer): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($customer['id']); ?></td>
                            <td><?php echo htmlspecialchars($customer['username']); ?></td>
                            <td><?php echo htmlspecialchars($customer['email']); ?></td>
                            <td>
                                <a href="#" class="btn btn-sm btn-primary disabled">View Orders</a>
                                <a href="#" class="btn btn-sm btn-danger disabled">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center">No customers found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'includes/footer.php'; ?>

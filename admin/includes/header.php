<?php
session_start();
// This path needs to be adjusted since it's in a subdirectory
include_once __DIR__ . '/../../database.php';

// Redirect to admin login if not authenticated
if (!isset($_SESSION['admin_loggedin']) || $_SESSION['admin_loggedin'] !== true) {
    // A little trick to handle the case where we are already on the login page
    // to avoid a redirect loop.
    if (basename($_SERVER['PHP_SELF']) != 'login.php') {
        header("Location: login.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-commerce Admin Panel</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom Admin CSS -->
    <link rel="stylesheet" href="assets/css/admin.css">
</head>
<body>

<div class="d-flex" id="wrapper">
    <!-- Sidebar -->
    <div class="bg-dark border-right" id="sidebar-wrapper">
        <div class="sidebar-heading text-white">Admin Panel</div>
        <div class="list-group list-group-flush">
            <a href="dashboard.php" class="list-group-item list-group-item-action bg-dark text-white"><i class="fas fa-tachometer-alt me-2"></i>Dashboard</a>
            <a href="categories.php" class="list-group-item list-group-item-action bg-dark text-white"><i class="fas fa-sitemap me-2"></i>Categories</a>
            <a href="category_properties.php" class="list-group-item list-group-item-action bg-dark text-white"><i class="fas fa-cogs me-2"></i>Category Properties</a>
            <a href="products.php" class="list-group-item list-group-item-action bg-dark text-white"><i class="fas fa-box me-2"></i>Products</a>
            <a href="orders.php" class="list-group-item list-group-item-action bg-dark text-white"><i class="fas fa-shopping-cart me-2"></i>Orders</a>
            <a href="#" class="list-group-item list-group-item-action bg-dark text-white"><i class="fas fa-users me-2"></i>Customers</a>
            <a href="#" class="list-group-item list-group-item-action bg-dark text-white"><i class="fas fa-cog me-2"></i>Settings</a>
        </div>
    </div>
    <!-- /#sidebar-wrapper -->

    <!-- Page Content -->
    <div id="page-content-wrapper">
        <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
            <div class="container-fluid">
                <button class="btn btn-primary" id="menu-toggle"><i class="fas fa-bars"></i></button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mt-2 mt-lg-0">
                        <?php if (isset($_SESSION['admin_loggedin']) && $_SESSION['admin_loggedin'] === true): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-user me-2"></i><?php echo htmlspecialchars($_SESSION['admin_username']); ?>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="#">Profile</a>
                                <a class="dropdown-item" href="#">Settings</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="logout.php">Logout</a>
                            </div>
                        </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container-fluid pt-4">
            <!-- Main content will start here -->

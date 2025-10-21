<?php
// Include the database connection file
include 'database.php';

function get_products() {
    global $link;
    $products = [];
    $sql = "SELECT p.*, c.name as category_name FROM products p JOIN categories c ON p.category_id = c.id";
    $result = mysqli_query($link, $sql);

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            // The ID from the database will be the key
            $products[$row['id']] = $row;
            // Convert sizes and colors back to arrays
            $products[$row['id']]['sizes'] = explode(',', $row['sizes']);
            $products[$row['id']]['colors'] = explode(',', $row['colors']);
        }
    }
    return $products;
}

function get_categories() {
    global $link;
    $categories = [];
    $sql = "SELECT * FROM categories";
    $result = mysqli_query($link, $sql);

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $categories[] = $row;
        }
    }
    return $categories;
}

$products = get_products();
$categories = get_categories();

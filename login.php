<?php
session_start();
include 'database.php';

if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = mysqli_real_escape_string($link, $_POST['username']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($link, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        if (password_verify($password, $user['password'])) {
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $username;
            header('Location: admin.php');
        } else {
            header('Location: index.php?error=invalid_credentials');
        }
    } else {
        header('Location: index.php?error=invalid_credentials');
    }
} else {
    header('Location: index.php');
}

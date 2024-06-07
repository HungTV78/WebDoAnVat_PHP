<?php
session_start();
include 'db.php';

if (isset($_GET['masp'])) {
    $masp = $_GET['masp'];

    // Kiểm tra nếu giỏ hàng tồn tại và sản phẩm có tồn tại trong giỏ hàng
    if (isset($_SESSION['cart']) && isset($_SESSION['cart'][$masp])) {
        // Xóa sản phẩm khỏi giỏ hàng
        unset($_SESSION['cart'][$masp]);
    }
}

// Chuyển hướng người dùng trở lại trang giỏ hàng sau khi xóa sản phẩm
header('Location: cart.php');
exit();
?>
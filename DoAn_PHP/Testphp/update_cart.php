<?php
session_start();

if (isset($_POST['quantity']) && isset($_POST['productId'])) {
    $quantity = $_POST['quantity'];
    $productId = $_POST['productId'];

    if ($quantity > 0) {
        $_SESSION['cart'][$productId] = $quantity;
    } else {
        unset($_SESSION['cart'][$productId]);
    }

    echo 'Cập nhật giỏ hàng thành công!';
}
?>

<?php
session_start();

// Check if the cart is not empty
if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {

    $paymentSuccess = true;

    if ($paymentSuccess) {
        // Clear the cart after a successful payment
        $_SESSION['cart'] = array();
        echo "Thanh toán thành công!";
    } else {
        echo "Thanh toán thất bại. Vui lòng thử lại!";
    }
} else {
    echo "Giỏ hàng trống.";
}

?>
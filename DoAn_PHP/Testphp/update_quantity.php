<?php
session_start();
include 'db.php';

if (isset($_GET['masp']) && isset($_GET['quantity'])) {
    $masp = $_GET['masp'];
    $quantity = $_GET['quantity'];

    // Kiểm tra số lượng hợp lệ (lớn hơn 0)
    if ($quantity > 0) {
        // Kiểm tra nếu giỏ hàng tồn tại
        if (isset($_SESSION['cart']) && isset($_SESSION['cart'][$masp])) {
            $_SESSION['cart'][$masp]['quantity'] = $quantity;
        }
    }
}

// Tính lại tổng giá trị
$totalValue = 0;
if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $sql = "SELECT giaban FROM sanpham WHERE masp = :masp";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':masp', $item['id']);
        $stmt->execute();
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        $totalValue += $product['giaban'] * $item['quantity'];
    }
}

// Chuyển hướng người dùng trở lại trang giỏ hàng sau khi cập nhật số lượng
header('Location: cart.php?total=' . $totalValue);
exit();
?>
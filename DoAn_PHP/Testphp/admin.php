<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['phanquyen'] !== 'Quản Lý') {
    header("Location: index.php");
    exit;
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Quản lý</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
        <header class="mb-4">
            <h1>Trang quản lý</h1>
        </header>
    <p>Chào mừng, <?php echo $_SESSION['tennd']; ?></p>
    <nav class="mb-4">
            <ul class="nav nav-pills">
                <li class="nav-item"><a class="nav-link" href="index.php">Trang chủ</a></li>
                <li class="nav-item"><a class="nav-link active" href="admin_categories.php">Quản lý danh mục</a></li>
                <li class="nav-item"><a class="nav-link" href="admin_products.php">Quản lý sản phẩm</a></li>
                <li class="nav-item"><a class="nav-link" href="admin_orders.php">Quản lý đơn hàng</a></li>
                <li class="nav-item"><a class="nav-link" href="admin_customer.php">Quản lý khách hàng</a></li>
                <li class="nav-item"><a class="nav-link" href="logout.php">Đăng xuất</a></li>
            </ul>
        </nav>
</body>
</html>

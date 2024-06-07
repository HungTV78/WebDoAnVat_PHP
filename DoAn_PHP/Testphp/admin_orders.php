<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['phanquyen'] != 'Quản Lý') {
    header('Location: login.php');
    exit();
}
include 'db.php';

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action']) && $_POST['action'] == 'update') {
        $mahd = $_POST['mahd'];
        $tinhtrang = $_POST['tinhtrang'];
        try {
            $sql = "UPDATE hoadon SET tinhtrang = ? WHERE mahd = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$tinhtrang, $mahd]);
            $success = 'Cập nhật tình trạng hóa đơn thành công.';
        } catch (PDOException $e) {
            $error = 'Lỗi khi cập nhật tình trạng hóa đơn: ' . $e->getMessage();
        }
    } elseif (isset($_POST['action']) && $_POST['action'] == 'delete') {
        $mahd = $_POST['mahd'];
        try {
            $sql = "DELETE FROM hoadon WHERE mahd = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$mahd]);
            $success = 'Xóa hóa đơn thành công.';
        } catch (PDOException $e) {
            $error = 'Lỗi khi xóa hóa đơn: ' . $e->getMessage();
        }
    }
}

$sql = "SELECT hoadon.*, khachhang.tenkh 
        FROM hoadon 
        JOIN khachhang ON hoadon.makh = khachhang.makh";
$stmt = $pdo->query($sql);
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý hóa đơn</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <header class="mb-4">
            <h1>Quản lý hóa đơn</h1>
        </header>
        <nav class="mb-4">
            <ul class="nav nav-pills">
                <li class="nav-item"><a class="nav-link" href="admin.php">Trang chủ</a></li>
                <li class="nav-item"><a class="nav-link" href="admin_categories.php">Quản lý danh mục</a></li>
                <li class="nav-item"><a class="nav-link" href="admin_products.php">Quản lý sản phẩm</a></li>
                <li class="nav-item"><a class="nav-link active" href="admin_orders.php">Quản lý hóa đơn</a></li>
                <li class="nav-item"><a class="nav-link" href="admin_customer.php">Quản lý khách hàng</a></li>
                <li class="nav-item"><a class="nav-link" href="logout.php">Đăng xuất</a></li>
            </ul>
        </nav>
        <main>
            <?php if ($success): ?>
                <div class="alert alert-success">
                    <?= $success ?>
                </div>
            <?php endif; ?>
            <?php if ($error): ?>
                <div class="alert alert-danger">
                    <?= $error ?>
                </div>
            <?php endif; ?>
            <h2>Danh sách hóa đơn</h2>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Ngày lập</th>
                        <th>Phương thức thanh toán</th>
                        <th>Tổng cộng</th>
                        <th>Chi tiết</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                    <tr>
                        <td><?= htmlspecialchars($order['mahd']) ?></td>
                        <td><?= htmlspecialchars($order['ngaylap']) ?></td>
                        <td><?= htmlspecialchars($order['phuongthuc']) ?></td>
                        <td><?= htmlspecialchars($order['tongcong']) ?></td>
                        <td>
                            <?php
                                if (!empty($order['masp']) && !empty($order['soluong']) && !empty($order['dongia']) && !empty($order['thanhtien'])) {
                                    $product_ids = explode(',', $order['masp']);
                                    $quantities = explode(',', $order['soluong']);
                                    $prices = explode(',', $order['dongia']);
                                    $total_prices = explode(',', $order['thanhtien']);
                                    for ($i = 0; $i < count($product_ids); $i++) {
                                        echo "Sản phẩm ID: {$product_ids[$i]}, Số lượng: {$quantities[$i]}, Đơn giá: {$prices[$i]}, Thành tiền: {$total_prices[$i]} <br>";
                                    }
                                } else {
                                    
                                }
                            ?>
                        </td>

                        <td>
                            <form method="POST" action="" class="d-inline-block">
                                <input type="hidden" name="action" value="update">
                                <input type="hidden" name="mahd" value="<?= htmlspecialchars($order['mahd']) ?>">
                                <div class="input-group">
                                    <select name="tinhtrang" class="form-select">
                                        <option value="Đã thanh toán" <?= $order['tinhtrang'] == 'Đã thanh toán' ? 'selected' : '' ?>>Đã thanh toán</option>
                                        <option value="Chưa thanh toán" <?= $order['tinhtrang'] == 'Chưa thanh toán' ? 'selected' : '' ?>>Chưa thanh toán</option>
                                    </select>
                                    <button type="submit" class="btn btn-warning">Cập nhật</button>
                                </div>
                            </form>
                            <form method="POST" action="" class="d-inline-block">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="mahd" value="<?= htmlspecialchars($order['mahd']) ?>">
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa hóa đơn này?');">Xóa</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </main>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

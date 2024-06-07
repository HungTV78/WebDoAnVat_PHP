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
        $makh = $_POST['makh'];
        $tenkh = $_POST['tenkh'];
        $sdt = $_POST['sdt'];
        $diemso = $_POST['diemso'];
        try {
            $sql = "UPDATE khachhang SET tenkh = ?, sdt = ?, diemso = ? WHERE makh = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$tenkh, $sdt, $diemso, $makh]);
            $success = 'Cập nhật thông tin khách hàng thành công.';
        } catch (PDOException $e) {
            $error = 'Lỗi khi cập nhật thông tin khách hàng: ' . $e->getMessage();
        }
    } elseif (isset($_POST['action']) && $_POST['action'] == 'delete') {
        $makh = $_POST['makh'];
        try {
            $sql = "DELETE FROM khachhang WHERE makh = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$makh]);
            $success = 'Xóa khách hàng thành công.';
        } catch (PDOException $e) {
            $error = 'Lỗi khi xóa khách hàng: ' . $e->getMessage();
        }
    }
}

$sql = "SELECT * FROM khachhang";
$stmt = $pdo->query($sql);
$customers = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Quản lý khách hàng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <header class="mb-4">
            <h1>Quản lý khách hàng</h1>
        </header>
        <nav class="mb-4">
            <ul class="nav nav-pills">
                <li class="nav-item"><a class="nav-link" href="admin.php">Trang chủ</a></li>
                <li class="nav-item"><a class="nav-link" href="admin_categories.php">Quản lý danh mục</a></li>
                <li class="nav-item"><a class="nav-link" href="admin_products.php">Quản lý sản phẩm</a></li>
                <li class="nav-item"><a class="nav-link" href="admin_orders.php">Quản lý hóa đơn</a></li>
                <li class="nav-item"><a class="nav-link active" href="admin_customers.php">Quản lý khách hàng</a></li>
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
            <h2>Danh sách khách hàng</h2>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên khách hàng</th>
                        <th>Số điện thoại</th>
                        <th>Điểm số</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($customers as $customer): ?>
                    <tr>
                        <td><?= htmlspecialchars($customer['makh']) ?></td>
                        <td><?= htmlspecialchars($customer['tenkh']) ?></td>
                        <td><?= htmlspecialchars($customer['sdt']) ?></td>
                        <td><?= htmlspecialchars($customer['diemso']) ?></td>
                        <td>
                            <form method="POST" action="" class="d-inline-block">
                                <input type="hidden" name="action" value="update">
                                <input type="hidden" name="makh" value="<?= htmlspecialchars($customer['makh']) ?>">
                                <div class="input-group">
                                    <input type="text" name="tenkh" value="<?= htmlspecialchars($customer['tenkh']) ?>" class="form-control" required>
                                    <input type="text" name="sdt" value="<?= htmlspecialchars($customer['sdt']) ?>" class="form-control" required>
                                    <input type="number" name="diemso" value="<?= htmlspecialchars($customer['diemso']) ?>" class="form-control" required>
                                    <button type="submit" class="btn btn-warning">Cập nhật</button>
                                </div>
                            </form>
                            <form method="POST" action="" class="d-inline-block">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="makh" value="<?= htmlspecialchars($customer['makh']) ?>">
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa khách hàng này?');">Xóa</button>
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

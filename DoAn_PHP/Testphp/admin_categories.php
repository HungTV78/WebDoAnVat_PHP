<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['phanquyen'] != 'Quản Lý') {
    header('Location: login.php');
    exit();
}
include 'db.php';

$categories = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];

        if ($action == 'add' && isset($_POST['tenloai'])) {
            $tenloai = $_POST['tenloai'];
            $sql = "INSERT INTO loaisanpham (tenloaisp) VALUES (?)"; 
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$tenloai]);
            header("Location: {$_SERVER['PHP_SELF']}");
            exit();
        } elseif ($action == 'edit' && isset($_POST['maloai']) && isset($_POST['tenloai'])) {
            $maloai = $_POST['maloai'];
            $tenloai = $_POST['tenloai'];
            $sql = "UPDATE loaisanpham SET tenloaisp = ? WHERE maloaisp = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$tenloai, $maloai]);
            header("Location: {$_SERVER['PHP_SELF']}");
            exit();
        } elseif ($action == 'delete' && isset($_POST['maloai'])) {
            $maloai = $_POST['maloai'];

            // Check if there are products associated with this category
            $check_sql = "SELECT COUNT(*) FROM sanpham WHERE maloaisp = ?";
            $check_stmt = $pdo->prepare($check_sql);
            $check_stmt->execute([$maloai]);
            $product_count = $check_stmt->fetchColumn();

            if ($product_count > 0) {
                echo "<script>alert('Không thể xóa danh mục này vì còn sản phẩm liên quan.');</script>";
            } else {
                $sql = "DELETE FROM loaisanpham WHERE maloaisp = ?";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$maloai]);
                header("Location: {$_SERVER['PHP_SELF']}");
                exit();
            }
        }
    }
}

$sql = "SELECT * FROM loaisanpham";
$stmt = $pdo->query($sql);

if ($stmt) {
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Quản lý danh mục</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <header class="mb-4">
            <h1>Quản lý danh mục</h1>
        </header>
        <nav class="mb-4">
            <ul class="nav nav-pills">
                <li class="nav-item"><a class="nav-link" href="admin.php">Trang chủ</a></li>
                <li class="nav-item"><a class="nav-link active" href="admin_categories.php">Quản lý danh mục</a></li>
                <li class="nav-item"><a class="nav-link" href="admin_products.php">Quản lý sản phẩm</a></li>
                <li class="nav-item"><a class="nav-link" href="admin_orders.php">Quản lý đơn hàng</a></li>
                <li class="nav-item"><a class="nav-link" href="admin_customer.php">Quản lý khách hàng</a></li>
                <li class="nav-item"><a class="nav-link" href="logout.php">Đăng xuất</a></li>
            </ul>
        </nav>
        <main>
            <h2>Danh sách danh mục</h2>
            <form class="mb-4" method="POST" action="">
                <input type="hidden" name="action" value="add">
                <div class="mb-3">
                    <input type="text" name="tenloai" class="form-control" placeholder="Tên danh mục" required>
                </div>
                <button type="submit" class="btn btn-primary">Thêm danh mục</button>
            </form>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên danh mục</th>
                        <th>Chỉnh sửa danh mục</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($categories)) : // Check if $categories is not empty ?>
                        <?php foreach ($categories as $category): ?>
                            <tr>
                                <td><?= htmlspecialchars($category['maloaisp']) ?></td> <!-- Corrected column name -->
                                <td><?= htmlspecialchars($category['tenloaisp']) ?></td> <!-- Corrected column name -->
                                <td>
                                    <form method="POST" action="" class="d-inline-block">
                                        <input type="hidden" name="action" value="edit">
                                        <input type="hidden" name="maloai" value="<?= htmlspecialchars($category['maloaisp']) ?>"> <!-- Corrected column name -->
                                        <div class="input-group">
                                            <input type="text" name="tenloai" class="form-control" value="<?= htmlspecialchars($category['tenloaisp']) ?>" required> <!-- Corrected column name -->
                                            <button type="submit" class="btn btn-warning">Sửa</button>
                                        </div>
                                    </form>
                                    <form method="POST" action="" class="d-inline-block">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="maloai" value="<?= htmlspecialchars($category['maloaisp']) ?>"> <!-- Corrected column name -->
                                        <button type="submit" class="btn btn-danger">Xóa</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3">Không có danh mục nào.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </main>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

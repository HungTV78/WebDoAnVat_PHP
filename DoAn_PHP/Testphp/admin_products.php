<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['phanquyen'] != 'Quản Lý') {
    header('Location: login.php');
    exit();
}
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action']) && $_POST['action'] == 'add') {
        $tensp = $_POST['tensp'];
        $giaban = $_POST['giaban'];
        $soluong = $_POST['soluong'];
        $maloaisp = $_POST['maloaisp'];
        $hinh = $_POST['hinh'];
        $sql = "INSERT INTO sanpham (tensp, giaban, soluong, maloaisp, hinh) VALUES (?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$tensp, $giaban, $soluong, $maloaisp, $hinh]);
        header("Location: {$_SERVER['PHP_SELF']}");
        exit();
    } elseif (isset($_POST['action']) && $_POST['action'] == 'edit') {
        $masp = $_POST['masp'];
        $tensp = $_POST['tensp'];
        $giaban = $_POST['giaban'];
        $soluong = $_POST['soluong'];
        $maloaisp = $_POST['maloaisp'];
        $hinh = $_POST['hinh'];
        $sql = "UPDATE sanpham SET tensp = ?, giaban = ?, soluong = ?, maloaisp = ?, hinh = ? WHERE masp = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$tensp, $giaban, $soluong, $maloaisp, $hinh, $masp]);
        header("Location: {$_SERVER['PHP_SELF']}");
        exit();
    } elseif (isset($_POST['action']) && $_POST['action'] == 'delete') {
        $masp = $_POST['masp'];
        
        try {
            // Bắt đầu giao dịch
            $pdo->beginTransaction();
            
            // Xóa các bản ghi liên quan trong bảng chitiethoadon
            $sql = "DELETE FROM chitiethoadon WHERE masp = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$masp]);
            
            // Xóa các bản ghi liên quan trong bảng chitiethoadonnhap (đã bị loại bỏ)
            // $sql = "DELETE FROM chitiethoadonnhap WHERE masp = ?";
            // $stmt = $pdo->prepare($sql);
            // $stmt->execute([$masp]);

            // Xóa sản phẩm
            $sql = "DELETE FROM sanpham WHERE masp = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$masp]);
            
            // Commit giao dịch
            $pdo->commit();
        } catch (PDOException $e) {
            // Rollback giao dịch nếu có lỗi
            $pdo->rollBack();
            throw $e;
        }

        header("Location: {$_SERVER['PHP_SELF']}");
        exit();
    }
}

// Fetch categories and products to display
$sql = "SELECT * FROM loaisanpham";
$stmt = $pdo->query($sql);
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

$sql = "SELECT * FROM sanpham";
$stmt = $pdo->query($sql);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Quản lý sản phẩm</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="ajax.js"></script>
</head>
<body>
    <div class="container mt-5">
        <header class="mb-4">
            <h1>Quản lý sản phẩm</h1>
        </header>
        <nav class="mb-4">
            <ul class="nav nav-pills">
                <li class="nav-item"><a class="nav-link" href="admin.php">Trang chủ</a></li>
                <li class="nav-item"><a class="nav-link" href="admin_categories.php">Quản lý danh mục</a></li>
                <li class="nav-item"><a class="nav-link active" href="admin_products.php">Quản lý sản phẩm</a></li>
                <li class="nav-item"><a class="nav-link" href="admin_orders.php">Quản lý đơn hàng</a></li>
                <li class="nav-item"><a class="nav-link" href="admin_customer.php">Quản lý khách hàng</a></li>              
                <li class="nav-item"><a class="nav-link" href="logout.php">Đăng xuất</a></li>
            </ul>
        </nav>
        <main>
            <h2>Danh sách sản phẩm</h2>
            <form class="mb-4" method="POST" action="">
                <input type="hidden" name="action" value="add">
                <div class="mb-3">
                    <input type="text" name="tensp" class="form-control" placeholder="Tên sản phẩm" required>
                </div>
                <div class="mb-3">
                    <input type="number" name="giaban" class="form-control" placeholder="Giá" required>
                </div>
                <div class="mb-3">
                    <input type="number" name="soluong" class="form-control" placeholder="Số lượng" required>
                </div>
                <div class="mb-3">
                    <select name="maloaisp" class="form-select" required>
                        <?php foreach ($categories as $category): ?>
                        <option value="<?= $category['maloaisp'] ?>"><?= $category['tenloaisp'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <input type="file" name="hinh" class="form-control" accept="image/*" required>
                </div>
                <button type="submit" class="btn btn-primary">Thêm sản phẩm</button>
            </form>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên sản phẩm</th>
                        <th>Giá</th>
                        <th>Số lượng</th>
                        <th>Loại</th>
                        <th>Hình ảnh</th>
                        <th>Chỉnh sửa sản phẩm</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product): ?>
                    <tr>
                        <td><?= $product['masp'] ?></td>
                        <td><?= $product['tensp'] ?></td>
                        <td><?= $product['giaban'] ?></td>
                        <td><?= $product['soluong'] ?></td>
                        <td><?= $product['maloaisp'] ?></td>
                        <td><img src="Hinh/<?= $product['hinh'] ?>" alt="<?= $product['tensp'] ?>" width="50"></td>
                        <td>
                            <form method="POST" action="" class="d-inline-block">
                                <input type="hidden" name="action" value="edit">
                                <input type="hidden" name="masp" value="<?= $product['masp'] ?>">
                                <div class="input-group">
                                    <input type="text" name="tensp" class="form-control" value="<?= $product['tensp'] ?>" required>
                                    <input type="number" name="giaban" class="form-control" value="<?= $product['giaban'] ?>" required>
                                    <input type="number" name="soluong" class="form-control" value="<?= $product['soluong'] ?>" required>
                                    <select name="maloaisp" class="form-select" required>
                                        <?php foreach ($categories as $category): ?>
                                        <option value="<?= $category['maloaisp'] ?>" <?= $product['maloaisp'] == $category['maloaisp'] ? 'selected' : '' ?>><?= $category['tenloaisp'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <input type="text" name="hinh" class="form-control" value="<?= $product['hinh'] ?>" required>
                                    <button type="submit" class="btn btn-warning">Sửa</button>
                                </div>
                            </form>
                            <form method="POST" action="" class="d-inline-block">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="masp" value="<?= $product['masp'] ?>">
                                <button type="submit" class="btn btn-danger">Xóa</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </main>
    </div>
</body>
</html>

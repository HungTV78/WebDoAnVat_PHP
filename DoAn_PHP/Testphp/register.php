<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tennd = $_POST['tennd'];
    $sdt = $_POST['sdt'];
    $diachi = $_POST['diachi'];
    $email = $_POST['email'];
    $ngaysinh = $_POST['ngaysinh'];
    $username = $_POST['username'];
    $matkhau = password_hash($_POST['matkhau'], PASSWORD_BCRYPT);
    $manhom = '2'; // default role:khách hàng

    // Check if the username already exists
    $sql_check = "SELECT * FROM nguoidung WHERE username = ?";
    $stmt_check = $pdo->prepare($sql_check);
    $stmt_check->execute([$username]);
    if ($stmt_check->rowCount() > 0) {
        $error = "Tên đăng nhập đã tồn tại. Vui lòng chọn tên khác.";
    } else {
        $sql = "INSERT INTO nguoidung (mand, tennd, sdt, diachi, email, ngaysinh, username, matkhau, manhom) 
                VALUES (UUID(), ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute([$tennd, $sdt, $diachi, $email, $ngaysinh, $username, $matkhau, $manhom])) {
            $mand = $pdo->lastInsertId(); // Get the last inserted id
            // Insert new customer into khachhang table
            $sql_khachhang = "INSERT INTO khachhang (mand, tenkh, sdt, diemso) VALUES (?, ?, ?, 0)";
            $stmt_khachhang = $pdo->prepare($sql_khachhang);
            if ($stmt_khachhang->execute([$mand, $tennd, $sdt])) {
                // Registration successful, redirect or show a success message
                echo "Đăng ký thành công!";
                header("Location: login.php");
                exit();
            } else {
                $error = "Lỗi tạo khách hàng!";
            }
        } else {
            $error = "Lỗi tạo người dùng!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container">
        
        <header>
            <h1>Shop Ăn Vặt Nhóm 14</h1>
        </header>
        
        <nav class="main-nav">
            <ul class="menu">
                <li><a href="index.php">Trang trủ</a></li>
                <li><a href="#">Khuyến mãi</a></li>
                <li><a href="#">Liên hệ</a></li>
                <li><a href="#">Giới thiệu</a></li>
                <li><a href="#">Hỗ trợ</a></li>
                <li class="user-links">
                    <?php
                    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
                        echo '<a href="logout.php">Đăng xuất</a>';
                        if ($_SESSION['phanquyen'] == 'Admin') {
                            echo '<a href="admin.php">Quản lý</a>';
                        }
                    } else {echo '<a href="login.php">Đăng nhập</a>';
                        echo '<a href="register.php">Đăng ký</a>';
                    }
                    ?>
                </li>
            </ul>
        </nav>
        <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h2 class="text-center">Register</h2>
                    </div>
                    <div class="card-body">
                <?php
                if (isset($error)) {
                    echo '<div class="alert alert-danger">' . $error . '</div>';
                }
                ?>
                <form method="POST">
                    <div class="form-group">
                        <label for="tennd">Tên người dùng:</label>
                        <input type="text" class="form-control" id="tennd" name="tennd" required>
                    </div>
                    <div class="form-group">
                        <label for="sdt">Số điện thoại:</label>
                        <input type="text" class="form-control" id="sdt" name="sdt" required>
                    </div>
                    <div class="form-group">
                        <label for="diachi">Địa chỉ:</label>
                        <input type="text" class="form-control" id="diachi" name="diachi" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="ngaysinh">Ngày tháng năm sinh:</label>
                        <input type="date" class="form-control" id="ngaysinh" name="ngaysinh" required>
                    </div>
                    <div class="form-group">
                        <label for="username">Tên đăng nhập:</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="matkhau">Mật khẩu:</label>
                        <input type="password" class="form-control" id="matkhau" name="matkhau" required>
                    </div>
                    
                    
                    <button type="submit" class="btn btn-primary btn-block">Đăng ký</button>
                </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    
</div>
</body>
</html>
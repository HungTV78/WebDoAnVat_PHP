<?php
session_start();

include 'db.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Đăng nhập</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .student-info {
            text-align: center;
            margin-top: 30px;
            padding: 20px;
        }

        .student-info h2 {
            margin-bottom: 20px;
            color: #333;
        }

        .card {
            border: none;
            border-radius: 8px;
            padding: 20px;
            margin: 10px;
            display: inline-block;
            width: 100%;
            max-width: 300px;
            transition: box-shadow 0.3s ease-in-out;
            background-color: #f8f9fa;
        }

        .card:hover {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .card p {
            margin: 0;
            font-size: 18px;
        }

        .card .student-name {
            font-weight: bold;
            color: #007bff;
        }

        .card .student-id {
            color: #6c757d;
        }
    </style>
</head>

<body>
    <div class="container">
        <header class="text-center my-4">
            <h1>Shop Ăn Vặt Nhóm 14</h1>
        </header>

        <nav class="main-nav">
            <ul class="menu">
                <li><a href="index.php">Trang chủ</a></li>
                <li><a href="khuyenmai.php">Khuyến mãi</a></li>
                <li><a href="#">Liên hệ</a></li>
                <li><a href="#">Giới thiệu</a></li>
                <li><a href="#">Hỗ trợ</a></li>
                <li class="user-links">
                    <?php
                    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
                        echo '<a href="logout.php">Đăng xuất</a>';
                        if ($_SESSION['quyen'] == 1) {
                            echo '<a href="admin.php">Quản lý</a>';
                        }
                    } else {
                        echo '<a href="login.php">Đăng nhập</a>';
                        echo '<a href="register.php">Đăng ký</a>';
                    }
                    ?>
                </li>
            </ul>
        </nav>

        <div class="student-info">
            <h2>Thông tin sinh viên</h2>
            <div class="row justify-content-center">
                <div class="col-md-4">
                    <div class="card">
                        <p class="student-name">Trần Tiến Danh</p>
                        <p class="student-id">MSSV: 2001215654</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <p class="student-name">Nguyễn Xuân Thắng</p>
                        <p class="student-id">MSSV: 2001216166</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <p class="student-name">Lê Tấn Hưng</p>
                        <p class="student-id">MSSV: 2001210520</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
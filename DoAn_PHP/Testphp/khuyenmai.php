<?php
session_start();

include 'db.php';
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Khuyến mãi</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/boxicons/2.1.0/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <style>
        .main-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 70vh;
            text-align: center;
        }

        .voucher-message {
            font-size: 24px;
            font-weight: bold;
            color: #ff5722;
            margin: 20px 0;
        }

        .use-now-button {
            display: inline-block;
            padding: 10px 20px;
            font-size: 18px;
            color: #fff;
            background-color: #ff5722;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            margin-top: 10px;
        }

        .customer-info {
            margin-bottom: 20px;
        }

        .customer-info table {
            border-collapse: collapse;
            width: 100%;
        }

        .customer-info th, .customer-info td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        .customer-info th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #f2f2f2;
            color: black;
        }
    </style>
</head>

<body>
    <div class="container">
        <header>
            <h1>Shop Ăn Vặt Nhóm 14</h1>
        </header>

        <nav class="main-nav">
            <ul class="menu">
                <li><a href="index.php">Trang chủ</a></li>
                <li><a href="#">Khuyến mãi</a></li>
                <li><a href="#">Liên hệ</a></li>
                <li><a href="introduce.php">Giới thiệu</a></li>
                <li class="user-links">
                    <?php
                    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
                        echo '<a href="logout.php">Đăng xuất</a>';
                        if ($_SESSION['quyen'] == '1') {
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

        <main>
            <div class="main-content">
                <?php
                if (isset($_SESSION['mand'])) {
                    $mand = intval($_SESSION['mand']);
                    $sql = "
                        SELECT kh.makh, kh.diemso, nd.tennd, nd.sdt 
                        FROM khachhang kh
                        JOIN nguoidung nd ON kh.mand = nd.mand
                        WHERE kh.mand = :mand
                    ";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute(['mand' => $mand]);
                    $customer = $stmt->fetch(PDO::FETCH_ASSOC);

                    if ($customer) {
                        echo '<div class="customer-info">';
                        echo '<table>';
                        echo '<tr><th>Mã khách hàng</th><td>' . htmlspecialchars($customer['makh']) . '</td></tr>';
                        echo '<tr><th>Tên khách hàng</th><td>' . htmlspecialchars($customer['tennd']) . '</td></tr>';
                        echo '<tr><th>Số điện thoại</th><td>' . htmlspecialchars($customer['sdt']) . '</td></tr>';
                        echo '<tr><th>Điểm số</th><td>' . htmlspecialchars($customer['diemso']) . '</td></tr>';
                        echo '</table>';
                        echo '</div>';

                        if ($customer['diemso'] >= 50) {
                            echo '<div class="voucher-message">Bạn có voucher 50%!</div>';
                        } elseif ($customer['diemso'] >= 25) {
                            echo '<div class="voucher-message">Bạn có voucher 25%!</div>';
                        } else {
                            echo '<div class="voucher-message">Bạn không có voucher.</div>';
                        }
                        echo '<a href="cart.php" class="use-now-button">Dùng ngay</a>';
                    } else {
                        echo "Không tìm thấy thông tin khách hàng.";
                    }
                } else {
                    echo "Bạn cần đăng nhập để xem thông tin khuyến mãi.";
                }
                ?>
            </div>
        </main>

        <footer>
            <div class="footer-container">
                <div class="footer-section">
                    <h3>ĂN VẶT 247</h3>
                    <p>Giao hàng mọi nơi trong thời gian nhanh nhất, nhận hàng nhanh chóng. Hình ảnh chụp thật 100%, đảm bảo sản phẩm đúng như hình đăng.</p>
                    <p>Liên hệ tư vấn nhanh chóng khi khách hàng đặt sản phẩm.</p>
                    <div class="contact-buttons">
                        <a href="zalo://chat" class="chat-button zalo">Chat Zalo</a>
                        <a href="https://www.facebook.com/profile.php?id=100039226352484" class="chat-button facebook">Chat Facebook</a>
                        <p class="hotline">Hotline: 0986.978.978</p>
                    </div>
                </div>
                <div class="footer-section">
                    <h3>THÔNG TIN LIÊN HỆ</h3>
                    <p>ĂN VẶT 247</p>
                    <p>140 Lê Trọng Tấn - TP Hồ Chí Minh</p>
                    <p>Email: hungle78.com.vn@gmail.com</p>
                    <p>Điện thoại: 0986.879.879</p>
                    <p>Hotline: 0986.978.978</p>
                </div>
                <div class="footer-section">
                    <h3>FANPAGE FACEBOOK</h3>
                    <div class="facebook-page">
                        <a href="https://www.facebook.com" target="_blank">
                            <img src="./Hinh/footer.jpg" alt="Facebook Page">
                        </a>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2024 Thiết kế website Ăn Vặt bởi nhom14.com.vn</p>
            </div>
        </footer>
    </div>
</body>
</html>

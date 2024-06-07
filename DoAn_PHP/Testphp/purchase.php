<?php
session_start();
include 'db.php';

// Lấy thông tin người dùng từ session
$mand = isset($_SESSION['mand']) ? $_SESSION['mand'] : null;

// Kiểm tra giỏ hàng và tính tổng tiền
$totalAmount = 0;
if (isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $productId => $quantity) {
        $sql = "SELECT giaban FROM sanpham WHERE masp = :masp";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':masp', $productId);
        $stmt->execute();
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        $totalAmount += $product['giaban'] * $quantity;
    }
}

// Nếu có giá trị tổng cộng từ form, cập nhật lại $totalAmount
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tongcong'])) {
    $totalAmount = $_POST['tongcong'];
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh toán</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            width: 100%;
            margin: 0 auto;
        }
        label {
            display: block;
            margin: 15px 0 5px;
            color: #555;
        }
        input[type="text"], select, input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            width: 100%;
            margin-top: 10px;
        }
        button:hover {
            background-color: #45a049;
        }
        .payment-option {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }
        .payment-option img {
            width: 40px;
            margin-right: 10px;
        }
        .payment-option input {
            margin-right: 10px;
        }
        .voucher-buttons button {
            background-color: #ff9800;
            width: calc(50% - 5px);
            margin: 5px;
        }
        .voucher-buttons button:hover {
            background-color: #e68900;
        }
    </style>
</head>
<body>

<form method="POST">
<h1>Thanh toán</h1>
    <label for="phuongthuc">Phương thức thanh toán</label>  
    <div class="payment-option">
        <input type="radio" id="tienmat" name="phuongthuc" value="Tiền mặt" required>
        <img src="Hinh/tienmat.jpg" alt="Cash Logo">
        <label for="tienmat">Tiền mặt</label>
    </div>
    <div class="payment-option">
        <input type="radio" id="atm" name="phuongthuc" value="ATM" required>
        <label for="atm">Thẻ ATM</label>
        <img class="atm-logo" src="Hinh/techcombank.png" alt="Techcombank Logo">
        <img class="atm-logo" src="Hinh/viettinbank.png" alt="Viettinbank Logo">
        <img class="atm-logo" src="Hinh/mbbank.png" alt="MB Bank Logo">
        <img class="atm-logo" src="Hinh/bidv.jpg" alt="BIDV Logo">
        <img class="atm-logo" src="Hinh/tpbank.png" alt="TPbank Logo">
        <img class="atm-logo" src="Hinh/vietcombank.png" alt="Vietcombank Logo">
    </div>

    <label for="tongcong">Tổng cộng</label>
    <input type="text" id="tongcong" name="tongcong" value="<?php echo $totalAmount; ?>" readonly>
    <input type="hidden" id="tongcong_hidden" name="tongcong" value="<?php echo $totalAmount; ?>">
    <?php
    if ($mand) {
        // Lấy thông tin khách hàng từ bảng nguoidung
        $sql = "SELECT khachhang.mand, khachhang.diemso FROM khachhang
                        INNER JOIN nguoidung ON khachhang.mand = nguoidung.mand
                        WHERE khachhang.mand = :mand";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':mand', $mand);
        $stmt->execute();
        $customer = $stmt->fetch(PDO::FETCH_ASSOC);

        // Nếu tìm thấy thông tin khách hàng
        if ($customer) {
            $diemso = $customer['diemso'];

            // Hiển thị nút voucher nếu điểm số đủ
            if ($diemso >= 25) {
                echo "<button type='submit' name='voucher_25'>Sử dụng voucher 25%</button>";
            }
            if ($diemso >= 50) {
                echo "<button type='submit' name='voucher_50'>Sử dụng voucher 50%</button>";
            }
        }
    }

// Xử lý khi ấn nút sử dụng voucher
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['voucher_25'])) {
        $totalAmount *= 0.75; // Giảm 25%
    } elseif (isset($_POST['voucher_50'])) {
        $totalAmount *= 0.5; // Giảm 50%
    }
}



// Kiểm tra nếu người dùng đã ấn nút "Thanh toán"
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['voucher_25']) && !isset($_POST['voucher_50'])) {
    // Lưu hóa đơn vào cơ sở dữ liệu
    $ngaylap = date('Y-m-d');
    $phuongthuc = $_POST['phuongthuc'];
    $mand = $_SESSION['mand'];
    $makh = isset($_SESSION['makh']) ? $_SESSION['makh'] : null;

    $sql = "INSERT INTO hoadon (ngaylap, phuongthuc, tongcong, mand, makh)
                    VALUES (:ngaylap, :phuongthuc, :tongcong, :mand, :makh)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':ngaylap', $ngaylap);
    $stmt->bindParam(':phuongthuc', $phuongthuc);
    $stmt->bindParam(':tongcong', $totalAmount);
    $stmt->bindParam(':mand', $mand);
    $stmt->bindParam(':makh', $makh);
    $stmt->execute();

    $mahd = $pdo->lastInsertId();

    foreach ($_SESSION['cart'] as $productId => $quantity) {
        $sql = "SELECT giaban FROM sanpham WHERE masp = :masp";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':masp', $productId);
        $stmt->execute();
        $product = $stmt->fetch(PDO::FETCH_ASSOC);
        $dongia = $product['giaban'];
        $thanhtien = $dongia * $quantity;

        $sql = "INSERT INTO chitiethoadon (masp, soluong, dongia, thanhtien, mahd)
                        VALUES (:masp, :soluong, :dongia, :thanhtien, :mahd)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':masp', $productId);
        $stmt->bindParam(':soluong', $quantity);
        $stmt->bindParam(':dongia', $dongia);
        $stmt->bindParam(':thanhtien', $thanhtien);
        $stmt->bindParam(':mahd', $mahd);
        $stmt->execute();
    }

    unset($_SESSION['cart']);
       
    
    echo "<script>
        alert('Thanh toán thành công!\\nNgày lập: $ngaylap\\nPhương thức: $phuongthuc\\nTổng cộng: $totalAmount');
        window.location.href = 'cart.php';
    </script>";

    // Ngăn chặn mã JavaScript được thực thi nếu đã có thông báo thành công
    exit();

}

?>
<button type="submit" >Thanh toán</button>
</form>
        <div class="payment-option">
            <form class="" method="POST" target="_blank" enctype="application/x-www-form-urlencoded" action="xulythanhtoanmomo.php">
                <input type="submit" value="Thanh toán Momo QRcode" class="btn btn-danger">
            </form>
        </div>
        <div class="payment-option">
            <form action="xulythanhtoanmomoatm.php" method="post" target="_blank" enctype="application/x-www-form-urlencoded">
                <input type="submit" value="Thanh toán Momo ATM" class="btn btn-danger">
            </form>
        </div>
</body>
</html>
<script>
    // Bắt sự kiện khi người dùng ấn vào nút sử dụng voucher
    document.querySelectorAll('button[name^="voucher"]').forEach(function(button) {
        button.addEventListener('click', function(event) {
            // Ngăn chặn hành vi mặc định của form (tức là không submit form)
            event.preventDefault();
            // Lấy giá trị của voucher từ tên nút (25 hoặc 50)
            var voucherValue = parseInt(this.name.split('_')[1]);
            // Cập nhật giá trị tổng cộng trên form
            var totalAmountField = document.getElementById('tongcong');
            var hiddenTotalAmountField = document.getElementById('tongcong_hidden');
            var currentTotal = parseFloat(hiddenTotalAmountField.value);
            var newTotal = currentTotal * (1 - voucherValue / 100);
            totalAmountField.value = newTotal;
            hiddenTotalAmountField.value = newTotal; // Cập nhật giá trị ẩn
        });
    });
</script>

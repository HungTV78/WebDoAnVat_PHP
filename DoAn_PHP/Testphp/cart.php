<?php
session_start();
include 'db.php';

// Kiểm tra nếu giỏ hàng không tồn tại hoặc không phải là mảng, khởi tạo lại
if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

// Xử lý thêm sản phẩm vào giỏ hàng
if (isset($_GET['masp'])) {
    $productId = $_GET['masp'];

    // Kiểm tra xem masp có tồn tại không
    // Và nếu tồn tại, thêm sản phẩm vào giỏ hàng
    if ($productId) {
        if (array_key_exists($productId, $_SESSION['cart'])) {
            $_SESSION['cart'][$productId]++;
        } else {
            $_SESSION['cart'][$productId] = 1;
        }
        echo "Thêm sản phẩm vào giỏ hàng thành công!";
        exit;
    }
}

// Xử lý xóa sản phẩm khỏi giỏ hàng
if (isset($_GET['remove'])) {
    $productId = $_GET['remove'];

    if (isset($_SESSION['cart'][$productId])) {
        unset($_SESSION['cart'][$productId]);
        echo 'Xóa sản phẩm thành công!';
    } else {
        echo 'Sản phẩm không tồn tại trong giỏ hàng.';
    }
    exit;
}

// Tính tổng tiền của các sản phẩm trong giỏ hàng
$totalAmount = 0;
if (!empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $productId => $quantity) {
        $sql = "SELECT giaban FROM sanpham WHERE masp = :masp";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':masp', $productId);
        $stmt->execute();
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        $totalAmount += $product['giaban'] * $quantity;
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
            text-align: left;
        }
    
        .button {
            background-color: #4CAF50; /* Green */
            border: none;
            color: white;
            padding: 10px 24px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
        }
        .button a {
            color: white;
            text-decoration: none;
        }
    </style>
    <script>
        function updateQuantity(quantity, productId, price) {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "update_cart.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    document.getElementById('tong-' + productId).innerHTML = price * quantity;
                    location.reload();
                }
            };
            xhr.send("quantity=" + quantity + "&productId=" + productId);
        }

        function removeProduct(productId) {
            var xhr = new XMLHttpRequest();
            xhr.open("GET", "cart.php?remove=" + productId, true);
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    location.reload();
                }
            };
            xhr.send();
        }
    </script>
</head>
<body>
    <div class="container">
        <?php
            if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
            echo 'Giỏ hàng trống.';
        } else {
            echo '<h1>Giỏ hàng</h1>';
            echo '<table>';
            echo '<tr><th>Tên sản phẩm</th><th>Giá bán</th><th>Số lượng</th><th>Hình ảnh</th><th>Tổng</th><th></th></tr>';

            foreach ($_SESSION['cart'] as $productId => $quantity) {
                // Lấy thông tin sản phẩm từ cơ sở dữ liệu
                $sql = "SELECT tensp, giaban, hinh FROM sanpham WHERE masp = :masp";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':masp', $productId);
                $stmt->execute();
                $product = $stmt->fetch(PDO::FETCH_ASSOC);

                // Tính giá trị tổng
                $tong = $product['giaban'] * $quantity;

                echo '<tr>';
                echo '<td>' . $product['tensp'] . '</td>';
                echo '<td>' . $product['giaban'] . '</td>';
                echo '<td><input type="number" min="1" value="' . $quantity . '" onchange="updateQuantity(this.value, ' . $productId . ', ' . $product['giaban'] . ')"></td>';
                echo '<td><img src="Hinh/' . $product['hinh'] . '" alt="Hình sản phẩm" width="100"></td>';
                echo '<td id="tong-' . $productId . '">' . $tong . '</td>';
                echo '<td><button class="button" onclick="removeProduct(' . $productId . ')">Xóa</button></td>';
                echo '</tr>';
            }

            echo '</table>';
            echo '<button class="button"><a href="purchase.php">Thanh toán</a></button>';
        }
        ?>
        <a href="index.php">
        <button class="button">Trở về</button>
        </a>
    </div>
    
</body>
</html>

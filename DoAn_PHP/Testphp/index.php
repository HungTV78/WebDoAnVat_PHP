<?php
session_start();

include 'db.php';

// Truy vấn tổng số lượng sản phẩm từ cơ sở dữ liệu
$total_products_query = "SELECT COUNT(*) AS total FROM sanpham";
$total_products_result = $pdo->query($total_products_query);
$total_products_row = $total_products_result->fetch(PDO::FETCH_ASSOC);
$total_products = $total_products_row['total'];

// Số lượng sản phẩm hiển thị trên mỗi trang
$per_page = 6;

// Tính toán tổng số trang
$total_pages = ceil($total_products / $per_page);

// Xác định trang hiện tại
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$current_page = max(1, min($current_page, $total_pages)); // Ensure current_page is within valid range

// Tính toán trang tiếp theo
$next_page = min($current_page + 1, $total_pages);

// Tính toán offset (vị trí bắt đầu của sản phẩm trong trang hiện tại)
$offset = ($current_page - 1) * $per_page;

// Truy vấn dữ liệu từ bảng "loaisanpham"
$query = "SELECT * FROM loaisanpham";
$result = $pdo->query($query);
$loaisanpham = $result->fetchAll(PDO::FETCH_ASSOC);

// Kiểm tra nếu có tham số "maloaisp" trong URL
if (isset($_GET['maloaisp'])) {
    $maloaisp = $_GET['maloaisp'];

    // Truy vấn dữ liệu sản phẩm tương ứng với loại sản phẩm được chọn
    $query = "SELECT * FROM sanpham WHERE maloaisp = :maloaisp LIMIT :per_page OFFSET :offset";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':maloaisp', $maloaisp, PDO::PARAM_INT);
    $stmt->bindParam(':per_page', $per_page, PDO::PARAM_INT);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else if (isset($_GET['search'])) {
    $searchTerm = $_GET['search'];
    // Truy vấn dữ liệu sản phẩm tương ứng với từ khóa tìm kiếm
    $query = "SELECT * FROM sanpham WHERE tensp LIKE :searchTerm LIMIT :per_page OFFSET :offset";
    $stmt = $pdo->prepare($query);
    $stmt->bindValue(':searchTerm', '%' . $searchTerm . '%', PDO::PARAM_STR);
    $stmt->bindParam(':per_page', $per_page, PDO::PARAM_INT);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    // Truy vấn dữ liệu từ bảng "sanpham" với offset tính được
    $query = "SELECT * FROM sanpham LIMIT :per_page OFFSET :offset";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':per_page', $per_page, PDO::PARAM_INT);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    // Nếu đã đăng nhập, hiển thị nút giỏ hàng
    $cart_link = '<a href="cart.php">';
} else {
    // Nếu chưa đăng nhập, hiển thị thông báo và không cho truy cập giỏ hàng
    $cart_link = '<a href="javascript:void(0)" onclick="showLoginMessage()">';
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang chủ</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/boxicons/2.1.0/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="container">
        <header>
            <h1>Shop Ăn Vặt Nhóm 14</h1>
        </header>

        <nav class="main-nav">
            <ul class="menu">
                <li><a href="index.php">Trang chủ</a></li>
                <li><a href="khuyenmai.php">Khuyến mãi</a></li>
                <li><a href="#">Liên hệ</a></li>
                <li><a href="introduce.php">Giới thiệu</a></li>
                <li><a href="#">Hỗ trợ</a></li>
                <li class="user-links">
                    <?php
                    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
                        if (isset($_SESSION['google_name'])) {
                            echo 'Welcome, ' . $_SESSION['google_name'] . '!';
                        } elseif (isset($_SESSION['tennd'])) {
                            echo 'Welcome, ' . $_SESSION['tennd'] . '!';
                        }
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
            <div class="search-bar-container">
                <form method="GET" action="index.php" class="search-form">
                    <input type="text" id="search" name="search" placeholder="Tìm kiếm sản phẩm...">
                    <button type="submit" class="search-button">Tìm kiếm</button>
                </form>
                <div class="cart-container">
                    <button class="cart-button">
                        <?php echo $cart_link; ?>
                        <div class="cart-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-cart4" viewBox="0 0 16 16">
                                <path d="M0 2.5A.5.5 0 0 1 .5 2H2a.5.5 0 0 1 .485.379L2.89 4H14.5a.5.5 0 0 1 .485.621l-1.5 6A.5.5 0 0 1 13 11H4a.5.5 0 0 1-.485-.379L1.61 3H.5a.5.5 0 0 1-.5-.5zM3.14 5l.5 2H5V5zM6 5v2h2V5zm3 0v2h2V5zm3 0v2h1.36l.5-2zm1.11 3H12v2h.61zM11 8H9v2h2zM8 8H6v2h2zM5 8H3.89l.5 2H5zm0 5a1 1 0 1 0 0 2 1 1 0 0 0 0-2m-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0m9-1a1 1 0 1 0 0 2 1 1 0 0 0 0-2m-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0"></path>
                            </svg>
                            <span id="cart-count">
                                <?php echo isset($_SESSION['GioHang']) ? count($_SESSION['GioHang']) : '0'; ?>
                            </span>
                        </div>
                        </a>
                    </button>
                </div>
            </div>

            <div class="sidebar">
                <h3>Danh mục sản phẩm</h3>
                <ul>
                    <?php foreach ($loaisanpham as $loai) : ?>
                        <li class="category"><a href="index.php?maloaisp=<?php echo $loai['maloaisp']; ?>"><?php echo $loai['tenloaisp']; ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php if (!empty($products)) { ?>
                <div class="product-list">
                    <?php foreach ($products as $product) : ?>
                        <div class="product-item">
                            <div class="sanphamimg">
                                <?php
                                $image_path = 'Hinh/' . $product['hinh'];
                                if (file_exists($image_path)) {
                                    echo '<img src="' . $image_path . '" alt="' . ($product['tensp'] ?? 'Unknown Product') . '">';
                                } else {
                                    echo '<img src="Hinh/khoga.jpg" alt="Unknown Product">';
                                }
                                ?>
                                <div class="button-overlay">
                                    <button onclick="showProductDetails(<?= $product['masp'] ?>)">Xem chi tiết</button>
                                </div>
                            </div>
                            <h3><?= isset($product['tensp']) ? $product['tensp'] : 'Unknown Product' ?></h3>
                            <p>Giá: <?= isset($product['giaban']) ? number_format($product['giaban']) : '0' ?> đ</p>
                            <p>Tình trạng: <?= isset($product['trangthai']) ? $product['trangthai'] : 'Unknown' ?></p>
                            <button class="button">Mua hàng</button>
                            <button class="add-to-cart" id="add-to-cart-<?= $product['masp'] ?>" data-masp="<?= $product['masp'] ?>">Thêm vào giỏ</button>
                        </div>
                    <?php endforeach; ?>
                </div>
                <!-- //phân trang -->
                <div class="pagination ">
                    <a href="?page=<?= max($current_page - 1, 1) ?>">&laquo; Prev</a>
                    <a href="?page=<?= $next_page ?>">Next &raquo;</a>
                </div>
            <?php } else { ?>
                <p>Không tìm thấy sản phẩm.</p>
            <?php } ?>

            <!-- chi tiết sản phẩm -->
            <div class="product-details" id="product-details">
                <button class="close-button" onclick="hideProductDetails()">Đóng</button>
                <div class="product-header">
                    <h2 id="product-title"></h2>
                    <img id="product-image" alt="">
                </div>
                <div class="product-content">
                    <p id="product-status"></p>
                    <p id="product-description"></p>
                    <p id="product-quantity"></p>
                    <p id="product-price"></p>
                </div>
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

    <script>
    // Xử lý nút thêm vào giỏ
    const buttons = document.querySelectorAll('.add-to-cart');

    buttons.forEach(button => {
        button.addEventListener('click', async () => {
            const isLoggedIn = <?= json_encode(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) ?>;
            if (!isLoggedIn) {
                alert("Bạn cần đăng nhập để thêm sản phẩm vào giỏ hàng.");
                return;
            }

            const productId = button.dataset.masp;

            try {
                const response = await fetch(`cart.php?masp=${encodeURIComponent(productId)}`);

                if (response.ok) {
                    const cartCountElement = document.getElementById('cart-count');
                    const currentCount = parseInt(cartCountElement.textContent);
                    cartCountElement.textContent = currentCount + 1;
                    alert("Thêm vào giỏ thành công!");
                } else {
                    alert("Có lỗi xảy ra khi thêm vào giỏ.");
                }
            } catch (error) {
                console.error('Error adding to cart:', error);
                alert("Có lỗi xảy ra khi thêm vào giỏ.");
            }
        });
    });

    // Xử lý hiển thị chi tiết sản phẩm
    function showProductDetails(masp) {
        const product = <?= json_encode($products) ?>.find(item => item.masp == masp);
        if (product) {
            document.getElementById('product-title').textContent = product.tensp;
            document.getElementById('product-image').src = 'Hinh/' + product.hinh;
            document.getElementById('product-status').textContent = 'Tình trạng: ' + product.trangthai;
            document.getElementById('product-description').textContent = 'Mô tả: ' + product.mota;
            document.getElementById('product-quantity').textContent = 'Số lượng: ' + product.soluong;
            document.getElementById('product-price').textContent = 'Giá bán: ' + product.giaban + ' đ';

            document.getElementById('product-details').style.display = 'block';
        }
    }

    function hideProductDetails() {
        document.getElementById('product-details').style.display = 'none';
    }

    // Cảnh báo đăng nhập
    function showLoginMessage() {
        alert("Vui lòng đăng nhập để xem giỏ hàng!");
    }

    // Xử lý phân trang
    const currentPage = <?= $current_page ?>;
    const totalPages = <?= $total_pages ?>;
    document.querySelector('.pagination .prevPage').setAttribute('href', `index.php?page=${Math.max(currentPage - 1, 1)}`);
    document.querySelector('.pagination .nextPage').setAttribute('href', `index.php?page=${Math.min(currentPage + 1, totalPages)}`);
</script>
</body>
</html>

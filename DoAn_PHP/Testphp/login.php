<?php
session_start();
require_once './vendor/autoload.php';
include 'db.php';

$clientID = '139865135539-a0shmo7ov13hnq8bc803g1tdi9j0uvrm.apps.googleusercontent.com';
$clientSecret = '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';
$redirectUrl = 'http://localhost:3333/DoAn_PHP/Testphp/login.php';

$client = new Google_Client();
$client->setClientId($clientID);
$client->setClientSecret($clientSecret);
$client->setRedirectUri($redirectUrl);
$client->addScope("profile");
$client->addScope("email");

if (isset($_GET['code'])) {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    $client->setAccessToken($token);

    $oauth2 = new Google_Service_Oauth2($client);
    $google_info = $oauth2->userinfo->get();
    $email = $google_info->email;
    $name = $google_info->name;

    $_SESSION['loggedin'] = true;
    $_SESSION['google_name'] = $name;
    $_SESSION['google_email'] = $email;
    $_SESSION['quyen'] = 2;

    header("Location: index.php");
    exit();
}


$error = ''; // KHởi tạo biến lỗi

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['username']) && isset($_POST['matkhau'])) {
        $tendn = $_POST['username'];
        $matkhau = $_POST['matkhau'];

        $tendn = filter_var($tendn, FILTER_SANITIZE_STRING);

        // Truy vấn để kiểm tra thông tin đăng nhập
        $sql = "SELECT * FROM nguoidung WHERE username = ?";
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute([$tendn])) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // Kiểm tra xem người dùng tồn tại và mật khẩu có đúng không
            if ($user && password_verify($matkhau, $user['matkhau'])) {
                // Lấy thông tin nhóm người dùng
                $sql_nhom = "SELECT * FROM nhomnguoidung WHERE manhom = ?";
                $stmt_nhom = $pdo->prepare($sql_nhom);
                if ($stmt_nhom->execute([$user['manhom']])) {
                    $nhom = $stmt_nhom->fetch(PDO::FETCH_ASSOC);

                    // Lưu thông tin đăng nhập vào session
                    $_SESSION['loggedin'] = true;
                    $_SESSION['mand'] = $user['mand'];
                    $_SESSION['tennd'] = $user['tennd'];
                    $_SESSION['phanquyen'] = $nhom['tennhom'];
                    $_SESSION['quyen'] = $nhom['quyen']; // Lưu quyền để sử dụng trong phần kiểm tra menu

                    // Định hướng người dùng đến trang chính hoặc trang admin
                    if ($nhom['tennhom'] == 'Quản Lý') {
                        header("Location: index.php");
                    } else {
                        header("Location: index.php");
                    }
                    exit();
                } else {
                    $error = "Lỗi truy vấn cơ sở dữ liệu nhóm người dùng!";
                }
            } else {
                $error = "Tên đăng nhập hoặc mật khẩu không chính xác!";
            }
        } else {
            $error = "Lỗi truy vấn cơ sở dữ liệu người dùng!";
        }
    } else {
        $error = "Vui lòng nhập tên đăng nhập và mật khẩu!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Đăng nhập</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
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
            <li><a href="#">Giới thiệu</a></li>
            <li><a href="#">Hỗ trợ</a></li>
            <li class="user-links">
                <?php
                if(isset($_SESSION['l   oggedin']) && $_SESSION['loggedin'] === true) {
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

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h2 class="text-center">Đăng nhập</h2>
                    </div>
                    <div class="card-body">
                        <?php
                        if (!empty($error)) {
                            echo '<div class="alert alert-danger">' . $error . '</div>';
                        }
                        ?>
                        <form method="POST">
                            <div class="form-group">
                                <label for="username">Tên đăng nhập:</label>
                                <input type="text" class="form-control" id="username" name="username" required>
                            </div>
                            <div class="form-group">
                                <label for="matkhau">Mật khẩu:</label>
                                <input type="password" class="form-control" id="matkhau" name="matkhau" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Đăng nhập</button>
                            <a href="<?php echo $client->createAuthUrl(); ?>" class="btn btn-danger btn-block mt-2">Login with Google</a>
                        </form>
                    
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</div>
</body>
</html>

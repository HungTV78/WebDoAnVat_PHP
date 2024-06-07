<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "qldoan";

// Kết nối database bằng PDO
try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Lỗi kết nối: " . $e->getMessage());
}

// Lấy dữ liệu sản phẩm từ database
$sql = "SELECT * FROM sanpham";
$stmt = $pdo->query($sql);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

$sql = "SELECT * FROM loaisanpham";
$stmt = $pdo->query($sql);
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

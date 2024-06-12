-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: sql212.byetcluster.com
-- Thời gian đã tạo: Th6 11, 2024 lúc 10:59 PM
-- Phiên bản máy phục vụ: 10.4.17-MariaDB
-- Phiên bản PHP: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `b33_36325743_qldan`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chitiethoadon`
--

CREATE TABLE `chitiethoadon` (
  `macthd` int(11) NOT NULL,
  `masp` int(11) DEFAULT NULL,
  `soluong` int(11) DEFAULT NULL,
  `dongia` float DEFAULT NULL,
  `thanhtien` float DEFAULT NULL,
  `mahd` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `chitiethoadon`
--

INSERT INTO `chitiethoadon` (`macthd`, `masp`, `soluong`, `dongia`, `thanhtien`, `mahd`) VALUES
(2, 4, 1, 150000, 150000, 2),
(3, 5, 1, 160000, 160000, 2),
(4, 6, 1, 15000, 15000, 3),
(5, 7, 1, 20000, 20000, 3),
(6, 2, 2, 35000, 70000, 4),
(7, 3, 1, 45000, 45000, 4),
(8, 2, 1, 35000, 35000, 5);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `giohang`
--

CREATE TABLE `giohang` (
  `magiohang` int(11) NOT NULL,
  `masp` int(11) DEFAULT NULL,
  `mand` int(11) DEFAULT NULL,
  `soluong` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `hoadon`
--

CREATE TABLE `hoadon` (
  `mahd` int(11) NOT NULL,
  `ngaylap` date DEFAULT NULL,
  `phuongthuc` varchar(225) DEFAULT NULL,
  `tongcong` float DEFAULT NULL,
  `mand` int(11) DEFAULT NULL,
  `makh` int(11) DEFAULT NULL,
  `tinhtrang` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `hoadon`
--

INSERT INTO `hoadon` (`mahd`, `ngaylap`, `phuongthuc`, `tongcong`, `mand`, `makh`, `tinhtrang`) VALUES
(1, '2024-05-18', 'Tiền Mặt', 70000, 1, 1, NULL),
(2, '2024-05-18', 'Tiền Mặt', 310000, 1, 2, NULL),
(3, '2024-05-18', 'Chuyển Khoản', 45000, 1, 3, NULL),
(4, '2024-06-11', 'Tiền mặt', 115000, 4, NULL, NULL),
(5, '2024-06-11', 'ATM', 26250, 4, NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `khachhang`
--

CREATE TABLE `khachhang` (
  `makh` int(11) NOT NULL,
  `tenkh` varchar(225) DEFAULT NULL,
  `sdt` varchar(225) DEFAULT NULL,
  `diemso` int(11) DEFAULT NULL,
  `mand` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `khachhang`
--

INSERT INTO `khachhang` (`makh`, `tenkh`, `sdt`, `diemso`, `mand`) VALUES
(1, 'Trần Văn A', '090912345', NULL, NULL),
(2, 'Trần Văn B', '090912346', NULL, NULL),
(3, 'Trần Văn C', '090912347', NULL, NULL),
(4, 'Trần Văn D', '0963972112', 50, 4);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `loaisanpham`
--

CREATE TABLE `loaisanpham` (
  `maloaisp` int(11) NOT NULL,
  `tenloaisp` varchar(225) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `loaisanpham`
--

INSERT INTO `loaisanpham` (`maloaisp`, `tenloaisp`) VALUES
(1, 'Khô'),
(2, 'Cơm Cháy'),
(3, 'Bánh Tráng'),
(4, 'Bánh'),
(5, 'Kẹo'),
(6, 'Thức Uống'),
(7, 'Trà'),
(8, 'Hạt Dinh Dưỡng'),
(9, 'Bánh/Mứt Tết');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `momo`
--

CREATE TABLE `momo` (
  `id_momo` int(11) NOT NULL,
  `code_cart` varchar(50) NOT NULL,
  `partner_code` varchar(50) NOT NULL,
  `order_id` int(11) NOT NULL,
  `amount` varchar(50) NOT NULL,
  `order_info` varchar(100) NOT NULL,
  `order_type` varchar(50) NOT NULL,
  `trans_id` int(11) NOT NULL,
  `pay_type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nguoidung`
--

CREATE TABLE `nguoidung` (
  `mand` int(11) NOT NULL,
  `tennd` varchar(225) DEFAULT NULL,
  `sdt` varchar(225) DEFAULT NULL,
  `diachi` varchar(225) DEFAULT NULL,
  `email` varchar(225) DEFAULT NULL,
  `ngaysinh` date DEFAULT NULL,
  `ngayvl` date DEFAULT NULL,
  `manhom` int(11) DEFAULT NULL,
  `username` varchar(225) NOT NULL,
  `matkhau` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `nguoidung`
--

INSERT INTO `nguoidung` (`mand`, `tennd`, `sdt`, `diachi`, `email`, `ngaysinh`, `ngayvl`, `manhom`, `username`, `matkhau`) VALUES
(1, 'Shop Ăn Vặt', '0909090909', 'Long An', 'shopanvat@gmail.com', '2003-05-22', NULL, 1, 'admin123', '$2y$10$H/B9SnKgFL6xzrBaMj73Jeex4TOQRzY6v7/4aohLKfUVcUYvSZZ6m'),
(2, 'Trần Văn Tèo', '0123456789', 'TPHCM', '123@gmail.com', '1980-05-25', '2024-01-01', 1, 'admin', '123'),
(3, 'Nguyễn Văn A', '090912345', '123 Lê Trọng Tấn', 'nguyenvana@gmail.com', '1990-01-01', '2024-01-02', 1, 'username', 'password'),
(4, 'Trần Văn D', '0963972112', 'TPHCM', '123@gmail.com', '2024-06-14', NULL, 2, 'a1', '$2y$10$7Y5VZz2cH7/h.vhhc6TYXenxJ6ggd7VCxeez38/h4nCHxURMJPZQq');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nhacungcap`
--

CREATE TABLE `nhacungcap` (
  `mancc` int(11) NOT NULL,
  `tenncc` varchar(225) DEFAULT NULL,
  `diachi` varchar(250) DEFAULT NULL,
  `sdt` varchar(225) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `nhacungcap`
--

INSERT INTO `nhacungcap` (`mancc`, `tenncc`, `diachi`, `sdt`) VALUES
(1, 'Công Ty A', '345 Lê Trọng Tấn', '090912345'),
(2, 'Công Ty B', '678 Lê Trọng Tấn', '090912346');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nhomnguoidung`
--

CREATE TABLE `nhomnguoidung` (
  `manhom` int(11) NOT NULL,
  `tennhom` varchar(225) DEFAULT NULL,
  `quyen` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `nhomnguoidung`
--

INSERT INTO `nhomnguoidung` (`manhom`, `tennhom`, `quyen`) VALUES
(1, 'Quản Lý', 1),
(2, 'Nhân Viên', 2);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sanpham`
--

CREATE TABLE `sanpham` (
  `masp` int(11) NOT NULL,
  `tensp` varchar(225) DEFAULT NULL,
  `hinh` varchar(225) DEFAULT NULL,
  `trangthai` varchar(225) DEFAULT NULL,
  `mota` varchar(500) DEFAULT NULL,
  `soluong` int(11) DEFAULT NULL,
  `giaban` float DEFAULT NULL,
  `maloaisp` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `sanpham`
--

INSERT INTO `sanpham` (`masp`, `tensp`, `hinh`, `trangthai`, `mota`, `soluong`, `giaban`, `maloaisp`) VALUES
(2, 'Khô Gà', 'khoga.jpg', 'Còn hàng', 'Khô Gà bếp làm 6 năm nay khách nào ăn cũng biết từng cọng thịt gà thấm vị săn ngon chứ không bị bở đâu nhé.', 5, 35000, 1),
(3, 'Khô Heo', 'khoheo.jpg', 'Còn hàng', 'Khô Heo bếp làm 6 năm nay khách nào ăn cũng biết từng cọng thịt gà thấm vị săn ngon chứ không bị bở đâu nhé.', 5, 45000, 1),
(4, 'Khô Bò', 'khobo.jpg', 'Còn hàng', 'Khô Bò bếp làm 6 năm nay khách nào ăn cũng biết từng cọng thịt gà thấm vị săn ngon chứ không bị bở đâu nhé.', 5, 55000, 1),
(5, 'Cơm Cháy Chà Bông', 'comchaychabong.jpg', 'Còn hàng', 'Cơm cháy chà bông size mini theo yêu cầu của khách yêu', 5, 150000, 2),
(6, 'Cơm Cháy Rong Biển', 'comchayrongbien.jpg', 'Còn hàng', 'Cơm cháy rong biển size mini theo yêu cầu của khách yêu', 5, 160000, 2),
(7, 'Bánh Tráng Bơ Tỏi', 'banhtrangbotoi.jpg', 'Còn hàng', 'Bánh tráng bơ tỏi tự làm theo đặc trưng của miền Tây.', 5, 15000, 3),
(8, 'Bánh Tráng Cuộn', 'banhtrangcuon.jpg', 'Còn hàng', 'Bánh tráng cuộn thịt heo nầu. Món ăn dân dã đậm chất vùng quê.', 5, 20000, 3),
(9, 'Bánh Tai Heo', 'banhtaiheo.jpg', 'Còn hàng', 'Bánh tai heo là món ăn dân dã đậm chất quê nhà được nhiều người yêu thích.', 5, 10000, 4),
(10, 'Bánh Ống Mè', 'ongme.jpg', 'Còn hàng', 'Bánh ống mè là món ăn đặc trưng của người Campuchia, qua thời gian đã trở thành món ăn quen thuộc của người dân Việt Nam.', 5, 12000, 4),
(11, 'Kẹo Bơ Sữa', 'keobosa.jpg', 'Còn hàng', 'Kẹo bơ sữa độc quyền của cửa hàng bánh kẹo Vân Anh.', 5, 20000, 5),
(12, 'Kẹo Đậu Phộng', 'keodauphong.jpg', 'Còn hàng', 'Kẹo đậu phộng lá me nội địa, hương vị rất đặc trưng.', 5, 15000, 5),
(13, 'Chanh Muối Đường Phèn', 'chanhmuoiduongphen.jpg', 'Còn hàng', 'Chanh muối đường phèn là món khai vị không thể thiếu trong mâm cơm ngày Tết.', 5, 20000, 6),
(14, 'Đá Me', 'dame.jpg', 'Còn hàng', 'Đá me làm từ nguyên liệu tự nhiên, thơm ngon và mát lành.', 5, 15000, 6),
(15, 'Trà Sữa', 'trasua.jpg', 'Còn hàng', 'Trà sữa được nhiều người ưa chuộng bởi vị ngọt thanh mát và hương thơm đặc trưng của trà sữa.', 5, 20000, 7),
(16, 'Hạt Ngũ Cốc', 'hatngucoc.jpg', 'Còn hàng', 'Hỗn hợp hạt ngũ cốc, chứa nhiều dưỡng chất tốt cho sức khỏe', 5, 30000, 8),
(17, 'Khô Mực', 'khomuc.jpg', 'Còn hàng', 'Khô Mực hương vị đậm đà, thơm ngon.', 3, 60000, 1),
(18, 'Khô Cá Dứa', 'khocadua.jpg', 'Còn hàng', 'Khô Cá Dứa tươi ngon, giàu dinh dưỡng.', 3, 65000, 1),
(19, 'Khô Cá Thiều', 'khocathieu.jpg', 'Còn hàng', 'Khô Cá Thiều tươi ngon, giàu dinh dưỡng.', 3, 70000, 1),
(20, 'Cơm Cháy Mắm Tỏi', 'comchaymamtoi.jpg', 'Còn hàng', 'Cơm cháy mắm tỏi thơm ngon, hấp dẫn.', 3, 80000, 2),
(21, 'Cơm Cháy Tròn Mini', 'comchaytronmini.jpg', 'Còn hàng', 'Cơm cháy tròn mini nhỏ gọn, tiện lợi.', 3, 75000, 2),
(22, 'Gạo Lức Sấy', 'gaolucsay.jpg', 'Còn hàng', 'Gạo Lức Sấy chất lượng cao, thơm ngon.', 3, 90000, 2),
(23, 'Bánh Tráng Cốt Dừa', 'banhtrangcotdua.jpg', 'Còn hàng', 'Bánh tráng cốt dừa thơm ngon, độc đáo.', 3, 20000, 3),
(24, 'Bánh Tráng Dẻo Phơi Sương', 'banhtrangdeophoisuong.jpg', 'Còn hàng', 'Bánh tráng dẻo phơi sương thơm ngon, mềm mịn.', 3, 25000, 3),
(25, 'Bánh Tráng Nướng Mắm Ruốt', 'banhtrangnuongmamruot.jpg', 'Còn hàng', 'Bánh tráng nướng mắm ruốt đậm đà, hấp dẫn.', 3, 30000, 3),
(26, 'Bánh Bông Lan Sốt Bơ', 'banhbonglansotbo.jpg', 'Còn hàng', 'Bánh bông lan sốt bơ thơm ngon, mềm mịn.', 3, 35000, 4),
(27, 'Bánh Bò Xốp', 'banhxop.jpg', 'Còn hàng', 'Bánh bò xốp thơm ngon, mềm mịn.', 3, 40000, 4),
(28, 'Kẹo Socola', 'keosocola.jpg', 'Còn hàng', 'Kẹo socola hảo hạng, ngọt ngào.', 3, 25000, 5),
(29, 'Kẹo Dẻo', 'keodeo.jpg', 'Còn hàng', 'Kẹo dẻo ngon miệng, thích hợp cho trẻ em.', 3, 20000, 5),
(30, 'Kẹo Ngậm', 'keongam.jpg', 'Còn hàng', 'Kẹo ngậm thơm ngon, giải khát tuyệt vời.', 3, 15000, 5),
(31, 'Soda Chanh', 'sodachanh.jpg', 'Còn hàng', 'Soda Chanh mát lạnh, sảng khoái.', 3, 12000, 6),
(32, 'Coca', 'coca.jpg', 'Còn hàng', 'Coca ngon tuyệt vời, thưởng thức cùng bạn bè.', 3, 10000, 6),
(33, 'Pepsi', 'pepsi.jpg', 'Còn hàng', 'Pepsi đầy sự lựa chọn, thỏa mãn cơn khát.', 3, 10000, 6);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `chitiethoadon`
--
ALTER TABLE `chitiethoadon`
  ADD PRIMARY KEY (`macthd`),
  ADD KEY `masp` (`masp`),
  ADD KEY `mahd` (`mahd`);

--
-- Chỉ mục cho bảng `giohang`
--
ALTER TABLE `giohang`
  ADD PRIMARY KEY (`magiohang`),
  ADD KEY `masp` (`masp`),
  ADD KEY `mand` (`mand`);

--
-- Chỉ mục cho bảng `hoadon`
--
ALTER TABLE `hoadon`
  ADD PRIMARY KEY (`mahd`),
  ADD KEY `mand` (`mand`),
  ADD KEY `makh` (`makh`);

--
-- Chỉ mục cho bảng `khachhang`
--
ALTER TABLE `khachhang`
  ADD PRIMARY KEY (`makh`);

--
-- Chỉ mục cho bảng `loaisanpham`
--
ALTER TABLE `loaisanpham`
  ADD PRIMARY KEY (`maloaisp`);

--
-- Chỉ mục cho bảng `momo`
--
ALTER TABLE `momo`
  ADD PRIMARY KEY (`id_momo`);

--
-- Chỉ mục cho bảng `nguoidung`
--
ALTER TABLE `nguoidung`
  ADD PRIMARY KEY (`mand`),
  ADD KEY `manhom` (`manhom`);

--
-- Chỉ mục cho bảng `nhacungcap`
--
ALTER TABLE `nhacungcap`
  ADD PRIMARY KEY (`mancc`);

--
-- Chỉ mục cho bảng `nhomnguoidung`
--
ALTER TABLE `nhomnguoidung`
  ADD PRIMARY KEY (`manhom`);

--
-- Chỉ mục cho bảng `sanpham`
--
ALTER TABLE `sanpham`
  ADD PRIMARY KEY (`masp`),
  ADD KEY `maloaisp` (`maloaisp`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `chitiethoadon`
--
ALTER TABLE `chitiethoadon`
  MODIFY `macthd` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `giohang`
--
ALTER TABLE `giohang`
  MODIFY `magiohang` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `hoadon`
--
ALTER TABLE `hoadon`
  MODIFY `mahd` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `khachhang`
--
ALTER TABLE `khachhang`
  MODIFY `makh` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `loaisanpham`
--
ALTER TABLE `loaisanpham`
  MODIFY `maloaisp` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `momo`
--
ALTER TABLE `momo`
  MODIFY `id_momo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `nguoidung`
--
ALTER TABLE `nguoidung`
  MODIFY `mand` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `nhacungcap`
--
ALTER TABLE `nhacungcap`
  MODIFY `mancc` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `nhomnguoidung`
--
ALTER TABLE `nhomnguoidung`
  MODIFY `manhom` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `sanpham`
--
ALTER TABLE `sanpham`
  MODIFY `masp` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `chitiethoadon`
--
ALTER TABLE `chitiethoadon`
  ADD CONSTRAINT `chitiethoadon_ibfk_1` FOREIGN KEY (`masp`) REFERENCES `sanpham` (`masp`),
  ADD CONSTRAINT `chitiethoadon_ibfk_2` FOREIGN KEY (`mahd`) REFERENCES `hoadon` (`mahd`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `giohang`
--
ALTER TABLE `giohang`
  ADD CONSTRAINT `giohang_ibfk_1` FOREIGN KEY (`masp`) REFERENCES `sanpham` (`masp`),
  ADD CONSTRAINT `giohang_ibfk_2` FOREIGN KEY (`mand`) REFERENCES `nguoidung` (`mand`);

--
-- Các ràng buộc cho bảng `hoadon`
--
ALTER TABLE `hoadon`
  ADD CONSTRAINT `hoadon_ibfk_1` FOREIGN KEY (`mand`) REFERENCES `nguoidung` (`mand`),
  ADD CONSTRAINT `hoadon_ibfk_2` FOREIGN KEY (`makh`) REFERENCES `khachhang` (`makh`);

--
-- Các ràng buộc cho bảng `nguoidung`
--
ALTER TABLE `nguoidung`
  ADD CONSTRAINT `nguoidung_ibfk_1` FOREIGN KEY (`manhom`) REFERENCES `nhomnguoidung` (`manhom`);

--
-- Các ràng buộc cho bảng `sanpham`
--
ALTER TABLE `sanpham`
  ADD CONSTRAINT `sanpham_ibfk_1` FOREIGN KEY (`maloaisp`) REFERENCES `loaisanpham` (`maloaisp`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

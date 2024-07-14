<?php
include 'connect_db.php';

if (!isset($_SESSION)) {
    session_start();
}

// Prepare the SQL query
$MaPhieuXuat= isset($_GET['MaPhieuXuat']) ? $_GET['MaPhieuXuat'] : '';

if ($MaPhieuXuat!== '') { // Kiểm tra xem $MaPhieuXuatcó tồn tại không trước khi sử dụng
    // Truy vấn có điều kiện nếu có 'MaPhieuXuat'
    $sql = $con->prepare("SELECT chitietphieuxuat.*,phieuxuat.* FROM chitietphieuxuat INNER JOIN phieuxuat ON chitietphieuxuat.MaPhieuXuat = phieuxuat.MaPhieuXuat WHERE chitietphieuxuat.MaPhieuXuat =? ");
    $sql->bind_param('i', $MaPhieuXuat);
    $sql->execute();
    $result = $sql->get_result();
} else {
    // Truy vấn không có điều kiện nếu không có 'MaPhieuXuat'
    $result = $con->query("SELECT chitietphieuxuat.*,phieuxuat.* FROM chitietphiexuat INNER JOIN phieuxuat ON chitietphieuxuat.MaPhieuXuat = phieuxuat.MaPhieuXuat");
}

// Set headers to prompt download of the file
header('Content-Type: application/vnd.ms-excel; charset=UTF-8');
header('Content-Disposition: attachment; filename=Xuat_kho.xls');

// Company information
$company_name = "CÔNG TY MÁY TÍNH COMPUTER STORE";
$company_logo = "C:\Users\dong8\Downloads\logo.png"; // Đường dẫn tới logo của bạn
$company_address = "15/93/81 Phạm Hữu Điều, Lê Chân, Hải Phòng";
$company_phone = "19001903";
$company_email = "tranvandong2812@gmail.com";
$company_website = "www.dongvan.com";
$current_date = date('d-m-Y, H:i a');
$created_by="";
$nhacc="";

$row = $result->fetch_assoc();
$created_by = $row['MaKho'];


// Output the company information
echo '<table>';
echo '<tr>';
echo '<td colspan="2" style="text-align:left;"><img src="' . $company_logo . '" alt="Company Logo" height="70"></td>';
echo '<td colspan="4" style="text-align:left; color:red; font-size:24px;">' . $company_name . '</td>';
echo '</tr>';
echo '<tr>';
echo '<td colspan="5" style="text-align:center;">' . $company_address . '</td>';
echo '</tr>';
echo '<tr>';
echo '<td colspan="5" style="text-align:center;">Tel: ' . $company_phone . ' Email: ' . $company_email . ' Website: ' . $company_website . '</td>';
echo '</tr>';
echo '<tr>';
echo '<td colspan="5" style="text-align:center; font-size:18px; font-weight:bold;">Chi Tiết Phiếu Xuất Kho</td>';
echo '</tr>';
echo '<tr>';
echo '<td colspan="2">Kho: ' . $created_by . '</td>';

echo '<td colspan="2" style="text-align:right;">Ngày in: ' . $current_date . '</td>';
echo '</tr>';
echo '</table>';

// Output the table headers
echo '<table border="1">';
echo '<tr>';
echo '<th>ID </th>';
echo '<th>Tên sản phẩm</th>';
echo '<th>Số lượng</th>';
echo '<th>Giá tiển</th>';
echo '<th>Thành tiền</th>';
echo '</tr>';


// Output the data rows
$totalAmount = 0;

// Output the data rows
foreach ($result as $row) {
    $itemTotal = $row['GiaTien'] * $row['SoLuong'];
    $totalAmount += $itemTotal;
    echo '<tr>';
    echo '<td>' . $row['ID'] . '</td>';
    echo '<td>' . $row['TenSP'] . '</td>';
    echo '<td>' . $row['SoLuong'] . '</td>';
    echo '<td>' . number_format($row['GiaTien'], 0, ',', '.') . ' VND</td>';
    echo '<td>' . number_format($itemTotal, 0, ',', '.') . ' VND</td>';
    echo '</tr>';
}

// Output the total amount row
echo '<tr>';
echo '<th colspan="4">Tổng tiền</th>';
echo '<th>' . number_format($totalAmount, 0, ',', '.') . ' VND</th>';
echo '</tr>';

echo '<tr>';
echo '<td colspan="5">Quý khách lưu ý: Giá bán, khuyến mại của sản phẩm và tình trạng còn hàng có thể bị thay đổi bất cứ lúc nào mà không kịp báo trước.</td>';
echo '</tr>';
echo '<tr>';
echo '<td colspan="5" style="text-align:center; font-weight:bold;">CHÂN THÀNH CẢM ƠN QUÝ KHÁCH</td>';
echo '</tr>';
echo '<tr>';
echo '<td colspan="5">Hỗ trợ chi tiết, vui lòng liên hệ Hotline: 1900 1903 (8h00-21h30 hàng ngày)</td>';
echo '</tr>';

echo '</table>';
// Đóng kết nối
$con->close();
?>

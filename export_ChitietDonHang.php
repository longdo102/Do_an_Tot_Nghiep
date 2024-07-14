<?php
include 'connect_db.php';

if (!isset($_SESSION)) {
    session_start();
}

// Prepare the SQL query
$order_id = isset($_GET['order_id']) ? $_GET['order_id'] : '';

if ($order_id !== '') { // Kiểm tra xem $order_id có tồn tại không trước khi sử dụng
    // Truy vấn có điều kiện nếu có 'order_id'
    $sql = $con->prepare("SELECT orders_detail.*, orders.* FROM orders_detail INNER JOIN orders ON orders_detail.order_id = orders.id WHERE order_id = ?");
    $sql->bind_param('i', $order_id);
    $sql->execute();
    $result = $sql->get_result();
} else {
    // Truy vấn không có điều kiện nếu không có 'order_id'
    $result = $con->query("SELECT orders_detail.*, orders.* FROM orders_detail INNER JOIN orders ON orders_detail.order_id = orders.id ");
}

// Set headers to prompt download of the file
header('Content-Type: application/vnd.ms-excel; charset=UTF-8');
header('Content-Disposition: attachment; filename=orders_detail.xls');

// Company information
$company_name = "CÔNG TY MÁY TÍNH COMPUTER STORE";
$company_logo = "C:\Users\dong8\Downloads\logo.png"; // Đường dẫn tới logo của bạn
$company_address = "15/93/81 Phạm Hữu Điều, Lê Chân, Hải Phòng";
$company_phone = "19001903";
$company_email = "tranvandong2812@gmail.com";
$company_website = "www.dongvan.com";
$current_date = date('d-m-Y, H:i a');
$created_by = "Khách hàng"; // Thay bằng tên người tạo báo cáo nếu cần

// Output the company information
echo '<table>';
echo '<tr>';
echo '<td colspan="2" style="text-align:left;"><img src="' . $company_logo . '" alt="Company Logo" height="70"></td>';
echo '<td colspan="4" style="text-align:left; color:red; font-size:24px;">' . $company_name . '</td>';
echo '</tr>';
echo '<tr>';
echo '<td colspan="8" style="text-align:center;">' . $company_address . '</td>';
echo '</tr>';
echo '<tr>';
echo '<td colspan="8" style="text-align:center;">Tel: ' . $company_phone . ' Email: ' . $company_email . ' Website: ' . $company_website . '</td>';
echo '</tr>';
echo '<tr>';
echo '<td colspan="8" style="text-align:center; font-size:18px; font-weight:bold;">Chi Tiết Đơn Hàng</td>';
echo '</tr>';
echo '<tr>';
echo '<td colspan="4">Người in: ' . $created_by . '</td>';
echo '<td colspan="4" style="text-align:right;">Ngày in: ' . $current_date . '</td>';
echo '</tr>';
echo '</table>';

// Output the table headers
echo '<table border="1">';
echo '<tr>';
echo '<th>ID đơn hàng</th>';
echo '<th>Tên khách hàng</th>';
echo '<th>Tên sản phẩm</th>';
echo '<th>Số lượng</th>';
echo '<th>Đơn giá</th>';
echo '<th>Thành tiền</th>';
echo '</tr>';

// Output the data rows
while ($row = $result->fetch_assoc()) {
    echo '<tr>';
    echo '<td>' . $row['order_id'] . '</td>';
    echo '<td>' . $row['name'] . '</td>';
    echo '<td>' . $row['product_name'] . '</td>';
    echo '<td>' . $row['quantity'] . '</td>';
    echo '<td>' . $row['price'] . '</td>';
    echo '<td>' . $row['price'] * $row['quantity'] . '</td>';
    echo '</tr>';
}


echo '<tr>';
echo '<td colspan="6">Quý khách lưu ý: Giá bán, khuyến mại của sản phẩm và tình trạng còn hàng có thể bị thay đổi bất cứ lúc nào mà không kịp báo trước.</td>';
echo '</tr>';
echo '<tr>';
echo '<td colspan="6" style="text-align:center; font-weight:bold;">CHÂN THÀNH CẢM ƠN QUÝ KHÁCH</td>';
echo '</tr>';
echo '<tr>';
echo '<td colspan="6">Hỗ trợ chi tiết, vui lòng liên hệ Hotline: 1900 1903 (8h00-21h30 hàng ngày)</td>';
echo '</tr>';

echo '</table>';
// Đóng kết nối
$con->close();
?>

<?php
include 'connect_db.php';
if (!isset($_SESSION)) {
    session_start();
}

// Prepare the SQL query
$kw = isset($_GET['id']) ? $_GET['id'] : '';

if ($kw) {
    $stmt = $con->prepare("SELECT orders.id, orders.created_time, menu_product.name, orders_detail.product_name, orders_detail.quantity, orders.status 
          FROM orders 
          INNER JOIN orders_detail ON orders.id = orders_detail.order_id 
          INNER JOIN product ON orders_detail.product_id = product.id 
          INNER JOIN menu_product ON product.menu_id = menu_product.id 
          WHERE menu_product.id = ?");
    $stmt->bind_param('s', $kw);
} else {
    $stmt = $con->prepare("SELECT orders.id, orders.created_time, menu_product.name, orders_detail.product_name, orders_detail.quantity, orders.status 
          FROM orders 
          INNER JOIN orders_detail ON orders.id = orders_detail.order_id 
          INNER JOIN product ON orders_detail.product_id = product.id 
          INNER JOIN menu_product ON product.menu_id = menu_product.id ");
}

// Execute the query
$stmt->execute();
$result = $stmt->get_result();

// Set headers to prompt download of the file
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename=orders.xls');

// Company information
$company_name = "CÔNG TY MÁY TÍNH COMPUTER STORE";
$company_logo = "C:\Users\dong8\Downloads\logo.png"; // Đường dẫn tới logo của bạn
$company_address = "15/93/81 Phạm Hữu Điều, Lê Chân, Hải Phòng";
$company_phone = "19001903";
$company_email = "tranvandong2812@gmail.com";
$company_website = "www.dongvan.com";
$timezone = new DateTimeZone('Asia/Bangkok'); // Thiết lập múi giờ GMT+7 (Asia/Bangkok)
$currentDateTime = new DateTime('now', $timezone);
$current_date = $currentDateTime->format('Y-m-d H:i:s');
$created_by = "admin3"; // Thay bằng tên người tạo báo cáo nếu cần

// Output the table headers
echo '<table>';
echo '<tr style="border:none;">';
echo '<td colspan="2" style="text-align:left; border:none;"><img src="' . $company_logo . '" alt="Company Logo" height="70"></td>';
echo '<td colspan="4" style="text-align:center; color:red; font-size:24px; border:none;">' . $company_name . '</td>';
echo '</tr>';
echo '<tr style="border:none;">';
echo '<td colspan="8" style="text-align:center; border:none;">' . $company_address . '</td>';
echo '</tr>';
echo '<tr style="border:none;">';
echo '<td colspan="8" style="text-align:center; border:none;">Tel: ' . $company_phone . ' Email: ' . $company_email . ' Website: ' . $company_website . '</td>';
echo '</tr>';
echo '<tr style="border:none;">';
echo '<td colspan="8" style="text-align:center; font-size:18px; font-weight:bold; border:none;">BÁO CÁO ĐƠN HÀNG</td>';
echo '</tr>';
echo '<tr style="border:none;">';
echo '<td colspan="4" style="border:none;">Người in: ' . $created_by . '</td>';
echo '<td colspan="4" style="text-align:right; border:none;">Ngày in: ' . $current_date . '</td>';
echo '</tr>';
echo '</table>';

// Output the table with order data
echo '<table border="1">';
echo '<tr>';
echo '<th>ID đơn hàng</th>';
echo '<th>Thời gian đặt</th>';
echo '<th>Ngành hàng</th>';
echo '<th>Tên sản phẩm</th>';
echo '<th>Số lượng</th>';
echo '<th>Tình trạng</th>';

echo '</tr>';

// Output the data rows
while ($row = $result->fetch_assoc()) {
    switch ($row['status']) {
        case 0:
            $status = "Đang Xử Lý";
            break;
        case 1:
            $status = "Đang Giao Hàng";
            break;
        case 2:
            $status = "Thành Công";
            break;
        default:
            $status = "Đơn hàng bị hủy";
            break;
    }

    echo '<tr>';
    echo '<td>' . $row['id'] . '</td>';
    echo '<td>' . $row['created_time'] . '</td>';
    echo '<td>' . $row['name'] . '</td>';
    echo '<td>' . $row['product_name'] . '</td>';
    echo '<td>' . $row['quantity'] . '</td>';
    
    echo '<td>' . $status . '</td>';
    echo '</tr>';
}

// Footer
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

// Close the statement
$stmt->close();
?>

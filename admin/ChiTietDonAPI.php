<?php
session_start();

if (isset($_SESSION['token'])) {
    $token = $_SESSION['token'];
    // Lấy đường dẫn hiện tại của trang
    $request_uri = $_SERVER['REQUEST_URI'];

    // Sử dụng hàm parse_url() để tách các thành phần của URL
    $parsed_url = parse_url($request_uri);

    // Lấy giá trị của tham số 'id' từ query string
    parse_str($parsed_url['query'], $query_params);
    $ord_num = $query_params['id'];

    $url = 'https://open.sendo.vn/api/partner/salesorder/' . $ord_num;
    $headers = array(
        'Authorization: bearer ' . $token
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    $jsonData = $response;
    $data = json_decode($jsonData, true);

} else {
    echo 'Token not found.';
}

?>

<style>
    @import "compass/css3";

    .container {
        width: 80%;
        margin-left: 150px;

        .container-header {
            display: flex;
            justify-content: center;
            line-height: 100px;
            font-size: 15px;
            font-weight: bold;
            font-family: 'Arial';

            p {
                margin: 20px 120px 10px 120px;
            }
        }
    }

    table {
        width: 100%;
        font-family: 'Arial';
        margin: 25px auto;
        border-collapse: collapse;
        border: 1px solid #f44336;
        border-bottom: 2px solid #f44336;
        box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.10),
            0px 10px 20px rgba(0, 0, 0, 0.05),
            0px 20px 20px rgba(0, 0, 0, 0.05),
            0px 30px 20px rgba(0, 0, 0, 0.05);

        tr {
            &:hover {
                background: #f4f4f4;

                td {
                    color: #555;
                }
            }
        }

        th,
        td {
            color: #999;
            border: 1px solid #eee;
            padding: 12px 35px;
            border-collapse: collapse;
            text-align: center;
        }

        th {
            background: #f44336;
            color: #fff;
            text-transform: uppercase;
            font-size: 14px;

            &.last {
                border-right: none;
            }
        }
    }
    .container .container-title
    {
        background-color: F44336;
        text-align: center;
        color: #fff;
    }
</style>

<body>
    <div class="container">
        <h1 class="container-title">Thông tin đơn hàng</h1>
        <p>Mã sản phẩm: <?php echo $data['result']['sales_order']['order_number']; ?></p>
        <?php $date = DateTime::createFromFormat('U', $data['result']['sales_order']['order_date_time_stamp']);?>
        <p>Thời gian đặt hàng: <?php echo $date->format('H:i d-m-Y');?></p>
        <p>Thanh toán: <?php
            switch ($data['result']['sales_order']['payment_method']) {
                case 1:
                    echo "Thanh toán khi nhận hàng";
                    break;
                case 2:
                    echo "Thanh toán trực tuyến";
                    break;
                case 4:
                    echo "Thanh toán kết hợp";
                    break;
                case 5:
                    echo "Thanh toán trả sau";
                    break;
                default:
                    echo $data['result']['sales_order']['payment_method'];
            } ?></p>
        <p>Địa chỉ lấy hàng: <?php echo $data['result']['sales_order']['store_picking_address']; ?></p>
        <p>Trạng thái: <?php
            switch ($data['result']['sales_order']['order_status']) {
                case 2:
                    echo "Chờ xác nhận";
                    break;
                case 3:
                    echo "Đang xử lý";
                    break;
                case 6:
                    echo "Đang vận chuyển";
                    break;
                case 8:
                    echo "Giao thành công";
                    break;
                case 13:
                    echo "Bị huỷ";
                    break;
                default:
                    echo $data['result']['sales_order']['order_status'];
            } ?></p>

        <h2>Thông tin người mua</h2>
            <p>Tên người nhận: <?php echo $data['result']['sales_order']['receiver_name']; ?></p>
            <p>Số điện thoại: <?php echo $data['result']['sales_order']['shipping_contact_phone']; ?></p>
            <p>Địa chỉ: <?php echo $data['result']['sales_order']['region_name']; ?></p>
            

        <div class="container-table">
            <table>
                <thead>
                    <tr>
                        <th>Tên sản phẩm</th>
                        <th>Số lượng</th>
                        <th>Thành tiền</th>
                        <th>Ghi chú</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <?php foreach ($data['result']['sku_details'] as $sku): ?>
                            <td><?php echo $sku['product_name']; ?></td>
                            <td><?php echo $sku['quantity']; ?></td>
                            <td><?php echo $sku['sub_total']; ?></td>
                        </tr>
                    </tbody>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
    <script>
        $('table tr').each(function () {
            $(this).find('th').first().addClass('first');
            $(this).find('th').last().addClass('last');
            $(this).find('td').first().addClass('first');
            $(this).find('td').last().addClass('last');
        });

        $('table tr').first().addClass('row-first');
        $('table tr').last().addClass('row-last');
    </script>

</body>
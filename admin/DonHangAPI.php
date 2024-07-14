<?php
session_start();
include 'connect_db.php';
$category = mysqli_query($con, "SELECT * FROM `donhang_api` ORDER BY `donhang_api`.`order_time` DESC");

mysqli_close($con);

if (isset($_SESSION['token'])) {
    $token = $_SESSION['token'];
    $url = 'https://open.sendo.vn/api/partner/salesorder/search';
    $data = array(
        'page_size' => 10, // Số lượng kết quả trả về mỗi lần
        'order_status' => null, // Lấy tất cả trạng thái
        'order_date_from' => '2024/06/07',
        'order_date_to' => '2024/06/20',
    );
    $headers = array(
        'Authorization: bearer ' . $token,
        'Content-Type: application/json',
        'cache-control: no-cache'
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    $data = json_decode($response, true);
} else {
    echo "Vui lòng kết nối tới API";
}

?>
<!DOCTYPE html>
<html>

<head>
    <style>
        .content,
        .container-fluid {
            width: 85%;
            position: relative;
            left: -90px;
            top: 0px;

            .card {
                min-height: 500px;
            }
        }

        .buttons {
            text-align: center;
            font-weight: bold;
            font-size: 16px;
            margin-bottom: 15px;
            line-height: 38px;
            width: 170px;
            border-style: none;
        }

        .buttons {
            color: #FFF;
            padding: 10px;
            background: #f44336;
        }

        .buttons :hover {
            color: #ffffff;
            text-decoration: none;
            opacity: 0.8;
        }

        .page-item {
            border: 1px solid rgba(0, 0, 0, 0.4);
            width: 35px;
            display: inline-block;
            text-align: center;
            line-height: 20px;
            color: black;
        }
    </style>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Đơn hàng Sendo</title>
    <!-- Favicon-->
    <link rel="icon" type="../logo/png" sizes="32x32" href="../logo/logo.png">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet"
        type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="plugins/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="plugins/node-waves/waves.css" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="plugins/animate-css/animate.css" rel="stylesheet" />

    <!-- Morris Chart Css-->
    <link href="plugins/morrisjs/morris.css" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="css/style.css" rel="stylesheet">

    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="css/themes/all-themes.css" rel="stylesheet" />

</head>

<body class="theme-red">
    <div class="overlay"></div>
    <!-- Search Bar -->
    <section class="content">
        <div class="container-fluid">

            <!-- Basic Examples -->
            <form id="product-form" method="POST" action="" enctype="multipart/form-data" class="title-connect">
                <div class="row clearfix">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="card">
                            <div class="header">
                                <h2>
                                    Danh sách đơn hàng
                                </h2>
                            </div>
                            <div class="body">
                                <button class="buttons" type="submit">
                                    Cập nhật đơn hàng
                                </button>
                                <div class="table-responsive">
                                    <table
                                        class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                        <thead>
                                            <tr>
                                                <th>Mã đơn hàng</th>
                                                <th>Thời gian đặt</th>
                                                <th>Tên người nhận</th>
                                                <th>SĐT</th>
                                                <th>Địa chỉ</th>
                                                <th>Tổng tiền</th>
                                                <th>Trạng thái</th>
                                                <th>Chi tiết</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php while ($row = mysqli_fetch_array($category)) { ?>
                                                <tr>
                                                    <td><?php echo $row['id'] ?></td>
                                                    <td><?php echo $row['order_time'] ?></td>
                                                    <td><?php echo $row['receiver_name'] ?></td>
                                                    <td><?php echo $row['buyer_phone'] ?></td>
                                                    <td><?php echo $row['receiver_address'] ?></td>
                                                    <td><?php echo number_format($row['total_amount'], 0, ',', '.') . ' đ'; ?>
                                                    </td>
                                                    <td><?php echo $row['order_status'] ?></td>
                                                    <td><a href="./ChiTietDonAPI.php?id=<?= urlencode($row['id']) ?>"
                                                            class="btn btn-blue">Chi tiết</a></td>
                                                </tr>
                                                <?php
                                            }
                                            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                                foreach ($data['result']['data'] as $ord) {
                                                    $host = "localhost";
                                                    $user = "root";
                                                    $password = "";
                                                    $database = "doan_ne";
                                                    $con = mysqli_connect($host, $user, $password, $database);

                                                    // Kiểm tra xem đơn hàng đã có ID trong cơ sở dữ liệu chưa
                                                    $order_number = mysqli_real_escape_string($con, $ord['sales_order']['order_number']);
                                                    $sql = "SELECT id FROM donhang_api WHERE id = '$order_number'";
                                                    $result = mysqli_query($con, $sql);
                                                    $order_id = mysqli_fetch_assoc($result)['id'] ?? null;
                                                    $date = DateTime::createFromFormat('U', $ord['sales_order']['order_date_time_stamp']);
                                                    $order_date = $date->format('Y-m-d H:i:s');
                                                    $receiver_name = mysqli_real_escape_string($con, $ord['sales_order']['receiver_name']);
                                                    $buyer_phone = mysqli_real_escape_string($con, $ord['sales_order']['buyer_phone']);
                                                    $receiver_address = mysqli_real_escape_string($con, $ord['sales_order']['receiver_full_address']);
                                                    $total_amount = $ord['sales_order']['total_amount'];
                                                    $order_status = $ord['sales_order']['order_status'];

                                                    if ($order_id) {
                                                        // Nếu đơn hàng đã có ID, thực hiện cập nhật
                                                        $sql = "
                                                            UPDATE donhang_api SET
                                                                order_time = '$order_date',
                                                                receiver_name = '$receiver_name',
                                                                buyer_phone = '$buyer_phone', 
                                                                receiver_address = '$receiver_address',
                                                                total_amount = $total_amount,
                                                                order_status = CASE '$order_status'
                                                                    WHEN '2' THEN 'Chờ xác nhận'
                                                                    WHEN '3' THEN 'Đang xử lý'
                                                                    WHEN '6' THEN 'Đang vận chuyển'
                                                                    WHEN '8' THEN 'Giao thành công'
                                                                    ELSE 'Bị huỷ'
                                                                END
                                                            WHERE id = '$order_number'
                                                        ";
                                                        mysqli_query($con, $sql);
                                                    } else {
                                                        // Nếu đơn hàng chưa có ID, thực hiện tạo mới
                                                        $sql = "
                                                            INSERT INTO donhang_api (
                                                                id, 
                                                                order_time,
                                                                receiver_name, 
                                                                buyer_phone,
                                                                receiver_address,
                                                                total_amount,
                                                                order_status
                                                            ) VALUES (
                                                                '$order_number',
                                                                '$order_date',
                                                                '$receiver_name',
                                                                '$buyer_phone',
                                                                '$receiver_address',
                                                                $total_amount,
                                                                CASE '$order_status'
                                                                    WHEN '2' THEN 'Chờ xác nhận'
                                                                    WHEN '3' THEN 'Đang xử lý'
                                                                    WHEN '6' THEN 'Đang vận chuyển'
                                                                    WHEN '8' THEN 'Giao thành công'
                                                                    ELSE 'Bị huỷ'
                                                                END
                                                            )
                                                        ";
                                                        mysqli_query($con, $sql);
                                                    }

                                                    echo "<script>window.location.href = 'http://localhost/doanWeb/admin/DonHangAPI.php';</script>";
                                                }
                                            }
                                            ?>
                                    </table>
                                    </tbody>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

    </section>

    <!-- Jquery Core Js -->
    <script src="plugins/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core Js -->
    <script src="plugins/bootstrap/js/bootstrap.js"></script>

    <!-- Select Plugin Js -->
    <script src="plugins/bootstrap-select/js/bootstrap-select.js"></script>

    <!-- Slimscroll Plugin Js -->
    <script src="plugins/jquery-slimscroll/jquery.slimscroll.js"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="plugins/node-waves/waves.js"></script>

    <!-- Jquery CountTo Plugin Js -->
    <script src="plugins/jquery-countto/jquery.countTo.js"></script>

    <!-- Morris Plugin Js -->
    <script src="plugins/raphael/raphael.min.js"></script>
    <script src="plugins/morrisjs/morris.js"></script>
    <!-- ChartJs -->
    <script src="plugins/chartjs/Chart.bundle.js"></script>

    <!-- Flot Charts Plugin Js -->
    <script src="plugins/flot-charts/jquery.flot.js"></script>
    <script src="plugins/flot-charts/jquery.flot.resize.js"></script>
    <script src="plugins/flot-charts/jquery.flot.pie.js"></script>
    <script src="plugins/flot-charts/jquery.flot.categories.js"></script>
    <script src="plugins/flot-charts/jquery.flot.time.js"></script>

    <!-- Sparkline Chart Plugin Js -->
    <script src="plugins/jquery-sparkline/jquery.sparkline.js"></script>

    <!-- Custom Js -->
    <script src="js/admin.js"></script>
    <script src="js/pages/index.js"></script>

    <!-- Demo Js -->
    <script src="js/demo.js"></script>
</body>

</html>
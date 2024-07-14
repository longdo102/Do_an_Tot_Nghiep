<?php
if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION['admin'])) {
    header('location: login.php');
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Welcome To | Bootstrap Based Admin Template - Material Design</title>
    <!-- Favicon-->
    <link rel="icon" type="../logo/png" sizes="32x32" href="../logo/logo.png">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>

<body class="theme-red">
    <!-- Page Loader -->

    <!-- #END# Page Loader -->
    <!-- Overlay For Sidebars -->
    <div class="overlay"></div>
    <!-- #END# Overlay For Sidebars -->
    <!-- Search Bar -->

    <!-- #END# Search Bar -->
    <!-- Top Bar -->
    <nav class="navbar">
        <div class="container-fluid">
            <div class="navbar-header">
                <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
                <a href="javascript:void(0);" class="bars"></a>
                <a class="navbar-brand" href="index.php">ADMIN PAGE</a>
            </div>

        </div>
    </nav>
    <!-- #Top Bar -->
    <section>
        <!-- Left Sidebar -->
        <aside id="leftsidebar" class="sidebar">
            <!-- User Info -->
            <?php

            include "info.php";
            ?>
            <!-- #User Info -->
            <!-- Menu -->
            <?php
            include "menu.php";
            ?>

        </aside>
        <!-- #END# Left Sidebar -->
        <!-- Right Sidebar -->

        <!-- #END# Right Sidebar -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>QUẢN LÝ</h2>
            </div>

            <!-- Widgets -->
            <?php
            include "quanly.php";
            include './connect_db.php';

            // Hàm lấy doanh thu trong 7 ngày qua
            function getRevenueLast7Days($con) {
                $data = [];
                for ($i = 6; $i >= 0; $i--) {
                    $date = date('Y-m-d', strtotime("-$i days"));
                    $sql = "SELECT SUM((od.quantity * p.price_new) - (od.quantity * p.price_nhap)) as revenue
                    FROM orders o
                    JOIN orders_detail od ON o.id = od.order_id
                    JOIN product p ON od.product_id = p.id
                    WHERE DATE(o.created_time) = '$date'
                      AND o.status IN (1, 2)";
                    $result = $con->query($sql);
                    $row = $result->fetch_assoc();
                    $data[$date] = $row['revenue'] ? $row['revenue'] : 0;
                }
                return $data;
            }

            $revenue_data = getRevenueLast7Days($con);
            ?>

            <div class="row clearfix">
            <div class="row">
                <div class="font-bold m-b-33 text-center">DOANH THU 7 NGÀY QUA</div>
            </div>
            <canvas id="revenueChart"  ></canvas>
            <style>
                #revenueChart {
                    background-color: white;
                    color: white;
                }
            </style>
            <button id="downloadExcel">Xuất báo cáo Excel</button>
            <button id="downloadPDF">Xuất biểu đồ</button>
            <script src="https://rawgit.com/eKoopmans/html2pdf/master/dist/html2pdf.bundle.js"></script>
            <script src="https://unpkg.com/konva@9.3.11/konva.min.js"></script>
    <script
      src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.debug.js"
      integrity="sha384-NaWTHo/8YCBYJ59830LTz/P4aQZK1sS0SneOgAvhsIl3zBu8r9RevNg5lHCHAuQ/"
      crossorigin="anonymous"
    ></script>
    <script>
    document.querySelector('#downloadPDF').addEventListener("click", function() {
        var canvas = document.getElementById('revenueChart');
        var width = canvas.width;
        var height = canvas.height;

        var newCanvas = document.createElement('canvas');
        newCanvas.width = width;
        newCanvas.height = height;
        var ctx = newCanvas.getContext('2d');

        ctx.fillStyle = "#FFFFFF";
        ctx.fillRect(0, 0, width, height);

        ctx.drawImage(canvas, 0, 0);

        var imgData = newCanvas.toDataURL("image/jpeg", 1.0);

        var pdf = new jsPDF();

        var pdfWidth = pdf.internal.pageSize.getWidth();
        var pdfHeight = pdf.internal.pageSize.getHeight();
        var ratio = Math.min(pdfWidth / width, pdfHeight / height);

        var imgWidth = width * ratio;
        var imgHeight = height * ratio;

        pdf.addImage(imgData, 'JPEG', 0, 0, imgWidth, imgHeight);

        // Lưu tệp PDF
        pdf.save("download.pdf");
    }, false);
</script>

            <?php
if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION['admin'])) {
    header('location: login.php');
}

include './connect_db.php';

function getTop5BestSellingProducts($con) {
    $sql = "SELECT p.id, p.name, SUM(od.quantity) as total_quantity_sold
            FROM orders_detail od
            JOIN product p ON od.product_id = p.id
            GROUP BY p.id, p.name
            ORDER BY total_quantity_sold DESC
            LIMIT 5";
    $result = $con->query($sql);
    $top_products = [];
    while ($row = $result->fetch_assoc()) {
        $top_products[] = $row;
    }
    return $top_products;
}

$top_products = getTop5BestSellingProducts($con);
?>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
<script>
    var revenueData = <?php echo json_encode($revenue_data); ?>;
    var labels = Object.keys(revenueData);
    var data = Object.values(revenueData);

    var ctx = document.getElementById('revenueChart').getContext('2d');
    var revenueChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Doanh thu (VND)',
                data: data,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
                
    document.getElementById("downloadExcel").addEventListener("click", function(){
        downloadAsExcel({ filename: "chart-data", chart: revenueChart });
    });

    function downloadAsExcel(args) {
        var chart = args.chart;
        console.log(chart.data)
        var filename = args.filename || 'chart-data';
        // Extracting data from the chart
        var dataPoints = chart.data.labels.map((label, index) => {
            return {
                [chart.data.datasets[0].label]: label,
                "VND": chart.data.datasets[0].data[index]
            };
        });

        // Creating worksheet from JSON data
        var ws = XLSX.utils.json_to_sheet(dataPoints);

        // Creating a new workbook and adding the worksheet
        var wb = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(wb, ws, "Sheet1");

        // Writing the workbook to a file
        XLSX.writeFile(wb, filename + ".xlsx");
    }
</script>

            <!-- Display Top 5 Best-Selling Products -->
            <div class="row clearfix">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="body bg-teal">
                            <div class="font-bold m-b--35">TOP 5 SẢN PHẨM BÁN CHẠY</div>
                            <ul class="dashboard-stat-list">
                                <?php foreach ($top_products as $product): ?>
                                    <li>
                                        <?php echo $product['name']; ?>
                                        <span class="pull-right"><b><?php echo $product['total_quantity_sold']; ?></b> <small>sản phẩm</small></span>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <style>
    .dashboard-stat-list {
        list-style-type: none;
        padding: 0;
    }

    .dashboard-stat-list li {
        border-bottom: 1px solid #ddd;
        padding: 10px 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .dashboard-stat-list li:last-child {
        border-bottom: none;
    }

    .dashboard-stat-list li span {
        color: #666;
    }

    .dashboard-stat-list li b {
        color: #333;
    }
</style>

            </style>
            <!-- #END# Display Top 5 Best-Selling Products -->
        </div>
            <br> <br>
            <?php
            function countOrders($con, $start_date, $end_date)
            {
                $sql = "SELECT COUNT(*) as total FROM orders WHERE created_time BETWEEN '$start_date' AND '$end_date'";
                $result = $con->query($sql);
                $row = $result->fetch_assoc();
                return $row['total'];
            }

            // Ngày hiện tại
            $today = date('Y-m-d');
            $yesterday = date('Y-m-d', strtotime('-1 day'));
            $start_of_week = date('Y-m-d', strtotime('last monday', strtotime('-1 week')));
            $end_of_week = date('Y-m-d', strtotime('last sunday', strtotime('-1 week')));
            $start_of_month = date('Y-m-d', strtotime('first day of last month'));
            $end_of_month = date('Y-m-d', strtotime('last day of last month'));
            $start_of_year = date('Y-m-d', strtotime('first day of january last year'));
            $end_of_year = date('Y-m-d', strtotime('last day of december last year'));

            $today_orders = countOrders($con, "$today 00:00:00", "$today 23:59:59");
            $yesterday_orders = countOrders($con, "$yesterday 00:00:00", "$yesterday 23:59:59");
            $last_week_orders = countOrders($con, "$start_of_week 00:00:00", "$end_of_week 23:59:59");
            $last_month_orders = countOrders($con, "$start_of_month 00:00:00", "$end_of_month 23:59:59");
            $last_year_orders = countOrders($con, "$start_of_year 00:00:00", "$end_of_year 23:59:59");
            $total_orders = countOrders($con, '0000-00-00 00:00:00', date('Y-m-d H:i:s'));

            function countOrdersByStatus($con, $status, $start_date, $end_date) {
                $sql = "SELECT COUNT(*) as total FROM orders WHERE status = $status and created_time BETWEEN '$start_date' AND '$end_date'";
                $result = $con->query($sql);
                $row = $result->fetch_assoc();
                return $row['total'];
            }
            
            $processing_orders = countOrdersByStatus($con, 0,"$start_of_month 00:00:00", "$end_of_month 23:59:59"); 
            $shipping_orders = countOrdersByStatus($con, 1,"$start_of_month 00:00:00", "$end_of_month 23:59:59");    
            $completed_orders = countOrdersByStatus($con, 2,"$start_of_month 00:00:00", "$end_of_month 23:59:59"); 
            $canceled_orders = countOrdersByStatus($con, 3,"$start_of_month 00:00:00", "$end_of_month 23:59:59");   
            ?>

            <div class="row clearfix">
                <!-- Answered Tickets -->
                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                    <div class="card">
                        <div class="body bg-teal">
                            <div class="font-bold m-b--35">THỐNG KÊ THEO THỜI GIAN</div>
                            <ul class="dashboard-stat-list">
                                <li>
                                    HÔM NAY
                                    <span class="pull-right"><b><?php echo $today_orders; ?></b> <small>đơn hàng</small></span>
                                </li>
                                <li>
                                    HÔM QUA
                                    <span class="pull-right"><b><?php echo $yesterday_orders; ?></b> <small>đơn hàng</small></span>
                                </li>
                                <li>
                                    TUẦN TRƯỚC
                                    <span class="pull-right"><b><?php echo $last_week_orders; ?></b> <small>đơn hàng</small></span>
                                </li>
                                <li>
                                    THÁNG TRƯỚC
                                    <span class="pull-right"><b><?php echo $last_month_orders; ?></b> <small>đơn hàng</small></span>
                                </li>
                                <li>
                                    NĂM TRƯỚC
                                    <span class="pull-right"><b><?php echo $last_year_orders; ?></b> <small>đơn hàng</small></span>
                                </li>
                                <li>
                                    TỪ TRƯỚC ĐẾN NAY
                                    <span class="pull-right"><b><?php echo $total_orders; ?></b> <small>đơn hàng</small></span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                    <div class="card">
                        <div class="body bg-teal">

                            <div class="font-bold m-b--35">THỐNG KÊ THEO TRẠNG THÁI</div>
                          
                           
                        
                            <ul class="dashboard-stat-list">
                                <li>
                                    ĐANG XỬ LÝ
                                    <span class="pull-right"><b><?php echo $processing_orders; ?></b> <small>đơn hàng</small></span>
                                </li>
                                <li>
                                    ĐANG GIAO HÀNG
                                    <span class="pull-right"><b><?php echo $shipping_orders; ?></b> <small>đơn hàng</small></span>
                                </li>
                                <li>
                                    THÀNH CÔNG
                                    <span class="pull-right"><b><?php echo $completed_orders; ?></b> <small>đơn hàng</small></span>
                                </li>
                                <li>
                                    BỊ HỦY
                                    <span class="pull-right"><b><?php echo $canceled_orders; ?></b> <small>đơn hàng</small></span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- #END# Answered Tickets -->
            </div>


        </div>
        <?php
        if (isset($_GET['click']) == 'logout')
            unset($_SESSION['current_user']);

        ?>
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
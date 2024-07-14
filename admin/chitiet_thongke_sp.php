<?php
include 'connect_db.php';
if (!isset($_SESSION)) {
    session_start();
}
$menu_id = $_GET['id'];
// Step 1: Calculate total number of records
$category = mysqli_query($con, "SELECT orders.id,orders.created_time,menu_product.name,orders_detail.product_name,orders_detail.quantity,orders.status FROM `orders` inner join `orders_detail` on orders.id=orders_detail.order_id inner join product on orders_detail.product_id=product.id inner JOIN menu_product on product.menu_id=menu_product.id where menu_product.id = $menu_id;");

?>
<!DOCTYPE html>
<html>

<head>
    <style>
       img{
           width: 100%;
       }
       .buttons{
           text-align: right;
           font-weight: bold;
           font-size: 16px;
           margin-bottom: 15px;
           line-height: 38px;
       }
       .buttons a{
           color: #FFF;
           padding: 10px;
           background: #f44336;
       }
       .buttons a:hover {
           color: #ffffff;
           text-decoration: none;
           opacity: 0.8;
       }
       .page-item {
           border: 1px solid rgba(0,0,0,0.4);
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
</head>

<body class="theme-red">
    <div class="overlay"></div>
    <nav class="navbar">
        <div class="container-fluid">
            <div class="navbar-header">
                <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
                <a href="javascript:void(0);" class="bars"></a>
                <a class="navbar-brand" href="index.php">ADMIN PAGE</a>
            </div>
        </div>
    </nav>
    <section>
        <aside id="leftsidebar" class="sidebar">
            <?php include "info.php"; ?>
            <?php include "menu.php"; ?>
        </aside>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>Quản lý</h2>
            </div>
            <?php include "quanly.php"; ?>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>Thống kê đơn hàng theo sản phẩm</h2>
                            <div class="body">
                            <form action="dathang.php" method="get">
                               
                                <a href="xuat_ex.php<?php echo isset($_GET['id']) ? '?id=' . $_GET['id'] : ''; ?>" class="btn btn-success">In ra Excel</a>
                            </form>

                        </div>
                        <div class="body">
                            
                            <?php
                                
                            ?>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                    <thead>
                                        <tr>
                                            <th>ID đơn hàng</th>
                                            <th>Thời gian đặt</th>
                                            <th>Ngành hàng</th>
                                            <th>Tên sản phẩm</th>
                                            <th>Số lượng</th>
                                            <th>Tình trạng</th>
                                            <th>Chi tiết đơn hàng</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    date_default_timezone_set('Asia/Saigon');
                                    while ($row = mysqli_fetch_assoc($category)) {
                                    ?>
                                        <tr>
                                            <td><?php echo $row['id'] ?></td>
                                            <td><?php echo $row['created_time'] ?></td>
                                            <td><?php echo $row['name'] ?></td>
                                            <td><?php echo $row['product_name'] ?></td>
                                            <td><?php echo $row['quantity'] ?></td>
                                            <td class="<?php echo ($row['status'] == 0) ? 'text-danger' : (($row['status'] == 1 || $row['status'] == 2) ? 'text-success' : 'text-danger'); ?>">
                                                <?php
                                                switch ($row['status']) {
                                                    case 0:
                                                        echo "Đang Xử Lý";
                                                        break;
                                                    case 1:
                                                        echo "Đang Giao Hàng";
                                                        break;
                                                    case 2:
                                                        echo "Thành Công";
                                                        break;
                                                    default:
                                                        echo "Đơn hàng bị hủy";
                                                        break;
                                                }
                                                ?>
                                            </td>
                                            <td><a href="./ChiTiet_donhang.php?id=<?= $row['id'] ?>" class="btn btn-blue">Chi tiết</a></td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
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

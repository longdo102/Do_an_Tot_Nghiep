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
<?php
        include './connect_db.php';
        $MaPhieuNhap=$_GET['MaPhieuNhap'];
        $result = mysqli_query($con,"SELECT * FROM chitietphieunhap WHERE MaPhieuNhap = '$MaPhieuNhap'" );
        $total = mysqli_num_rows($result);
        print_r($MaPhieuNhap);

?>
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
    
</head>

<body class="theme-red">
    <!-- Page Loader -->
    <div class="page-loader-wrapper">
        <div class="loader">
            <div class="preloader">
                <div class="spinner-layer pl-red">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div>
            <p>Please wait...</p>
        </div>
    </div>
    <?php

    ?>
    <!-- #END# Page Loader -->
    <!-- Overlay For Sidebars -->
    <div class="overlay"></div>
    <!-- #END# Overlay For Sidebars -->
    <!-- Search Bar -->
    <div class="search-bar">
        <div class="search-icon">
            <i class="material-icons">search</i>
        </div>
        <input type="text" placeholder="START TYPING...">
        <div class="close-search">
            <i class="material-icons">close</i>
        </div>
    </div>
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
                <h2>Quản lý</h2>
            </div>

            <!-- Widgets -->
            <?php
            include "quanly.php";
            ?>
            <!-- #END# Widgets -->
            
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            
            <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                    <div class="header">
                            <h2>
                                Chi tiết phiếu nhập
                            </h2>
                        </div>
                        <div class="body">
                        <div class="buttons">
                        <a href="export_ChitietNhapKho.php<?php echo isset($_GET['MaPhieuNhap']) ? '?MaPhieuNhap=' . $_GET['MaPhieuNhap'] : ''; ?>" class="btn btn-success">In ra Excel</a>
                        <a href="./edit_chitietnhap.php?MaPhieuNhap=<?= $MaPhieuNhap ?>">Tạo chi tiết phiếu</a>
                            

                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                <thead>
                                 <tr>
                                <th>ID </th>
                                
                                <th>Tên Sản phẩm</th>
                                <th>Số lượng</th>
                                
                                <th>Giá tiền </th>
                                
                                </tr>
                                </thead>
                                <tbody>
                                
                                <?php foreach ($result as $value)
                                    {
                                         
                                    ?>
                                <tr>
                                <td><?php echo $value['ID'] ?></td>
                                
                                <td><?php echo $value['TenSP'] ?></td>
                                <td><?php echo $value['SoLuong'] ?></td>
                                <td><?php echo $value['GiaTien'] ?></td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                                </table>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Basic Examples -->
            
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

<?php
include 'connect_db.php';

$category = mysqli_query($con, "SELECT * FROM `phieuxuat`  ");
//B1: tính tổng số bản ghi

$total = mysqli_num_rows($category);

//B2 : THiết lập số bảng ghi trên 1 trang
$limit = 7;
//B3: tính số trang
$page = ceil($total / $limit);
//B4: lấy trang hiện tại
$current_page = (isset($_GET['page']) ? $_GET['page'] : 1);
//B5: tính start
$start = ($current_page - 1) * $limit;
//B6: query sử dụng limit
$category = mysqli_query($con,"SELECT * FROM `phieuxuat` LIMIT $start,$limit");
//print_r($category);exit;
// $stmt = $con->prepare("INSERT INTO `phieuxuat` (`MaPhieuXuat`, `NgayXuat`, `GhiChu`, `MaKho`) VALUES (NULL, ?, ?, ?)");

// // Bind the parameters
// $stmt->bind_param("ssi", $_POST['NgayXuat'], $_POST['GhiChu'], $_POST['MaKho']);

// // Execute the statement
// $stmt->execute();
// $result = $stmt->get_result();
// // Close the statement
// $stmt->close();

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
                <h2>Kho</h2>
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
                                Phiếu xuất
                            </h2>
                        </div>
                        <div class="body">
                        <div class="buttons">
                            <a href="./edit_xuat.php">Tạo phiếu xuất kho</a>
                            
                             </div>
                             <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                    <thead>
                                        <tr>
                                        <td>Mã phiếu xuất</td>
                                        <td>Ngày xuất</td>
                                        <td>Ghi chú</td>
                                        
                                        <td>Mã kho</td>
                                        
                                        <td>Xóa</td>
                                        <td>Chi tiết</td>
                                        </tr>
                                    </thead>
                                    
                                    <tbody>
                                    <?php
                                        while ($row = mysqli_fetch_array($category)) 
                                    {
                                        ?>
                                        <tr>
                                            <td><?= $row['MaPhieuXuat'] ?></td>
                                            <td><?= $row['NgayXuat'] ?></td>
                                            <td><?= $row['GhiChu'] ?></td>
                                           
                                            <td><?= $row['MaKho'] ?></td>
                                            <!-- <td><a href="./edit_xuat.php?MaPhieuXuat=<?= $row['MaPhieuXuat'] ?> " class="btn btn-danger">Sửa</a></td> -->
                                            <td><a href="./delete_xuat.php?MaPhieuXuat=<?= $row['MaPhieuXuat'] ?>" class="btn btn-danger">Xóa</a></td>
                                            <td><a href="./ChiTietXuat.php?MaPhieuXuat=<?= $row['MaPhieuXuat'] ?>" class="btn btn-danger">Xem chi tiết</a></td>
                                        </tr>
                                    <?php 
                                    }
                                     ?>
                                       
                                    </tbody>
                                </table>
                                <div class="pagination-bar my-3">
                                <div class="col-12">
                                    <nav>
                                        <ul class="pagination justify-content-center">
                                        
                                        <ul class="pagination">
                                           
                                        <?php if($current_page -1 > 0) { ?>
                                            <li><a href="xuatkho.php?page=<?php echo $current_page -1 ?>">&laquo;</a></li>
                                            <?php } ?>
                                            <?php for($i=1; $i<=$page ;$i++) { ?>
                                                <li class="<?php echo ($current_page ==$i) ? 'active' : '' ?>"><a href="xuatkho.php?page=<?php echo $i ?>"><?php echo $i ?></a></li>
                                              <?php  }?>
                                              
                                              <?php if($current_page +1 <= $page ) { ?>
                                            <li><a href="xuatkho.php?page=<?php echo $current_page +1 ?>">&raquo;</a></li>
                                            <?php } ?>
                                        </ul>
                                        
                                        
                                        </ul>
                                    </nav>
                                </div>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
            <!-- #END# Basic Examples -->
            
        </div>
        <?php


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

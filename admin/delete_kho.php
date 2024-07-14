<?php
    ?>
    <head>
        <style>
            .main-content {
                text-align: center;
                border: 1px solid;
                width: 100%;
            
            }  
            .main-content h1{
                color: #f44336;
                text-transform: uppercase;
            } 
            a{
                font-size: 30px;
                text-decoration: none;
                margin-bottom: 12px;
                display: block;
            }
            a:hover{
                color: #f44336;
            }

        </style>
    </head>
    <div class="main-content">
        <h1>Xóa kho</h1>
        <div id="content-box">
            <?php
            $error = false;
            

            if (isset($_GET['MaKho']) 
                && !empty($_GET['MaKho']) ) {
                include 'connect_db.php';

                $makho = $_GET['MaKho'];

// Thực hiện truy vấn
                $id_nhap = mysqli_query($con, "SELECT MaPhieuNhap FROM phieunhap WHERE phieunhap.MaKho = '$makho'");
                $id_xuat = mysqli_query($con, "SELECT MaPhieuXuat FROM phieuxuat WHERE phieuxuat.MaKho = '$makho'");

                $id_ctxuat = mysqli_query($con, "SELECT ID FROM chitietphieuxuat WHERE MaPhieuXuat IN (SELECT MaPhieuXuat FROM phieuxuat WHERE MaKho = '$makho');");
                $id_ctnhap = mysqli_query($con, "SELECT ID FROM chitietphieunhap WHERE MaPhieunhap IN (SELECT MaPhieunhap FROM phieunhap WHERE MaKho = '$makho');");
               
                $MaCTPhieuXuat = "";
                $MaPhieuXuat = "";
                $MaCTPhieuNhap = "";
                $MaPhieuNhap = "";

                $result = "";
                $result1 = "";
                $result2 = "";
                $result3 = "";

                if ($id_ctxuat) {
                    while ($row = mysqli_fetch_assoc($id_ctxuat)) {
                        $MaCTPhieuXuat=$row['chitietphieuxuat'];
                        $result = mysqli_query($con, "DELETE FROM `chitietphieuxuat` WHERE `ID` ='$MaCTPhieuXuat' ");
                    }
                }
                if ($id_xuat) {
                    while ($row = mysqli_fetch_assoc($id_xuat)) {
                        $MaPhieuXuat=$row['MaPhieuXuat'];
                        $result1 = mysqli_query($con, "DELETE FROM `phieuxuat` WHERE `MaPhieuXuat` ='$MaPhieuXuat' ");
                    }
                }
                if ($id_ctnhap) {
                    while ($row = mysqli_fetch_assoc($id_ctnhap)) {
                        $MaCTPhieuNhap=$row['chitietphieunhap'];
                        $result2= mysqli_query($con, "DELETE FROM `chitietphieunhap` WHERE `ID` ='$MaCTPhieuNhap'");
                    }
                }
                if ($id_nhap) {
                    while ($row = mysqli_fetch_assoc($id_nhap)) {
                        $MaPhieuNhap=$row['MaPhieuNhap'];
                        $result3 = mysqli_query($con, "DELETE FROM `phieuxuat` WHERE `MaPhieunhap` ='$MaPhieuNhap' ");
                    }
                }
              
               
                // $MaPhieuXuat=$_GET['MaPhieuXuat'];
                // $MaPhieuNhap=$_GET['MaPhieuNhap'];
                // $MaKho=$_GET['MaKho'];

                // $MaPhieuXuat= mysqli_real_escape_string($con, $_GET['MaPhieuXuat']);
                // $MaPhieuNhap= mysqli_real_escape_string($con, $_GET['MaPhieuNhap']);
                // $MaKho = mysqli_real_escape_string($con, $_GET['MaKho']);

                // $result2 = mysqli_query($con, "DELETE FROM `phieuxuat` WHERE `MaKho` ='$MaKho' ");
                // $result3 = mysqli_query($con, "DELETE FROM `chitietphieunhap` WHERE `MaPhieuNhap` ='$MaPhieuNhap' ");
                // $result5= mysqli_query($con, "DELETE FROM `phieunhap` WHERE  `MaKho` ='$MaKho'");
                $result6 = mysqli_query($con, "DELETE FROM `kho` WHERE `MaKho` ='$makho' ");
                
                if (!$result6) {
                    $error = "Không thể xóa kho.";
                }
                mysqli_close($con);
                if ($error !== false) {
                    ?>
                    <div id="error-notify" class="box-content">
                        <h2>Thông báo</h2>
                        <h4><?= $error ?></h4>
                        <a href="kho.php">Danh sách kho</a>
                    </div>
                <?php } else { ?>
                    <div id="success-notify" class="box-content">
                        <h2>Xóa kho thành công</h2>
                        <a href="kho.php" >Danh sách kho</a>
                    </div>
                <?php } ?>
            <?php } ?>
        </div> 
        
    </div>
    <?php
?>
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
        <h1>Xóa phiếu</h1>
        <div id="content-box">
            <?php
            $error = false;
            if (isset($_GET['MaPhieuXuat']) && !empty($_GET['MaPhieuXuat'])) {
                include 'connect_db.php';
                $MaPhieuXuat=$_GET['MaPhieuXuat'];
                $MaPhieuXuat = mysqli_real_escape_string($con, $_GET['MaPhieuXuat']);
               
                $result = mysqli_query($con, "DELETE FROM `chitietphieuxuat` WHERE `MaPhieuXuat` ='$MaPhieuXuat' ");
                $result1 = mysqli_query($con, "DELETE FROM `phieuxuat` WHERE `MaPhieuXuat` ='$MaPhieuXuat' ");
                if (!$result) {
                    $error = "Không thể xóa phiếu.";
                }
                mysqli_close($con);
                if ($error !== false) {
                    ?>
                    <div id="error-notify" class="box-content">
                        <h2>Thông báo</h2>
                        <h4><?= $error ?></h4>
                        <a href="xuatkho.php">Danh sách phiếu</a>
                    </div>
        <?php } else { ?>
                    <div id="success-notify" class="box-content">
                        <h2>Xóa phiếu thành công</h2>
                        <a href="xuatkho.php" >Danh sách phiếu</a>
                    </div>
                <?php } ?>
    <?php } ?>
        </div>
    </div>
    <?php
?>
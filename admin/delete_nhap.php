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
            if (isset($_GET['MaPhieuNhap']) && !empty($_GET['MaPhieuNhap'])) {
                include 'connect_db.php';
                $MaPhieuNhap=$_GET['MaPhieuNhap'];
                $MaPhieuNhap = mysqli_real_escape_string($con, $_GET['MaPhieuNhap']);
                
                $result = mysqli_query($con, "DELETE FROM `chitietphieunhap` WHERE `MaPhieuNhap` ='$MaPhieuNhap' ");
                $result1 = mysqli_query($con, "DELETE FROM `phieunhap` WHERE `MaPhieuNhap` ='$MaPhieuNhap' ");
                if (!$result) {
                    $error = "Không thể xóa phiếu.";
                }
                mysqli_close($con);
                if ($error !== false) {
                    ?>
                    <div id="error-notify" class="box-content">
                        <h2>Thông báo</h2>
                        <h4><?= $error ?></h4>
                        <a href="nhapkho.php">Danh sách phiếu</a>
                    </div>
        <?php } else { ?>
                    <div id="success-notify" class="box-content">
                        <h2>Xóa phiếu thành công</h2>
                        <a href="nhapkho.php" >Danh sách phiếu</a>
                    </div>
                <?php } ?>
    <?php } ?>
        </div>
    </div>
    <?php
?>
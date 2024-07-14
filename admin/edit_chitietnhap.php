<link rel="stylesheet" type="text/css" href="css/admin_style.css">
<script src="resources/ckeditor/ckeditor.js"></script>
<style>
    .danhmuc {
        min-width: 200px;
        height: 30px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }
    .hidden {
        display: none;}
</style>
<?php
include 'connect_db.php';
include 'function.php';
       // $MaPhieuNhap=$_GET['MaPhieuNhap'];
    //    // $sql = "SELECT * FROM `chitietphieunhap` WHERE MaPhieuNhap = '$MaPhieuNhap'";
    //     $menu =  mysqli_query ($con,"SELECT * FROM `chitietphieuxuat` WHERE `MaPhieuXuat` = ".$_REQUEST['MaPhieuXuat']);
    //     $menu_pro = mysqli_fetch_assoc($menu );
?>
<div class="main-content">
    <h1>Tạo phiếu nhập kho</h1>
    <div id="content-box">
        <?php
        //$MaPhieuNhap=$_GET['MaPhieuNhap'];
        // $sql = "SELECT * FROM `chitietphieunhap` WHERE MaPhieuNhap = $_GET['MaPhieuNhap']";
        // $menu = mysqli_query($con, $sql);
        // $menu_pro = mysqli_fetch_all($menu, MYSQLI_ASSOC);
        // echo"<pre>";
        // print_R($menu_pro);
        if (isset($_GET['action']) && ($_GET['action'] == 'add' || $_GET['action'] == 'edit')) {
            if (isset($_POST['TenSP']) && !empty($_POST['TenSP']) && isset($_POST['SoLuong']) && !empty($_POST['SoLuong']) &&  isset($_POST['GiaTien']) && !empty($_POST['GiaTien'])) {
                $galleryImages = array();
                if (empty($_POST['TenSP'])) {
                    $error = "Bạn phải nhập tên sản phẩm";
                }
                elseif (empty($_POST['SoLuong'])) {
                    $error = "Bạn phải nhập số lượng";
                }
                elseif (empty($_POST['GiaTien'])) {
                    $error = "Bạn phải nhập giá tiền";
                }
                //  elseif (empty($_POST['GhiChu'])) {
                //     $error = "Bạn phải nhập ghi chú";
                // } 
                
                if (!isset($error)) {
                    //if ($_GET['action'] == 'edit' && !empty($_GET['MaPhieuXuat'])) { //Cập nhật lại sản phẩm
                    //    $result = mysqli_query($con, "UPDATE `product` SET `menu_id` = '" . $_POST['menu_id'] . "',`name` = '" . $_POST['name'] . "',`image` =  '" . $image . "', `price` = " . str_replace('.', '', $_POST['price']) . ", `price_new` = " . str_replace('.', '', $_POST['price_new']) . ", `price_nhap` = " .str_replace('.','',$_POST['price_nhap']) . ", `content` = '" . $_POST['content'] . "', `last_updated` = " . time() . " WHERE `product`.`id` = " . $_GET['id']);
                    //} 
                    //else { //Thêm sản phẩm
                        //print_r('abc'.$_POST['NgayNhap'].' '. $_POST['GhiChu'] . ' ' .  $_POST['MaKho']);
                        //$_POST['GhiChu'] = str_replace(array('<p>', '</p>'), '', $_POST['GhiChu']);


                        // $result = mysqli_query($con, "INSERT INTO `phieuxuat` (`MaPhieuXuat`,`NgayNhap`, `GhiChu`, `MaKho`) VALUES (NULL, '" . $_POST['NgayNhap'] . "','" . $_POST['GhiChu'] . "','" . $_POST['MaKho'] . "');");
                        $stmt = $con->prepare("INSERT INTO `chitietphieunhap` (`MaPhieuNhap`,`TenSP`, `SoLuong`,`GiaTien`) VALUES ( ?, ?, ?,?)");

                        // Bind the parameters
                        $stmt->bind_param("isii", $_POST['MaPhieuNhap'], $_POST['TenSP'],$_POST['SoLuong'], $_POST['GiaTien']);

                        // Execute the statement
                        $stmt->execute();

                        // Close the statement
                        $stmt->close();
                    }
                    // if (!$result) { //Nếu có lỗi xảy ra
                    //     $error = "Có lỗi xảy ra trong quá trình thực hiện.";
                    // } 
                    // else { //Nếu thành công
                    //     if (!empty($galleryImages)) {
                    //         $product_id = ($_GET['action'] == 'edit' && !empty($_GET['id'])) ? $_GET['id'] : $con->insert_id;
                    //         $insertValues = "";
                    //         foreach ($galleryImages as $path) {
                    //             if (empty($insertValues)) {
                    //                 $insertValues = "(NULL, " . $product_id . ", '" . $path . "', " . time() . ", " . time() . ")";
                    //             } else {
                    //                 $insertValues .= ",(NULL, " . $product_id . ", '" . $path . "', " . time() . ", " . time() . ")";
                    //             }
                    //         }
                    //         $result = mysqli_query($con, "INSERT INTO `image_library` (`id`, `product_id`, `path`, `created_time`, `last_updated`) VALUES " . $insertValues . ";");
                    //     }
                    // }
                }
             else {
                $error = "Bạn chưa nhập thông tin phiếu nhập.";
            }
        ?>
            <div class="container">
                <div class="error"><?= isset($error) ? $error : "Cập nhật thành công" ?></div>
                <a href="nhapkho.php">Quay lại danh sách phiếu nhập</a>
            </div>

            <?php
            } 
                ?>
        <?php
        //}
        //  else {
        //     if (!empty($_GET['id'])) {
        //         $result = mysqli_query($con, "SELECT * FROM `product` WHERE `id` = " . $_GET['id']);
        //         $product = $result->fetch_assoc();
        //         $gallery = mysqli_query($con, "SELECT * FROM `image_library` WHERE `product_id` = " . $_GET['id']);
        //         if (!empty($gallery) && !empty($gallery->num_rows)) {
        //             while ($row = mysqli_fetch_array($gallery)) {
        //                 $product['gallery'][] = array(
        //                     'id' => $row['id'],
        //                     'path' => $row['path']
        //                 );
        //             }
        //         }
        //     }
        ?>
            <form id="product-form" method="POST" action="<?= (!empty($product) && !isset($_GET['task'])) ? "?action=edit&id=" . $_GET['MaPhieuNhap'] : "?action=add" ?>" enctype="multipart/form-data">
                <input type="submit" title="Lưu phiếu" value="" />
                <?php
                // echo $result;
                // print_r($result);
                ?>

                <div class="clear-both"></div>
                <div class="wrap-field">
                    <label>Tên Sản Phẩm: </label>
                    <input type="text" name="TenSP" value="<?= (!empty($product) ? $product['TenSP'] : "") ?>" />
                    <div class="clear-both"></div>
                </div>
                <div class="wrap-field">
                    <label>Số Lượng </label>
                    <input type="text" name="SoLuong" value="<?= (!empty($product) ? $product['SoLuong'] : "") ?>" />
                    <div class="clear-both"></div>
                </div>
                <div class="wrap-field">
                    <label>Giá tiền/ Sản Phẩm </label>
                    <input type="text" name="GiaTien" value="<?= (!empty($product) ? $product['GiaTien'] : "") ?>" />
                    <div class="clear-both"></div>
                </div>

                <!-- <div class="wrap-field">
                    <label>Ghi chú: </label>
                    <textarea name="GhiChu" id="product-content"><?= (!empty($product) ? $product['GhiChu'] : "") ?></textarea>
                    <div class="clear-both"></div>
                </div> -->
                
                <div class="wrap-field hidden">
                    <label>Mã phiếu nhập </label>
                    <?php  $abc=$_GET['MaPhieuNhap']; ?>
                    <input type="text" name="MaPhieuNhap" value="<?php  echo $abc; ?>" />
                    <div class="clear-both"></div>
                </div>
                <!-- <div class="wrap-field" style="margin-top: 20px;">
                    <label>Mã Phiếu nhập </label>
                    <select name="MaPhieuNhap" class="danhmuc">
                        <?php foreach ($menu_pro as $value) {
                        ?>
                            <option value="<?php echo $value['MaPhieuNhap'] ?>"> 

                        <?php } ?>

                    </select>
                    <div class="clear-both"></div>
                </div> -->

            </form>
            <div class="clear-both"></div>
            <script>
                // Replace the <textarea id="editor1"> with a CKEditor
                // instance, using default configuration.
                // Phuchuu
                CKEDITOR.replace('product-content');
            </script>
        <?php //} ?>
    </div>
</div>

<?php
?>
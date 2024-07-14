<link rel="stylesheet" type="text/css" href="css/admin_style.css">
<script src="resources/ckeditor/ckeditor.js"></script>
<style>
    .danhmuc {
        min-width: 200px;
        height: 30px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }
</style>
<?php
include 'connect_db.php';
include 'function.php';

?>
<div class="main-content">
    <h1>Tạo phiếu nhập kho</h1>
    <div id="content-box">
        <?php
        $sql = "SELECT * FROM `kho` order by MaKho ASC";
        $menu = mysqli_query($con, $sql);
        $menu_pro = mysqli_fetch_all($menu, MYSQLI_ASSOC);
        // echo"<pre>";
        // print_R($menu_pro);
        if (isset($_GET['action']) && ($_GET['action'] == 'add' || $_GET['action'] == 'edit')) {
            if (isset($_POST['NgayNhap']) && !empty($_POST['NgayNhap']) && isset($_POST['GhiChu']) && !empty($_POST['GhiChu']) &&  isset($_POST['NhaCC']) && !empty($_POST['NhaCC'])) {
                $galleryImages = array();
                if (empty($_POST['GhiChu'])) {
                    $error = "Bạn phải nhập ngày nhập kho";
                }
                elseif (empty($_POST['NhaCC'])) {
                    $error = "Bạn phải nhập nhà cung cấp";
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
                        $_POST['GhiChu'] = str_replace(array('<p>', '</p>'), '', $_POST['GhiChu']);


                        // $result = mysqli_query($con, "INSERT INTO `phieuxuat` (`MaPhieuXuat`,`NgayNhap`, `GhiChu`, `MaKho`) VALUES (NULL, '" . $_POST['NgayNhap'] . "','" . $_POST['GhiChu'] . "','" . $_POST['MaKho'] . "');");
                        $stmt = $con->prepare("INSERT INTO `phieunhap` (`NgayNhap`, `GhiChu`,`NhaCC`, `MaKho`) VALUES ( ?, ?, ?,?)");

                        // Bind the parameters
                        $stmt->bind_param("sssi", $_POST['NgayNhap'], $_POST['GhiChu'],$_POST['NhaCC'], $_POST['MaKho']);

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
                $error = "Bạn chưa nhập thông tin phiếu xuất.";
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
                    <label>Ngày xuất phiếu: </label>
                    <input type="date" name="NgayNhap" value="<?= (!empty($product) ? $product['NgayNhap'] : "") ?>" />
                    <div class="clear-both"></div>
                </div>
                <div class="wrap-field">
                    <label>Nhà cung cấp: </label>
                    <input type="text" name="NhaCC" value="<?= (!empty($product) ? $product['NhaCC'] : "") ?>" />
                    <div class="clear-both"></div>
                </div>

                <div class="wrap-field">
                    <label>Ghi chú: </label>
                    <textarea name="GhiChu" id="product-content"><?= (!empty($product) ? $product['GhiChu'] : "") ?></textarea>
                    <div class="clear-both"></div>
                </div>
                
                <div class="wrap-field" style="margin-top: 20px;">
                    <label>Kho: </label>
                    <select name="MaKho" class="danhmuc">
                        <?php foreach ($menu_pro as $value) {
                        ?>
                            <option value="<?php echo $value['MaKho'] ?>"> <?php echo $value['TenKho'] ?></option>

                        <?php } ?>

                    </select>
                    <div class="clear-both"></div>
                </div>

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
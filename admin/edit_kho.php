<link rel="stylesheet" type="text/css" href="css/admin_style.css" >
<script src="resources/ckeditor/ckeditor.js"></script>
<style>
    .danhmuc{
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
    <h1>Tạo kho</h1>
        <div id="content-box">
            <?php
            $sql = "SELECT * FROM `kho`";
            $menu = mysqli_query($con,$sql);
            $menu_pro = mysqli_fetch_all($menu,MYSQLI_ASSOC);
            if (isset($_GET['action']) && ($_GET['action'] == 'add' || $_GET['action'] == 'edit')) {
                if (isset($_POST['TenKho']) && !empty($_POST['TenKho']) && isset($_POST['DiaChi']) && !empty($_POST['DiaChi']) && isset($_POST['QuanLyKho']) && !empty($_POST['QuanLyKho'])) {
                    if (empty($_POST['TenKho'])) {
                        $error = "Bạn phải nhập tên kho";
                    } 
                    elseif (empty($_POST['DiaChi'])) {
                        $error = "Bạn phải nhập địa chỉ kho";
                    } 
                    elseif (empty($_POST['QuanLyKho'])) {
                        $error = "Bạn phải nhập tên quản lý kho";
                    } 
                    if (!isset($error)) {
                        // if ($_GET['action'] == 'edit' && !empty($_GET['MaKho'])) { //Cập nhật lại sản phẩm
                        //   //  $result = mysqli_query($con, "UPDATE `kho` SET `MaKho` = '" . $_POST['MaKho'] . "',`TenKho` = '" . $_POST['TenKho'] . "' ,`DiaChi` = '" . $_POST['DiaChi'] . "',`QuanLyKho` = '" . $_POST['QuanLyKho'] . "' WHERE `kho`.`MaKho` = " . $_GET['MaKho']);
                        // } else { //Thêm sản phẩm
                            $result = mysqli_query($con, "INSERT INTO `Kho` (`TenKho`, `DiaChi`, `QuanLyKho`) VALUES ('" . $_POST['TenKho'] . "', '" . $_POST['DiaChi'] . "', '" . $_POST['QuanLyKho'] . "');");
                        //}
                        if (!$result) { //Nếu có lỗi xảy ra
                            $error = "Kho đã tồn tại";
                        } 
                    }
                } else {
                    $error = "Bạn chưa nhập thông tin kho.";
                }
                ?>
                <div class = "container">
                    <div class = "error"><?= isset($error) ? $error : "Thêm kho thành công" ?></div>
                    <a href = "kho.php">Quay lại danh sách kho</a>
                </div>
                <?php
            } 
                ?>
                <form id="product-form" method="POST" action="<?= (!empty($product) && !isset($_GET['task'])) ? "?action=edit&id=" . $_GET['MaKho'] : "?action=add" ?>"  enctype="multipart/form-data">
                    <input type="submit" title="Lưu sản phẩm" value="" />
                    <div class="clear-both"></div>
                    <div class="wrap-field">
                        <label>Tên kho: </label>
                        <input type="text" name="TenKho" value="<?= (!empty($product) ? $product['TenKho'] : "") ?>" />
                        <div class="clear-both"></div>
                    </div>
                    <div class="wrap-field">
                        <label>Địa chỉ kho: </label>
                        <input type="text" name="DiaChi" value="<?= (!empty($product) ? $product['DiaChi'] : "") ?>" />
                        <div class="clear-both"></div>
                    </div>
                    <div class="wrap-field">
                        <label>Tên quản lý kho: </label>
                        <input type="text" name="QuanLyKho" value="<?= (!empty($product) ? $product['QuanLyKho'] : "") ?>" />
                        <div class="clear-both"></div>
                    </div>
                </form>
                <div class="clear-both"></div>
                <script>
                    // Replace the <textarea id="editor1"> with a CKEditor
                    // instance, using default configuration.
                    CKEDITOR.replace('product-content');
                </script>
        </div>
    </div>

    <?php
?>

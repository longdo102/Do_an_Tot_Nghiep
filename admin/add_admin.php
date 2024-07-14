<style>
    .role {
        min-width: 200px;
        height: 30px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }
</style>
<?php
if (!isset($_SESSION)) {
    session_start();
}
include './connect_db.php';
$error = [];
if (isset($_POST['username'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $rpassword = $_POST['rpassword'];
    $status = $_POST['status'];
    $role = $_POST['role'];

    if (empty($username)) {
        $error['username'] = 'Bạn chưa nhập tên đăng nhập';
    }
    if (empty($password)) {
        $error['password'] = 'Bạn chưa nhập mật khẩu';
    }
    if ($password != $rpassword) {
        $error['rpassword'] = 'Mật khẩu nhập lại không đúng';
    }
    if (empty($status)) {
        $error['status'] = 'Bạn chưa nhập trạng thái';
    }
    if (empty($role)) {
        $error['role'] = 'Bạn chưa nhập vai trò';
    }
    if (empty($error)) {
        $sql = mysqli_query($con, "INSERT INTO `admin` (`username`, `password`, `status`, `role`) VALUES ('$username', ('$password'),'$status', '$role')");

        if ($sql) {
?>
            <div id="edit-notify" class="box-content">
                <h1><?= "Đăng ký tài khoản thành công" ?></h1>
                <a href="./nhanvien.php">Quay lại</a>
            </div>
<?php
        }
    }
}
?>
<!DOCTYPE html>
<html>
<style>
    .has-error {
        color: violet;
    }
</style>

<head>
    <title>Register</title>
    <!-- for-mobile-apps -->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="keywords" content="User Register Form Widget Responsive, Login form web template, Sign up Web Templates, Flat Web Templates, Login signup Responsive web template, Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
    <!-- //for-mobile-apps -->
    <link href='//fonts.googleapis.com/css?family=Lato:400,100,100italic,300italic,300,400italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>
    <link href='//fonts.googleapis.com/css?family=Amaranth:400,400italic,700,700italic' rel='stylesheet' type='text/css'>
    <link rel="icon" type="logo/png" sizes="32x32" href="logo/logo.png">
    <link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
</head>

<body>


    <div class="content">
        <h1>Thêm nhân viên mới</h1>
        <div class="main">

            <form action="./add_admin.php" method="Post" autocomplete="off">
                <h5>Username</h5>
                <input type="text" name="username" value=""><br />
                <div class="has-error">
                    <span>
                        <?php echo (isset($error['username'])) ? $error['username'] : '' ?>
                    </span>
                </div>
                <h5>Password</h5>
                <input type="password" name="password" value="" /></br>
                <div class="has-error">
                    <span>
                        <?php echo (isset($error['password'])) ? $error['password'] : '' ?>
                    </span>
                </div>
                <h5>Re-Password</h5>
                <input type="password" name="rpassword" value="" /></br>
                <div class="has-error">
                    <span>
                        <?php echo (isset($error['rpassword'])) ? $error['rpassword'] : '' ?>
                    </span>
                </div>
                <h5>Trạng thái</h5>
                <input type="text" name="status" value="" /><br />
                <div class="has-error">
                    <span>
                        <?php echo (isset($error['status'])) ? $error['status'] : '' ?>
                    </span>
                </div>
                <h5>Role</h5>
                <input type="text" name="role" value="" /><br />
                <div class="has-error">
                    <span>
                        <?php echo (isset($error['role'])) ? $error['role'] : '' ?>
                    </span>
                </div>
                <input type="submit" value="Đăng ký">
            </form>
        </div>
    </div>

</body>

</html>
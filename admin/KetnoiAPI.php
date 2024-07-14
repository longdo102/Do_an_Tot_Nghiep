<?php
  session_start();
?>
<link rel="stylesheet" type="text/css" href="css/admin_style.css">
<script src="resources/ckeditor/ckeditor.js"></script>

<style>
    .danhmuc {
        min-width: 200px;
        height: 30px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    .btn-connect {
        margin-bottom: 30px;
        margin-top: 30px;
    }

    .title-connect {
        margin-top: 30px;
    }

    .darksoul-hover-fill-button1 {
  margin: auto;
  display: flex;
  width: 200px;
  height: 50px;
  border-radius: 5px;
  outline: none;
  border: 1px solid #00FA9A;
  background-color: white;
  font-family: "Belanosima", sans-serif;
  cursor: pointer;
  align-items: center;
  justify-content: left;
}
.color-fill-1 {
  position: absolute;
  margin-left: -7px;
  width: 2px;
  height: 50px;
  background-color: #00FA9A;
  visibility: hidden;
}
.darksoul-hover-fill-button1:hover .color-fill-1 {
  visibility: visible;
  width: 200px;
  height: 50px;
  border-radius: 5px;
  transition: all cubic-bezier(0.445, 0.05, 0.55, 0.95) 0.5s;
}
.darksoul-hover-fill-button1:hover {
  box-shadow: 1px 1px 20px  #00FA9A;
  transition: all 1s;
}
.darksoul-hover-fill-button1 p {
  margin: auto;
  z-index: 10;
}

.darksoul-hover-fill-button2 {
  margin: auto;
  display: flex;
  width: 200px;
  height: 50px;
  border-radius: 25px;
  outline: none;
  border: 1px solid #00FA9A;
  background-color: white;
  font-family: "Belanosima", sans-serif;
  cursor: pointer;
  align-items: center;
  justify-content: left;
}
.color-fill-2 {
  position: absolute;
  margin-left: -7px;
  width: 20px;
  height: 50px;
  border-radius: 25px 0px 0px 25px;
  background-color: #00FA9A;
  visibility: hidden;
}
.darksoul-hover-fill-button2:hover .color-fill-2 {
  visibility: visible;
  width: 200px;
  height: 50px;
  border-radius: 25px;
  transition: all 0.5s;
  background-color: #00FA9A;
}
.darksoul-hover-fill-button2:hover {
  box-shadow: 1px 1px 20px #00FA9A;
  transition: all 1s;
}
.darksoul-hover-fill-button2 p {
  margin: auto;
  z-index: 10;
}

.darksoul-hover-fill-button3 {
  margin: auto;
  display: flex;
  width: 200px;
  height: 50px;
  border-radius: 5px;
  outline: none;
  border: 1px solid rgb(255, 204, 86);
  background-color: white;
  font-family: "Belanosima", sans-serif;
  cursor: pointer;
  align-items: center;
  justify-content: left;
}
.color-fill-3 {
  position: absolute;
  margin-left: -7px;
  width: 200px;
  height: 1px;
  background-color: rgb(255, 204, 86);
  visibility: hidden;
}
.darksoul-hover-fill-button3:hover .color-fill-3 {
  visibility: visible;
  width: 200px;
  height: 50px;
  border-radius: 5px;
  transition: all 0.5s;
  background-color: rgb(255, 204, 86);
}
.darksoul-hover-fill-button3:hover {
  box-shadow: 1px 1px 20px rgb(255, 204, 86);
  transition: all 1s;
}
.darksoul-hover-fill-button3 p {
  margin: auto;
  z-index: 10;
}
@media only screen and (max-width: 600px) {
  body {
    flex-direction: column;
  }
}
.disclaimer {
  position: absolute;
  bottom: 0px;
  left: 0;
  margin-left: auto;
  right: 0;
  margin-right: auto;
  width: fit-content;
  color: rgb(0, 0, 0);
  text-align: center;
}
.disclaimer a {
  text-decoration: none;
  color: #202020;
  font-family: "Kaushan Script", cursive;
  font-weight: 900;
}
.disclaimer a:hover {
  text-decoration: overline;
}

.darksoul-hover-fill-button2 > p
{
    font-size: 16px;
}
</style>
<?php
include 'connect_db.php';

?>
<div class="main-content">

    <h1>Kết Nối</h1>
    <form id="product-form" method="POST" action="" enctype="multipart/form-data" class="title-connect">
        <div class="clear-both"></div>
        <div class="wrap-field">
            <label for="shop_key">Shop Key:</label>
            <input type="text" id="shop_key" name="shop_key" required>
            <label for="secret_key">Secret Key:</label>
            <input type="text" id="secret_key" name="secret_key" required>
            <div class="clear-both"></div>
            <button class="btn-connect darksoul-hover-fill-button2" type="submit">
                <div class="color-fill-2"></div>
                <p>Connect</p>
            </button>
            
        </div>
       
                
                <a href="index.php "><h4>Quay lại</h4></a>
            
        <?php
        
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Lấy dữ liệu từ form
            $shop_key = htmlspecialchars($_POST['shop_key']);
            $secret_key = htmlspecialchars($_POST['secret_key']);

            // Tạo mảng dữ liệu
            $data = array(
                'shop_key' => $shop_key,
                'secret_key' => $secret_key
            );

            // Xử lý dữ liệu ở đây (ví dụ: lưu trữ vào file hoặc hiển thị)
            $url = 'https://open.sendo.vn/login';
            $headers = array(
                'Content-Type: application/json;charset=utf-8'
            );

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            curl_close($ch);

            $responseData = json_decode($response);

            if ($responseData->success) {
                $token = $responseData->result->token;
                $_SESSION['token'] = $token;
                echo $token;
                echo "<h4 style='font-size:20px;'>Kết nối thành công!</h4>";
            } else {
                echo "<h4 style='font-size:20px;'>Kết nối chưa thành công. Vui lòng kiểm tra lại Mã shop và Mã bảo mật!</h4>";
            }
        }

        ?>
    </form>
</div>
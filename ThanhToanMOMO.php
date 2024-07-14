<?php
header('Content-type: text/html; charset=utf-8');
if(!isset($_SESSION))
{
    session_start();
}
include './connect_db.php';

$cart = (isset($_SESSION['cart'])) ? $_SESSION['cart'] : [];
function execPostRequest($url, $data)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen($data)
    ));
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);

    $result = curl_exec($ch);

    if ($result === false) {
        $error = curl_error($ch);
        curl_close($ch);
        throw new Exception('cURL error: ' . $error);
    }

    curl_close($ch);
    return $result;
}

// Calculate total price from cart
$total_price = 0;
foreach ($cart as $key => $value) {
    $total_price += ($value['price'] * $value['quantity']);
}

$endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";
$partnerCode = getenv('MOMO_PARTNER_CODE') ?: 'MOMOBKUN20180529';
$accessKey = getenv('MOMO_ACCESS_KEY') ?: 'klm05TvNBzhg7h7j';
$secretKey = getenv('MOMO_SECRET_KEY') ?: 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';

$orderInfo = "Thanh toán qua MoMo";
$amount = $total_price;  // Use total price as the amount
$orderId = time() . "";
$redirectUrl = "https://webhook.site/b3088a6a-2d17-4f8d-a383-71389a6c600b";
$ipnUrl = "https://webhook.site/b3088a6a-2d17-4f8d-a383-71389a6c600b";
$extraData = "";

$requestId = time() . "";
$requestType = "captureWallet";

$rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;
$signature = hash_hmac("sha256", $rawHash, $secretKey);

$data = array(
    'partnerCode' => $partnerCode,
    'partnerName' => "Test",
    "storeId" => "MomoTestStore",
    'requestId' => $requestId,
    'amount' => $amount,
    'orderId' => $orderId,
    'orderInfo' => $orderInfo,
    'redirectUrl' => $redirectUrl,
    'ipnUrl' => $ipnUrl,
    'lang' => 'vi',
    'extraData' => $extraData,
    'requestType' => $requestType,
    'signature' => $signature
);

try {
    $result = execPostRequest($endpoint, json_encode($data));
    $jsonResult = json_decode($result, true);

    if (isset($jsonResult['payUrl'])) {
        header('Location: ' . $jsonResult['payUrl']);
        exit();
    } else {
        throw new Exception('Error in response: ' . $result);
    }
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
}
?>

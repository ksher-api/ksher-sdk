<?php
include_once 'ksher_pay_sdk.php';
$appid='mch20027';
$privatekey=<<<EOD
-----BEGIN RSA PRIVATE KEY-----
MIIBOgIBAAJBAMhFg7PoOgSvUWzfTv4xerdNRc0lZMGTh71dV3g0d4GEO88tOlph
LTPVnBGVvpvFvhYDgDQqWtGIm8NIHopQDJsCAwEAAQJADYmVY33ZHiPzrxZRMqGJ
mAZjJ4DVlLgyPrymgvuY8GovDisXC/4Oo2JCwGJLJEiYWvWJqkLIMnMfF9Mj6pEx
oQIhAPxbrlTCZsoxIXoftfA79EoXpPyJnQ26C4dcbkxQOAWZAiEAyylnP8uxMOIP
MsgXT1LF+WTGfw4JZyQCmJDKlIbFnFMCIHU6caVWGUHbyN1eVbofX7/7c90MYDS8
NBbRTTuOGDghAiEAoN2u4Kf0LOXC7Q3czzWWhyxRtEc0ENRFrfJwRf0VOfsCIFwg
IATE8U+GHPfygz0oBJwLfPaOAIdxup1x38UswEl/
-----END RSA PRIVATE KEY-----
EOD;

set_time_limit(0);
$class = new KsherPay($appid, $privatekey);
$action = isset($_POST['action']) ? $_POST['action'] : '';

if ($action == 'native_pay') {
	echo "<br />---------<br />native_pay:<br />";
	$native_pay_data = array(
		"mch_order_no" => $_POST['mch_order_no'],
		"total_fee" => round($_POST['total_fee'], 2) * 100,
		"fee_type" => $_POST['fee_type'],
		"channel" => $_POST['channel'],
		"notify_url" => 'http://' . $_SERVER['HTTP_HOST'] . "/test/demo/demo_notify.php", //回调地址
		);

	$native_pay_response = $class->native_pay($native_pay_data);
	$native_pay_array = json_decode($native_pay_response, true);


	if (isset($native_pay_array['code']) && $native_pay_array['code'] == 0 && $native_pay_array['data']['imgdat']) {
		echo "<h2> Successfully Create C Scan B Order</h2>";
		echo "<p>Please scan QR code:<p>";
		echo "\n<img src='" . $native_pay_array['data']['imgdat'] . "'alt='payment qr code'>\n";
	} else {
		echo "<h2> Fail to Create C Scan B Order</h2>";
		echo "<p1> Here's the raw response :</p1>";
	print_r($native_pay_array);
	}
	exit;
} else if ($action == 'gateway_pay') {
	echo "<br />gateway_pay<br />";
	$gateway_pay_data = array(
		'mch_order_no' => $_POST['mch_order_no'],
		"total_fee" => round($_POST['total_fee'], 2) * 100,
        "fee_type" => $_POST['fee_type'],
		"channel_list" => 'promptpay,wechat,alipay,truemoney,airpay,linepay,card',
        'mch_code' => $_POST['mch_order_no'],
        'mch_redirect_url' => 'http://www.ksher.cn',
        'mch_redirect_url_fail' => 'http://www.ksher.cn',
		'product_name' => $_POST['product_name'],
        'refer_url' => 'http://www.ksher.cn',
		"mch_notify_url" => 'http://' . $_SERVER['HTTP_HOST'] . "/test/demo/demo_notify.php",
		'device' => 'PC'
	);

    $gateway_pay_response = $class->gateway_pay($gateway_pay_data);
    $gateway_pay_array = json_decode($gateway_pay_response, true);

	if (isset($gateway_pay_array['data']['pay_content'])) {
		echo "<h2> Successfully Create Redirect Order</h2>";
		echo '<a href=' . $gateway_pay_array['data']['pay_content'] . '>enter link to pay</a>';
	} else {
		echo "<h2> Fail to create Redirect Order</h2>";
		echo "<p1> Here's the raw response </p1>";
		echo $gateway_pay_response;
    }
    exit();
} elseif ($action == 'order_query') {
	echo "<br />order query<br />";
	$order_query_data = array('mch_order_no' => $_POST['mch_order_no']);
    $order_query_response = $class->order_query($order_query_data);
    $order_query_array = json_decode($order_query_response, true);
	echo '<br />response parameter：<br />';
    print_r($order_query_response);
    exit();

} elseif ($action == 'order_refund') {
	echo "<br />order_refund<br />";
	$order_refund_data = array(
		'mch_order_no' => $_POST['mch_order_no'],
		'mch_refund_no' => $_POST['mch_refund_no'],
		"total_fee" => round($_POST['total_fee'], 2) * 100,
		"refund_fee" => round($_POST['refund_fee'], 2) * 100,
		'fee_type' => $_POST['fee_type'],
	);
    $order_refund_response = $class->order_refund($order_refund_data);
    $order_refund_array = json_decode($order_refund_response, true);
	echo '<br />response parameter：<br />';
    print_r($order_refund_response);
    exit();

}  elseif ($action == 'refund_query') {
	echo "<br />refund_query<br />";
	$refund_query_data = array(
		'mch_order_no' => $_POST['mch_order_no']
	);
    $refund_query_response = $class->refund_query($refund_query_data);
    $refund_query_array = json_decode($refund_query_response, true);
	echo '<br />response parameter：<br />';
    print_r($refund_query_response);
    exit();

} elseif ($action == 'gateway_order_query') {
	echo "<br />gateway_pay_query<br />";
	$gateway_query_data = array('mch_order_no' => $_POST['mch_order_no']);
    $gateway_query_response = $class->gateway_order_query($gateway_query_data);
    $gateway_query_array = json_decode($gateway_query_response, true);
	echo '<br />response parameter：<br />';
    print_r($gateway_query_response);
    exit();

} elseif ($action == 'quick_pay') {
	echo "<br />---------<br />quick_pay:<br />";
	$quick_pay_data = array(
		"mch_order_no" => $_POST['mch_order_no'],
		"total_fee" => round($_POST['total_fee'], 2) * 100,
		"fee_type" => $_POST['fee_type'],
		"auth_code" => $_POST['auth_code'],
		"device_id" => $_POST['device_id'],
		"notify_url" => 'http://' . $_SERVER['HTTP_HOST'] . "/test/demo/demo_notify.php",
		);

	$quick_pay_response = $class->quick_pay($quick_pay_data);
	$quick_pay_array = json_decode($quick_pay_response, true);
	echo "<br />response parameter：<br />";
	print_r($quick_pay_array);
	if (isset($quick_pay_array['code']) && $quick_pay_array['code'] == 0 && $quick_pay_array['data']['result'] == 'SUCCESS') {
		echo "SUCCESS";
	}
	exit();
} elseif ($action == 'get_payout_balance') {
	echo "<br />---------<br />get_payout_balance:<br />";
	$get_payout_balance_data = array(
		"fee_type" => $_POST['fee_type']
		);

	$qet_payout_balance_response = $class->get_payout_balance($get_payout_balance_data);
	$get_payout_balance_array = json_decode($qet_payout_balance_response, true);
	echo "<br />response parameter：<br />";
	print_r($get_payout_balance_array);
	if (isset($get_payout_balance_array['code']) && $get_payout_balance_array['code'] == 0 && $get_payout_balance_array['data']['result'] == 'SUCCESS') {
		echo "SUCCESS";
	}
	exit();
} elseif ($action == 'payout') {
	echo "<br />---------<br />payout:<br />";
	$payout_data = array(
		"mch_order_no" => $_POST['mch_order_no'],
		"total_fee" => round($_POST['total_fee'], 2) * 100,
		"fee_type" => $_POST['fee_type'],
		"channel" => "payout",
		"receiver_mobile" => $_POST['receiver_mobile'],
		"receiver_no" => $_POST['receiver_no'],
		"receiver_type" => $_POST['receiver_type']
		);

	$payout_response = $class->payout($payout_data);
	$payout_array = json_decode($payout_response, true);
	echo "<br />response parameter：<br />";
	print_r($payout_array);
	// if (isset($payout_array['code']) && $payout_array['code'] == 0 && $payout_array['data']['result'] == 'SUCCESS') {
	// 	echo "SUCCESS";
	// }
	exit();
} elseif ($action == 'order_query_payout') {
	echo "<br />---------<br />payout:<br />";
	$order_query_payout_data = array(
		"channel" => "payout",
		"mch_order_no" => $_POST['mch_order_no']
		);

	$order_query_payout_response = $class->payout($order_query_payout_data);
	$order_query_payout_array = json_decode($order_query_payout_response, true);
	echo "<br />response parameter：<br />";
	print_r($order_query_payout_array);
	if (isset($order_query_payout_array['code']) && $order_query_payout_array['code'] == 0 && $order_query_payout_array['data']['result'] == 'SUCCESS') {
		echo "SUCCESS";
	}
	exit();
} else{
	echo "not select";
	exit();
}
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
$action = isset($_POST['action']) ? $_POST['action'] : 'quick_pay';

if($action == 'native_pay'){
	echo "<br />---------<br />native_pay支付:<br />";
	$native_pay_data = array("mch_order_no" => $_POST['mch_order_no'],
		"total_fee" => round($_POST['local_total_fee'], 2)*100,
		"fee_type" => $_POST['fee_type'],
		"channel" => 'wechat',
		"notify_url" => 'http://'.$_SERVER['HTTP_HOST']."/test/demo/demo_notify.php", //回调地址
		);
	$native_pay_response = $class->native_pay($native_pay_data);
	$native_pay_array = json_decode($native_pay_response, true);
	echo "<br />返回参数：<br />";
	print_r($native_pay_array);
	if(isset($native_pay_array['code']) && $native_pay_array['code'] == 0 && $native_pay_array['data']['imgdat']){
		echo "<br /><hr /><br />请扫码：<img src='".$native_pay_array['data']['imgdat']."' />";
	}
	exit;
}else if($action == 'gateway_pay'){
    echo "<br />gateway_pay支付<br />";
    $gateway_pay_data = array('mch_order_no'=>$_POST['mch_order_no'],
        "total_fee" => round($_POST['local_total_fee'], 2)*100,
        "fee_type" => $_POST['fee_type'],
        "channel_list" => 'wechat,alipay,linepay,truemoney',
        'mch_code' => $_POST['mch_order_no'],
        'mch_redirect_url' => 'http://www.ksher.cn',
        'mch_redirect_url_fail' => 'http://www.ksher.cn',
        'product_name' => '商品名称',
        'refer_url' => 'http://www.ksher.cn',
        'device' => 'PC');
    $gateway_pay_response = $class->gateway_pay($gateway_pay_data);
    $gateway_pay_array = json_decode($gateway_pay_response, true);
    echo '<br />返回参数：<br />';
    if (isset($gateway_pay_array['data']['pay_content'])){
        echo '<a href='.$gateway_pay_array['data']['pay_content'].'>pay 去支付</a>';
    }else{
        print_r($gateway_pay_response);
    }
    exit();
}elseif($action == 'gateway_order_query'){
    echo "<br />gateway_pay_query支付查询<br />";
    $gateway_query_data = array('mch_order_no'=>$_POST['mch_order_no']);
    $gateway_query_response = $class->gateway_order_query($gateway_query_data);
    $gateway_query_array = json_decode($gateway_query_response, true);
    echo '<br />返回参数：<br />';
    print_r($gateway_query_response);
    exit();
}else{
	echo "<br />---------<br />quick_pay支付:<br />";
	$native_pay_data = array(
		"mch_order_no" => $_POST['mch_order_no'],    // 80000001
		"total_fee" => round($_POST['total_fee'], 2)*100,   //100    //$_POST['total_fee'] 
		"fee_type" => 'JPY',
		"auth_code" => $_POST['auth_code'],  //'111111111'
		"device_id" => $_POST['device_id'],  //'pos_00001'
		);
	$quick_pay_response = $class->quick_pay($native_pay_data);
	$quick_pay_array = json_decode($quick_pay_response, true);
	echo "<br />返回参数：<br />";
	print_r($quick_pay_array);
	if(isset($quick_pay_array['code']) && $quick_pay_array['code'] == 0 && $quick_pay_array['data']['result'] == 'SUCCESS'){
		echo "SUCCESS";
	}
	exit;
}


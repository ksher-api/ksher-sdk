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

$time = date("Y-m-d H:i:s", time());
$class = new KsherPay($appid, $privatekey);

//1.接收参数
$input = file_get_contents("php://input");
tempLog("------notify data ".$time." begin------" );
$query = urldecode($input);
if( !$query){
    tempLog("NO RETURN DATA" );
    echo json_encode(array('result'=>'FAIL',"msg"=>'NO RETURN DATA'));
    exit;
}
//2.验证参数
$data_array = json_decode($query,true);
tempLog("notify data :".json_encode( $data_array) );
if( !isset( $data_array['data']) || !isset( $data_array['data']['mch_order_no']) || !$data_array['data']['mch_order_no']){
    tempLog("notify data FAIL" );
    echo json_encode(array('result'=>'FAIL',"msg"=>'RETURN DATA ERROR'));
    exit;
}
//3.处理订单
if( array_key_exists("code", $data_array)
    && array_key_exists("sign", $data_array)
    && array_key_exists("data", $data_array)
    && array_key_exists("result", $data_array['data'])
    && $data_array['data']["result"] == "SUCCESS"){
    //3.1验证签名
    $verify_sign = $class->verify_ksher_sign($data_array['data'], $data_array['sign']);
    tempLog("IN IF function sign :". $verify_sign );
    if( $verify_sign==1 ){
        //更新订单信息 change order status
        //....
        tempLog('change order status');
    }
}
//4.返回信息
tempLog("------notify data ".$time." end------" );
echo json_encode(array('result'=>'SUCCESS',"msg"=>'OK'));


function tempLog( $string ){
    if( !$string ) return false;
    $file = dirname(__FILE__)."/notify_log_".date("Ymd").".txt";
    $handle = fopen( $file, 'a+');
    fwrite( $handle , $string."\r");
    fclose( $handle );
}
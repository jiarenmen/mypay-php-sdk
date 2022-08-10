<?php
//下单案例

include 'config.php';
include 'myPay.class.php';
$myPay=new myPay();

$out_trade_no=date("YmdHis");//生成订单号
$siteurl = ($_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://').$_SERVER['HTTP_HOST']; //获取当前网站地址

//请求参数
$data=array(
	'mid'=>$mypay_config['id'],
	'out_trade_no'=>$out_trade_no,//你平台的订单号
	'price'=>0.02,//支付金额
	'pay_type'=>1,//支付方式，1微信，2支付宝，3QQ
	'notify_url'=>$siteurl.'/notify.php',//异步回调跳转地址
	'return_url'=>$siteurl.'/success.php',//同步回调跳转地址
);
//生成签名并加入到请求参数里
$data['sign']=$myPay->getSign($mypay_config['key'],$data);

$url=$mypay_config['url']."/api/client.order/place_order?";//下单地址
//拼接URL所有GET参数
foreach($data as $k=>$v){
	$url.="&".$k."=".urlencode($v);
}

//跳转下单URL(拼接的URL链接)
echo "<script>window.location.href='{$url}';</script>";
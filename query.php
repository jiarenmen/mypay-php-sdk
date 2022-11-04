<?php
//查询订单案例

include 'config.php';
include 'myPay.class.php';
$myPay=new myPay();

//请求参数
$data=array(
    'mid'=>$mypay_config['id'],
	'out_trade_no'=>'2022110418414887214707',//你平台的订单号
	'timestamp'=>time(),
);

//生成签名并加入到请求参数里
$data['sign']=$myPay->getSign($mypay_config['key'],$data);

$res=json_decode($myPay->post($mypay_config['url']."/api/client.order/query",$data),true);
if(isset($res['code'])){
	if($res['code']==10000){
		//查询成功

		/**  以下为$res的结构
		Array
		(
			[code] => 10000
			[message] => 查询成功
			[data] => Array
				(
					[id] => 130
					[sid] => 1
					[order_no] => 2022110418414928718594
					[supplier_no] => 2022110422001407821454183314
					[out_trade_no] => 2022110418414887214707
					[price] => 0.01
					[original_price] => 0.01
					[pay_type] => 2
					[pay_status] => 1
					[create_time] => 1667558509
					[payment_time] => 1667558536
					[timeout_time] => 1667562109
					[gateway] => 2
					[notify_url] => http://yanzheng.giao.cc/index
					[return_url] => http://yanzheng.giao.cc/index/buy
					[notify_status] => 2
					[code_id] => 0
					[account_id] => 0
					[source] => 0
				)

		)
		*/
		print_r($res);
	}else{
		//出现失败 $res['message'] 是失败返回的内容
		echo $res['message'];
	}
}else{
	echo "查询失败";
	//查询失败，请求出错
}

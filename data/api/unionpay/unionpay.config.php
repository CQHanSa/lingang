﻿<?php
header ( 'Content-type:text/html;charset=utf-8' );

require_once(dirname(__FILE__).'/../../../Common/index.php');


if($money<0 && $userid=='' && $username==''){
	header('location:/member.php');
	exit();	
}

$row = $dosql->GetOne("SELECT id,username FROM `#@__member` WHERE `id`='$userid'");
if($row['username']!=$username){
	header('location:/member.php');
	exit();	
}

$userid=AuthCode($row['id'] ,'ENCODE');



require_once(dirname(__FILE__).'/func/common.php');
require_once(dirname(__FILE__).'/func/SDKConfig.php');
require_once(dirname(__FILE__).'/func/secureUtil.php');
require_once(dirname(__FILE__).'/func/log.class.php');
/**
 * 消费交易-前台 
 */


/**
 *	以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己需要，按照技术文档编写。该代码仅供参考
 */
// 初始化日志
$log = new PhpLog ( SDK_LOG_FILE_PATH, "PRC", SDK_LOG_LEVEL );
$log->LogInfo ( "============处理前台请求开始===============" );
// 初始化日志
$params = array(
		'version' => '5.0.0',				//版本号
		'encoding' => 'utf-8',				//编码方式
		'certId' => getSignCertId (),			//证书ID
		'txnType' => '01',				//交易类型	
		'txnSubType' => '01',				//交易子类
		'bizType' => '000201',				//业务类型
		'frontUrl' =>  'http://localhost/data/api/unionpay/Balance_FrontReceive.php',  		//前台通知地址
		'backUrl' => 'http://localhost/data/api/unionpay/Balance_BackReceive.php',		//后台通知地址	
		'signMethod' => '01',		//签名方法
		'channelType' => '07',		//渠道类型，07-PC，08-手机
		'accessType' => '0',		//接入类型
		'merId' => '777290058112538',		        //商户代码，请改自己的测试商户号
		'orderId' => date('YmdHis'),	//商户订单号
		'txnTime' => date('YmdHis'),	//订单发送时间
		'txnAmt' => $money*100,		//交易金额，单位分
		'currencyCode' => '156',	//交易币种
		'defaultPayType' => '0001',	//默认支付方式	
		//'orderDesc' => '订单描述',  //订单描述，网关支付和wap支付暂时不起作用
		'reqReserved' =>$userid, //请求方保留域，透传字段，查询、通知、对账文件中均会原样出现
		);


// 签名
sign ( $params );


// 前台请求地址
$front_uri = SDK_FRONT_TRANS_URL;
$log->LogInfo ( "前台请求地址为>" . $front_uri );
// 构造 自动提交的表单
$html_form = create_html ( $params, $front_uri );

$log->LogInfo ( "-------前台交易自动提交表单>--begin----" );
$log->LogInfo ( $html_form );
$log->LogInfo ( "-------前台交易自动提交表单>--end-------" );
$log->LogInfo ( "============处理前台请求 结束===========" );
echo $html_form;

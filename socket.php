<?php require_once(dirname(__FILE__).'/Common/index.php'); ?>
<?php
set_time_limit(0);//无限请求超时时间
if(!isset($_GET['sid'])){ message('非法访问','javascript:window.close()');exit();  }
$shopid = get('sid');
$shop = MysqlOneSelect('lgsc_shops','*',"id='$shopid'");
$touserid = get('uid');
$r_user = MysqlOneSelect('lgsc_member','avatar',"id='$user[userid]'");

//更新浏览记录状态
//$rest = MysqlOneExc('lgsc_socket',"state=1",'update',"touserid='$user[userid]'");
/*if($user['userid'] == $shop['userid'])
{
	$togoodsid = '';
	$touserid = '';
	$toshopid = '';
}*/
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="edge" />
    <title>商家在线客服</title>
    <link rel="stylesheet" type="text/css"  href="css/socket.skin.css" />
    <link rel="stylesheet" type="text/css"  href="css/socket.style.css" />
    <style type="text/css">
        .hiddenElem
        {
            display: none;
        }
    </style>
    <script type="text/javascript">
        var pid = '1351586523';
        var imgUrl = new String('jfs/t601/206/1774498/300457/3b13e1d5/54460496N3797172a.jpg');
        var advertiseWord = "";
        var wname = "";
        try{
            advertiseWord = new String('【领券立减60】小狗新一代机皇！买就赠床褥除螨器！');
        }
        catch (e){
            advertiseWord = "";
        }
        try{
            wname = new String('小狗（puppy）小型无耗材超静音除螨家用吸尘器D-9005');
        }
        catch (e){
            wname="";
        }
        var price = new String('http://jprice.360buyimg.com/price/gp1351586523-1-1-3.png');
        var stock = new String('北京朝阳区三环以内(有货)');
        var score = new String('5');
        var commentNum = new String('13644');
        var pin = '';
        var pamsUid = '68c98a8c-c63a-4288-a511-c1d5c2437c5b';
        var evaluationRate = new String('100');
        var msgElves = new String('');
        var lastwaiter = new String('');
        var wid = new String('');
        var JSessionId = '${sessionId}';
        var entry = '';
        var fromAgile = '';
        var fromConvChat = '';
        var waiterSeq = '';
        var consultGid='';
        var oid = '';
    </script>
</head>
<body>
<!-- 【建议】设置最小高度和最小宽度 -->
<div class="im-wrap">
<!-- im头部 -->
<div class="im-header">
    <a href="/shops.php?sid=<?=$shopid?>" class="im-logo" target="_blank" id="shopLogo">
        <img src="/<?=$shop['shop_logo']?>" title="<?=$shop['shopname']?>">
    </a>
    <span class="im-split-line"></span>
    <span id="shopLogo"></span>
    <span class="im-chat-object" id="logoTitle"><?=$shop['shopname']?></span>
    <div class="im-btn-area" id="win_title">
        <a href="#" id="j_chatMax" class="im-btn-max" title="最大化" style="display: block;"></a>
        <a href="#" id="j_chatRestore" class="im-btn-min" title="还原" style="display: none;"></a>
        <a href="#" id="j_chatClose" class="im-btn-close" title="关闭"></a>
    </div>

</div>
<!-- im主题内容 -->
<div class="im-content">
<div class="im-main-content">
<div class="im-chat-window">
	<div id="scrollDiv" class="im-chat-list" style="height:333px;">
		<div class="im-msg im-msg-notice"><i class="im-icon-notice"></i>
        	<p>还在为咨询客服不能截图，不能看聊天记录而风中凌乱吗？<img style="vertical-align:middle" src="http://static.360buyimg.com/im/img/s73.gif"><br><a target="_blank" href="http://dongdong.jd.com/?hmsr=chat&amp;hmmd=&amp;hmpl=&amp;hmkw=&amp;hmci=">京东咚咚客户端</a>已经全新上线啦，新功能新体验，保障交易安全，<a href="http://jss.360buy.com/outLinkServicePoint/e73c73fd-5dbc-419b-944b-89417446132c.exe" target="_blank">猛戳下载</a></p>
            <span class="im-msg-tl"></span><span class="im-msg-tr"></span><span class="im-msg-bl"></span>
            <span class="im-msg-br"></span>
		</div>
         
		<div class="im-msg im-msg-prompt" style="display:none">
            <i class="im-icon-exclamation"></i>
            <p><span id="risk_sys_msg">为了保护您的账号安全，请直接回复下图问题的计算结果！<br><img style="height:30px;padding:10px;" src="http://storage.jd.com/jdim_file/144170269596642322219255481614.jpg"></span></p><span class="im-msg-tl"></span><span class="im-msg-tr"></span><span class="im-msg-bl"></span>
            <span class="im-msg-br"></span>
		</div>
        
		<div class="im-msg im-msg-notice" style="display:none">
            	<i class="im-icon-notice"></i>
                <p>客服 小狗官方旗舰店-依依 已加入会话，为保证您的服务质量，请您在服务结束后，点击“小红心”为本次服务做出评价</p>
                <span class="im-msg-tl"></span><span class="im-msg-tr"></span>
                <span class="im-msg-bl"></span><span class="im-msg-br"></span>
		</div>
        
        
        
        
       
       </div>
    <div class="im-edit-area">
        <div class="im-edit-toolbar">
            <!-- hover效果加class im-icon-word-hover -->
           <!-- <a href="#" class="im-icon-word" id="j_font" title="设置字体"></a>
            <a href="#" class="im-icon-face" title="选择表情" id="expressionButton"></a>
            <a href="#" class="im-icon-pic" title="贴图">
                <span class="im-txt" id="sendImageButton"></span>
            </a>
            <a href="#" class="im-icon-file" title="上传文件">
                <span class="" id="sendFileButton"></span>
            </a>-->
            <a href="#" class="im-icon-bell" title="震客服一下" id="actionVibrationButton"></a>
            <a href="/chatlog/chatlog.action" target="_blank" class="im-icon-msg-record" title="消息记录"></a>
            <a href="#" class="im-recommend-situation" id="degreeButton">
                <i class="im-icon-hart"></i>
                <span class="im-txt">满意度评价</span>
            </a>
            <!-- 上传文件 图片 -->
            <div class="im-upload-content flash" style=" position: absolute; left: 0px; right:0; z-index: 99; bottom: 40px; height:0px;" id="fsUploadProgress"></div>

            <!-- 字体弹出层 -->
            <div class="im-pop-word j_popWord" style="display:none">
                <select class="t_inp" name="text_in_font_type" id="text_in_font_type">
                </select>
                <select class="h_inp" name="text_in_font_size" id="text_in_font_size">
                </select>
                <a href="#" class="im-icon-color im-icon-color-hover" title="设置颜色" id="colorButton"> </a>
                <a href="#" class="im-icon-close" title="关闭" id="j_fontClose"></a>
                <!-- 选择颜色样式pop -->
                <div class="im-pop-color" style="bottom: 32px; left: 160px;" id="colorPanel">
                </div>
            </div>

            <!-- 表情弹出层 -->
            <div class="im-pop-face" id="j_popFace" style="top: -130px; left: 41px;position:absolute;z-index:100;display:none">
            </div>
            <!-- 评价弹出层 -->
            <div class="im-pop-recommend j_recommend"  style="left: 216px; top: -212px; width:391px; display:none">
                <p>您对当前客服人员服务满意吗？</p>
                <p>
                    <label style="margin-right:11px;"><input type="radio" name="degree" value="100" id="degree100">非常满意</label>
                    <label style="margin-right:11px;"><input type="radio" name="degree" value="75" id="degree75">满意</label>
                    <label style="margin-right:11px;"><input type="radio" name="degree" value="50" id="degree50">一般</label>
                    <label style="margin-right:11px;"><input type="radio" name="degree" value="25" id="degree25">不满意</label>
                    <label style="margin-right:11px;"><input type="radio" name="degree" value="0" id="degree0">非常不满意</label>
                </p>
                <div style="display:none" class="degreeeq50">
                    <p>您的问题解决了吗？</p>
                    <p>
                        <input type="radio" name="sloveQ" value="1" />解决了
                        <input type="radio" name="sloveQ" value="-1" />没解决
                    </p>
                </div>
                <div style="display:none" class="degreelt50">
                    <p>您不满意的原因是？</p>
                    <p class="evaq_list">
                        <input type="checkbox" value="2" />问题没有得到解决
                        <input type="checkbox" value="3" />对客服态度不满意
                        <input type="checkbox" value="5" />客服对业务不熟悉
                    </p>
                </div>
                <div class="im-recommend-edit-area">
                    <textarea class="im-edit-ipt" id="degreeContent"></textarea>
                    <div class="im-edit-tip" id="degreeInput">还可以输入<span class="im-txt-num">256</span>字</div>
                </div>
                <div class="im-btn-area">
                    <a href="#" class="im-btn im-btn-submit" id="submitDegreeButton">
                        <span class="im-txt">提交</span>
                        <span class="im-btn-l"></span>
                        <span class="im-btn-r"></span>
                    </a>
                </div>
                <div class="degree-tip" style="color:red;display:none">请您对当前客服的服务做一个评价</div>
            </div>
        </div>


        <div class="im-edit-ipt-area">
            <!--
            <textarea class="im-edit-ipt" placeholder="请说明您要咨询的问题……"></textarea>-->
            <div id="text_in" placeholder="请说明您要咨询的问题……" class="im-edit-ipt" style="OVERFLOW-Y: auto;  FONT-WEIGHT: normal; FONT-SIZE: 12px; OVERFLOW-X: hidden; WORD-BREAK: break-all; FONT-STYLE: normal; outline:none; " contenteditable="true"></div>
        </div>
        <div class="im-edit-btn-area">
            <div class="im-link-area">
                <a href="http://chat.jd.com/jdchat/dispute.action" target="_blank"  class="im-txt-link jf" style="display:none;">交易纠纷联系京东客服</a>
            </div>
            <div class="im-btn-send-area" title="按Enter键换行,按Ctrl+Enter键发送">
                <a href="#" class="im-btn im-btn-send" id="sendMsg" 
                    touserid="<?=$uid?>" 
                    toshopid="<?=$sid?>" 
                    togoodsid='' 
                    avatar="<?=$r_user['avatar']?>" 
                    username="<?=$user['username']?>" 
                    userid="<?=$user['userid']?>" 
                 >
                    <span class="im-txt">发送</span>
                    <span class="im-btn-l"></span>
                </a>
                <a href="#" class="im-btn im-btn-send-set "  id="change" title="发送设置">
                    <i class="im-icon-arrow-down"></i>
                    <span class="im-btn-r"></span>
                </a>
                <!-- 编辑发送浮层 -->
                <div class="im-pop-send-set cbut" style="position: absolute; top: 0; right: -250px;display:none;">
                    <ul class="im-send-set-list">
                        <!-- 当前高亮加class current -->
                        <li class="im-item current" id="hotkey1">
                            <a href="#" class="im-item-content">
                                <i class="im-icon-right"></i>
                                <span class="im-txt">按Enter键换行,按Ctrl+Enter键发送</span>
                            </a>
                        </li>
                        <li class="im-item" id="hotkey2">
                            <a href="#" class="im-item-content">
                                <i class="im-icon-right"></i>
                                <span class="im-txt">按Enter键换行,按Ctrl+Enter键发送</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <a href="#" class="im-btn im-btn-close" id="talk_c">
                <span class="im-txt">结束对话</span>
                <span class="im-btn-l"></span>
                <span class="im-btn-r"></span>
            </a>
            <div class="im-edit-tip" id="chat_count">按Enter键换行,按Ctrl+Enter键发送</div>
        </div>
    </div>
</div>
<div class="im-right-sidebar">
<div class="im-shop-service">
<ul class="im-tab im-shop-tab">
        <li class="im-item current">
            <div class="im-item-content" style="width: 76px;">咨询商品</div>
        </li>
        <li class="im-item">
        	<div class="im-item-content" style="width: 75px;">店铺信息</div>
    	</li>
    	<!--<li class="im-item">
        	<div class="im-item-content" style="width: 75px;">我的订单</div>
    	</li>
   		 <li class="im-item">
        	<div class="im-item-content" style="width: 133px;">最近的返修/退换</div>
    	</li>-->
</ul>
<div class="im-tab-contents">
    <!-- 商品咨询 -->
<div class="im-tab-content" style="display:none;height:320px;overflow:auto;">
<?php if(!isset($_GET['goodsid'])){ ?>
<div class="im-shop-info" id="j_noShopInfo" ><p class="im-txt-lighter im-txt-center">暂无数据</p></div>
<?php } ?>
<div class="im-product-info" <?=isset($_GET['goodsid']) ? '' : 'style="display:none"'?>>
<div class="im-product-pic">
<a href="http://item.jd.com/1351586523.html" target="_blank">
	<img src="http://img10.360buyimg.com/n4/jfs/t601/206/1774498/300457/3b13e1d5/54460496N3797172a.jpg" title='【领券立减60】小狗新一代机皇！买就赠床褥除螨器！'>
											</a>
										</div>
										<div class="im-product">
											<div class="im-product-title">小狗（puppy）小型无耗材超静音除螨家用吸尘器D-9005</div>
										    <div class="im-product-title">
											     <a href="http://item.jd.com/1351586523.html" target="_blank" title='【领券立减60】小狗新一代机皇！买就赠床褥除螨器！'>【领券立减60】小狗新一代机皇！买就赠床褥除螨器！</a>
										    </div>
											<div class="im-btn-area">
    <a href="http://gate.jd.com/InitCart.aspx?pid=1351586523&pcount=1&ptype=1" target="_blank" class="im-btn-addtocart" title="加入购物车">加入购物车<b></b></a>
</div>
</div>

    <p class="im-item">
        京&nbsp;东&nbsp;价：<span class="im-txt-rmb" id="j_price">&yen;799.00</span>
    </p>
            <p class="im-item">
            库&nbsp;&nbsp;&nbsp;&nbsp;存：<span class="im-txt-blue">北京朝阳区三环以内(有货)</span>
        </p>
                <p class="im-item">
            好评得分：<i class="im-icon-start im-icon-start-5" title="5分"></i><span class="im-txt-blue">(13644条评论)</span>
        </p>
                <p class="im-item">
            好&nbsp;评&nbsp;率：<span class="im-txt-blue">100%</span>好评
        </p>
    </div>
    <div class="im-common-question">
        <div class="im-title">常见问题</div>
        <ul class="im-question-list" style="height:120px;overflow:auto;">
        </ul>
    </div>
</div>
<!-- 店铺信息 -->
<div class="im-tab-content" style="display:block;">
    <div class="im-shop-info" id="j_noShopInfo" style="display:none"><p class="im-txt-lighter im-txt-center">暂无数据</p></div>
    <div class="im-shop-info" id="j_shopInfo">
        <p class="im-item">
            店铺名称：<?=$shop['shopname']?>
        </p>
        <p class="im-item">
            卖&nbsp;&nbsp;&nbsp;&nbsp;家：<?=$shop['shop_username']?>
        </p>
         <p class="im-item">
            店铺地址：<?=one_cas($shop['shop_prov'])?> <?=one_cas($shop['shop_city'])?> <?=one_cas($shop['shop_town'])?><?=$shop['shop_address']?>
        </p>
        <p class="im-item">
            综合评分：<i class="im-icon-start im-icon-start-5" title="5分"></i>
        </p>
        <p class="im-item" >
            联系电话：<?=$shop['shop_tel']?>
        </p>

        <table class="im-shop-info-table">
            <tr>
                <th colspan="2" width="">店铺动态评分</th>
                <th>与行业相比</th>
            </tr>
            <tr>
                <td width="60">描述相符：</td>
                <td width="100" id="productScore"><i class="im-icon-start im-icon-start-5" title="5分"></i></td>
                <!-- 升箭头用class im-txt-rise -->
                <td width="100" id="productRatio"><span></span></td>
            </tr>
            <tr>
                <td width="60">服务态度：</td>
                <td width="100" id="serviceScore"><i class="im-icon-start im-icon-start-5" title="5分"></i></td>
                <!-- 降箭头用class im-txt-rise -->
                <td width="100" id="serviceRatio"><span ></span></td>
            </tr>
            <tr>
                <td width="60">发货速度：</td>
                <td width="100" id="timeScore"><i class="im-icon-start im-icon-start-5" title="5分"></i></td>
                <!-- 升箭头用class im-txt-rise -->
                <td width="100" id="timeRatio"><span ></span></td>
            </tr>
        </table>
    </div>
    <div class="im-common-question">
        <div class="im-title">常见问题</div>
        <ul class="im-question-list" style="height:120px;overflow:auto;">
        </ul>
    </div>
</div>
<div class="im-tab-content" style="display: none;">
    <div class="im-order-info no-order" style="display:none"><p class="im-txt-lighter im-txt-center">暂无数据</p></div>
    <div class="im-order-info orders" style="display:none">
        <div class="im-order-info-more">
            <div class="im-pagination">
                <a href="#" class="im-item im-btn im-btn-gray" id="j_prevBtn">
                    <span class="im-txt">上页</span>
                    <span class="im-btn-l"></span>
                    <span class="im-btn-r"></span>
                </a>
                <span class="im-item im-txt" id="j_orderNum">1/5</span>
                <a href="#" class="im-item im-btn im-btn-gray" id="j_nextBtn">
                    <span class="im-txt">下页</span>
                    <span class="im-btn-l"></span>
                    <span class="im-btn-r"></span>
                </a>
            </div>
            <a href="http://jd2008.jd.com/JdHome/OrderList.aspx" class="im-read-more im-txt-link" target="blank">查看更多>></a>
        </div>

        <div class="im-blue-box im-order-detail">
            <div class="im-item-group">
                <div class="im-label im-txt-light">订单状态：</div>
                <div class="im-label-content" id="j_orderState"></div>
            </div>
            <div class="im-item-group">
                <div class="im-label im-txt-light">订单编号：</div>
                <div class="im-label-content" id="j_orderId"></div>
            </div>
            <div class="im-item-group">
                <div class="im-label im-txt-light">订单金额：</div>
                <div class="im-label-content" id="j_shouldPay"></div>
            </div>
            <div class="im-item-group">
                <div class="im-label im-txt-light">支付方式：</div>
                <div class="im-label-content" id="j_paymentTypeName"></div>
            </div>
            <div class="im-item-group">
                <div class="im-label im-txt-light">收货人：</div>
                <div class="im-label-content" id="j_customerName"></div>
            </div>
            <div class="im-item-group">
                <div class="im-label im-txt-light">下单时间：</div>
                <div class="im-label-content" id="j_dateSubmit"></div>
            </div>
            <div class="im-item-group">
                <div class="im-label im-txt-light">下单商品：</div>
                <div class="im-label-content">
                    <ul class="im-order-pics" id="j_wareImgUrl">
                    </ul>
                </div>
            </div>
        </div>
        <div class="im-blue-box im-order-detail" style="display:none">
            <div class="im-item-group">
                <div class="im-label im-txt-light">送货方式：</div>
                <div class="im-label-content"></div>
            </div>
            <div class="im-item-group">
                <div class="im-label im-txt-light">承运人：</div>
                <div class="im-label-content"></div>
            </div>
            <div class="im-item-group">
                <div class="im-label im-txt-light">运货单号：</div>
                <div class="im-label-content"></div>
            </div>
            <hr class="im-item-group-line">
            <div class="im-item-group">
                <div class="im-label im-txt-light">支付方式：</div>
                <div class="im-label-content"></div>
            </div>
            <div class="im-item-group">
                <div class="im-label im-txt-light">收货人：</div>
                <div class="im-label-content"></div>
            </div>
            <div class="im-item-group">
                <div class="im-label im-txt-light">下单时间：</div>
                <div class="im-label-content"></div>
            </div>
        </div>
    </div>
</div>
<!-- 最近的返修/退换货 -->
<div class="im-tab-content" style="display: none;">
    <div class="im-order-info no-reqairs" style="display:none"><p class="im-txt-lighter im-txt-center">暂无数据</p> </div>
    <div class="im-order-info reqairs" style="display:none">
        <div class="im-order-info-more">
            <div class="im-pagination">
                <a href="#" class="im-item im-btn im-btn-gray" id="j_repairPrevBtn">
                    <span class="im-txt">上页</span>
                    <span class="im-btn-l"></span>
                    <span class="im-btn-r"></span>
                </a>
                <span class="im-item im-txt" id="j_repairNum">1/5</span>
                <a href="#" class="im-item im-btn im-btn-gray" id="j_repairNextBtn">
                    <span class="im-txt">下页</span>
                    <span class="im-btn-l"></span>
                    <span class="im-btn-r"></span>
                </a>
            </div>
            <a href="http://myjd.jd.com/repair/repairs.action" class="im-read-more im-txt-link" target="blank">查看订单>></a>
        </div>

        <div class="im-blue-box im-order-detail">
            <div class="im-item-group">
                <div class="im-label im-txt-light">编号：</div>
                <div class="im-label-content" id="j_repairId">107636789</div>
            </div>
            <div class="im-item-group">
                <div class="im-label im-txt-light">当前状态：</div>
                <div class="im-label-content" id="j_repairStatus">等待客户确认</div>
            </div>
            <div class="im-item-group">
                <div class="im-label im-txt-light">申请时间：</div>
                <div class="im-label-content" id="j_repairTime">2013-03-19</div>
            </div>
            <div class="im-item-group">
                <div class="im-label im-txt-light">商品名称：</div>
                <div class="im-label-content" id="j_repairWareName">美国宝丽来Polaroid合金系列男士半框架拉斯框架 67731 GUC</div>
            </div>
        </div>
    </div>
</div>

</div>
</div>
</div>
</div>
</div>
</div>
</body>
<script type="text/javascript" src="js/jquery-1.11.2.min.js"></script>
<script type="text/javascript" src="js/style.common.js"></script>
<script type="text/javascript" src="js/style.socket.js"></script>
</html>

</body>
</html>
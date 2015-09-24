<?php if(!defined('IN_MEMBER')) exit('Request Error!'); 

$web_name="商品管理";


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="utf-8">
<title><?php echo $cfg_webname; ?> - <?php echo $web_title?></title>
<link href="/css/css.css" rel="stylesheet" type="text/css" />
<link href="/css/common.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="/css/order.css"/>
<link rel="stylesheet" type="text/css" href="/css/member.css">
<script type="text/javascript" src="/js/jquery-1.11.2.min.js"></script>
<script type="text/javascript" src="/templates/default/js/member.js"></script>
<script type="text/javascript" src="/templates/default/js/getuploadify.js"></script>
<script type="text/javascript" src="/js/click.js"></script>
</head>

<body>
<!-- 顶部信息 -->
<?php include_once("../../public/top.php") ?>

<!-- logo+搜索 -->
<?php include_once("../../public/logo_search.php") ?>

<!-- 导航菜单栏 -->
<?php include_once("../../public/menu.php") ?>

<div class="icontent">
	<div class="icontent_c">
    	<!-- 当前位置 -->
    	<div class="order_top">
        	当前位置：<a href="/">首页</a>&gt;<a href="/member.php"><?php echo $web_title?></a>&gt;<?php echo $web_name?>
        </div>
        
        <?php include_once("./leftinfo.php") ?>
        
        <div class="order_cont1 t_right">
        	<div class="sr_ordernum1">
            	<span class="fr"><a href="?action=goods_edit" class="btn1 mt10">添加商品</a></span>
            	<span class="page_bt"><?php echo $web_name?></span>
                <div class="divclear"></div>
            </div>
            
            <div class="door_type">
            	<span><b>门店分类：</b></span>
                <span class="door_xz">
                    <select>
                    	<option>分类一</option>
                    	<option>分类二</option>
                    	<option>分类三</option>
                    	<option>分类四</option>
                    </select>
                    <div class="divclear"></div>
                </span>
                <span class="door_xz">
                    <select>
                    	<option>分类一</option>
                    	<option>分类二</option>
                    	<option>分类三</option>
                    	<option>分类四</option>
                    </select>
                    <div class="divclear"></div>
                </span>
            	<span><b>商品：</b></span>
                <span class="sp_sr"><input type="text"></span>
                <span class="select_btn"><a>查询</a></span>
                <div class="divclear"></div>
            </div>
            
            <div class="sp_lbcz">
            	<div class="sp_btnj">
                    <ul>
                        <li class="sp_bg1"><a href="#">删除</a></li>
                        <li class="sp_bg2"><a href="#">下架</a></li>
                        <li class="sp_bg3"><a>推荐</a></li>
                        <li class="sp_bg4"><a>精品</a></li>
                        <li class="sp_bg5"><a>新品</a></li>
                        <li class="sp_bg6"><a>热销</a></li>
                        <li class="sp_bg7"><a>添加</a></li>
                    </ul>
                </div>
                <table class="sp_cz" cellpadding="0" cellspacing="0" border="0">
                	<thead>
                	<tr>
                    	<td><div><label><input type="checkbox"></label></div></td>
                    	<td>商品名称</td>
                    	<td>价格</td>
                    	<td>推荐</td>
                    	<td>精品</td>
                    	<td>新品</td>
                    	<td>热销</td>
                    	<td>上架</td>
                    	<td>审核</td>
                    	<td>库存</td>
                    	<td>操作</td>
                    </tr>
                    </thead>
                    <tbody>
                	<tr>
                    	<td><div><input type="checkbox" name="checkid[]" id="checkid[]" value="1" /></div></td>
                    	<td><a><img src="/images/cp_01.png"><span>asdfassdfsdfsdf</span></a></td>
                    	<td>21.00</td>
                    	<td><i class="sh_true"></i></td>
                    	<td><i class="sh_true"></i></td>
                    	<td><i class="sh_false"></i></td>
                    	<td><i class="sh_true"></i></td>
                    	<td><i class="sh_true"></i></td>
                    	<td><i class="sh_true"></i></td>
                    	<td>98</td>
                    	<td>
                        	<a>查看</a>|<a>修改</a>|<a>删除</a>
                        </td>
                    </tr>
                    <tr>
                    	<td><div><input type="checkbox" name="checkid[]" id="checkid[]" value="1" /></div></td>
                    	<td><a><img src="/images/cp_01.png"><span>asdfassdfsdfsdf</span></a></td>
                    	<td>21.00</td>
                    	<td><i class="sh_true"></i></td>
                    	<td><i class="sh_true"></i></td>
                    	<td><i class="sh_false"></i></td>
                    	<td><i class="sh_true"></i></td>
                    	<td><i class="sh_true"></i></td>
                    	<td><i class="sh_true"></i></td>
                    	<td>98</td>
                    	<td>
                        	<a>查看</a>|<a>修改</a>|<a>删除</a>
                        </td>
                    </tr>
                    <tr>
                    	<td><div><input type="checkbox" name="checkid[]" id="checkid[]" value="1" /></div></td>
                    	<td><a><img src="/images/cp_01.png"><span>asdfassdfsdfsdf</span></a></td>
                    	<td>21.00</td>
                    	<td><i class="sh_true"></i></td>
                    	<td><i class="sh_true"></i></td>
                    	<td><i class="sh_false"></i></td>
                    	<td><i class="sh_true"></i></td>
                    	<td><i class="sh_true"></i></td>
                    	<td><i class="sh_true"></i></td>
                    	<td>98</td>
                    	<td>
                        	<a>查看</a>|<a>修改</a>|<a>删除</a>
                        </td>
                    </tr>
                    <tr>
                    	<td><div><input type="checkbox" name="checkid[]" id="checkid[]" value="1" /></div></td>
                    	<td><a><img src="/images/cp_01.png"><span>asdfassdfsdfsdf</span></a></td>
                    	<td>21.00</td>
                    	<td><i class="sh_true"></i></td>
                    	<td><i class="sh_true"></i></td>
                    	<td><i class="sh_false"></i></td>
                    	<td><i class="sh_true"></i></td>
                    	<td><i class="sh_true"></i></td>
                    	<td><i class="sh_true"></i></td>
                    	<td>98</td>
                    	<td>
                        	<a>查看</a>|<a>修改</a>|<a>删除</a>
                        </td>
                    </tr>
                    <tr>
                    	<td><div><input type="checkbox" name="checkid[]" id="checkid[]" value="1" /></div></td>
                    	<td><a><img src="/images/cp_01.png"><span>asdfassdfsdfsdf</span></a></td>
                    	<td>21.00</td>
                    	<td><i class="sh_true"></i></td>
                    	<td><i class="sh_true"></i></td>
                    	<td><i class="sh_false"></i></td>
                    	<td><i class="sh_true"></i></td>
                    	<td><i class="sh_true"></i></td>
                    	<td><i class="sh_true"></i></td>
                    	<td>98</td>
                    	<td>
                        	<a>查看</a>|<a>修改</a>|<a>删除</a>
                        </td>
                    </tr>
                    <tr>
                    	<td><div><input type="checkbox" name="checkid[]" id="checkid[]" value="1" /></div></td>
                    	<td><a><img src="/images/cp_01.png"><span>asdfassdfsdfsdf</span></a></td>
                    	<td>21.00</td>
                    	<td><i class="sh_true"></i></td>
                    	<td><i class="sh_true"></i></td>
                    	<td><i class="sh_false"></i></td>
                    	<td><i class="sh_true"></i></td>
                    	<td><i class="sh_true"></i></td>
                    	<td><i class="sh_true"></i></td>
                    	<td>98</td>
                    	<td>
                        	<a>查看</a>|<a>修改</a>|<a>删除</a>
                        </td>
                    </tr>
                    <tr>
                    	<td><div><input type="checkbox" name="checkid[]" id="checkid[]" value="1" /></div></td>
                    	<td><a><img src="/images/cp_01.png"><span>asdfassdfsdfsdf</span></a></td>
                    	<td>21.00</td>
                    	<td><i class="sh_true"></i></td>
                    	<td><i class="sh_true"></i></td>
                    	<td><i class="sh_false"></i></td>
                    	<td><i class="sh_true"></i></td>
                    	<td><i class="sh_true"></i></td>
                    	<td><i class="sh_true"></i></td>
                    	<td>98</td>
                    	<td>
                        	<a>查看</a>|<a>修改</a>|<a>删除</a>
                        </td>
                    </tr>
                    <tr>
                    	<td><div><input type="checkbox" name="checkid[]" id="checkid[]" value="1" /></div></td>
                    	<td><a><img src="/images/cp_01.png"><span>asdfassdfsdfsdf</span></a></td>
                    	<td>21.00</td>
                    	<td><i class="sh_true"></i></td>
                    	<td><i class="sh_true"></i></td>
                    	<td><i class="sh_false"></i></td>
                    	<td><i class="sh_true"></i></td>
                    	<td><i class="sh_true"></i></td>
                    	<td><i class="sh_true"></i></td>
                    	<td>98</td>
                    	<td>
                        	<a>查看</a>|<a>修改</a>|<a>删除</a>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="sp_btnj1"><ul>
                	<li class="sp_bg1"><a href="#">删除</a></li>
                	<li class="sp_bg2"><a href="#">下架</a></li>
                	<li class="sp_bg3"><a>推荐</a></li>
                	<li class="sp_bg4"><a>精品</a></li>
                	<li class="sp_bg5"><a>新品</a></li>
                	<li class="sp_bg6"><a>热销</a></li>
                </ul>
                </div>
            </div>
            
        </div>
    </div>
</div>

<!-- 底部 -->
<?php include_once("../../public/footer.php") ?>
<script type="text/javascript">

$(".addtype_ej li").hover(function(){
	$(this).addClass('one');
},function(){
	$(this).removeClass('one');
});
</script>
</body>
</html>

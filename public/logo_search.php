<div class="itop">
    <!--top 3-->
	<div class="itop_search">
    	<div class="itop_searchc">
        	<span class="itop_logo t_left"><a href="/"><img src="/images/logo.png"></a><span class="itop_name1"><?php echo $web_title?></span></span>
        	<span class="itop_scname2 t_right">
            	<div class="itop_scinput1">
                	<form id="goodsform" name="goodsform" action="/goods.php" method="get">
                	<input type="text"  placeholder="请输入商品关键词" name="keyword" id="keyword" /><span><a href="javascript:;" onclick="CheckKeyword()" >搜索</a></span>
                    </form>
                    <div class="divclear"></div>
                </div>
            	<div class="rem_search">
					<span>热门搜索：</span>
                   	<?php
					if(!empty($cfg_hotsearch)){
						$searchkeyArr=explode('|',$cfg_hotsearch);
						foreach($searchkeyArr as $k => $v){
							if($k==0){
								$onekey='class="bord_b"';	
							}else{
								$onekey='';	
							}
							if($k>8){
								break;	
							}
							echo '<a '.$onekey.' href="/goods.php?keyword='.$v.'">'.$v.'</a>';
						}
					}
					?>
                </div>
            </span>
            <div class="divclear"></div>
        </div>
    </div>
</div>
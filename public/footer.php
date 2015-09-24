<footer class="ifooter">
	<!-- 质量保证 -->
    <div class="bzzl">
        <div class="bzzl_c">
        	<ul>
            	<li><span class="c1"><i>正品</i>质量保障</span></li>
            	<li><span class="c2"><i>服务</i>质量保障</span></li>
            	<li><span class="c3"><i>商品</i>质量保障</span></li>
            	<li><span class="c4"><i>安全</i>质量保障</span></li>
            </ul>
        </div>
    </div>
	<div class="ifooter_c">
	<!-- 链接 -->
    <ul>
    	<?php 
		$dosql->Execute("SELECT id,classname,linkurl FROM `#@__infoclass` WHERE id in(1,2,3,4) AND checkinfo=true ORDER BY orderid asc, id asc ");
		while($row = $dosql->GetArray())
		{
		?>
        <li>
            <dl>
            	<dt><a><?php echo $row['classname']?></a></dt>
                <?php 
				$dosql->Execute("SELECT id,classname,linkurl FROM `#@__infoclass` WHERE parentid='".$row['id']."' AND checkinfo=true ORDER BY orderid asc, id asc ",$row['id']);
				while($row2 = $dosql->GetArray($row['id']))
				{
					if(!empty($row2['linkurl'])){
						$gourl=$row2['linkurl'];
					}else{
						$gourl=$cfg_webpath.'/help.php?cid='.$row2['id'];	
					}
				?>
                <dd><a href="<?php echo $gourl?>"><?php echo $row2['classname']?></a></dd>
                <?php
				}
				?>
        	</dl>
        </li>
        <?php
		}
		?>
    </ul>
    <div class="divclear"></div>
    </div>
    <!-- 版权 -->
    <?php require_once(dirname(__FILE__).'/bottom.php'); ?>
</footer>
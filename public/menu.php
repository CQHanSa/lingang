<script type="text/javascript" src="/js/menu.js"></script>
<div class="itop">  
    <div class="menu">
    	<div class="menu_c">
        	<div class="all_sp"><a>全部商品</a>
            	<ul>
                	<?php
                    $dosql->Execute("SELECT id,classname FROM `#@__goodstype` WHERE `parentid`='0' and checkinfo='true' ORDER BY orderid ASC, id ASC limit 12");
					$i=1;
					while($row = $dosql->GetArray())
					{
					?>
                	<li><a href="/goods.php?oncid=<?php echo $row['id']?>"><i class="sy_bg<?php echo $i;?>"></i><?php echo $row['classname']?></a>
                    	<div class="category">
							<div class="mode_bd">
                            <?php
							$dosql->Execute("SELECT id,classname FROM `#@__goodstype` WHERE `parentid`='".$row['id']."' and checkinfo='true' ORDER BY orderid ASC, id ASC ",$row['id']);
							while($row2 = $dosql->GetArray($row['id']))
							{
							?>
                            <dl>
                            	<dt><a href="/goods.php?oncid=<?php echo $row['id']?>&twcid=<?php echo $row2['id']?>"><?php echo $row2['classname']?></a></dt>
                                <dd>
                                	<?php
									$dosql->Execute("SELECT id,classname FROM `#@__goodstype` WHERE `parentid`='".$row2['id']."' and checkinfo='true' ORDER BY orderid ASC, id ASC ",$row2['id']);
									while($row3 = $dosql->GetArray($row2['id']))
									{
									?>
                                	<em><a href="/goods.php?oncid=<?php echo $row['id']?>&twcid=<?php echo $row2['id']?>&thcid=<?php echo $row3['id']?>"><?php echo $row3['classname']?></a></em>
                                    <?php
									}
									?>
                        		</dd>
                            </dl>
							<?php
							}
							?>	
                            </div>
                        </div>
                    </li>
                    <?php
					$i++;
					}
					?>
                </ul>
            </div>
        	<ul class="navmenu">
            	<li><a href="/">首页</a></li>
            	<?php
				$nav = MysqlRowSelect('lgsc_goodstype','*',"parentid = 0 and checkinfo = 'true' order by orderid asc",'4');
				for($i=0,$n=count($nav);$i<$n;$i++)
				{
					$url = "/goods.php?oncid=".$nav[$i]['id'];
				?>
                <li><a href="<?=$url?>" ><?=$nav[$i]['classname']?></a></li>
                <?php 
				}
				?>
            	<li><a>饮食健康</a></li>
            	<li><a>菜谱大全</a></li>
            	<li><a>饮食咨询</a></li>
            </ul>
        </div>
    </div>
</div>
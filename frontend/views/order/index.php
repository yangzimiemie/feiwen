<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>填写核对订单信息</title>
	<link rel="stylesheet" href="/style/base.css" type="text/css">
	<link rel="stylesheet" href="/style/global.css" type="text/css">
	<link rel="stylesheet" href="/style/header.css" type="text/css">
	<link rel="stylesheet" href="/style/fillin.css" type="text/css">
	<link rel="stylesheet" href="/style/footer.css" type="text/css">


	<script type="text/javascript" src="/js/jquery-1.8.3.min.js"></script>
	<script type="text/javascript" src="/js/cart2.js"></script>
    <script type="text/javascript" src="/layer/layer.js"></script>

</head>
<body>
	<!-- 顶部导航 start -->
    <?php
    include Yii::getAlias('@app'). "/views/common/nav.php";
    ?>
	<!-- 顶部导航 end -->
	
	<div style="clear:both;"></div>
	
	<!-- 页面头部 start -->
	<div class="header w990 bc mt15">
		<div class="logo w990">
			<h2 class="fl"><a href="index.html"><img src="/images/logo.png" alt="京西商城"></a></h2>
			<div class="flow fr flow2">
				<ul>
					<li>1.我的购物车</li>
					<li class="cur">2.填写核对订单信息</li>
					<li>3.成功提交订单</li>
				</ul>
			</div>
		</div>
	</div>
	<!-- 页面头部 end -->
	
	<div style="clear:both;"></div>
<form>
	<!-- 主体部分 start -->
	<div class="fillin w990 bc mt15">
		<div class="fillin_hd">
			<h2>填写并核对订单信息</h2>
		</div>

		<div class="fillin_bd">
			<!-- 收货人信息  start-->
			<div class="address">
				<h3>收货人信息</h3>
				<div class="address_info">
				<p>
                    <?php foreach ($address as $row):?>
					<input type="radio" value="<?=$row->id?>" <?=$row->status?"checked":""?> name="address_id" id="checked"/><?=$row->name?>  <?=$row->mobile?>    <?=$row->province?>  <?=$row->city?>  <?=$row->county?>  <?=$row->address?> </p>
				<?php endforeach;?>
                </div>
                <a href="<?=\yii\helpers\Url::to(['address/index'])?>">添加地址</a>

            </div>
			<!-- 收货人信息  end-->

			<!-- 配送方式 start -->
			<div class="delivery">
				<h3>送货方式 </h3>

				<div class="delivery_select">
					<table>
						<thead>
							<tr>
								<th class="col1">送货方式</th>
								<th class="col2">运费</th>
								<th class="col3">简介</th>
							</tr>
						</thead>
						<tbody>
                        <?php foreach ($deliverys as $k=>$delivery):?>
                            <tr class="<?=$k?"":"cur"?>">
                                <td>
                                    <input type="radio" name="delivery" value="<?=$delivery->id?>" <?=$k==0?"checked":""?> /><?=$delivery->name?>
                                </td>
                                <td>￥<span><?=$delivery->price?></span></td>
                                <td><?=$delivery->intro?></td>
                            </tr>
                        <?php endforeach;?>
						</tbody>
					</table>

				</div>
			</div> 
			<!-- 配送方式 end --> 

			<!-- 支付方式  start-->
			<div class="pay">
				<h3>支付方式</h3>
				<div class="pay_info">

				</div>
				<div class="pay_select ">
					<table>
                        <?php foreach ($payments as $k=>$payment):?>
						<tr class="<?=$k?"":"cur"?>">
							<td class="col1"><input type="radio" name="pay" value="<?=$payment->id?>" <?=$k==0?"checked":""?>/><?=$payment->name?></td>
							<td class="col2"><?=$payment->intro?></td>
						</tr>
						<?php endforeach;?>
					</table>
				</div>
			</div>
			<!-- 支付方式  end-->

			<!-- 商品清单 start -->
			<div class="goods">
				<h3>商品清单</h3>
				<table>
					<thead>
						<tr>
							<th class="col1">商品</th>
							<th class="col3">价格</th>
							<th class="col4">数量</th>
							<th class="col5">小计</th>
						</tr>	
					</thead>
					<tbody>
                    <?php
                    foreach ($good as $good):?>
						<tr >
							<td class="col1"><a href="<?=\yii\helpers\Url::to(['goods/cart-list'])?>"><img src="<?=$good->logo?>" alt="" /></a>  <strong><a href=""><?=$good->name?></a></strong></td>
							<td class="col3">￥<?=$good->price?></td>
							<td class="col4"> <?=$cart[$good->id]?></td>
							<td class="col5"><span>￥<?=$good->price*$cart[$good->id]?></span></td>
						</tr>
					<?php endforeach;?>
					</tbody>
					<tfoot>
						<tr>
							<td colspan="5">
								<ul>
									<li>
										<span><?=$shopNum?>件商品，总商品金额：</span>
                                        <em>￥<span id="goods_price"><?=$shopPrice?></span></em>
									</li>

									<li>
										<span>运费：</span>
                                        <em>￥<span id="freight"><?=number_format($deliverys[0]->price,2)?></span></em>
									</li>
									<li>
										<span>应付总额：</span>
                                        <em>￥<span class="total"><?=$deliverys[0]->price+$shopPrice?></span></em>
									</li>
								</ul>
							</td>
						</tr>
					</tfoot>
				</table>
			</div>
			<!-- 商品清单 end -->
		
		</div>

		<div class="fillin_ft">
			<a href="javascript:;" id="add"><span>提交订单</span></a>
			<p>应付总额：<strong><em>￥<span class="total"><?=$deliverys[0]->price+$shopPrice?></span></em></strong></p>
			
		</div>
	</div>
</form>
	<!-- 主体部分 end -->
	<div style="clear:both;"></div>
	<!-- 底部版权 start -->
	<div class="footer w1210 bc mt15">
		<p class="links">
			<a href="">关于我们</a> |
			<a href="">联系我们</a> |
			<a href="">人才招聘</a> |
			<a href="">商家入驻</a> |
			<a href="">千寻网</a> |
			<a href="">奢侈品网</a> |
			<a href="">广告服务</a> |
			<a href="">移动终端</a> |
			<a href="">友情链接</a> |
			<a href="">销售联盟</a> |
			<a href="">京西论坛</a>
		</p>
		<p class="copyright">
			 © 2005-2013 京东网上商城 版权所有，并保留所有权利。  ICP备案证书号:京ICP证070359号 
		</p>
		<p class="auth">
			<a href=""><img src="/images/xin.png" alt="" /></a>
			<a href=""><img src="/images/kexin.jpg" alt="" /></a>
			<a href=""><img src="/images/police.jpg" alt="" /></a>
			<a href=""><img src="/images/beian.gif" alt="" /></a>
		</p>
	</div>
	<!-- 底部版权 end -->
<script>
$(function () {
    /**
     * 找到他的父亲 改变事件
     * 找到运费
     * 获取运费 改变运费
     * 找到总价，更改总价，保留两位小数
      */
    $("input[name='delivery']").change(function () {
       var price = $(this).parent().next().children().text();
       $("#freight").text(price);
        $(".total").text((parseFloat(price)+parseFloat($("#goods_price").text())).toFixed(2));
        console.dir(price);
    });
    $("#add").click(function () {
        $.post("index",$("form").serialize(),function (data) {
            console.debug(data);
            if(data.status){
                layer.msg(data.msg);
                location.href="/order/wx-pay?id="+data.id;
            }else{
                layer.msg(data.msg);
            }
        },'json');
    });
});
 </script>
</body>
</html>

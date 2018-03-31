<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>收货地址</title>
	<link rel="stylesheet" href="/style/base.css" type="text/css">
	<link rel="stylesheet" href="/style/global.css" type="text/css">
	<link rel="stylesheet" href="/style/header.css" type="text/css">
	<link rel="stylesheet" href="/style/home.css" type="text/css">
	<link rel="stylesheet" href="/style/address.css" type="text/css">
	<link rel="stylesheet" href="/style/bottomnav.css" type="text/css">
	<link rel="stylesheet" href="/style/footer.css" type="text/css">

    <script type="text/javascript" src="/layer/layer.js"></script>
	<script type="text/javascript" src="/js/header.js"></script>
	<script type="text/javascript" src="/js/home.js"></script>
	<script type="text/javascript" src="/js/PCASClass.js"></script>
    <script type="text/javascript" src="/layer/layer.js"></script>
</head>
<body>
		<!-- 顶部导航 start -->
        <?php
        include Yii::getAlias('@app'). "/views/common/nav.php";
        ?>
	<!-- 顶部导航 end -->
	
	<div style="clear:both;"></div>

	<!-- 头部 start -->
        <?php
        include Yii::getAlias('@app'). "/views/common/header.php";
        ?>
	<!-- 头部 end-->
	
	<div style="clear:both;"></div>

	<!-- 页面主体 start -->
	<div class="main w1210 bc mt10">
		<div class="crumb w1210">
			<h2><strong>我的XX </strong><span>> 我的订单</span></h2>
		</div>
		
		<!-- 左侧导航菜单 start -->
		<div class="menu fl">
			<h3>我的XX</h3>
			<div class="menu_wrap">
				<dl>
					<dt>订单中心 <b></b></dt>
					<dd><b>.</b><a href="">我的订单</a></dd>
					<dd><b>.</b><a href="">我的关注</a></dd>
					<dd><b>.</b><a href="">浏览历史</a></dd>
					<dd><b>.</b><a href="">我的团购</a></dd>
				</dl>

				<dl>
					<dt>账户中心 <b></b></dt>
					<dd class="cur"><b>.</b><a href="">账户信息</a></dd>
					<dd><b>.</b><a href="">账户余额</a></dd>
					<dd><b>.</b><a href="">消费记录</a></dd>
					<dd><b>.</b><a href="">我的积分</a></dd>
					<dd><b>.</b><a href="">收货地址</a></dd>
				</dl>

				<dl>
					<dt>订单中心 <b></b></dt>
					<dd><b>.</b><a href="">返修/退换货</a></dd>
					<dd><b>.</b><a href="">取消订单记录</a></dd>
					<dd><b>.</b><a href="">我的投诉</a></dd>
				</dl>
			</div>
		</div>
		<!-- 左侧导航菜单 end -->

		<!-- 右侧内容区域 start -->
		<div class="content fl ml10">
			<div class="address_hd">
				<h3>收货地址薄</h3>
                <?php

                foreach ($address as $key=>$row):?>
                    <dl class="last"> <!-- 最后一个dl 加类last -->
                        <dt><?=$row->name?> <?=$row->province?> <?=$row->city?> <?=$row->county?><?=$row->address?> <?=$row->mobile?></dt>
					<dd>
						<a href="">修改</a>
						<a href="javascript:void (0)" class="del" data_id="<?=$row->id?>">删除</a>
						<a href="">设为默认地址</a>
					</dd>
				</dl>
                <?php endforeach;?>
			</div>

			<div class="address_bd mt10">
				<h4>新增收货地址</h4>
				<form action="" name="address_form" id="address_form">
						<ul>
							<li>
								<label for=""><span>*</span>收 货 人：</label>
								<input type="text" name="Address[name]" class="txt" id="name"/>
							</li>
							<li>
								<label for=""><span>*</span>所在地区：</label>
                                <select name="Address[province]" id="province"></select>
                                <select name="Address[city]" id="city"></select>
                                <select name="Address[county]"id="county"></select>
							</li>
							<li>
								<label for=""><span>*</span>详细地址：</label>
								<input type="text" name="Address[address]" class="txt address" id="address" />
							</li>
							<li>
								<label for=""><span>*</span>手机号码：</label>
								<input type="text" name="Address[mobile]" class="txt" id="mobile"/>
							</li>
							<li>
								<label for="">&nbsp;</label>
								<input type="checkbox" name="Address[status]" class="check" />设为默认地址
							</li>
							<li>
								<label for="">&nbsp;</label>
								<input type="button" name="save_btn" class="address_btn" value="保存" />
							</li>
						</ul>
					</form>
			</div>	

		</div>
		<!-- 右侧内容区域 end -->
	</div>
	<!-- 页面主体 end-->

	<div style="clear:both;"></div>

	<!-- 底部导航 start -->
	<div class="bottomnav w1210 bc mt10">
		<div class="bnav1">
			<h3><b></b> <em>购物指南</em></h3>
			<ul>
				<li><a href="">购物流程</a></li>
				<li><a href="">会员介绍</a></li>
				<li><a href="">团购/机票/充值/点卡</a></li>
				<li><a href="">常见问题</a></li>
				<li><a href="">大家电</a></li>
				<li><a href="">联系客服</a></li>
			</ul>
		</div>
		
		<div class="bnav2">
			<h3><b></b> <em>配送方式</em></h3>
			<ul>
				<li><a href="">上门自提</a></li>
				<li><a href="">快速运输</a></li>
				<li><a href="">特快专递（EMS）</a></li>
				<li><a href="">如何送礼</a></li>
				<li><a href="">海外购物</a></li>
			</ul>
		</div>

		
		<div class="bnav3">
			<h3><b></b> <em>支付方式</em></h3>
			<ul>
				<li><a href="">货到付款</a></li>
				<li><a href="">在线支付</a></li>
				<li><a href="">分期付款</a></li>
				<li><a href="">邮局汇款</a></li>
				<li><a href="">公司转账</a></li>
			</ul>
		</div>

		<div class="bnav4">
			<h3><b></b> <em>售后服务</em></h3>
			<ul>
				<li><a href="">退换货政策</a></li>
				<li><a href="">退换货流程</a></li>
				<li><a href="">价格保护</a></li>
				<li><a href="">退款说明</a></li>
				<li><a href="">返修/退换货</a></li>
				<li><a href="">退款申请</a></li>
			</ul>
		</div>

		<div class="bnav5">
			<h3><b></b> <em>特色服务</em></h3>
			<ul>
				<li><a href="">夺宝岛</a></li>
				<li><a href="">DIY装机</a></li>
				<li><a href="">延保服务</a></li>
				<li><a href="">家电下乡</a></li>
				<li><a href="">京东礼品卡</a></li>
				<li><a href="">能效补贴</a></li>
			</ul>
		</div>
	</div>
	<!-- 底部导航 end -->

	<div style="clear:both;"></div>
	<!-- 底部版权 start -->
        <?php
        include Yii::getAlias('@app'). "/views/common/foot.php";
        ?>
	<!-- 底部版权 end -->
	 <script>
             new PCAS("Address[province]","Address[city]","Address[county]");
             $(function () {
                 /**
                  * 先找到保存按钮,为它添加一个点击事件
                  * 发起ajax请求，判断状态
                  */
                 $(".address_btn").click(function () {
                     $.post('/address/add',$("#address_form").serialize(),function (data) {
                         console.dir(data);
                         if(data.status){
                             window.location.href='/address/add';
                         }else{
                             $.each(data.data,function (k,v){
                                 layer.tips(v[0], '#'+k, {
                                     tips: [2, '#CB82D8'], //配置颜色
                                     tipsMore: true//不摧毁，延迟显示
                                 });
                                 console.log(k);
                             });
                         }
                     },'json');
                 });
                 //先找到删除
                 $(".del").click(function () {
                     var del = $(this);
                     var id = del.attr('data_id');
                    //提交数据
                     $.getJSON("/address/del?id="+id,function (data) {
                         //删除
                         if(data.status){
                             layer.msg(data.msg);
                             //父级的父级删除
                             del.parent().parent().remove();
                         }
                     });
                 });
             });
         </script>
</body>
</html>


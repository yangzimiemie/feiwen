<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>登录商城</title>
	<link rel="stylesheet" href="/style/base.css" type="text/css">
	<link rel="stylesheet" href="/style/global.css" type="text/css">
	<link rel="stylesheet" href="/style/header.css" type="text/css">
	<link rel="stylesheet" href="/style/login.css" type="text/css">
	<link rel="stylesheet" href="/style/footer.css" type="text/css">
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
		</div>
	</div>
	<!-- 页面头部 end -->
	
	<!-- 登录主体部分start -->
	<div class="login w990 bc mt10">
		<div class="login_hd">
			<h2>用户登录</h2>
			<b></b>
		</div>
		<div class="login_bd">
			<div class="login_form fl">
				<form action="" method="post" id="login">
					<ul>
						<li>
							<label for="">用户名：</label>
                            <input type="text" class="txt" name="User[username]" id="username"/>
						</li>
						<li>
							<label for="">密码：</label>
                            <input type="password" class="txt" name="User[password]" id="password"/>
							<a href="">忘记密码?</a>
						</li>
                        <li class="checkcode">
                            <label for="">验证码：</label>
                            <input type="text"  name="User[code]" id="code"/>
                            <img src="/user/code" id="codeImage"/>
                            <span>看不清？<a href="Javascript:void(0)" id="changeCode">换一张</a></span>
                        </li>
						<li>
							<label for="">&nbsp;</label>
							<input type="checkbox" class="chb" name="rememberMe" /> 保存登录信息
						</li>
						<li>
							<label for="">&nbsp;</label>
							<input type="button" value="" class="login_btn" />
						</li>
					</ul>
				</form>

				<div class="coagent mt15">
					<dl>
						<dt>使用合作网站登录商城：</dt>
						<dd class="qq"><a href=""><span></span>QQ</a></dd>
						<dd class="weibo"><a href=""><span></span>新浪微博</a></dd>
						<dd class="yi"><a href=""><span></span>网易</a></dd>
						<dd class="renren"><a href=""><span></span>人人</a></dd>
						<dd class="qihu"><a href=""><span></span>奇虎360</a></dd>
						<dd class=""><a href=""><span></span>百度</a></dd>
						<dd class="douban"><a href=""><span></span>豆瓣</a></dd>
					</dl>
				</div>
			</div>
			
			<div class="guide fl">
				<h3>还不是商城用户</h3>
				<p>现在免费注册成为商城用户，便能立刻享受便宜又放心的购物乐趣，心动不如行动，赶紧加入吧!</p>

				<a href="/user/reg" class="reg_btn">免费注册 >></a>
			</div>

		</div>
	</div>
	<!-- 登录主体部分end -->

	<div style="clear:both;"></div>
	<!-- 底部版权 start -->
    <?php
    include Yii::getAlias('@app'). "/views/common/foot.php";
    ?>
	<!-- 底部版权 end -->
    <script type="text/javascript" src="/js/jquery-1.8.3.min.js"></script>
    <script type="text/javascript" src="/layer/layer.js"></script>
    <script type="text/javascript">
        function getQueryVariable(variable)
        {
            var query = window.location.search.substring(1);
            var vars = query.split("&");
            for (var i=0;i<vars.length;i++) {
                var pair = vars[i].split("=");
                if(pair[0] == variable){return pair[1];}
            }
            return(false);
        }
        $(function () {
            $(".login_btn").click(function () {
                //发起ajax请求
                $.post('/user/login',$('#login').serialize(),function (result) {
                console.dir(result);
                    if(result.status){
                        var url = getQueryVariable('url');
                        if(url===false){
                            window.location.href="/home/index";
                        }else{
                            window.location.href=decodeURIComponent(url);
                        }
                    }else{
                        $.each(result.data,function (k,v){
                            layer.tips(v[0], '#'+k, {
                                tips: [2, '#CB82D8'], //配置颜色
                                tipsMore: true//不摧毁，延迟显示
                            });
                            console.log(k);
                        });
                    }
                },'json');
            });
            //找到验证码和图片给他们一个点击事件
            $('#codeImage,#changeCode').click(function (){
                //发起ajax请求，在找到图片验证码去修改他的src
                $.getJSON('/user/code?refresh',function (data) {
                    $('#codeImage').attr('src',data.url);
                    console.dir(data);
                })
            });
        });
    </script>
</body>
</html>
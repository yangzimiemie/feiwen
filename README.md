## 项目概述
##### 类似京东商城的B2C商城 (C2C B2B O2O P2P ERP进销存 CRM客户关系管理)
##### 电商或电商类型的服务在目前来看依旧是非常常用，虽然纯电商的创业已经不太容易，但是各个公司都有变现的需要，所以在自身应用中嵌入电商功能是非常普遍的做法。

为了让大家掌握企业开发特点，以及解决问题的能力，我们开发一个电商项目，项目会涉及非常有代表性的功能。
为了让大家掌握公司协同开发要点，我们使用git管理代码。
在项目中会使用很多前面的知识，比如架构、维护等等。


## 开发环境和技术

```
开发环境	Window
开发工具	Phpstorm+PHP 5.6.27-nts+Apache
相关技术	Yii2.0+CDN+jQuery+sphinx
```

## 主要的功能模块有：

```
前台：首页、商品展示、商品购买、订单管理、在线支付等。
后台：品牌管理、商品分类管理、商品管理、订单管理、系统管理和会员管理六个功能模块。
```
## 完成的后端功能模块
- [x] 品牌管理：
- [x] 文章管理：
- [x] 商品分类管理：
- [x] 商品管理：
- [x]  账号管理：
- [x]  权限管理：
- [x]  菜单管理：
## 前端功能模块：
- [x] 注册登录
- [x] 收货地址
- [x] 商品展示
- [x] 商品购买
- [x] 订单管理
- [x] 在线支付
 
**品牌功能模块第一天**

1. 先分析数据表再去建表->
2. 建立模型->
3. 属性、规则、label->
4. 控制器CRUD->上传图片使用了webupload和qiniu->
5. 视图
        
**选择上传方式**
```
        switch (\yii::$app->params['uploadType']){
            case "local":
                echo "local";
                break;
            case "qiniu":
                echo "qiniu";
                break;
        }
```        
**文章功能模块第二天**

_1.先分析数据表_

```
分析文章分类（article）
	id
	name
	logo
	status
	sort
	detail
	title
	is_help
```

	
	_2.创建模型_
	
	写规则->label
	
	3.控制器->
	
1. 	进行了文章和文章内容和文章分类名进行了交互->

2. 	实现了富文本

	**商品分类功能模块第三天**
	
	1.分析表
	

```
商品分类表
    	id
    	name
    	tree(树) 左值右值
    	lft
    	rgt
    	parent_id
    	detail
    	depth(深度)
```

    	
    2.创建表
    
    3.gii生成模块和控制器视图
    
    4.在控制器添加方法中折叠分类，在列表中显示无限极分类，删除的时候不可以删除有孩子的节点
## 商品功能模块第四天
#### 先分析需求
    1.	商品分类只能选择第三级分类
    2.	商品相册,添加完商品后,跳转到添加商品相册页面,允许多图片上传
    3.  商品列表页可以进行搜索(商品名,商品状态,售价范围
    4.  新增商品自动生成sn,规则为年月日+今天的第几个商品,也可以自己写
    
#### 分析商品表

	id
	name
	status
	sn
	create_time
	update_time
	details（商品详情）
	price（价格）
	sort(排序)
	goods_cate_id
	brand(商品品牌)
	
2. 建立模型
    规则->label

3. 控制器
 
         显示分页列表
        添加数据并且添加详情表的数据
        编辑同添加
        删除
4.视图的显示和添加修改页面

#### 商品货号自动生成为年月日+数据表中数据而定
```
 if (!$goods->sn) {
        $goodsTime = strtotime(date('Ymd'));
        $count = Goods::find()->where(['>', 'create_time', $goodsTime])->count();
        $count = $count + 1;
        $countStr = "0000" . $count;
        $countStr = substr($countStr, -5);
        $goods->sn = date('Ymd') . $countStr;
   
```
### 多图上传
在编辑的时候需要回显多张图片的时候需要遍历
```
GoodsImages::deleteAll(['goods_id'=>'id']);//需要删除全部，解决图片出现多次
    foreach ($goods->images as $image){
            $files = new GoodsImages();
            $files->goods_id=$goods->id;
            $files->images=$image;
            $files->save();
    }
        $images = GoodsImages::find()->where(['goods_id'=>$id])->asArray()->all();
        $images = array_column($images,'images');
        $goods->images = $images;
```
## 管理模块
需求：完成管理员的登录，管理员的CRUD，ip地址
###### 先分析数据表
管理员表

	id
	username
	auth_key
	password_hash
	status
	email
	logo
	login_ip
	login_time
	create_time
	update_time
	
	使用加密
	```
	  $admin = Admin::findOne(['username'=>$model->username]);
              //判断用户是否存在
              if($admin){
                  if (\yii::$app->security->validatePassword($model->password,$admin->password_hash)) {
                        //密码正确就用user组件登录
                     \yii::$app->user->login($admin,$model->rememberMe?3600*24*7:0);
                     //修改登录的时间和IP
                      $admin->login_ip=ip2long(\yii::$app->request->userIP);
                      $admin->login_time=time();
                      $admin->save();
```
登录遇到的问题：不够细心！！！
```
## 2018-3-22做的是场景和调试代码
```
在弄场景的时候需要在models中设置规则和一个scenarios类

   [['password_hash'],'required','on' => ['add']],
   [['password_hash'],'safe','on' => ['edit']]
   
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['add'] = ['password_hash','username','status','logo','email'];
        $scenarios['edit'] = ['password_hash','username','status','logo','email'];
        return $scenarios;
    }
    再到控制器去设置  $admin->setScenario('edit');
    ```

需求:
    在修改的时候需要看不到密码，所以在视图中设置一个默认空的值，在去视图中$password=$admin->password_hash;
    还需要进行判断，用的是三元表达式
    
     $admin->password_hash=$admin->password_hash!==""?\yii::$app->security->generatePasswordHash($admin->password_hash):$password;
     假如密码不为空，就写一个密码，为空就为之前设置的默认密码。
```
2018-3-22做了权限的管理

1.首先创建了一个authItem的表单

2.去创建控制器:

列表的显示 

添加权限：

创建权限createPermission->设置权限description
在把权限添加到库中去

修改权限：

因为name是主键所以不可以修改（主键一般都不修改，因为主键是唯一的）

```
if($permission){
                //设置权限
                $permission->description=$per->description;
                //添加到库中
                if($amg->update($name,$permission)) {
                    \yii::$app->session->setFlash('success', "修改权限");
                    return $this->redirect('index');
                }
            }else{
                \yii::$app->session->setFlash('danger', "不可以修改权限名称");
                return $this->redirect('index');
            }
//因为name是主键不可以修改所以在视图中设置了一个
echo $from->field($per,'name')->textInput(['disabled'=>"disabled"]);
```
删除权限

```
      //1.先实列化组件
    $auth = \yii::$app->authManager;
    //2.找到
    $per = $auth->getPermission($name);
    //3.删除
    if ($auth->remove($per)) {
        return $this->redirect('index');
    }
```
## 角色的管理
1. 创建控制器
2. 添加的角色的时候需要判定是否添加了权限
```
添加的时候需要显示权限所有在authItem模型中声明一个permission属性
                //判断有没有添加权限
                if($role->permission){
                    //循环并且将权限加入到角色
                    foreach($role->permission as $perName){
                        //找到权限并获得权限名
                        $per = $auth->getPermission($perName);
                        //给角色添加权限
                        $auth->addChild($createRole,$per);
                    }
                }
                //因为有多个权限所有用循环
                //视图中用CheckBox
```
3.修改角色
```
//需要删除角色当前的权限
 $auth->removeChildren($createRole);
```
4.删除

需要先找到再去删除 （remove）

5.把用户添加到角色

指派角色名和id


## 过滤器
创建一个文件（filters）->第一次的时候需要命名空间
```
public function beforeAction($action)
    {
        //判断当前用户有没有权限
        if(!\yii::$app->user->can($action->uniqueId)){
            $html = <<<html
        <script>
        window.history.go(-1);
        </script>
html;
            \yii::$app->session->setFlash('success','你没有权限操作');
            echo $html;
            return false;
        }
        return parent::beforeAction($action);
    }
```
需要注入行为
 ```
  public function behaviors()
    {
        return [
            'rbac'=>[
               'class'=>RbacFilter::className(),
            ],
        ];
   }
```
也可以写一个全局，在配置里面就不用单独写在控制器里面了

## 菜单目录
1. 先创建数据表
   需要id/name/icon/url/parent_id(因为菜单是二级所有要父级ID)
2. 创建模型
3. 创建控制器->添加需要的目录并添加地址
4. 在模型中写一个静态的方法
```
//声明一个静态方法
public static function menus(){
    $menuAll=[
                'label' => '商品模块', 'icon' => 'cart-arrow-down', 'url' => ['index'],
                'items' => [
                ['label' => '商品管理', 'icon' => 'paint-brush', 'url' => ['goods/index'],],
                ['label' => '商品分类', 'icon' => 'folder-open', 'url' => ['goods-cate/index'],],
                ],
                ];
    $menuAll=[];
    //得到所有父级
    $menuPar = self::find()->where(['parent_id'=>0])->all();
    //循环出来
    foreach ($menuPar as $menu){
      $newMenu=[];
      $newMenu['label']=$menu->name;
      $newMenu['icon']=$menu->icon;
      $newMenu['url']=$menu->url;
       //再去找父级ID的娃儿
        $parChind = self::find()->where(['parent_id'=>$menu->id])->all();
        //再去循环
        foreach ($parChind as $chind){
            $newChind = [];
            $newChind['label']=$chind->name;
            $newChind['icon']=$chind->icon;
            $newChind['url']=$chind->url;
            $newMenu['items'][]=$newChind;
        }
        $menuAll=$newMenu;
    }
//    exit;
    return $menuAll;
}
```
2018-3-25  RBAC和菜单

rbac的完善：
1. 先去下载yii2 admin
2. 按照步骤进行配置
```
return [
//    'as rabc'=>[
//        'class'=>\backend\filters\RbacFilter::className(),
//    ],
    'as access' => [
        'class' => 'mdm\admin\components\AccessControl',
        'allowActions' => [
//            '/*',
//            'site/*',
            'rbac/*',
            'admin/*',
            'some-controller/some-action',
            // The actions listed here will be allowed to everyone including guests.
            // So, 'admin/*' should not appear here in the production, of course.
            // But in the earlier stages of your development, you may probably want to
            // add a lot of actions here until you finally completed setting up rbac,
            // otherwise you may not even take a first step.
        ]
    ],
    'modules' => [
        'rbac' => [
            'class' => 'mdm\admin\Module',
//            'layout' => 'left-menu',
        ]
],
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
//    'modules' => [],
    'components' => [
        //语言包配置
        'i18n'=>[
            'translations'=>[
                '*'=>[
                    'class'=>'yii\i18n\PhpMessageSource',
                    'fileMap'=>[
                        'common'=>'common.php',
                    ],
                ],
            ],
        ],
```
进行角色和权限/路由的分配
菜单->新增菜单->设置图标时需要设置排序和数据

```
//还需要在视图left.php中：
   <?php
        $callback = function($menu){
            $data = json_decode($menu['data'], true);
            $items = $menu['children'];
            $return = [
                'label' => $menu['name'],
                'url' => [$menu['route']],
            ];
            //处理我们的配置
            if ($data) {
                //visible
                isset($data['visible']) && $return['visible'] = $data['visible'];
                //icon
                isset($data['icon']) && $data['icon'] && $return['icon'] = $data['icon'];
                //other attribute e.g. class...
                $return['options'] = $data;
            }
            //没配置图标的显示默认图标
            (!isset($return['icon']) || !$return['icon']) && $return['icon'] = 'fa fa-circle-o';
            $items && $return['items'] = $items;
            return $return;
        };
        //这里我们对一开始写的菜单menu进行了优化
        echo dmstr\widgets\Menu::widget( [
            'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
            'items' => \mdm\admin\components\MenuHelper::getAssignedMenu(Yii::$app->user->id, null, $callback),
        ] ); ?>
```
设置角色的权限：为角色设置相应的权限
# 前台
## 用户的注册
数据库中有自带的user表，添上几个需要的字段
创建model，分析需要的属性和规则。
创建控制器，添加reg方法
```
  if ($user->validate()) {
                $user->password_hash=\Yii::$app->security->generatePasswordHash($user->password);
                $user->auth_key=\yii::$app->security->generateRandomString();
                $user->login_ip=ip2long(\yii::$app->request->userIP);
                if ($user->save(false)) {
                    $result = ['status'=>1,'data'=>$user->errors,'msg'=>'注册成功啦~'];
                    return \yii\helpers\Json::encode($result);
                }
            }else{
                $result = ['status'=>0,'data'=>$user->errors,'msg'=>'注册失败啦~'];
                return \yii\helpers\Json::encode($result);
            }
```
显示视图的时候把前台的模板弄过来需要修改一些路径。
在视图中找到提交按钮，修改为button，提交ajax请求，判读状态默认为1，登录成功跳转页面，如下：
```
     $(".login_btn").click(function () {
            //发起ajax请求
            $.post('/user/reg',$('#reg').serialize(),function (result) {
//                console.dir(result);
                if(result.status){
                    window.location.href="/user/login";
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
```
在注册的时候需要短信生成：
        /*
         * 生成验证码随机六位
         * 将验证码发送给手机
         * 将验证码存于session，手机号当键。验证码当值
         * 错误的话打印错误信息
         */
 ```
     $code = rand(100000,999999);
        $config = [
            'access_key' => 'LTAICIw8JtwoPRoH',
            'access_secret' => '3qD8D4TUEGWBZrbM3wRyjIZOQ67hsH',
            'sign_name' => '菲纹',
        ];
//        $aliSms = new Mrgoon\AliSms\AliSms();
        $aliSms = new AliSms();
        $response = $aliSms->sendSms($tel, 'SMS_128651091', ['code'=> $code], $config);
//        var_dump($response);exit;
        if ($response->Message=="OK"){
            $session = \yii::$app->session;
//        var_dump($session);exit;
            $session->set("tel".$tel,$code);
        }else{
            var_dump($response->Message);
        }     
```
验证验证码是否输入正确：
```
    public function actionSms($tel,$code){
        //通过手机号取出存在session
        $codeOld = \yii::$app->session->get("tel".$tel);
        //判断验证码是否正确
        if($code==$codeOld){
            echo "ok";
        }else{
            echo "no";
        }

    }
```
在reg视图中，发起ajax请求获取手机号的值
```
function bindPhoneNum(){
		    //发起ajax请求
            $.getJSON('/user/send-sms?tel='+$("#tel").val(),function (data) {
                console.dir(data);
            });
```
在模型中把获取存在session的验证码
判断验证码是否正确
```
   public function validateMessage($attribute,$params){
         //获取之前存在session的验证码
        $coded = \yii::$app->session->get("tel".$this->tel);
        //判断验证码是否正确
        if($this->message!=$coded){
             $this->addError($attribute,'验证码错误');
        }
//        var_dump($coded);exit;
        //判断验证码是否正确
    }
```
## 验证码：
```
 public function actions()
    {
        return [
            'code' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
                'minLength' => 3,
                'maxLength' => 3,
                'foreColor' => 0x520000
            ],
        ];
    }
```
在视图中找到验证码为它添加一个点击事件，可以点击图片或者点击换一张，
```
  $('#codeImage,#changeCode').click(function (){
                //发起ajax请求，在找到图片验证码去修改他的src
                $.getJSON('/user/code?refresh',function (data) {
                    $('#codeImage').attr('src',data.url);
                    console.dir(data);
                })
            });
        });
```
在模型中需要设置验证码的属性和规则
        
## 用户登录
添加一个login的方法

创建一个模型对象

判断是否post提交

绑定数据，进行验证

用户去找到用户数据

再去判断用户登录是否正确

如果正确就验证密码，密码正确用user组件去登录

再去为登录时间和登录IP赋值，保存数据

返回视图

在视图中和注册类似

#### js跳转：
```
 window.location.href="/user/index";
 ```
 做登录的时候因为用的同一个模型，所有写了一个类，使用了场景
 ```
   public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['login'] = ['password','username','code','rememberMe'];
        $scenarios['reg'] = ['password_hash','username','rePassword','code','email','tel','$message'];
        return $scenarios;
    }
```
在规则里面需要的就'on'=>'reg'/'on'=>'login',不加on的就是通用。

```
//在控制器里面需要调用场景：
$login->setScenario('login');
```
## 退出登录
```
  public function actionLogout(){
        \yii::$app->user->logout();
        return $this->redirect('login');
    }
```
## 收货地址
1. #### 先分析需要的字段：
```
收货地址
	id
	name
	省	
	市
	区
	详细地址
	电话
	默认地址
	用户id
```
2. 创建模型->规则、label
3. 创建address控制器，添加一个添加地址的方法
   重要的是要判断默认地址，如果设置了默认地址就要删除全部状态
```
  if ($model->status===null) {
                    $model->status=0;
                }else{
                    Address::updateAll(['status'=>0,'user_id'=>$model->user_id]);
                    $model->status=1;
                }
```
4.三级联动

pcas js 
把js下载好赋值进来，然后在视图中添加三个省市区县name
```
 <select name="Address[province]" id="province"></select>
      <select name="Address[city]" id="city"></select>
      <select name="Address[county]"id="county"></select>
      
      //需要在js中  
new PCAS("Address[province]","Address[city]","Address[county]");
```

#### 显示添加地址的数据：
```
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
```
#### 引入导航和头部/尾部的重复部分
1. 在视图中创建一个公共的文件夹，在视图中写好三个部分的.php
2. 导航：
  ```
    <li>您好，欢迎<?=!Yii::$app->user->isGuest?Yii::$app->user->identity->username:""?>来到菲纹商城！
                    <?php
                       $htmlGuest=<<<html
                           [<a href="/user/login">登录</a>] [<a href="/user/reg">免费注册</a>]
html;
                       $htmlLogin=<<<html
                      [<a href="/user/logout">注销</a>]
html;

                       if(Yii::$app->user->isGuest){
                           echo $htmlGuest;
                       }else{
                           echo $htmlLogin;
                       }

                    ?>
```
3.页头：
三重循环

## 商品列表
   点击商品跳转到商品详情页面
   
   详情页面，需要在视图修改图片，大图中图小图。
   
   点击加入购物车，进入购物车列表
   
   在购物车列表中进行商品的添加，修改，删除。
   
   购物车列表的添加删除修改，也是需要登录和未登录状态。
   
   实现购物车的原理：
   
      在添加购物车的时候需要传递两个参数，商品ID和商品数量。
      
      判断用户是否登录->登录就保存到数据库->未登录保存在cookie
      结算的时候要判断用户是否登录，未登录需要登录，登录就结算
      


## 订单：
把订单列表的视图写活需要找到购物车和支付配送表
将购物车表位一维数组，找出键值和全部商品
```
$address = Address::find()->where(['user_id'=>$userId])->all();
        $carts= Cart::find()->where(['user_id'=>$userId])->all();
        $cart = ArrayHelper::map($carts,'goods_id','num');
        $getKey = array_keys($cart);
        $good = Goods::find()->where(['in','id',$getKey])->all();
```
视图的商品数量和价格都需要循环所有在控制器中

```
/**
         * 商品数量和商品价格需要循环
         * 先创建一个商品数量和商品总计的属性
         */
        $shopPrice = 0;
        $shopNum = 0;
        foreach ($good as $row){
            $shopPrice += $row->price*$cart[$row->id];
            $shopNum += $cart[$row->id];
        }
        $shopPrice = number_format($shopPrice,2);
```

#### 对订单表和订单详情的赋值

**交易号和年月日和随机四位数**

找出商品中的库存，当购物车中的商品ID>商品库存需要抛出异常

商品详情需要在保存的时候false

买了商品后需要减去库存
```
   $goods->stock = $goods->stock-$cart[$goods->id];
                             $goods->save(false);
```
清空购物车
```
  Cart::deleteAll(['user_id'=>$userId]);
                 $transaction->commit();//提交事务
```
## 服务器的配置
```
graph TD
A[服务器] --> B[解析域名,实例公有IP]
A-->c(添加解析,空白和所有)
A-->d
d[安装宝塔]-->e[记住密码]

d-->f[安全组->配置规则]
d-->g[设置需要的入口/端口号]
d-->C[登录宝塔,极速安装Apache]
```

```
graph TD
A[添加站点]-->B[使用github上传到网站目录]
B-->C[需要初始化]
B-->E[修改配置]
B-->D[修改网站目录]
D-->g[安装中国镜像和composer install]
D-->F[取消防跨站攻击]
F-->j[软件管理PHP7.0重启]

A-->b[压缩上传]
b-->c[zip格式]
```

```
graph TD
A[导入数据库]-->B[设置权限所有人!!!!!]
B-->C[新建mysql连接]
C-->D[数据传输]
A-->E[数据库管理]
E-->F[进行CRUD]
```

## 微信支付


```
sequenceDiagram
商户后台系统->>商户后台系统: 1.生成订单
商户后台系统->>微信支付系统: 2.调统一接口(API接口)
微信支付系统->>微信支付系统: 3.生成待支付
微信支付系统->>商户后台系统: 4.返回预支付链接code_url
商户后台系统->>商户后台系统: 5.将链接生成二维图片
微信支付系统->>微信支付系统: 6.验证链接是否有效
商户后台系统->>微信支付用户: 将二维图片展示给用户
微信支付用户->>微信支付系统: 7.用户输入密码
微信支付系统->>微信支付系统: 8.完成交易
微信支付系统->>商户后台系统: 9.异步通知商户支付结果
```




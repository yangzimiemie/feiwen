
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
## 完成的功能模块
- [x] 品牌管理：
- [x] 文章管理：
- [x] 商品分类管理：
- [x] 商品管理：
- [x]  账号管理：
- [ ] 权限管理：
- [ ] 菜单管理：
- [ ] 订单管理：
 
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

    	





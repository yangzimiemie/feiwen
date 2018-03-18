<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/993323" height="100px">
    </a>
    <h1 align="center">Yii 2 Advanced Project Template</h1>
    <br>
</p>

Yii 2 Advanced Project Template is a skeleton [Yii 2](http://www.yiiframework.com/) application best for
developing complex Web applications with multiple tiers.

The template includes three tiers: front end, back end, and console, each of which
is a separate Yii application.

The template is designed to work in a team development environment. It supports
deploying the application in different environments.

Documentation is at [docs/guide/README.md](docs/guide/README.md).

[![Latest Stable Version](https://img.shields.io/packagist/v/yiisoft/yii2-app-advanced.svg)](https://packagist.org/packages/yiisoft/yii2-app-advanced)
[![Total Downloads](https://img.shields.io/packagist/dt/yiisoft/yii2-app-advanced.svg)](https://packagist.org/packages/yiisoft/yii2-app-advanced)
[![Build Status](https://travis-ci.org/yiisoft/yii2-app-advanced.svg?branch=master)](https://travis-ci.org/yiisoft/yii2-app-advanced)

DIRECTORY STRUCTURE
-------------------

```
common
    config/              contains shared configurations
    mail/                contains view files for e-mails
    models/              contains model classes used in both backend and frontend
    tests/               contains tests for common classes    
console
    config/              contains console configurations
    controllers/         contains console controllers (commands)
    migrations/          contains database migrations
    models/              contains console-specific model classes
    runtime/             contains files generated during runtime
backend
    assets/              contains application assets such as JavaScript and CSS
    config/              contains backend configurations
    controllers/         contains Web controller classes
    models/              contains backend-specific model classes
    runtime/             contains files generated during runtime
    tests/               contains tests for backend application    
    views/               contains view files for the Web application
    web/                 contains the entry script and Web resources
frontend
    assets/              contains application assets such as JavaScript and CSS
    config/              contains frontend configurations
    controllers/         contains Web controller classes
    models/              contains frontend-specific model classes
    runtime/             contains files generated during runtime
    tests/               contains tests for frontend application
    views/               contains view files for the Web application
    web/                 contains the entry script and Web resources
    widgets/             contains frontend widgets
vendor/                  contains dependent 3rd-party packages
environments/            contains environment-based overrides
```
"# feiwen" 
## 项目概述
**类似京东商城的B2C商城 (C2C B2B O2O P2P ERP进销存 CRM客户关系管理)
电商或电商类型的服务在目前来看依旧是非常常用，虽然纯电商的创业已经不太容易，但是各个公司都有变现的需要，所以在自身应用中嵌入电商功能是非常普遍的做法。
为了让大家掌握企业开发特点，以及解决问题的能力，我们开发一个电商项目，项目会涉及非常有代表性的功能。
为了让大家掌握公司协同开发要点，我们使用git管理代码。
在项目中会使用很多前面的知识，比如架构、维护等等。**


## #开发环境和技术

```
开发环境	Window
开发工具	Phpstorm+PHP5.6.27-nts+Apache
相关技术	Yii2.0+CDN+jQuery+sphinx
```

## #主要的功能模块有：

```
前台：首页、商品展示、商品购买、订单管理、在线支付等。
后台：品牌管理、商品分类管理、商品管理、订单管理、系统管理和会员管理六个功能模块。
```
- [x] 品牌管理：
- [x] 文章管理：
- [ ] 商品分类管理：
- [ ] 商品管理：
- [ ] 账号管理：
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
    	





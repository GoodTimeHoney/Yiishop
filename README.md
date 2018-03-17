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
# 项目描述简介
类似京东商城的B2C商城 (C2C B2B O2O P2P ERP进销存 CRM客户关系管理)
电商或电商类型的服务在目前来看依旧是非常常用，虽然纯电商的创业已经不太容易，但是各个公司都有变现的需要，所以在自身应用中嵌入电商功能是非常普遍的做法。
为了让大家掌握企业开发特点，以及解决问题的能力，我们开发一个电商项目，项目会涉及非常有代表性的功能。
为了让大家掌握公司协同开发要点，我们使用github管理代码。
在项目中会使用很多前面的知识，比如架构、维护，以及数据库的搭建。



# 主要功能模块
系统包括：
后台：品牌管理、商品分类管理、商品管理、订单管理、系统管理和会员管理六个功能模块。
前台：首页、商品展示、商品购买、订单管理、在线支付等

1.3.开发环境和技术
开发环境	Window
开发工具	Phpstorm+PHP7.1+github+Apache
相关技术	Yii2.0+CDN+jQuery+sphinx

# 人员组成
职位	      人数	    备注
项目经理和组长	1   	一般小公司由项目经理负责管理，中大型公司项目由项目经理或组长负责管理
开发人员	    1 	
UI设计人员	    1	
前端开发人员	1	    专业前端不是必须的，所以前端开发和UI设计人员可以同一个人
测试人员     	1      	有些公司并未有专门的测试人员，测试人员可能由开发人员完成测试。

#   day1
  第一天的学习中我明白了一个项目的简单运行流程，以及数据库的搭建，和brand相关的字段，虽然第一天的任务不是很难。但是对Yii的增删改查有了进一步的完善和熟练。
  
#    day2
第二天的话相比于第一点难度可能会大一些，运用了三个表的规则，分别是文章表，文章分类表，文章内容表，这天的难点可能是分类下拉菜单、本地文件保存和云服务器保存以及编辑器等的运用。分类下拉菜单运用的是ArrayHelper::map方法，云服务器用的是七牛云，编辑器运用的百度uediter。文章表和文章内容表的关系是一对一的关系，文章表的id对应article-id。创建时间和编辑时间是运用的Yii自带的注入方法。
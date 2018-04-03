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
# day4-day5
此项目主要是goods、goods_gallery、goods_intro和admin的运用。在这两天的运用中我们学习到了无限极分类，多图上传，富文本，和ztree的用法，在admin的登录过程，我们一定要记得重写，切记别入坑，当然我也知道了怎么获取客户端的地址---ipYii::$app->request->userIP。
# day7
RBAC的流程慢慢的清除了，掌握锅炉器的两张方法，怎样获取当前的路由等等....
# day13
# 第一种项目上传步骤
1.在阿里云上控制台下中安全组和域名中设置端口和域名。端口(888,8888,3306),域名看自己情况设置(注意：*和@的区别)。
2.在宝塔(https://www.bt.cn/)中的Linux面板中找到composer安装(yum install -y wget && wget -O install.sh http://download.bt.cn/install/install.sh && sh install.sh)。
3.安装好宝塔以后进入后台安装apache、mysql和php,(注意：如果进不了后天看端口打开没)。
4.进入www/wwwroot目录，将GitHub上的项目克隆下来。(命令：git clone github地址).
5.进入项目根目录，给init赋予执行权限(命令：chmod 777 init),然后在执行init。
6.安装composer中国镜像，然后执行composer install -vvv。
7.导入数据库。有两种方式：一种宝塔导入数据库，一种本地链接远程数据库，注意打开放行3306，和所有人访问。
8.设置完网站入口后，需要在网站目录中将防跨站攻击取消，并且在软件管理中php7.0设置中重启php。

# 第二中项目上传
压缩目录下文件。注意格式是zip.然后在网站根目录下解压即可.


注意：更新GitHub项目是，项目根目录下执行git pull即可.
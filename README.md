新版样板项目

### 特点

1. 模块化开发模版

2. 使用 dotenv 环境变量配置敏感数据

3. 更灵活的目录结构

### 安装

##### 安装 composer 依赖包

```bash
composer install
```

##### 复制 .env.example 文件为 .env 并编辑配置

##### 开发服务器环境

###### 修改 Hosts 
```text
    127.0.0.1 www.bp.test
```
      
###### Nginx 配置

```text
server {
    listen	80;
    server_name www.bp.test;

    root {项目根目录}/public;
    index index.php index.html index.htm;
    
    rewrite ^/(.*)/$ /$1 permanent;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    include php71-fpm;
}
```

##### 数据表初始化方法：

```bash
php bin/yii migrate --migrationPath=@vendor/huijiewei/yii2-wechat/src/migrations
```

### 其他

网站主目录
http://www.bp.test/

后台访问路径
http://www.bp.test/admin

微信公众号访问路径
http://www.bp.test/wechat

后台管理：
用户：13012345678
密码：123456

Version: 2018-06-19 18:30
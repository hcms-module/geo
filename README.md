# 介绍
Geo是地理位置模块，默认拥有省市区联动组件、定位地址获取组件。让你在开发需要地址信息提交的过程中不在浪费时间。

## 省市区组件
这里提供了，地址单选和多选，支持省市区、省市联动。
![](https://ftp.bmp.ovh/imgs/2022/02/994e09d4d64f8b65.png)
## 地址定位
根据这个组件我们在管理后台表单编辑中就可以轻松拿到需要定位的位置的经纬度信息。
- 该组件需要向腾讯地图申请开发的key [https://lbs.qq.com/](https://lbs.qq.com/)
![](https://ftp.bmp.ovh/imgs/2022/02/bbf0ec59c3441fb8.png)

# 安装

```shell
php bin/hyperf.php hcms:install geo
```
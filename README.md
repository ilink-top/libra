# LibraAdmin

## 快速安装

> 第一步：安装代码

```
git clone https://github.com/ilink-top/Libra.git
```

> 第二步：检测环境以及配置数据库

```
php think Libraadmin:install --db mysql://root:123456@127.0.0.1:3306/Libraadmin#utf8mb4
```

> 第三步：数据库迁移

```
php think migrate:run
```

**注：安装完成后，后台管理员的账号密码请查看：application/install/lock.ini**

## 鸣谢

- [iView-Admin](https://github.com/iview/iview-admin)
- [iView](https://github.com/iview/iview)
- [Vue](https://github.com/vuejs/vue)
- [Webpack](https://github.com/webpack/webpack)
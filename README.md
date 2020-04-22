# LibraAdmin

## 快速安装

> 第一步：安装程序

```
git clone https://github.com/ilink-top/LibraAdmin.git /path/to/your/project
cd /path/to/your/project
```

> 第二步：安装 Composer 包

```
composer install
```

> 第三步：程序初始化

```
composer run-script post-root-package-install
composer run-script post-create-project-cmd
composer run-script post-autoload-dump
```

> 第四步：创建符号链接

```
php artisan storage:link
```

> 第五步：配置数据库并导入数据

```
php artisan migrate
php artisan db:seed
```

> 第六步：安装 Node 包

```
npm install
```

> 第七步：生成静态文件

```
npm run dev
```

**注：安装完成后，后台管理员的账号密码均为：admin

## 鸣谢

- [AdminLTE](https://github.com/ColorlibHQ/AdminLTE)
- [Bootstrap](https://github.com/twbs/bootstrap)
- [Bootstrap Fileinput](https://github.com/kartik-v/bootstrap-fileinput)
- [Bootstrap Switch](https://github.com/Bttstrp/bootstrap-switch)
- [Font Awesome](https://github.com/FortAwesome/Font-Awesome)
- [Font Awesome Iconpicker](https://github.com/itsjavi/fontawesome-iconpicker)
- [iCheck](https://github.com/fronteed/icheck)
- [jQuery](https://github.com/jquery/jquery)
- [jQuery DataTables](https://github.com/DataTables/Dist-DataTables-Bootstrap)
- [jQuery Serialize Object](https://github.com/macek/jquery-serialize-object)
- [jQuery Toastr](https://github.com/CodeSeven/toastr)
- [jQuery TreeGrid](https://github.com/maxazan/jquery-treegrid)
- [Select2](https://github.com/select2/select2)
- [WangEditor](https://github.com/wangfupeng1988/wangEditor)
- [Laravel](https://github.com/laravel/laravel)
- [Laravel Collective HTML](https://github.com/LaravelCollective/html)
- [Laravel jQuery DataTables API](https://github.com/yajra/laravel-datatables)
- [Laravel Permission](https://github.com/spatie/laravel-permission)
# 框架简介

## 1、什么是框架？
- 特征1：是一堆代码的集合
- 特征二：一个半成品的应用
- 特征三：包含了一些优秀的设计模式

定义：框架是一堆包含了常量、方法和类等代码的集合，它是一个半成品的应用，只包含了一些项目开发时所用到的底层架构，并不包含业务逻辑，框架还包含了一些优秀的设计模式，如单例模式、工厂模式、AR（Active Record）模式等。

## 2、为什么要使用框架？
在以后的实际开发过程中，会有一个成型的开发流程。<br>
如果在上述流程中不使用框架进行开发会出现一下问题：
- 代码风格不一样，维护困难，可能会造成项目生命周期短
- 一处小的修改，会牵扯出很多地方的修改
- 在后期满足客户需求方面（功能扩展）存在局限性

## 3、使用框架的好处
- 使用框架会帮助我们==简单、快捷、高效==地开发项目
- 可以让我们有更多的时间专注于业务逻辑的开发，不需要关注==底层架构==
- 便于处理多人协助开发中遇到的问题

## 4、常见的主流框架

- Zend Framework <br>
是重量级框架，是php语言公司出品的官方框架，但是由于官方考虑的功能比较全面，导致比较臃肿，启动慢。
- Yii <br>
是重量级框架，是美籍华人开发的框架，作者叫薛强（英文名Qiang），最大的特点，是将代码的重用性发挥到了机智，目前Yii框架在外企用的比较多。
- Symfony <br>
重量级框架，一款国外框架。
- Laravel <br>
轻量级框架，一款国外框架。
- CodeIgniter <br>
轻量级框架，简称CI框架，代码火焰/火焰代码，一款国外框架。
- ThinkPHP <br/>
是一款国人开发的框架，目前有==中文的社区、中文官网、中文帮助文档==等，在国内使用比较普遍，因为其有一系列中文支持，所以比较适合作为入门级框架学习。
- ......

## 5、MVC

### 5.1、什么是MVC？
MVC是一个设计模式，它是强制将用户的输入、逻辑、输出相分离，将整个项目分为三个部分：控制器（C）、模型（M）、视图（V）。

### 5.2、在编程中所经历的编程阶段

在整个编程开发的历史中，一共经历了三个阶段

-第一阶段：混合编程阶段 <br/>
通俗说，“混编”模式 <br/>
特点：就是将php代码和html写在一个文件中
优点：效率高。 <br/>
缺点：不易于维护，会造成一个前端人员不得不面对后端代码，后端人员不得不面对前端代码。

-第二阶段：模板引擎阶段 <br/>
模板引擎典型的如smarty。 <br/>
优点：将前端的输出和后端的逻辑代码相分离 <br/>
缺点：效率比第一种低。

-第三阶段：MVC设计阶段 <br/>
优点：就是强制将用户的输入、逻辑、输出相分离，在维护上简单性提高了很多。 <br/>
缺点：效率比前面两种模式都低。

# 二、ThinkPHP框架介绍

## 1、简述
ThinkPHP框架最早诞生于2006年初，最初的名字叫做FSC。于207年元旦更名为ThinkPHP，同时其官网上线。ThinkPHP是一款国人自主开发的框架，有中文官网、论坛、帮助文档，其中代码中包含了丰富的中文注释。
## 2、下载
下载从官网下载：[官网](url:http://www.thinkphp.cn)  

目前最新版本 5.1.12

扩展（了解）：==关于软件版本的修饰词== <br/>
Alpha版本：内测版本，内部测试。 <br/>
Beta版本：公测版本，面向用户，由用户去找bug。 <br/>
RC版本：候选版本，软件在这个阶段就已经不会有太多的功能性调整，主要是排错。 <br/>
R版本：release版本，发行版本，稳定版本。 <br/>

## 3、目录结构
一级目录
<pre>
-Application    应用目录
-Public         存放图片、CSS、JS等公共静态资源文件目录ssss
-ThinkPHP       框架核心目录
.htaccess       分布式配置文件(配合apache对站点进行配置)
composer.json   给composer软件使用的说明文件
index.php       项目的入口文件
README.md       项目的说明文件
</pre>

<pre>
-Application    应用目录
  index.html    目录安全文件
  README.md
-Public         存放图片、CSS、JS等公共静态资源文件目录
  -Common       公共目录 系统函数库目录，里面存放了functions.php
    functions.php
  -Conf         系统配置文件目录
    convention.php  系统配置文件
    debug.php       
  -Lang         语言包目录
  -Library      ThinkPHP目录的核心目录
    Behavior    行为文件目录
    Org         功能扩展目录
    Think       最核心的目录
    Vendor      第三方扩展目录
      Smarty    Smarty模板  
  -Mode         模式
  -Tpl          系统模板目录，里面包含了系统所用的模板
    dispatch_jump.tpl   跳转模板
    page_trace.tpl      跟踪信息模板
    think_exception.tpl 异常模板
  LICENSE.txt   许可文件
  logo.png
  ThinkPHP.php  项目接口文件，在后期开发的时候，需要被项目入口文件所引入
-ThinkPHP       框架核心目录
.htaccess       分布式配置文件(配合apache对站点进行配置)
composer.json   给composer软件使用的说明文件
index.php       项目的入口文件
README.md       项目的说明文件
</pre>

thinkphp_3.2.3_full -> THinkPHP -> Library ->Think 目录<br/>
Think目录
<pre>
-thinkphp_3.2.3_full
    -ThinkPHP
        -Library
            -Think
                -Cache
                -Controller
                -Crypt
                -Db
                -Image
                -Log
                -Model
                -Session
                -Storage
                -Template
                -Upload     上传
                    -Driver 上传的驱动文件
                -Verify
                    -bgs    验证码背景图片
                    -ttfs   字体文件
                    -zhttfs 中文字体文件 
                App.class.php
                Auth.class.php
                Behavior.class.php
                Build.class.php
                Cache.class.php
                Controller.class.php    MVC中"C"父类
                Crypy.class.php
                Db.class.php            底层类 数据库类
                Dispatcher.class.php
                Exception.class.php
                Hook.class.php
                Image.class.php         功能类 图像处理类 1
                Log.class.php
                Model.class.php         MVC中"M"父类
                Page.class.php          功能类 数据分页类 2
                Route.class.php
                Storage.class.php
                Template.class.php
                Think.class.php
                Upload.class.php        功能类 文件上传类 3
                Verify.class.php        功能类 验证码类 4
                View.class.php          MVC中"V"父类
                
</pre>

==补充：
在ThinkPHP中除了convention.php配置文件之外，还有其他的配置文件，但是convention.php文件是系统级别的配置文件，还有一个是应用界别的配置文件，最后还有一个分组级别的的配置文件。== <br/><br/>

从作用范围上来说：<br/>
系统 > 应用 > 分组 <br/>
从优先级上说：<br/>
分组  > 应用 > 系统


##  4、部署(重点)

<b>第一步：创建站点目录 </b><br/>
<b>第二步：配置Apache虚拟主机的配置文件，创建一个虚拟主机 </b><br/>
文件位于Apache目录下conf/extra/httpd-vhosts.conf<br/>
```
<VirtualHost *:80>
    #配置站点管理员的邮箱，当站点报500错误的时候会在页面上提示错误信息，并且列出管理员邮箱
    ServerAdmin webAdmin@tencent.com
    #站点根目录 
    DocumentRoot "D:/web/zerg"
    #站点绑定的域名
    ServerName www.zerg.com
    #站点的别名(一般是不带www的域名)
    ServerAlias zerg.com
    #错误日志的存储位置，logs目录在Apache目录下
    ErrorLog "logs/zerg-error.log"
    #正常访问日志的存储位置，logs目录在Apache目录下，common是指日志的记录规则名称。
    CustomLog "logs/zerg-access.log" common
    #针对目录的详细配置
    <Directory "D:\www\web\zerg>
        #允许所有访问
        allow from all
        #允许重写
        allowOverride all
        #允许显示站点目录的文件结构
        options +indexes
    </Directory>
</VirtualHost>
```
<b>第三步：重启Apache </b><br/>
<b>第四步：修改hosts文件，将配置文件中声明的2个域名绑定(解析) </b><br/>
问题：host文件在哪？<br/>
C:\WINDOWS\System32\drivers\etc\hosts <br/>
或者：`win+r` 后，输入  `drivers` or `to hosts` 命令<br/>

Application目录结构：
```
-Application
    -Common     #应用级别的通用文件目录
        -Common #函数库目录
        -Conf   #配置文件目录
            config.php  #配置文件
        index.html
    -Home       #分组目录，平台目录(前、后台)
        -Common #分组级别函数库文件目录
        -Conf   #分组配置文件目录
        -Controller #MVC C目录
        -Model      #MVC M目录
        -View       #MVC V目录
        index.html
    -Runtime    #临时文件目录
        -Cache
        -Data
        -Logs
        -Temp
    index.html
    README.md
```

说明：<br/>
在首次运行`index.php`入口文件的时候才会产生对应的目录结构。再次运行不会产生变化。<br/>

## 5、细节问题

### 5.1、自动生成
在首次运行`index.php`入口文件的时候才会产生对应的目录结构，目录的名字取决于在index.php中定义的APP_PATH敞亮的值。

### 5.2、目录安全文件
除了application，在自动生成的目录中都有一个空白的html文件，文件名叫做index.html,这个文件我们称之为目录安全文件。<br/>
==其作用==：<br/>
在Apache的配置文件中有 options+indexs,默认展示站点目录，如果在站点目录中不存在index开头的文件，则会展示目录结构，但是有了index.html(目录安全文件)之后就不会展示结构了。<br/><br/>
一句话概括，==防止列出站点的文件结构==。

### 5.3、文件生成

当我们首次运行入口文件的时候，发现在磁盘中系统给我们生成了一些目录，那这些目录是如何生成的？<br/><br/>
文件夹/文件的生成，主要取决于ThinkPHP的==系统流程==：(手册中： 架构 -> 系统流程)

### 5.4、 默认访问

在部署之后，访问会看到一个笑脸，笑脸是如何输出的？ <br/>
==默认分组：Home <br/>
默认控制器：Index  <br/>
默认方法：index  <br/>==

上述的默认值，可以在系统配置文件中找到：<br/>
`ThinkPHP -> Conf -> convention.php `中
`DEFAULT_MODULE、DEFAULT_CONTROLLER、DEFAULT_ACTION`

# 三、ThinkPHP中控制器

## 1、控制器创建

命名规则：==控制器名(英文首字母大写)+Controller关键词+.class.php==<br/>
eg：创建商品控制器则可以携程GoodsController.class.php,用户控制器则写成UsersController.class.php。<br/>

案例：在Home分组中创建一个用户控制器。<br/>

控制器结构代码：<br/>
总结步骤:  
- 第一步：声明当前控制器（类）的命名空间
- 第二步：引入父类控制器（类）
- 第三部：生命控制器（类）并继承父类

==说明：命名空间==  
- 第一：命名空间是在php5.3版本中引入的一个概念，所以ThinkPHP3.2.3要求大于等于5.3版本的php。  
- 第二：命名空间本身跟目录没有关系，但是在ThinkPHP中命名的声明和使用必须跟目录挂钩。

案例：参考上述结构代码的完善三步骤，来完善刚才创建的Users控制器。 

在类中编写一个测试方法，名字可以起叫test 

```
#定义命名空间
namespace Home\Controller;
#引入父类控制器
use Think\Controller;
#定义控制器并且继承父类
class UsersController extends Controller{
    //测试方法 public private protected static
    public function test(){
        echo date('Y-m-d H:i:s',time()).'<br/> Home Users test';
    }

}
```

访问URL： `http://localhost/thinkphp_3.2.3_full/index.php/Home/Users/test` or `http://localhost/thinkphp_3.2.3_full/index.php?m=Home&c=Users&a=test`

若后期需要更多的控制器来实现功能，则只需要按照上述的创建步骤反复的创建更多的控制器就行

# 四、路由形式（重点）
路由：是指访问项目中具体某个方法的==URL==地址。  
在thinkPHP中，有四种路由形式，分别为  
- 普通形式路由
- Pathinfo形式路由
- Rewrite形式路由
- 兼容形式路由

## 1、普通形式路由（get形式路由）
路由形式：http://网址/入口文件?m=模式名&c=控制器名&a=方法名  
例如：访问 Home分组下的Users控制器的test方法，并且传递一个参数，id=1  
`http://localhost/thinkphp_3.2.3_full/index.php?m=Home&c=Users&a=test&id=1`  
问题：URL传递的任何东西都会在URL地址栏中显示出来，既不安全，也不好看。

## 2、pathinfo路由形式（默认）
路由形式：http://网址/入口文件/模式名/控制器名/方法名/参数名1/参数值1/参数名2/参数值2  
例如：访问 Home分组下的Users控制器的test方法，并且传递一个参数，id=233  
`http://localhost/thinkphp_3.2.3_full/index.php/Home/Users/test/id/233`  

## 3、rewrite 路由形式
`restart 重启; rename 重命名; redirect 重定向; repeat 重复`

路由形式：`http://网址/分组名/控制器名/方法名/参数名1/参数值2`和thinkPHP默认的路由形式相比就是只缺少了入口文件(index.php)。  
`http://localhost/thinkphp_3.2.3_full/Home/Users/test/id/233`  
注意：该路由形式不能直接使用，需要配置完成后才可以使用。  
1. 需要修改Apache配置文件`httpd.conf`开启重写模块  
将`LoadModule rewrite_module modules/mod_rewrite.so` 注释去掉
2. 需要修改虚拟主机配置文件，给需要重写的站点目录配置处添加`AllowOverride all`  
文件位于Apache目录下conf/extra/httpd-vhosts.conf  
确认加上`AllowOverride all` 这一行配置 ***允许重写***
```
<VirtualHost *:80>
    #配置站点管理员的邮箱，当站点报500错误的时候会在页面上提示错误信息，并且列出管理员邮箱
    ServerAdmin webAdmin@tencent.com
    #站点根目录 
    DocumentRoot "D:/web/zerg"
    #站点绑定的域名
    ServerName www.zerg.com
    #站点的别名(一般是不带www的域名)
    ServerAlias zerg.com
    #错误日志的存储位置，logs目录在Apache目录下
    ErrorLog "logs/zerg-error.log"
    #正常访问日志的存储位置，logs目录在Apache目录下，common是指日志的记录规则名称。
    CustomLog "logs/zerg-access.log" common
    #针对目录的详细配置
    <Directory "D:\www\web\zerg>
        #允许所有访问
        allow from all
        #允许重写
        allowOverride all
        #允许显示站点目录的文件结构
        options +indexes
    </Directory>
</VirtualHost>
```

3. 如果修改了Apache配置文件，则还需要重新启动apache
4. 将ThinkPHP压缩包中的`.htaccess` 文件复制到入口文件的同级目录  
注意：php一共有好几个运行模式，每个运行模式的使用`.htaccess`文件的方法可能不一样。  
这种路由形式需要Apache的支持，而除了Apache软件之外服务器软件还有nginx、lightd等等，所以第三种路由形式一般情况下不推荐使用。  

## 4、兼容路由形式

路由形式：http://网址/入口文件?s=/分组名/控制器名/方法名/参数名1/参数值1  

***问题：兼容路由形式有几个参数？***
答：上述路由形式只有一个参数，参数名是s，等于号后面的都是s参数的值。 

例如：访问 Home分组下的Users控制器的test方法，并且传递一个参数，id=233  
`http://localhost/thinkphp_3.2.3_full/index.php?s=/Home/Users/test/id/233`  

## 5、关于thinkPHP中路由形式的配置
路由形式在thinkPHP系统中的配置文件是由体现的，`URL_MODEL`
```
'URL_MODEL'             =>  1,       // URL访问模式,可选参数0、1、2、3,代表以下四种模式：
    // 0 (普通模式); 1 (PATHINFO 模式); 2 (REWRITE  模式); 3 (兼容模式)  默认为PATHINFO 模式
```

特别说明：路由形式的配置值，不影响我们在地址栏中直接输入其他形式路由访问。该配置项的值影响的是thinkPHP系统封装的URL组装函数(U函数)的生成url地址的形式。  
# 五、分组
分组：一般的项目都会根据某个功能的使用对象，来区分代码，这个时候放到一起之后会形成一个目录，这个目录就可以称之为分组。分组就是我们通常所指的平台（前台、后台）。  
例如在刚部署好的`thinkPHP`系统中`Home`目录就是一个分组目录。后期如果需要使用更多的分组，则需要自己去创建分组。  

**如何去创建分组？**  
步骤：*参照 Home 分组的目录结构，重新创建一个新的目录，在其中依照 Home 中的结构，创建对应的目录即可。*

```
namespace Admin\Controller;
use Think\Controller;

class TestController extends Controller
{
    public function test(){
        echo __APP__;
    }
}
```

如果需要创建多个分组，参考以上的步骤，反复创建对应的目录即可。 

# 六、控制器中的跳转
## 1、URL组装
URL组装就是根据某个规则，来组成一个URL地址，这个功能就叫做URL组装。  
在thinkPHP中，系统提供了一个封装的函数来处理URL的组装，这个方法叫做U方法。
U方法是系统提供的快速方法，除了U方法这样的大写字母的方法之外，还有一些其他的快速方法如：==A、B、C、D、E、F、G、I、M、R、S==。这些方法都定义在系统的函数库文件中(functions.php)。  

U 方法语法格式：
   U('URL路径'，参数数组);
例如：要使用U方法组装出当前控制器下index方法地址，则可以写成 U('index');

```
public function test1(){
    echo U('index').'<br/>';
    echo U('Index/index').'<br/>';
    echo U('Home/Index/index').'<br/>';
    echo U('index',array('id' => 233,'name' => 'msp')).'<br/>';
}
```
**eg:**  
**访问** `http://localhost/thinkphp_3.2.3_full/index.php/Admin/Test/test1.html`  
**输出** 
```
/thinkphp_3.2.3_full/index.php/Admin/Test/index.html
/thinkphp_3.2.3_full/index.php/Admin/Index/index.html
/thinkphp_3.2.3_full/index.php/Home/Index/index.html
/thinkphp_3.2.3_full/index.php/Admin/Test/index/id/233/name/msp.html
```
后面有html后缀，在系统配置中`Conf  -> convention.php `   
`'URL_HTML_SUFFIX'       =>  'html',  // URL伪静态后缀设置`

## 2、系统跳转方法
在ThinkPHP中系统有2个跳转方法，分别是成功跳转，和失败跳转：
成功： $this->success(跳转提示,跳转地址,等待时间);  
失败： $this->error()  
==跳转提示参数必须要有，后面的地址和时间可以省略，若没有跳转地址，则跳转到上一页==  

在实际使用的时候，成功跳转回看到一个笑脸。  

说明：上述案例中使用success 和 error 方法在当前的控制器中并没有定义，其实父类控制器中已经定义好了方法，由于当前控制器继承了父类，所以可以直接使用。 

# 七、ThinkPHP中的视图（重点）
## 1、什么是视图
视图就是MVC三大组成部分中V (View)，主要负责信息的输出和展示。  
## 2、视图的创建
创建的位置，需要在分组目录下的View目录中，与控制器同名的目录中。例如Test控制器中的login方法，需要有一个模板，则该模板文件login.html 需要放到View/Test/login.html  

如果有多个模板文件，则按照上面的要求进行创建。

# 3、视图的展示
在smarty中展示模板使用的方法是display，在ThinkPHP中同样也是display方法。Display在ThinkPHP中的语法格式：  
```
$this->display();   #展示当前控制器下与当前请求方法名称一致的模板文件
$this->display('模板文件名[不带后缀]');     #展示当前控制旗下的指定模板文件
$this->display('View目录下的目录名/模板文件名[不带后缀]');    #展示指定控制器目录下的指定模板文件
```

## 4、变量分配 (初级)

在实际开发的时候不仅仅只是展示模板这么简单，往往还需要展示数据，这个时候变量还在控制器的方法中，需要将数据传递给模板并展示，这个过程叫做变量分配。  

在ThinkPHP中系统封装好了一个变量的分配方法，这个方法叫做assign。  

具体语法：  
**$this->assign('模板中变量名',$php中的变量名);**  

说明：==一般情况，两个参数的变量都是一样的。==

案例：在test控制器中的test方法中传递一个变量给test.html
```
public function test(){
    echo 'Admin分组 Test控制器 index方法<br/>';
    echo __APP__;
    $id = $_GET['id'];
    $id = ($id == '') ? '1' : $id;
    $this ->assign('id',$id);
    $this->display();
} 
```
在ThinkPHP中默认的展示基本变量方法如下： 
`{$模板中的变量名}`

```
id = {$id} #模板中展示变量例子
```
## 5、变量分隔符
在ThinkPHP中默认的变量左右分隔符是 { 和 } ，其实是可以被更改的，可以在配置文件中找到具体的配置项     
```
'TMPL_L_DELIM'          =>  '{',            // 模板引擎普通标签开始标记
'TMPL_R_DELIM'          =>  '}',            // 模板引擎普通标签结束标记
```

## 6、==模板常量==替换机制
在实际开发的时候会出现这样一个问题：在引入图片、css、js文件的时候，往往需要写一些比较复杂的路径，所以这个时候我们比较希望能有一些特殊的常量，将很长很复杂的路径简单化，这个时候可以考虑使用模板常量替换的机制。  

在ThinkPHP中系统默认给我们提供一下几个常用的==模板常量==：  
```
__MODULE__  #表示从域名后面开始一直到分组名结束的路由
__CONTROLLER__  #表示从域名后面开始一直到控制器结束的路由
__ACTION__  #表示从域名后面开始一直到方法结束的路由
__PUBLIC__  #站点根目录下的Public目录的路由
__SELF__    #当前页面地址 表示从域名后面开始，一直到路由的最后（包括参数,若无参数与 __ACTION__ 相同）
```
URL访问路径`http://localhost/TP3.2.3/index.php/Admin/Test/test4/id/100`
```
/TP3.2.3/index.php/Admin    #__MODULE__
/TP3.2.3/index.php/Admin/Test   #__CONTROLLER__
/TP3.2.3/index.php/Admin/Test/test4     #__ACTION__
/TP3.2.3/Public     #__PUBLIC__
/TP3.2.3/index.php/Admin/Test/test4/id/100  #__SELF__
```
为什么上述的几个常量就可以表示上面输出的这些路由呢？  
答：在ThinkPHP中“模板常量”是通过模板内容替换机制来实现的，并非是常量的定义。  
替换机制可以查看行为文件ContentReplaceBehavior.class.php `ThinkPHP -> Library -> Behavior -> ContentReplaceBehavior.class.php`  

为了后期使用的方便，我们可以在配置文件中定义一个自定义的模板常量：  
说明：**在开发时，不到万不得已不要去修改系统配置文件。可以将需要修改的配置项在分组/应用级别的配置文件中去定义。**
`Application -> Common -> Conf -> config.php`
```
<?php
return array(
	//'配置项'=>'配置值'

    //模板常量
    'TMPL_PARSE_STRING' => array(
        '__ADMIN__' => __ROOT__.'/Public/Admin'
    ),
);
```

# 八、综合案例-实现OA系统的登录页面展示
控制器：PublicController.class.php  
方法：login  
模板文件：login.html  

1. 创建控制器文件，并且编写结构代码
2. 编写方法login，展示模板文件login.html
3. 将模板文件复制到指定位置
4. 将相应的静态资源文件复制到指定的位置
位置：/Public/Admin
5. 修改模板文件 login.html 中的静态资源文件的引入路径。

`day01 -> 14 -> 7:00`
































<p>Please ==don't== use any `<blink>` tags.</p>

```
aa
var name='abc';
echo name;
```










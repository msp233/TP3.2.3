# 一、ThinkPHP中的视图（2）（重点）

## 1、模板内容获取方法
在ThinkPHP中有一个方法和display方法有点相似。这个方法叫做fetch方法：  
display方法： $this->display();     展示模板   
fetch方法： $this->fetch();     获取模板（有返回值） 

在ThinkPHP中系统封装好了一个有好的打印方法，这个方法是dump方法：  
**语法格式：dump(需要打印的变量);       
封装在系统的函数库文件functions.php中**

在底层实现上差异：
display方法：替换模板中常量/变量 -> 获取模板内容 -> 输出模板内容  
fetch方法：替换模板中常量/变量 -> 获取模板内容  

display方法的前两步实际是调用fetch方法实现的。  

## 2、视图中的注释

视图中的注释特指是ThinkPHP中视图的注释。  
html注释 <!-- -->  
```
<!-- 这是普通的注释 在页面源代码中可以看到 -->
    在ThinkPHP中的模板注释<br/>
    行注释：{//注释内容}<br/>
    块注释：{/*块注释内容*/}<br/>

```


**经典面试题：**
问：ThinkPHP中的行注释和块注释与普通的html注释有什么区别？  
答：普通的html注释属于==客户端注释==，会在浏览器的源代码中输出；而ThinkPHP中的模板注释则属于==服务器端==注释，不会被浏览器输出。  

注意点：
- 行注释不要当作块注释来写（横跨多行）;
- 在行注释和块注释(花括号 {} 中)不要再次出现模板变量{$str}（花括号）;

## 3、变量分配（进阶）
- 简单变量的输出
- 一维数组的输出
- 二维数组的输出
- 对象变量的输出

### 3.1、一维数组
在ThinkPHP中变量的分配（不考虑变量类型）都是使用assign语法格式：  
$this->assign('模板中的变量',php中变量); 

在控制器中定义一个一维数组：
```
/*变量的输出（一维数组）*/
    public function test6(){
        //定义一维数组
        $arr = array('张三','李四','王五');;
        //变量分配
        $this->assign('arr',$arr);
        $this->display();
    }
```
在php中输出数组的具体元素可以通过下表的形式输出：$arr[key]。   
关于数组在模板中输出的语法格式：  
- 支持中括号形式=={$arr[key]}==  
- 支持点形式：=={$arr.key}==

定义模板并输出：
```
花括号形式：{$arr[0]} - {$arr[1]} - {$arr[2]}<hr/>
点形式：{$arr.0} - {$arr.1} - {$arr.2}<hr/>
```
两种形式在输出效果上没什么区别，所以在实际开发的时候，两种任意一种都可以使用。  

### 3.2、二维数组
 在方法中定义一个二维数组，并传值
 ```
 //定义二维数组
        $arr2 = array(
            array('白骨精','大师兄','二师兄'),
            array('诸葛亮','张飞','关羽'),
            array('李逵','戴宗','林冲'),
        );
        //变量分配
        $this->assign('arr2',$arr2);
 ```
 
 定义模板并输出：
```
中括号形式：<br/>
{$arr2[0][0]} - {$arr2[0][1]} - {$arr2[0][2]} <br/>
{$arr2[1][0]} - {$arr2[1][1]} - {$arr2[1][2]} <br/>
{$arr2[2][0]} - {$arr2[2][1]} - {$arr2[2][2]} <hr/>
点形式：<br/>
{$arr2.0.0} - {$arr2.0.1} - {$arr2.0.2} <br/>
{$arr2.1.0} - {$arr2.1.1} - {$arr2.1.2} <br/>
{$arr2.2.0} - {$arr2.2.1} - {$arr2.2.2} <hr/>
```
 
### 3.3、对象变量
对象在实例化之后，一般会保存到一个变量中去，这个变量也可以被分配到模板中。  

```
namespace Admin\Controller;
class Student{
    
}
```
存储位置位于 Admin/Contrller/Student.class.php  

类的实例化：
```
public function test7(){
        //实例化student对象
        $stu = new Student();
        
        //给类的属性赋值
        $stu -> id = 1000;
        $stu ->name = 'tom';
        $stu ->sex = 'boy';
        dump($stu);
    }
```
需要注意：==在命名空间的语法要求中，如果不写命名空间（也不使用include、require系统会默认先去当前空间下去寻找需要的元素，若找不到，则报错。==  

为了在后期使用中文的时候不乱码，可以在入口文件(index.php)中添加一个header头
```
 //给入口文件添加一个header头声明字符集
 header('Content-Type:text/html;charset=utf-8');
 ```

输出结果
```
object(Admin\Controller\Student)[6]
  public 'id' => int 1000
  public 'name' => string 'tom' (length=3)
  public 'sex' => string 'boy' (length=3)
```

将对象变量分配到模板中去展示：
```
$stu = new Student();
        //给类的属性赋值
        $stu -> id = 1000;
        $stu ->name = 'tom';
        $stu ->sex = 'boy';

        //变量的分配
        $this->assign('stu',$stu);
        //展示模板
        $this->display();
        //dump($stu);
```

在php中如何去输出一个对象的属性？  
可以通过$obj->attribute; / $obj::attr;这两种形式输出对象的属性。  

在ThinkPHP的模板中输出属性的值，可以通过下面的两种方式来实现：
支持箭头形式：$obj->attr;  
支持冒号形式：$obj::attr;  
```
箭头形式：<br/>
{$stu->id} - {$stu->name} - {$stu->sex} <hr/>
冒号形式：<br/>
{$stu:id} - {$stu:name} - {$stu:sex} <hr/>
```
切记：在ThinkPHP模板中，在输出对象的属性的时候，千万不要使用点形式，因为ThinkPHP不允许把对象当作数组来使用。  


模板输出效果：
```
箭头形式：
1000 - tom - boy
冒号形式：
1000 - tom - boy
```

## 4、系统变量

在ThinkPHP中系统提供了以下几个系统级别的变量（超全局变量在模板中的使用）：  
```
$Think.server   #等价于$_SERVER,获取服务器的相关信息
$Think.get      #等价于$_GET，获取get请求的信息    
$Think.post     #等价于$_POST，获取post请求中的信息    
$Think.request  #等价于$_REQUEST，获取get和cookie中的信息    
$Think.cookie   #等价于$_COOKIE，获取cookie中的信息    
$Think.session  #等价于$_SESSION，获取session中的信息
$Think.config   #获取ThinkPHP中所有配置文件的一个总和，如果后面制定了元素，则获取指定的配置
```
上述7个系统变量的语法都是一样的，在模板中使用的语法格式是：  
=={$Think.xxx.具体的元素下标}==   
例如：需要获取get请求中的id，则可以写成{$Think.get.id}。  

案例： 在模板中输出其中的部分变量信息。  
```
<b>$Think.server.path:</b>
{$Think.server.path}<br/>

<b>$Think.get.id:</b>
{$Think.get.id}<br/>

<b>$Think.request.pid:</b>
{$Think.request.pid}<br/>

<b>$Think.cookie.PHPSESSID:</b>
{$Think.cookie.PHPSESSID}<br/>

<b>$Think.config.DEFAULT_MODULE:</b>
{$Think.config.DEFAULT_MODULE}<br/>
```
访问URL:  
`http://localhost/TP3.2.3/index.php/Admin/Test/test8/id/123/pid/666`

显示为：
```
$Think.server.path: D:\Python36\Scripts\;D:\Python36\;D:\Python27\;D:\Python27\Scripts;C:\WINDOWS\system32;C:\WINDOWS;C:\WINDOWS\System32\Wbem;C:\WINDOWS\System32\WindowsPowerShell\v1.0\;D:\Program Files\nodejs\;C:\Program Files\Intel\WiFi\bin\;C:\Program Files\Common Files\Intel\WirelessCommon\;D:\Program Files\Git\cmd;C:\Program Files\MySQL\MySQL Utilities 1.6\;C:\Program Files\MySQL\MySQL Server 5.7\bin;E:\software\ClockworkMod\Universal Adb Driver\;E:\software\MATLAB\R2017a\runtime\win64;E:\software\MATLAB\R2017a\bin;D:\php\php-5.6.32;C:\composer;C:\WINDOWS\system32\config\systemprofile\AppData\Local\Microsoft\WindowsApps
$Think.get.id: 123
$Think.request.pid: 666
$Think.cookie.PHPSESSID: ijepl1iflia4cimdmhva9ch1u7
$Think.config.DEFAULT_MODULE: Home
```

## 5、视图中使用函数（重点）
在实际开发的时候，有些变量在模板中不能直接使用，举个例子，在数据表中存储的时间一般都是时间戳格式，在展示的时候需要处理格式化，需要便利，操作相对而言比较繁琐。这个时候可以使用视图中使用函数的方式来解决这个问题。  

语法格式：  
{$name|fn1|fn2=参数1,参数2....}  

参数说明：
$变量：模板变量  
|：变量修饰符
函数名1：表示需要使用的第一个函数  
函数名2：表示需要使用的第二个函数  
参数1、参数2： 函数2的参数  
###：表示变量的自身


案例一（经典）：时间戳的格式化，（100%工作中使用）
```
$time = time();
$this->assign('time',$time);
$this->display();
```
分析：格式化时间戳使用的函数是，date，语法格式是date('Y-m-d H:i:s',时间戳)
```
{$time|date='Y-m-d H:i:s',###}
```

特别说明：
- ###什么时候该写，什么时候不该写？当需要使用的函数只有一个参数时并且参数是变量自身时，###可以省略不写；
- 当需要使用的函数有多个参数，但是其第一个参数是变量自身时，###可以省略不写。
- 关于函数名的说明，函数名对应的函数必须是php内置的函数或者是在函数库文件中定义好的函数；其他的主观臆造的函数不能使用。

案例2：定义一个字符串，截取其中的前5个字符，并且将其转化成大写。
```
{$str|substr=0,5|strtoupper}
{$str|substr=###,0,5|strtoupper}
```

## 6、默认值
使用场景：在论坛的用户个性签名出，一般会看到一句提示“这个家伙很懒，什么都没留下......”，这句话只有当用户的个性签名没有填写的时候才会显示。  

默认值：当某个变量==不存在或者为空==的时候，就会显示默认的字符，默认的字符就是变量的默认值。  

语法：
{$变量名|default=默认值}  
结合视图中使用函数的语法格式，可以得知 default 其实是ThinkPHP自己封装的函数,默认值是函数的参数  

```
$str1 = {$str1|default='什么都没有看到啊，好可惜~~'}<br/>
```
## 7、运算符
在ThinkPHP中同样支持在模板中对变量进行运算
- + `{$a+$b}`
- - `{$a-$b}`
- `* {$a*$b}`
- / `{$a/$b}`
- % `{$a%$b}`
- ++ `{$a++}`或`{++$a}`
- -- `{$a--}`或`{--$a}`

在方法中定义变量a和变量b传递给模板展示计算结果

控制器方法：
```
$a = 100;
$b = 10;
//传递给模板
$this->assign('a',$a);
$this->assign('b',$b);
$this->display();
```
模板文件：
```
$a = {$a}<br/>
$b = {$b}<br/>
$a + $b = {$a+$b}<br/>
$a - $b = {$a-$b}<br/>
$a * $b = {$a*$b}<br/>
$a / $b = {$a/$b}<br/>
$a % $b = {$a%$b}<br/>

$a = {$a}<br/>
$a++ = {$a++}<br/>
$a = {$a}<br/>
++$a = {++$a}<br/>
$a = {$a}<br/>
$b = {$b}<br/>
--$b = {--$b}<br/>
$b = {$b}<br/>
$b-- = {$b--}<br/>
$b = {$b}<br/>
```

输出结果：
```
$a = 100
$b = 10
$a + $b = 110
$a - $b = 90
$a * $b = 1000
$a / $b = 10
$a % $b = 0
$a = 100
$a++ = 100
$a = 101
++$a = 102
$a = 102
$b = 10
--$b = 9
$b = 9
$b-- = 9
$b = 8
```

## 8、文件包含

在实际开发的时候一般情况会把网站的公共部分，如头部、尾部等部分可以单独的存放到一个文件中，在后期的时候可以直接引入该部分，在后期维护的时候只需要维护一份代码几句可以；如果说首尾等公共部分不单独拿出来，会造成两个问题，一个是代码重复，再者就是在后期维护时很麻烦。

在ThinkPHP中系统提供了一个模板标签，可以让我们引入一些公共部分的代码文件，这个标签是include标签；  
```
<include file='需要引入的模板文件'/>
```
说明：路径可以是相对路径，但是是相对于入口文件的相对路径    
案例：使用include的标签语法，来实现页面的首尾引入效果。
先创建出三个模板文件（顶部、body、尾部）;  
```
header.html
body.html
footer.html
```

模板中的引入代码
```
<include file="./Application/Admin/View/Test/header.html"/>
<div>content</div>
<include file="./Application/Admin/View/Test/footer.html"/>
```

说明：在实际开发的时候，上述的路径很长还很容易写错。往往我们还会将其写成另外一种比较简单的方法。
```
<include file='View目录名/模板文件名'/>
```
可以改写成
```
<include file="Test/header"/>
<div>content</div>
<include file="Test/footer"/>
```
除了使用include标签来引入文件之外，include标签还有另外一个用法：用来传递参数给引入的模板文件。
```
<include file="" 参数名="参数值" />
```
上述语法是给引入文件传递一个参数，参数名的名字就是后面的参数名，值就是参数值  

引入写法：
```
<include file="Test/footer" year="2018"/>
```

在目标文件中使用参数的位置，写成下面的形式 
```
 Copyright [year] msp 版权所有
```

效果：
```
Copyright 2018 msp 版权所有
```

说明：如果目标文件中的参数[year]不存在，则[year]会被原样输出出来。  

##9、循环遍历（重点）

在ThinkPHP中，系统提供了2个标签来实现数组在模板中的遍历。
volist标签、foreach标签。  

volist语法格式：
```
<volist name="需要便利的模板变量名" id="当前遍历到的元素">
循环体
</volist>
```

foreach语法格式：
```
<foreach name="需要便利的模板变量名" item="当前遍历到的元素">
</foreach>
```
从上述的语法格式发现 volist标签和foreach标签的语法结构上答题是一样的，那为什么系统还封装2个模板标签呢？  
区别在于：volist除了上述的name和id属性对之外，还支持更多的属性对，如mod、key、length等等，而foreach标签除了上述的name和item之外只支持key属性对。可以理解成foreach标签是volist标签的一个简化版本。

后期在使用时可以根据实际情况选择性的使用volist标签和foreach标签。

php foreach语法格式：
```
foreach($variable as $key => $value){
    # code...
}
```

### 9.1、一维数组遍历

控制器定义数组并传值到模板
```
//定义一维数组
        $arr1 = array('西游记','三国','水浒');

        //定义二维数组
        $arr2 = array(
            array('白骨精','大师兄','二师兄'),
            array('诸葛亮','张飞','关羽'),
            array('李逵','戴宗','林冲'),
        );

        $this->assign('arr1',$arr1);
        $this->assign('arr2',$arr2);
        $this->display()
```

模板循环遍历显示：
```
$arr1数据：<hr/>
<volist name="arr1" id="item">
    {$item}<br/>
</volist>
<hr/>
<hr/>
$arr2数据：<hr/>
<volist name="arr2" id="item">
    <volist name="item" id="son">
         {$son} -
    </volist>
    <br/>
</volist>
<hr/>
foreach:
<foreach name="arr1" item="item">
    {$item}-
</foreach>
<hr/>
<foreach name="arr2" item="item">
    {$item[0]}-{$item[1]}-{$item[2]}<br/>
</foreach>
```

输出结果：
```
$arr1数据：
西游记
三国
水浒
$arr2数据：
白骨精 -大师兄 -二师兄 - 
诸葛亮 -张飞 -关羽 - 
李逵 -戴宗 -林冲 - 
foreach: 西游记-三国-水浒-
白骨精-大师兄-二师兄
诸葛亮-张飞-关羽
李逵-戴宗-林冲
```

## 10、if标签
if标签如果 php中if的作用，if是用于流程控制的。  
在ThinkPHP中if标签也是用于流程控制的。  

if标签的语法格式：
```
<if condition="条件表达式">
输出结果1
<elseif condition="条件表达式2"/>
输出结果2
<elseif condition="条件表达式3"/>
...
<else/>
最后一个输出
</if>
```

案例：在php输出今天的星期数字，然后传递给模板，在模板中使用if判断今天是星期几？  

```
$day = date('w',time());
$this->assign('day',$day);
$this->display();
```

```
<if condition="$day == 0">
    星期日
    <elseif condition="$day == 1"/>
    星期一
    <elseif condition="$day == 2"/>
    星期二
    <elseif condition="$day == 3"/>
    星期三
    <elseif condition="$day == 4"/>
    星期四
    <elseif condition="$day == 5"/>
    星期五
    <else/>
    星期六
</if>
```

## 11、php标签

php标签就是指在模板中使用php语法格式  
模板中的php标签ThinkPHP支持2种形式：
- PHP内置的php标签； 语法格式：<?php php代码段?>
- ThinkPHP封装的php标签；语法格式： <php>PHP代码段</php>

```
原始php标签：<?php echo 'heeeeeello heihei ~~~';  ?> <hr/>

ThinkPHP封装的php标签：<php>echo '嘿嘿嘿';</php> <hr/>
```

在实际开发的时候一般情况不建议在模板中使用php标签，在配置项中有一个配置项可以禁用php标签，配置项叫做：`TMPL_DENY_PHP`
```
'TMPL_DENY_PHP'         =>  false, // 默认模板引擎是否禁用PHP原生代码
```
禁用php标签之后，只是禁用掉原始的php标签，并不会禁用thinkPHP框架封装的php标签 （<php></php>），但是不建议禁用，原因是系统的跳转方法的模板文件使用了原生的php标签  

# 二、ThinkPHP中的模型

## 1、配置数据库连接
数据库的连接配置项可以在系统的主配置文件中找到：

```
'DB_TYPE'               =>  'mysql',     // 数据库类型
'DB_HOST'               =>  '127.0.0.1', // 服务器地址
'DB_NAME'               =>  'db_oa',          // 数据库名
'DB_USER'               =>  'root',      // 用户名
'DB_PWD'                =>  '123456',          // 密码
'DB_PORT'               =>  '3306',        // 端口
'DB_PREFIX'             =>  'sp_',    // 数据库表前缀
'DB_PARAMS'          	=>  array(), // 数据库连接参数
'DB_DEBUG'  			=>  TRUE, // 数据库调试模式 开启后可以记录SQL日志
'DB_FIELDS_CACHE'       =>  true,        // 启用字段缓存
'DB_CHARSET'            =>  'utf8',      // 数据库编码默认采用utf8
'DB_DEPLOY_TYPE'        =>  0, // 数据库部署方式:0 集中式(单一服务器),1 分布式(主从服务器)
'DB_RW_SEPARATE'        =>  false,       // 数据库读写是否分离 主从式有效
'DB_MASTER_NUM'         =>  1, // 读写分离后 主服务器数量
'DB_SLAVE_NO'           =>  '', // 指定从服务器序号
```

## 2、数据库/表创建
数据库名：db_oa
数据表名：sp_dept  (department)

```
create database db_oa;

use db_oa;

create table sp_dept(
    id int not null key auto_increment,
    name varchar(50) not null,
    pid int not null default 0,
    sort int not null default 50,
    remark varchar(255)
);
```

## 3、什么是模型

模型是MVC三大组成部分的M（MODEL），作用是负责与数据表的数据交互（CURD）。  


## 4、模型的创建

命名规范：==模型名(要求是不带前缀的表名并且首字母大写) + Model关键词 + class.php==
代码结构规范：
- 第一步：声明命名空间
- 第二部：引入父类模型 Model.class.php
- 第三部：声明模板并且继承父类模型

例如：创建一个部门模型文件  
命名： `DeptModel.class.php`
```
//声明命名空间
namespace Admin\Model;
//引入父类模型
use Think\Model;

//声明模型并且继承父类模型
class DeptModel extends Model{

}
```

问：空模型能否进行数据表的基本操作（CURD）？
答：可以，因为模型继承了父类，所以可以执行基本的操作。

## 5、模型的实例化操作（重点）

模型虽然已经创建完成，但是由于模型的本质是一个类，类在使用的时候需要实例化操作。

### 5.1、普通实例化方法

普通实例化方法是指通过自己编写代码来new一个对象。  
`$obj = new 类名();`

在控制器中定义一个方法来实例化模型，使用的是普通方式实例化。  


创建部门控制器文件：`DeptController.class.php`  
```
namespace Admin\Controller;
use Think\Controller;
use Admin\Model as Model;
class DeptController extends Controller{//展示实例化的结果
    public function shilihua(){
        //普通实例化方法
        $model = new Model\DeptModel();
        dump($model);
    }
}
```
### 5.2、快速实例化方法
上述的普通实例化方法虽然可以进行实例化操作，但是使用上比较麻烦，还需要考虑命名空间，所以ThinkPHP为了简单、快速、搞笑开发，为我们提供了 2 个快速方法可以对模型进行实例化操作：  
M方法 和 D方法。

D方法实例化：  
`$obj = D('模型名');`  
表达的含义：实例化我们自己创建的模型（分组/Model目录中）；==如果传递了模型名，则实例化指定的模型。如果没有指定或者模型名不存在，则直接实例化父类模型（Model.class.php）。==

M方法实例化：  
`$obj = M('不带前缀的表名');`  
表达的含义：直接实例化父类模型（Think目录下的Model.class.php）；==如果指定了表名，则实例化父类模型的时候关联指定的表；如果没有指定表名（没有传递参数）则不关联表，一般用于执行原生的sql语句（`M()->query(原生的sql语句);`）==  

案例：使用快速方法D 和 M方法对模型进行实例化
```
//普通实例化方法
//$model = new Model\DeptModel();

//实例化自定义模型 D
$model = D('Dept');//其实实例化结果和使用普通new方法是一样的
//$model = D();//实例了父类模型，不关联表
//$model = M('Dept'); //实例化父类，关联数据表
//$model = M();//实例化父类，不关联表
dump($model);
```

经典面试题：
问：实例化方法中D方法 与 M方法 有什么区别？  
答：D方法是实例化自定义模型，如果自定义模型不存在，则实例化父类模型；M方法本身就是直接实例化父类模型。两者差异是实例化的对象不一样。  

**在后期开发的时候如何去选择是使用D方法还是M方法呢？
可以根据自身的情况，如果需要使用的操作父类已经封装好了，则可以直接实例化父类（使用M方法），如果父类中方法不能满足我们的开发需求，需要自己定义方法，则这个时候可以使用D方法实例化自定义模型。**  

## 6、CURD操作

CURD操作也就是模型操作数据表的基本操作。C(create) U(update) R(read) D(delete)操作就是增删改查操作。  

### 6.1 增加操作
回想一下在mysql中增加操作使用的语法格式是：insert into 语句。  
在ThinkPHP中系统给我们封装好了模型中的方法，可以通过方法来实现数据的增加操作，这个方法叫做add()方法；  
==$model->add(一维数组);  
一维数组要求必须是键值（关联）数组，键必须和数据表中字段名要匹配。如果不匹配则在增加的时候会被ThinkPHP过滤掉。==  

**add()方法的返回值是新增记录的主键id。**

案例：往部门表中使用add方法添加一条记录。
```
//add方法使用
    public function add(){
        $model = M('Dept');//直接使用基本的增删改查可以使用父类模型
        //声明数组（关联数组）
        $data = array(
          'name' => '人事部',
            'pid' => '0',
            'sort' => '1',
            'remark' => '这是人事部门'
        );
        $result = $model->add($data);
        dump($result);
    }
```

补充：如果需要添加多个记录怎么实现呢？  
方法一：可以循环使用add方法；  
方法二：可以使用另外一个方法addAll，  
语法：`$model->addAll(二维数组);`  
==要求：最里面的那层数组也是关联数组（也要求键名和数据表字段对应），外层数组必须是下标从0开始的从0开始的连续索引数组。==  
```
//批量添加
$data = array(
    array(
        'name' => '公关部',
        'pid' => 0,
        'sort' => 3,
        'remark' => '公共关系维护'
    ),
    array(
        'name' => '总裁办',
        'pid' => 0,
        'sort' => 4,
        'remark' => '权力最高的部门'
    )
);
$result = $model->addAll($data);
```
上述的addAll方法使用起来需要注意的点太多，谨慎使用。

### 6.2、修改操作
在mysql中修改操作使用的是：update table语句  
在ThinkPHP中使用的是save方法，语法格式：
**$model->save(一维关联数组);**  
条件需要一维关联数组==必须要有主键信息==。如果没有主键信息，则相当于批量修改，在ThinkPHP中，系统为了防止误操作，不允许批量修改。  

案例：使用save方法实现部门表中财务部门的信息。
```
//save方法的使用
public function xiuagai(){
    //实例化父类模型
    $model = M('Dept');
    //修改操作
    $data = array(
        'id' => '2',
        'sort' => '22',
        'remark' => '我们是财神^_^',
    );
    $result = $model->save($data);
    dump($result);
}
```
**返回false，表示修改操作并没有执行，而不是指mysql执行失败。**  

返回值：  
表示受到影响的行数  

###6.3、查询操作
MySQL中查询操作使用的语法是：select语句。  
在thinkPHP中系统封装了方法可以直接用于查询：select方法、find方法。

Select方法语法：  
```
$model->select();   #表示查询全部的信息
$model->select(id); #表示查询指定id的信息
$model->select('id1,id2,id3,......');   #表示查询指定id集合的信息 等价 where id in ('1,2,3,4')
```

find方法语法：
```
$model->find();     #表示查询当前表中的第一条记录，相当于limit 1；
$model->find(id);   #表示查询表中的指定id的记录；
```

返回值：  
select方法返回值是一个二维数组，即使查询的是一条记录，返回值也是二维数组；find返回值是一维数组。

案例：使用select方法和find方法查询部门表中的数据  
```
//查询
public function chaxun(){
    //实例化模型
    $model = M('Dept');
    //select部门
    //$result = $model->select(); //查询全部  返回二维数组
    //$result = $model->select(1);  //指定id  返回二维数组
    //$result = $model->select('1,2');  //指定id集合  返回二维数组

    //find部分
    //$result = $model->find();     //limit 1  返回一维数组
    $result = $model->find(11);     //指定id  返回一维数组

    dump($result);
}
```

### 6.4、删除操作
在MySQL中删除使用delete from语句。
在ThinkPHP中可以使用系统封装的方法 delete 方法：  
```
$model->delete();       //不能使用，删除方法必须要有条件，不能执行没有条件的删除
$model->delete(id);     //删除指定id对应的记录
$model->delete('id1,id2,id3....');      //删除多个id对应的记录
```
关于删除的说明：  
删除分为两种删除：物理删除、逻辑删除。  
物理删除：是指真删除。
逻辑删除：是指假删除，本质是修改操作。在数据表中定义一个状态字段，比如说status，取值是0或1。
在查询的时候读取状态是1的；当用户点击删除之后出发修改操作，将状态从1修改成0。因为查询只查询状态是1的，所以0的就不会被显示在页面上。

案例：使用delete方法实现数据删除操作。
```$xslt
//删除操作
    public function shanchu(){
        //实例化模型
        $model = M('Dept');
        //删除操作
        //$result = $model->delete();  //false

        $result = $model->delete(12);  //返回受影响的行数
        $result = $model->delete(11,12);  //删除多个id记录 返回受影响的行数
        //打印$result
        dump($result);
    }
```
 
















day02 18 4:29






















![image](https://note.youdao.com/favicon.ico)






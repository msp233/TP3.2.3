# 一、ThinkPHP中的模型
 
 ## 1、数据对象创建
 数据对象也就是父类模型中的$this->data，上一天我们在使用AR模式时使用了数据对象，
 在模型实例化的时候数据对象还是一个空数组，在后来使用了魔术方法__set来设置了数据对象的值。  

 ```
 public function __set($name,$value){
    //设置数据对象属性
    $this->data[$name] = $value;
 }
 ```
从上述的一个流程中我们可以得出，既然data属性之前是空数组，后期使用的时候需要先给其赋值，  
也就说明，**在使用数据对象的时候必须先创建数据对象**。而__set 是设置数据对象的一种方法；
但是这种方式在使用时并不方便，原因是设置一个属性就得写一行代码；
因此在ThinkPHP中系统还提供另外一种批量设置数据对象的方法，create方法。(默认取post数据)  
语法：  
 $model->create();
 
 ThinkPHP -> Model.class.php 文件中的create()方法
 ```
  // 如果没有传值默认取POST数据
 if(empty($data)) {
     $data   =   I('post.');
 }elseif(is_object($data)){
     $data   =   get_object_vars($data);
 }
 ```
 通过它的实现代码，可以发现，如果不给create方法传递参数，则其默认使用post中的数据。
 ```
 // 赋值当前数据对象
 $this->data =   $data;
 // 返回创建的数据以供其他调用
 return $data;
 ```
 在结尾的两行代码中，其做了2个操作
 1. 将处理完成的data数据赋值给了data属性，这步就是创建数据对象。
 2. 将处理完成的数据返回出去。
 
 案例：改写之前编写的部门信息入库的代码，使用数据对象的创建方式。
 ```
 //add方法
     public function add(){
         //判断请求类型
         //$_POST
         if(IS_POST){
             $model = M('Dept');
             //数据对象的创建
             $data = $model->create();//不传递参数则接收post数据
             $re = $model->add($data);
             //注意：create()返回值可以不接收，接收一般为了打印出来看数据，
             //add()也可以不传递$data参数,add不传递参数，表示使用数据对象的值
             if($re){
                 $this->success('添加成功',U('showList'),3);
             }else{
                 $this->error('添加失败');
             }
 
         }else{
             //查询出顶级部门
             $model = M('Dept');
             $data = $model->where('pid = 0')->select();
             //展示数据
             $this->assign('data',$data);
             //展示模板
             $this->display();
         }
     }
 ```
- 说明：如果表单中字段和数据表中字段不匹配，则在创建数据对象的时候会被过滤掉
注意：create()返回值可以不接收，接收一般为了打印出来看数据，  
- 关于是否接收数据对象创建方法返回值说明：  
add()也可以不传递数据参数,add不传递参数，表示使用数据对象的值。
- 如果使用自动验证的时候，则必须要接收返回值。

## 2、自动验证

自动验证就是在提交数据时，系统会按照指定的**规则**，进行数据的有效性、合理性的验证。
上述提及到的规则，系统默认没有，如果需要使用自动验证，规则需要我们自己去定义。  

在前端中 javascript的验证叫前端验证，在ThinkPHP中也存在验证机制，这样的验证称之为后端验证。  

自动验证语法：没有语法，由数据对象创建方法create方法实现自动验证，我们需要写的就是验证规则。
```
// 数据自动验证
if(!$this->autoValidation($data,$type)) return false;
```
因为在create方法中执行了自动验证的处理，如果需要使用自动验证，则必须要用数据对象创建方法进行接收数据。  

那如何定义，所谓的规则呢？ 
ThinkPHP -> Model.class.php
```
protected $_validate        =   array();  // 自动验证定义
```
在父类模型中存在一个成员属性，叫做_validate，这个属性是保存验证规则的。由于不能在父类模型中直接更改属性，
**所以可以把这个属性复制到子类（自定义模型）中去定义规则**。  
```
//声明模型并且继承父类模型
class DeptModel extends Model{
    //自动验证定义
    protected $_validate = array();
}
```
规则编写（参考手册）：  
无论是什么方法，验证股则的定义是统一的规则，定义格式为：
```
array( 
    array(验证字段1,验证规则,错误提示,[验证条件,附加规则,验证时间]), 
    array(验证字段2,验证规则,错误提示,[验证条件,附加规则,验证时间]),
    ...... ); 
```
必选参数：  
1. 验证字段：表单中每一个表单项的name值；
2. 验证规则：要进行验证的规则，需要结合附加规则，如果在使用正则验证的附加规则情况下，
系统还内置了一些常用正则验证的规则，可以直接作为验证规则使用，
包括：require 字段必须、email 邮箱、url URL地址、currency 货币、number 数字。 
3. 提示信息：用于验证失败后的提示信息定义 
可选参数：
4. 验证条件 （可选）：
- 0 存在字段就验证（默认）
- 1 必须验证 
- 2 值不为空的时候验证 

5. 附加规则
附加规则：结合验证规则，两种规则配合起来使用，具体支持的方法，可以参考手册“自动验证”
```
规则  说明  
regex  正则验证，定义的验证规则是一个正则表达式（默认）  
function  函数验证，定义的验证规则是一个函数名  
callback  方法验证，定义的验证规则是当前模型类的一个方法  
confirm  验证表单中的两个字段是否相同，定义的验证规则是一个字段名  
equal  验证是否等于某个值，该值由前面的验证规则定义  
notequal  验证是否不等于某个值，该值由前面的验证规则定义（3.1.2版本新增）  
in  验证是否在某个范围内，定义的验证规则可以是一个数组或者逗号分割的字符串  
notin  验证是否不在某个范围内，定义的验证规则可以是一个数组或者逗号分割的字符串（3.1.2版本新增）  
length  验证长度，定义的验证规则可以是一个数字（表示固定长度）或者数字范围（例如3,12 表示长度从3到12的范围）  
between  验证范围，定义的验证规则表示范围，可以使用字符串或者数组，例如1,31或者array(1,31)  
notbetween  验证不在某个范围，定义的验证规则表示范围，可以使用字符串或者数组（3.1.2版本新增）  
expire  验证是否在有效期，定义的验证规则表示时间范围，可以到时间，例如可以使用 2012-1-15,2013-1-15 表示当前提交有效期在2012-1-15到2013-1-15之间，也可以使用时间戳定义  
ip_allow  验证IP是否允许，定义的验证规则表示允许的IP地址列表，用逗号分隔，例如201.12.2.5,201.12.2.6  
ip_deny  验证IP是否禁止，定义的验证规则表示禁止的ip地址列表，用逗号分隔，例如201.12.2.5,201.12.2.6  
unique  验证是否唯一，系统会根据字段目前的值查询数据库来判断是否存在相同的值，当表单数据中包含主键字段时unique不可用于判断主键字段本身  
```

6. 验证时间（可选）：1表示新增数据的时候验证，2表示编辑的时候验证，3表示全部情况下都验证（默认）。  

案例：针对部门添加功能，使用自动验证来验证字段的合法性。
说明：如果在自动验证中使用函数(function)来验证字段的合法性，
则第二个参数要求是函数名（函数名要是函数是php内置的函数或者自己定义的函数<可以是函数库中声明的，也可以在当前模型中去定义>）  

注意：因为规则是定义在自定义模型中，所以实例化模型时，必须实例化自定义模型。  
自动验证失败，则create方法返回false，如果验证成功，则返回正常的数组。

输出用户提示信息：  
$model->getError();

```
$model = D('Dept');
if($model->create()){
    $re = $model->add($data);
    if($re){
        $this->success('添加成功',U('lister'),3);
    }else{
        $this->error('添加失败');
    }
}else{
    $this->error($model->getError());
}
```

批量验证：  
需要配置一个成员属性：$patchValidate设置成true
此时批量验证返回的错误信息是一个数组格式
```
array (size=2)
  'name' => string '部门名称不能为空' (length=24)
  'sort' => string '排序必须是数字！' (length=24)
```

## 3、字段映射
映射就是表示一个对应关系。
应用场景：在目前表单中的name值和数据表中的字段名都是一样的，有一些人可能通过当前功能和表单的name值
猜测出数据表的名字和表结构，后期就可能会找到系统的漏洞对系统的进行攻击，系统的安全性存在威胁。  
因此我们可以使用一个障眼法，将name值来随机制定，name值就和表中的字段不一致，那样别人就猜不出来了。  

因为如果字段和数据表中的字段不匹配，在操作的时候会被系统过滤，所以需要有一个对照列表，告知系统，不对应的name字段是数据表中的字段。  

字段映射和自动验证一样，没有语法，只有规则定义：
成员属性： $_map  
```
protected %_map = array();   //字段映射定义
```
因为成员属性是父类模型中的，所以不能在父类中直接修改，需要在自定义模型中修改。  
```
//字段映射定义
protected $_map = array(
    //映射规则  表单name值 => 数据表字段名
    'abc' => 'name',
);
```
因为数据对象中使用了字段映射的检查，所以，此处如果需要使用字段映射，
则必须要使用数据对象的创建方法接收数据($model->create())。  
通过修改前端表单中的name值进行测试
```
<input type="text" name="abc" class="form-control">
```
`dump($model->create())`测试结果：  
```
array (size=3)
  'pid' => string '0' (length=1)
  'sort' => string '23' (length=2)
  'remark' => string '                                            ' (length=44)
```
```
array (size=4)
  'pid' => string '0' (length=1)
  'sort' => string '23' (length=2)
  'remark' => string '                                            ' (length=44)
  'name' => string '前端df' (length=8)
```
在使用字段映射后，被映射的字段会被放到数组的最后，按照字段映射的先后顺序进行排列。  

## 4、特殊表的实例化操作
在实际开发的时候可能会遇到有特殊标的情况，可能表会没有前缀、标的前缀不是在配置文件中定义的前缀。  
模拟出一张特殊表：  
表名：q    szphp  

创建模型文件：  
`SzphpModel.class.php`  
```
<?php
namespace Admin\Model;
use Think\Model;
class SzphpModel extends Model{
    
}
```

```
1146:Table 'db_oa.sp_szphp' doesn't exist [ SQL语句 ] : SHOW COLUMNS FROM `sp_szphp`
```
解决办法：
```
protected $trueTableName = 'szphp';
```

# 二、ThinkPHP中的实用项（2）
## 1、会话控制
会话支持一般指的是cookie和session。在PHP核心中有说及php对于cookie和session支持，
在ThinkPHP中系统为了方便开发的实用，也封装了相应cookie和session方法。
### 1.1、session的支持
在ThinkPHP中系统封装了一个方法用来实现对于session的操作：session() （定义在系统函数库文件中functions.php）。
- session(‘name’,’value’)	 创建一个名为name的session值，值是value
- $value = session(‘name’)	 读取session中的name元素值，值赋给value
- session(‘name’,null)		删除名为name元素的值
- session(null)			删除全部的session元素
- session()				读取全部的session信息
- session(‘?name’)		判断名为name的session元素是否存在，如果存在则返回true，如果不存在，则返回false。

案例：在方法中使用session方法session进行操作  

### 1.2、cookie支持
- cookie(‘name’,’value’)		设置一个名为name的cookie值，值是value
- cookie(‘name’,’value’,3600)	设置一个名为name的cookie值，值是value，有效期是3600s
- $value = cookie(‘name’)		读取名为name的cookie赋值给value
- cookie(‘name’,null)			删除名为name的cookie值
- cookie(null)				删除全部的cookie（有问题）
- cookie()					获取全部的cookie

cookie(null)有问题，  
改 `functions.php`文件的`cookie()`方法
 添加两个 `|| $name == null`
```
if (!empty($prefix) || $name == null) {// 如果前缀为空字符串将不作处理直接返回
    foreach ($_COOKIE as $key => $val) {
        if (0 === stripos($key, $prefix) || $name == null) {
            setcookie($key, '', time() - 3600, $config['path'], $config['domain'],$config['secure'],$config['httponly']);
            unset($_COOKIE[$key]);
        }
    }
}
```

## 2、文件加载
文件加载在ThinkPHP中系统提供三个方式。

### 2.1、函数库形式加载
函数库在ThinkPHP中有三大类：系统函数库文件(functions.php),应用级别函数库文件、分组级别函数库文件。  
**上述三大类的文件只有系统函数库文件默认是存在的，其他两类默认不存在，需要自行创建；**  
**上述三大类文件只有系统函数库文件名叫做functions.php，另外两大类文件名叫做function.php。**  

定义好的函数库文件中的函数，在使用的时候遵循php内置函数语法的要求，只要直接写上函数名(参数)，这种形式就可以了。  

说明：  
1. 不需要引入function.php，系统在执行的时候自动帮我们引入了文件function.php文件；  
2. 如果函数定义在应用级别的函数库文件中，则能在全部的分组（整个应用）使用；如果函数定义在某个分组的函数库文件中，则只能在当前的分组中使用，否则会报函数未定义。

### 2.2、通过配置项动态加载

在系统的执行流程中有 一个文件会被执行到App.class.php  
在该方法中执行了一个load_ext_file函数。  
该方法是在系统函数库文件中定义的：`functions`
```
function load_ext_file($path) {
  // 加载自定义外部文件
  if($files = C('LOAD_EXT_FILE')) {
      $files      =  explode(',',$files);
      foreach ($files as $file){
          $file   = $path.'Common/'.$file.'.php';
          if(is_file($file)) include $file;
      }
  }
  ...
}
```

**扩展：C方法**  
C方法也是快速方法之一，其作用是操作ThinkPHP中的配置项：  
C(name,value);			设置配置项name的值，值是value  
C(name);					读取配置项name的值  
C();						读取全部的配置项  

**通过代码的阅读，可以发现配置项LOAD_EXT_FILE的配置格式应该是类似于下面这种形式：**
`LOAD_EXT_FILE	=>	‘abc,cde,efg…’`    
**而且上述的文件应该是位于应用级别的函数库目录中。**  

配置项：
在应用级别的配置文件`functions.php`中定义配置项LOAD_EXT_FILE，引入文件`info.php`  
```
    //动态加载文件
    'LOAD_EXT_FILE' => 'info'//包含文件名的字符串，多个文件名用逗号分割
```
在应用函数库文件目录中定义一个info.php
```
function getInfo(){
    //输出phpinfo的信息
    phpinfo();
}
```
控制器方法中调用
```
//自动加载
//测试load_ext_file引入
//文件载入
public function test35(){
    getInfo();
}
```

**上述需要注意的是，同样文件在系统封装的方法中已经进行了引入，所以在使用具体的函数的时候不需要再对文件进行单独的引入，
只需要像使用函数库文件的形式直接编写需要使用的函数名即传递相应的参数即可。**  

### 2.3、通过load方法加载
**语法：**`load(‘@/不带后缀的php文件名’);`  
**需要注意的是，文件必须存在于分组级别的函数库目录中，并且只能用于定义的分组中。**    

**案例：通过自己在分组目录中创建文件hello.php，然后在其中定义一个函数，然后再去使用load方法加载并且使用其中的函数。**  
目录位置：`Application/admin/Common/
```
function sayHello($who){
    echo 'Hello '.$who.'!';
}
```
在控制器中使用load方法加载hello.php文件：
```
//load方法
public function test36(){
    load('@/hello');
    sayHello('Tom');
}
```
说明：上述三个文件的加载方式在实际开发的时候都可以使用，
但是一般以第一种为主（通过函数库形式自动加载）。其他的仅供参考。

# 三、ThinkPHP中功能类-验证码类

验证码：  
captcha（全自动识别机器与人类的图灵测试）。  
常见验证码可以分为三种：
- 页面上的图片形式
- 短信验证码
- 语音验证码。  

在ThinkPHP中，为了提高开发效率，系统封装了一个验证码类：`Verify.class.php`  

## 1、介绍
方法：
构造方法：  
在实例化的时候可以传递一个数组，用于和其成员属性config进行合并，生成新的配置。
```
public function __construct($config=array()){
    $this->config   =   array_merge($this->config, $config);
}
```
Check方法：校验验证码，传递参数，用户输入的验证码
```
/**
 * 验证验证码是否正确
 * @access public
 * @param string $code 用户验证码
 * @param string $id 验证码标识     
 * @return bool 用户验证码是否正确
 */
public function check($code, $id = '') {
    $key = $this->authcode($this->seKey).$id;
    // 验证码不能为空
    $secode = session($key);
    ......
```
Entry方法：输出图片，保存验证码到session中
```
/**
 * 输出验证码并把验证码的值保存的session中
 * 验证码保存到session的格式为： array('verify_code' => '验证码值', 'verify_time' => '验证码创建时间');
 * @access public     
 * @param string $id 要生成验证码的标识   
 * @return void
 */
public function entry($id = '') {
    // 图片宽(px)
    $this->imageW || $this->imageW = $this->length*$this->fontSize*1.5 + $this->length*$this->fontSize/2; 
    // 图片高(px)
    $this->imageH || $this->imageH = $this->fontSize * 2.5;
```

## 2、生成常规验证码
常规验证码是指有数字+大小写字母组成的验证码。  
**步骤：**  
1. 实例化验证码类
2. 输出图片
```
//常规验证码
public function test37(){
    //清理缓存区
    ob_end_clean();
    //配置项
    $config = array(
        'UserImgBg' =>  false,          //使用背景图片
        'fontSize'  =>  25,              // 验证码字体大小(px)
        'useCurve'  =>  false,            // 是否画混淆曲线
        'useNoise'  =>  true,            // 是否添加杂点
        'imageH'    =>  0,               // 验证码图片高度
        'imageW'    =>  0,               // 验证码图片宽度
        'length'    =>  4,               // 验证码位数
    );
    //实例化验证码类
    $verify = new \Think\Verify($config);
    //输出验证码
    $verify->entry();
}
```

## 3、生成中文验证码
需要字体文件，字体文件可以在自己的计算机中找到：  
打开【控制面板】-切换到【大图标】，找到【字体】-搜索‘黑体’-复制【黑体常规】  

复制到zhttfs目录中  
需要字体文件，字体文件可以在自己的计算机中找到：  
打开【控制面板】-切换到【大图标】，找到【字体】-搜索‘黑体’-复制【黑体常规】  

复制到zhttfs目录中`/ThinkPHP/Library/Think/Verify/zhttfs` 
```
//中文验证码
public function test38(){
    //清理缓存区
    ob_end_clean();
    //配置
    $cfg = array(
        'useZh' => true,//使用中文验证码
    );
    $verify = new \Think\Verify($cfg);
    $verify->entry();
}
```
## 4、补充说明
关于中文验证码的几点说明：  
1. 以后在实际开发的时候不到万不得已不要使用中文验证码；
2. 中文验证码需要中文字体的支持，中文字体可以在自己计算机中找到，当也可以去字体网站下载（比如说站长之家chinaz.com）；
3. 使用中文验证码必须开启php的扩展mbstring。
扩展开启：打开php.ini文件，去掉扩展前的分号，保存，重启Apache：
```
extension=php_mbstring.dll
extension=php_curl.dll
```

# 四、综合案例
## 1、实现后台登录功能
控制器：PublicController.class.php  
模版：login.html  
方法：login	captcha	checkLogin  
第一步：在控制器中创建captcha方法，用于输出验证码  
```
//captcha方法
public function captcha(){
   ob_end_clean();
   //配置
   $cfg = array(
       'UserImgBg' =>  false,          //使用背景图片
       'fontSize'  =>  25,              // 验证码字体大小(px)
       'useCurve'  =>  false,            // 是否画混淆曲线
       'useNoise'  =>  true,            // 是否添加杂点
       'imageH'    =>  0,               // 验证码图片高度
       'imageW'    =>  0,               // 验证码图片宽度
       'length'    =>  4,               // 验证码位数
   );
   //实例化验证码类
   $verify = new \Think\Verify($cfg);
   //输出验证码
   $verify->entry();
}
```
第二步：在模版文件login.html中输出验证码
```
<img src="__CONTROLLER__/captcha">
```
给图片绑定点击事件，让点击图片能够刷新验证码：  
```
<img onclick="this.src='__CONTROLLER__/captcha/t/'+Math.random()" style="margin-left:5px;margin-right:0px;padding-right: 0px" src="__CONTROLLER__/captcha">
```
第三步：准备创建用户表  
表名：`sp_user`  
```
create table sp_user(
id int(11) keyx not null auto_increment,
username varchar(40) not null,
password char(32) not null,
nickname varchar(40) default null,
truename varchar(40) default null,
dept_id int(11) default null,
sex varchar(10) not null,
birthday date not null,
tel varchar(11) not null,
email varchar(50) not null,
remark varchar(255) default null,
addtime int(11) default null,
role_id int(11) default null
);
```
第四步：检查表单  
添加form标签：  
字段完善：  
修改登录按钮的href属性，阻止其默认的浏览器行为：
```
<a href="javascript:void(0)" class="btn">登录</a>
```
**第五步：编写jQuery代码实现表单的提交**  



## 2、完善部门管理功能

### 2.1、完成部门列表展示

### 2.2、完成部门编辑功能

### 2.3、完成部门删除功能
















 ```
 day04 -> 11 -> 12:18
 ```
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 

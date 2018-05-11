# 一、ThinkPHP中的实用项（1）
在开发的时候我们往往会遇到一些开发的错误，需要去解决错误，一般这个时候我们需要借助与开发工具/调试工具；
比如说浏览器自带的“审核元素”（F12），在thinkPHP中系统为了方便我们在开发时对代码进行调试，也封装了一系列的调试方法：  

代码调试：
- 跟踪信息
- 两种模式
- sql调试
- 性能调试

## 1、跟踪信息
跟踪信息：就是查询/展示系统的执行相关状况。  
在ThinkPHP中跟踪信息默认是关闭的，如果需要使用，则需要开启，可以通过配置项：`SHOW_PAGE_TRACE` 开启。  

上述的配置项在主配置文件中是不存在的（在ThinkPHP中除了主配置文件中已经列出的配置项外，还存在一些零星的配置项，
这些配置项在主配置文件中不存在，但是其他地方有使用），需要使用的话可以自己在配置文件中定义。
```$xslt
//显示跟踪信息
    'SHOW_PAGE_TRACE'  => true,  //默认为false，开启则改写成true
```
在开启跟踪信息后，在页面右下角会出现一个小图标:  
![image](https://raw.githubusercontent.com/msp233/TP3.2.3/master/md/img/tiaoshi.png)  
图标的左边绿色是ThinkPHP的logo，右侧的黑块上显示的是当前请求执行所消耗的时间单位是s(秒)  

![image](https://raw.githubusercontent.com/msp233/TP3.2.3/master/md/img/tiaoshiInfo.png)

在==当前模式==下加载了三个配置文件，`convention.php` 应用 `config.php` 模块配置文件`config.php` 系统函数库文件 `functions.php`
![image](https://note.youdao.com/favicon.ico)

## 2、两种模式
在ThinkPHP系统中，为了方便开发，提供了两种模式：  开发/调试模式、生产模式。
- 开发/调试模式：是指在开发调试阶段所使用的模式。
- 生产模式：是指项目上线的时候所使用的模式，错误信息比较模糊。

在ThinkPHP中两种模式，其默认是生产模式，其配置项名字叫做APP_DEBUG, 定义的位置在==入口文件==中：  
==当APP_DEBUG为false时表示开启生产模式，为true时，表示开启调试模式。==  

在跟踪信息中的体现：  
生产模式：
文件加载数变少
生产模式下系统函数库文件functions.php、系统配置文件、应用配置文件没有被加载，但是多了一个common-runtime.php文件（没有被加载的文件都放到了这个文件里了）  

相比调试模式，生产模式下使用缓存文件 common-runtime.php，所以效率上要比调试模式高。  

如果在生产模式下去修改主配置文件/应用配置文件/系统函数库文件是否会生效？  
答：不会，因为在圣餐模式上述的几个文件压根都没有被加载，所以修改无效。如果想让它生效，可以把缓存文件删掉，或者开启调试模式去修改，修改完成后在换回生产模式。  

针对跟踪信息和两种模式的说明：
因为跟踪信息和两种模式中的调试模式都聚会输出系统执行的相关信息，所以在项目上线的时候应该关掉跟踪信息，开启生产模式。  

## 3、sql调试

在开发的时候，难免会遇到sql的错误，这个时候需要对sql进行调试，因为thinkPHP在执行CURD操作的时候是让开发者写方法，并不是很直观的sql。  
`$model->getLastSql();`  
表达的含义：==获取**当前模型**中，**最后一条** **成功执行**的sql语句==。  
案例：使用getLastSql()方法，获取最后一条成功执行的语句

```
//sql 调试
public function test15(){
    //实例化模型
    $model = D('Dept');
    $data = $model->select();
    echo $model->getLastSql();
    echo $model->_sql();
}
```
补充说明：  
上述的getLastSql方法在写的时候不方便，所以ThinkPHP3.2版本后，系统增加了一个别名方法：_sql();  
```
$model->_sql();
```

## 4、性能调试（了解）
在以前可能写过这么一个小功能，测试一段代码的执行时间。在ThinkPHP中，系统提供了一个性能测试的跨苏方法，这个快速方法叫做G。
语法：
```
    G('开始标记');
    需要统计效率的代码段
    ...
    G('结束标记');
    
    G('开始标记','结束标记',数字/字符 m)
```
    ==针对G方法的第三个参数：如果参数是数字，则表示统计代码的执行时间，数字表示精确的小数位数，单位是秒；如果是字符m，则表示统计内存开销，单位是byt（需要服务器的支持）==。

案例：使用G方法来统计某段代码的执行时间开销。  
```
public function test16(){
        G('start');
        for($i=0 ; $i<100;$i++){
            for($n=0;$n<100;$n++){
                for($m=0;$m<100;$m++){
                    for($x=0;$x<100;$x++){
                        $i*$n*$m*$x;
                    }
                }
            }
        }
        G('end');
        echo G('start','end','m');
        ##or
        echo G('start','end',8);
    }
```
# 二、AR模式
AR模式即Active Record模式，是一个对象-关系映射（ORM）技术。每个AR类代表一张数据表（或视图），
数据表（或视图）的字段在AR类中体现为类的属性，一个AR实例则表示表中的一行。  

**AR模式的核心：三个映射/对应     
AR类  ----> 表 (模型类关联了数据表)   
AR类的属性  ----> 表的字段   
AR类的实例  ----> 表的记录**    

AR模式的语法格式：
AR模式在ThinkPHP中的典型的应用：CURD操作。
```
//实例化模型
$model = M(关联的表);
$model->属性/表中字段 = 字段值；
$model->属性/表中字段 = 字段值；
...
//AR实例（操作）映射到表中记录 CURD没有参数
$model->CURD操作;
```

## 2、AR模式的CURD操作
在ThinkPHP中除了第二天所学习的CURD操作方法之外，还支持使用AR模式来完成。

### 2.1、增加操作
案例：使用AR模式的语法格式来实现增加操作

```
//AR模式增加操作
public function test17(){
    //第一个映射：类映射表（类关联表）
    $model = M('Dept');
    //属性映射到字段
    $model->name = '技术部';
    $model->pid = '0';
    $model->sort = '10';
    $model->remark = '技术部门最屌';
    //第三个映射：实例映射记录
    $result = $model->add();//没有参数
    dump($result);
}
```
返回值：
```
新增记录的主键id 
```
跟踪信息中的sql语句:
```
INSERT INTO `sp_dept` (`name`,`pid`,`sort`,`remark`) VALUES ('技术部','0','10','技术部门最屌')
```

通过上述的代码，可能会有以下两个疑问：  
**问题1：难道父类模型中真的有name、pid、sort、remark属性么？  
答：通过观察父类模型的底层实现，我们找到了一个特殊的魔术方法__set，可以参考php手册。
问题2：为什么add方法没有参数也能执行添加操作？**  
答：通过问题1中的解答，我们可以得知如果使用AR模式的话，data属性是有值的，然后通过查看add方法的底层实现
```
public function add($data='',$options=array(),$replace=false) {
        if(empty($data)) {
            // 没有传递数据，获取当前数据对象的值
            if(!empty($this->data)) {
                $data           =   $this->data;
                // 重置数据
                $this->data     = array();
            }else{
                $this->error    = L('_DATA_TYPE_INVALID_');
                return false;
            }
        }
        ...
}
```
其中判断是否给add方法传递参数，如果没有传值，则使用父类模型中data属性中值，
而data属性中的值恰恰就是问题1中的数据。  




魔术方法：
```
__set() #给不可访问的属性赋值时，会被调用
__get() #读取不可访问属性的值时，会被调用
当对不可访问属性调用isset()或empty()时，__isset()会被调用
当对不可访问属性调用unset()时，__unset()会被调用
```


### 2.2、修改操作
需要注意：不管是直接通过save方法传递数组，还是使用AR模式，修改时候的主键id必须要。
```
//AR模式的修改操作
public function test18(){
    //实例化模型
    $model = M('Dept');
    //属性映射到字段
    $model->pid = 0;
    $model->remark = '技术部是最叼的部门~~~';
    $model->id = 13; //确定主键信息
    $result = $model->save();
    dump($result);
}
```
返回值和之前的save传递数组一样，表示受到影响的行数。
跟踪信息中的sql语句：
```
UPDATE `sp_dept` SET `pid`='0',`remark`='技术部是最叼的部门~~~' WHERE `id` = 13
```
之所以save方法可以像add方法一样不传递参数，是因为其也有判断。  

### 2.3、查询操作
在ThinkPHP中，AR模式没有查询操作，这里的查询操作还是使用之前的select和find方法。  

### 2.4、删除操作
需要注意：删除的时候必须要指定主键信息
案例：使用AR模式删除表中的数据。
```
//AR模式删除操作
public function test19(){
    $model = M('Dept');
    //指定主键信息
    $model->id='62';
    //$model->id='62,126,23';
    $result = $model->delete();
    dump($result);  //返回结果，返回被影响的行数
}
```
跟踪信息的sql语句
```
DELETE FROM `sp_dept` WHERE `id` = 62
DELETE FROM `sp_dept` WHERE `id` IN ('62','126','23')
```

### 2.5、补充说明
在AR模式中U、D操作必须需要指定主键信息，但是有一种情况下可以不指定主键也能执行U、D操作，
**在之前有做过查询语句，则后面如果没有指定主键，会操作当前查询到的记录。**
```
//AR模式可以不指定主键信息
public function test20(){
    $model = M('Dept');
    $re = $model->find('13');
    dump($re);
    $model->pid = 1;
    $re = $model->save();
    dump($re);
}
```

# 三、ThinkPHP中的辅助方法（重点）
在原生的sql语句中除了我们目前所使用的基本操作之外，还有类似于group、where、order、limit等等这样的字句。
在后期需要用到上述的一些字句方法，以目前的知识储备肯定是不行的，所以ThinkPHP封装了相应的字句方法
- where  
表示限制查询条件
- limit
表示限制输出的条数
- field
表示限制输出的字段，也就是select id,name,pid 这样的语句
- order
表示按照指定的字段进行指定的排序
- group
表示安扎奥指定的字段进行分组查询
- 特别说明


```
day03 -> 7 -> 04:37
```







 













































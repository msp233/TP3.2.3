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
表示按照指定的字段进行分组查询

## 1、where方法
作用：限制查询的条件。  
在原生的sql语句中，select字段 from表 where条件  

在ThinkPHP中系统封装了一个where方法来实现在原生的sql语句中where效果。  
语法：  
$model->where(条件表达式);       //在ThinkPHP中条件表达式支持字符串形式也支持数组形式,推荐使用字符串形式。
$model->CURD操作;     //

eg:
```
$model->where(array('id'=>1); 
```
案例：使用where方法查询id大于3的数据  

```
//where方法
public function test21(){
    $model = M('Dept');
    $model->where('id>3'); //条件where id>3
    $re = $model->select();
    dump($re);
}
```
回忆：在mysql中除了where子句之外，还有一个语法格式也能限制查询条件，这个语法是having语法。  
问题：where字句和having子句有什么区别？  
答：两个语句都表示限制查询条件，但是意义上有差异，**where表示限制查询条件，但是要求条件中的字段必须是数据表中存在的字段；
而having要求条件中的字段必须是结果集中存在的。**  

## 2、limit方法
作用：限制输出的条数。（典型的应用：数据分页）  
在原生的sql语句中，**select 字段 from 表 where limit 限制的条数；**  

在ThinkPHP中，系统提供了limit方法来实现原生的sql语句中限制条数的效果：  
- $model->limit(n);     //n表示大于0的数字，表示输出表中的前n行
- $model->limit(起始位置,偏移量/长度);   //表示从第起始位置开始，往后查询指定长度的记录数，在实际使用的时候，该方法还支持写成$model->limit('起始位置,偏移量');（参数是一个带逗号的字符串整体）

案例：使用limit语法格式来实现表中的数据限制
```
//limit方法
public function test22(){
    $model = M('Dept');
    $re = $model->where('id>=1')->limit(1,2)->select();  //数据下标从0开始，limit1 是从第二条数据开始
    dump($re);
}
```

sql语句：
```
SELECT * FROM `sp_dept` WHERE ( id>=1 ) LIMIT 1,2
```

返回：
```
array (size=2)
  0 => 
    array (size=5)
      'id' => string '2' (length=1)
      'name' => string '财务部' (length=9)
      'pid' => string '0' (length=1)
      'sort' => string '22' (length=2)
      'remark' => string '我们是财神^_^' (length=18)
  1 => 
    array (size=5)
      'id' => string '11' (length=2)
      'name' => string '公关部' (length=9)
      'pid' => string '0' (length=1)
      'sort' => string '3' (length=1)
      'remark' => string '公共关系维护' (length=18)
```

后期使用的分页效果，其实就是limit的第二种语法格式。  

## 3、field方法
作用：限制输出的结果集字段。  
语法：
`$model->field('字段1,字段2 as 别名,字段3...);     //参数也就是select之后到from之前的那一串字符串。`  
案例：使用field方法来查询部门表中的数据，只要显示id和name就可以。  
原生的sql：select id name from oa_dept;

```
//field方法
public function test23(){
    $model = M('Dept');
    $re = $model->field('id,name as 部门名称')->where('id>1')->limit(0,3)->select();
    dump($re);
}
```
sql语句：
```
SELECT `id`,name as 部门名称 FROM `sp_dept` WHERE ( id>1 ) LIMIT 0,3
```
结果：
```
array (size=3)
  0 => 
    array (size=2)
      'id' => string '2' (length=1)
      '部门名称' => string '财务部' (length=9)
  1 => 
    array (size=2)
      'id' => string '11' (length=2)
      '部门名称' => string '公关部' (length=9)
  2 => 
    array (size=2)
      'id' => string '12' (length=2)
      '部门名称' => string '总裁办' (length=9)
```

## 4、order方法
作用：指按照==指定的字段==进行==指定规则==的排序
在原生的sql语法中使用是：order by 字段 排序规则（升序asc/降序desc）。  
语法：
$model->order('字段名 排序规则');  
案例：使用order方法查询部门表中的数据，并且按照id进行降序排列。  
原生的sql ： select * from sp_dept order by id desc;

```
//order方法
    public function test24(){
        $model = M('Dept');
        $re = $model->field('id,name as 部门名称')->where('id>=2')->order('id desc')->limit(0,3)->select();   //desc 降序 
        dump($re);
    }
```
```
SELECT `id`,name as 部门名称 FROM `sp_dept` WHERE ( id>=2 ) ORDER BY id desc LIMIT 0,3
```
## 5、group方法
作用：分组查询。
在ThinkPHP中group分组可以使用group方法来实现：
$model->group('字段名');  

案例：使用group的方法去查询部门表，要求查询出部门名称和出现的次数。
原生sql： 
select name as 部门名称,count(*) as 出现次数 from sp_dept group by name;
```
//group方法
public function test25(){
    $model = M('Dept');
    $re = $model->field('name as 部门名称,count(*) as 出现次数')->group('name')->select();
    dump($re);
}
```

输出结果：
```
array (size=5)
  0 => 
    array (size=2)
      '部门名称' => string '人事部' (length=9)
      '出现次数' => string '1' (length=1)
  1 => 
    array (size=2)
      '部门名称' => string '公关部' (length=9)
      '出现次数' => string '1' (length=1)
  2 => 
    array (size=2)
      '部门名称' => string '总裁办' (length=9)
      '出现次数' => string '1' (length=1)
  3 => 
    array (size=2)
      '部门名称' => string '技术部' (length=9)
      '出现次数' => string '1' (length=1)
  4 => 
    array (size=2)
      '部门名称' => string '财务部' (length=9)
      '出现次数' => string '1' (length=1)
```

__call  调用对象中不存在的方法时，调用__call 魔术方法  

# 四、连贯操作（重点）

连贯操作：所谓连贯操作就是将辅助方法全部卸载一行上的方法，这样的形式叫做连贯操作。  

也就是如下的形式：  
`$model->where()->limit()->order()->field()->select();`  

注意点：辅助方法的顺序，在连贯操作中没有要求，只要符合模型在最前面，CURD方法在最后面即可。  

案例：将上述第五个辅助方法的案例代码用连贯操作的形式改写：  
```
//group方法
public function test25(){
    $model = M('Dept');
    $re = $model->field('name as 部门名称,count(*) as 出现次数')->group('name')->select();
    dump($re);
}
``` 

问：连贯操作上的辅助方法为什么可以写在一行上呢？
答：原因就是每一个辅助方法最后的返回值都是$this，而$this是指当前的模型类，由模型类去调用后续的辅助方法，
这个是行得通的。这也是为什么要求CURD方法必须放在最后的原因。  

**在以后的开发过程中，不管是自己写的代码还是别人写的代码，都会遵循使用连贯操作的形式来替代每一个辅助方法单独一行的写法。**  

# 五、ThinkPHP中的统计查询
在ThinkPHP中系统提供了一下几个查询方法的使用，方便在后期需要做统计的使用。
- count()  表示查询表中总的记录数
- max()  查询某个字段的最大值
- min()  查询某个字段的最小值
- avg()  查询某个字段的平均值
- sum()  求出某个字段的总和

## 1、count方法
**语法：$model->[where()->]count();**  
案例：查询出部门表中总的记录数  
```
//count方法
public function test26(){
    $model = M('Dept');
    $count = $model->count();
    dump($count);
}
```
追踪信息的sql语法：
```
SELECT COUNT(*) AS tp_count FROM `sp_dept` LIMIT 1
```
返回值是字符形式`string '5' (length=1)` 5

## 2、max方法
语法：
$model->max('字段名');  
案例：查询部门表中id最大的部门的id。
在以后实际开发的时候有一个应用：**通过max方法查询最后注册的会员id**。  
```
//max 查询部门表中id最大的部门的id
    public function test27(){
        $model = M('Dept');
        $re = $model->max('id');
        dump($re);
    }
```
追踪信息的sql：
```
SELECT MAX(id) AS tp_max FROM `sp_dept` LIMIT 1
```
返回输出：`string '13'`

## 3、min方法
语法：$model->min('字段名');  
案例：使用min方法查询部门表中id最小的信息。  
在以后的使用也有一个典型的应用：查询最早注册的会员id。  
```
// 查询部门表中id最小的部门的id
public function test28(){
    $model = M('Dept');
    $min = $model->min('id');
    dump($min);
}
```
sql语句：
```
SELECT MIN(id) AS tp_min FROM `sp_dept` LIMIT 1
```
返回输出结果：`string'1'`

## 4、avg方法
语法： $model->avg('字段名');  
案例：求出部门中id的平均值。  
一般用于求取工资、年龄的平均值
```
//查询部门表中id平均值
    public function test29(){
        $model = M('Dept');
        $avg = $model->avg('id');
        dump($avg);
    }
```
sql语句：
```
SELECT AVG(id) AS tp_avg FROM `sp_dept` LIMIT 1
```
输出返回值：`string '7.8000'`

## 5、sum方法
语法：$model->model('字段名')
案例：查询部门表中id的总和
```
//查询部门表id总和
public function test30(){
    $model = M('Dept');
    $sum = $model->sum('id');
    dump($sum);
}
```
 sql语句：
 ```
 SELECT SUM(id) AS tp_sum FROM `sp_dept` LIMIT 1 
 ```
 
 输出返回值：`string '39'`

# 六、扩展（1）
## 1、fetchSql
前面我们介绍了sql调试的一个方法 getLastSql或者别名_sql(),但是这个方法要求最后一条成功执行的sql，
所以如果那这个方法来调试sql，只能调试逻辑错误，并不能拿来调试语法错误，所以这里给大家介绍一个新的sql调试方法，
fetchSql()。  
语法：  
$model->where()->limit()...->order()->fetchSql(true)->CURD操作;  

fetchSql方法使用的时候可以完全看作是一个辅助方法，所以要求必须在model之后，在CURD操作之前，顺序无所谓。
FetchSql方法只能在ThinkPHP3.2.3版本之后使用。

```
 //fetchSql
    public function test31(){
        $model = M('Dept');
        $re = $model->field('id,name as 部门名称')->where('id>=2')->order('id desc')->fetchSql(true)->limit(0,10)->select();  //desc 降序
        dump($re);
    }
```

**跟踪信息，sql不执行**  
返回值：
```
string 'SELECT `id`,`name`,dddd as 部门名称 FROM `sp_dept` WHERE ( id>=2adfadf ) ORDER BY id desc LIMIT 0,10  '
```
说明：通过跟踪信息和返回值，我们可以发现，使用fetchSql之后原有的连贯操作没有被执行（在跟踪信息中没有sql显示），
而是直接将连贯操作的语法组成的sql语句给返回。  

# 七、综合案例

## 1、后台首页
1. 写控制器
Application/Admin/Controller/IndexController.class.php  
```
public function index(){
    $this->display();
}
public function home(){
    $this->display();
}
```
2. 复制index.html、home.html文件到 Application/Admin/View/Index/ 目录下

3. 修改两个模板文件中静态资源文件的引入路径

4. 纠正home页面引入路径
```
src="__CONTROLLER__/home"
```

另外一种方式：
在模板中也可以使用U方法来指定URL地址。  
U方法在模板中使用方法，需要注意，需要在其外面加上{:xxxxxx}
```
src="{:U('home')}"
```

## 2、部门管理

### 2.1、设计二级导航

- 先复制有二级菜单的代码，将其粘贴到想添加二级菜单处。
- 修改二级菜单栏目名称及跳转地址{:U(showList)}、{:U(add)}

### 2.2、实现部门的添加功能
控制器：DeptController.class.php 已经存在
方法： add
模板文件： add.html
1. 创建add方法，展示模板
2. 复制模板文件add.html 到指定位置
./Application/Admin/View/Dept/add.html
3. 修改模板文件中静态资源文件的引入路径
__ADMIN__
4. 表单中大部分地方都没有问题，只有一个地方，就是提交按钮和清空按钮，它是a标签，但是修改成input后，央视会消失，
所以我们可以通过jQuery的方法来保证样式和表单的提交。
编写jQuery代码：
```
//jQuery代码  定义载入事件
$(function(){
    //给确定按钮绑定一个点击事件
    $('.confirm').on('click',function(){
        //事件的处理程序
        $('form').submit();
    });
    //给清空内容按钮绑定一个点击事件
    $('.clear').on('click',function(){
        //事件的处理程序Q
        //juery对象转换成DOM对象两种方法
        $('form')[0].reset();
        //$('form').get(0).reset();
    });
});
```
5. 展示上级部门信息
```
//add方法
public function add(){
    //查询出顶级部门
    $model = M('Dept');
    $data = $model->where('pid = 0')->select();
    //展示数据
    $this->assign('data',$data);
    //展示模板
    $this->display();
}
```
展示在模板中：  
分析：因为select的返回值是二维数组，所以需要遍历操作
```
<select name="pid">
    <option value="0">顶级部门</option>
    <volist name="data" id="vol">
        <option value="{$vol.id}">{$vol.name}</option>
    </volist>
</select>
```
6. 表单信息提交的操作
改写add方法，判断是否是post请求，如果是，则处理表单的提交，如果不是则展示模板。  
扩展：如何判断请求是否是post？  
答：要是以前，我们可以使用if($_POST)来判断，但是在ThinkPHP中，系统为我们封装了几个比较常用的常量，
可以直接用常量来判断你，常见常量如下：
IS_POST 如果请求是post，则IS_POST的值是true，否则是false  
IS_GET  
IS_AJAX 如果请求是ajax，则IS_AJAX的值是true，否则是false  
IS_CGI  
IS_PUT  

关于数据接收的说明：  
在之前我们使用的时候$_POST来接收数据，在ThinkPHP中，我们可以使用I方法（快速方法）来接收数据，
I方法可以接收任何类型的输入（post、get、request、put等等），
并且系统默认自带防sql注入的方法（使用php内置的函数htmlspecialchars)。  

语法：  
```
I('变量类型.变量名/修饰符',['默认值'],['过滤方法或正则'],['额外数据源'])
```
变量类型：
```
 get  获取GET参数  
 post  获取POST参数  
 param  自动判断请求类型获取GET、POST或者PUT参数  
 request  获取REQUEST 参数  
 put  获取PUT 参数  
 session  获取 $_SESSION 参数  
 cookie  获取 $_COOKIE 参数  
 server  获取 $_SERVER 参数  
 globals  获取 $GLOBALS参数  
 path  获取 PATHINFO模式的URL参数  
 data  获取 其他类型的参数，需要配合额外数据源参数 
```
默认值：是当使用过滤方法之后，原先的内容如果变成了空字符串，则会使用默认值来代替。  
过滤方法：是对ThinkPHP默认提供的htmlspecialchars的补充，函数名可以是php内置的，也可以是函数库中的。  

额外的说明：如果想接收整个数组，则可以不写变量名，写成`I('get.')`    

```
//add方法
public function add(){
    //判断请求类型
    //$_POST
    if(IS_POST){
        //处理表单提交
        //$post = $_POST;
        $post = I('post.');
        dump($post);
        $model = M('Dept');
        $re = $model->add($post);

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















```
day03 -> 17 -> 35:26
```







 













































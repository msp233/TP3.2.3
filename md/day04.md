# 一、ThinkPHP中的模型
 
 ## 1、数据对象创建
 数据对象也就是父类模型中的$this->data，上一天我们在使用AR模式时使用了数据对象，
 在模型实例化的时候数据对象还是一个空数组，在后来使用了魔术方法__set来设置了数据对象的值。  
 
从上述的一个流程中我们可以得出，既然data属性之前是空数组，后期使用的时候需要先给其赋值，  
也就说明，**在使用数据对象的时候必须先创建数据对象**。而__set 是设置数据对象的一种方法；
但是这种方式在使用时并不方便，原因是设置一个属性就得写一行代码；
因此在ThinkPHP中系统还提供另外一种批量设置数据对象的方法，create方法。  
语法：  
 $model->create();
 
 ThinkPHP -> Model.class.php 文件中的create()方法
 ```
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
在父类模型中存在一个成员属性，叫做_validate，这个属性是保存验证规则的。  








































 ```
 day04 -> 02 -> 00:00
 ```
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
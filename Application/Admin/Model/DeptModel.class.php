<?php
/**
 * Created by PhpStorm.
 * User: msp
 * Date: 2018/5/9
 * Time: 15:41
 */
//声明命名空间
namespace Admin\Model;
//引入父类模型
use Think\Model;

//声明模型并且继承父类模型
class DeptModel extends Model{
    //开启批量验证
    //protected $patchValidate = true;

    //字段映射定义
    protected $_map = array(
        //映射规则  表单name值 => 数据表字段名
        'abc' => 'name',
    );

    //自动验证定义
    protected $_validate = array(
        //array(验证字段1,验证规则,错误提示,[验证条件,附加规则,验证时间]),
        //针对部门名称的规则
        array('name','require','部门名称不能为空'),
        array('name','','部门名称已经存在',0,'unique',1),
        //array('sort','number','排序必须是数字！'),
        //使用函数的方式来验证排序字段必须为数字
        array('sort','is_numeric','排序必须是数字！',0,'function'),
    );
/*
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
6. 验证时间（可选）：1表示新增数据的时候验证，2表示编辑的时候验证，3表示全部情况下都验证（默认）。
 * */


















}


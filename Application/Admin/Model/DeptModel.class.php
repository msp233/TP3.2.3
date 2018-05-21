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
        //针对部门名称的规则
        array('name','require','部门名称不能为空'),
        array('name','','部门名称已经存在',0,'unique'),
        //array('sort','number','排序必须是数字！'),
        //使用函数的方式来验证排序字段必须为数字
        array('sort','is_numeric','排序必须是数字！',0,'function'),
    );



















}


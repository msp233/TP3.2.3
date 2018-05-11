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
    public $name = '';
    public $pid = 0;
    public $sort = 50;

}


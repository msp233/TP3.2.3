<?php
/**
 * Created by PhpStorm.
 * User: msp
 * Date: 2018/5/5
 * Time: 20:05
 */
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



























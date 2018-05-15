<?php
/**
 * Created by PhpStorm.
 * User: msp
 * Date: 2018/5/6
 * Time: 22:40
 */
namespace Admin\Controller;
use Think\Controller;
class PublicController extends Controller{
    public function login(){
        //展示模板
        $this->display();
        //获取模板内容
        //$re = $this->fetch();
        //echo '<hr/><hr/>';
        //dump打印
        //dump($re);

    }
    public function index(){
        $this->display();
    }
}
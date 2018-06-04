<?php
/**
 * Created by PhpStorm.
 * User: msp
 * Date: 2018/5/13
 * Time: 18:46
 */
namespace Admin\Controller;

use Think\Controller;

class IndexController extends Controller{
    public function index(){
        $this->display();
    }
    public function home(){
        $this->display();
    }
}
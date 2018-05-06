<?php
/**
 * Created by PhpStorm.
 * User: msp
 * Date: 2018/5/6
 * Time: 11:29
 */

namespace Admin\Controller;
use Think\Controller;

class TestController extends Controller
{
    public function test(){
        echo 'Admin分组 Test控制器 index方法<br/>';
        echo __APP__;
        $id = $_GET['id'];
        $id = ($id == '') ? '1' : $id;
        $this ->assign('id',$id);
        #return $this->display();
        #return $this->display('test1');
        $this->display('Demo/test1');
    }

    public function test1(){
        echo U('index').'<br/>';
        echo U('Index/index').'<br/>';
        echo U('Home/Index/index').'<br/>';
        echo U('index',array('id' => 233,'name' => 'msp')).'<br/>';
    }

    public function test2(){
        $this -> success('操作成功',U('index'),10);
    }

    public function test3(){
        $this -> error('跳转失败');
    }
    /*
     * 模板常量
     **/
    public function test4(){
        $this -> display();
    }

    public function index(){
        echo 'Admin分组 Test控制器 index方法';
    }
}
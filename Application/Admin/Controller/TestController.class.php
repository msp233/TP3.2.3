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

    /*
     * 视图注释
     * */
    public function test5(){
        $this->display();
    }

    /*变量的输出（数组）*/
    public function test6(){
        //定义一维数组
        $arr = array('西游记','三国','水浒');

        //定义二维数组
        $arr2 = array(
            array('白骨精','大师兄','二师兄'),
            array('诸葛亮','张飞','关羽'),
            array('李逵','戴宗','林冲'),
        );
        //变量分配
        $this->assign('arr',$arr);
        $this->assign('arr2',$arr2);
        $this->display();
    }

    //变量分配（对象）
    public function test7(){
        //实例化student对象
        $stu = new Student();
        //给类的属性赋值
        $stu->id = 1000;
        $stu->name = 'tom';
        $stu->sex = 'boy';

        //变量的分配
        $this->assign('stu',$stu);
        //展示模板
        $this->display();
        //dump($stu);
    }

    //系统变量
    public function test8(){
        //展示模板
        $this->display();
    }

    //模板中函数的使用
    public function test9(){
        $time = time();
        $str = 'abcDefgfsadfadf';
        $this->assign('str',$str);
        $this->assign('time',$time);
        $this->display();
    }

    //默认值
    public function test10(){
        $str1 = '';
        $str2 = '有东西 非空';
        $this->assign('str1',$str1);
        $this->assign('str2',$str2);
        $this->display();
    }

    public function index(){
        echo 'Admin分组 Test控制器 index方法';
    }
}

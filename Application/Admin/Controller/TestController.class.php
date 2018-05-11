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

    //运算符
    public function test11(){
        //定义两个变量
        $a = 100;
        $b = 10;
        //传递给模板
        $this->assign('a',$a);
        $this->assign('b',$b);
        $this->display();
    }

    //展示头部
    public function header(){
        //展示模板
        $this->display();
    }

    //展示body
    public function body(){
        //展示模板
        $this->display();
    }

    //展示底部
    public function footer(){
        //展示模板
        $this->display();
    }

    //数组遍历
    public function test12(){
        //定义一维数组
        $arr1 = array('西游记','三国','水浒');

        //定义二维数组
        $arr2 = array(
            array('白骨精','大师兄','二师兄'),
            array('诸葛亮','张飞','关羽'),
            array('李逵','戴宗','林冲'),
        );

        $this->assign('arr1',$arr1);
        $this->assign('arr2',$arr2);
        $this->display();
    }

    /*if标签
     * 在php输出今天的星期数字，
     * 然后传递给模板，在模板中使用if判断今天是星期几？
     * */
    public function test13(){
        $day = date('w',time());
        $this->assign('day',$day);
        $this->display();
    }

    //php标签在模板中的使用
    public function test14(){
        $this->display();
    }

    //sql 调试
    public function test15(){
        //实例化模型
        $model = D('Dept');
        $data = $model->select();
        echo $model->getLastSql();
    }

    //使用G方法来统计某段代码开销
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
    }

    public function index(){
        echo 'Admin分组 Test控制器 index方法';
    }
}

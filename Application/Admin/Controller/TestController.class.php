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

    //AR模式增加操作
    public function test17(){
        //第一个映射：类映射表（类关联表）
        $model = M('Dept');
        //属性映射到字段
        $model->name = '技术部';
        $model->pid = '0';
        $model->sort = '10';
        $model->remark = '技术部门最屌';
        //第三个映射：实例映射记录
        $result = $model->add();//没有参数
        dump($result);
    }

    //AR模式的修改操作
    public function test18(){
        //实例化模型
        $model = M('Dept');
        //属性映射到字段
        $model->pid = 0;
        $model->remark = '技术部是最叼的部门~~~';
        $model->id = 13; //确定主键信息
        $result = $model->save();
        dump($result);
    }

    //AR模式删除操作
    public function test19(){
        $model = M('Dept');
        //指定主键信息
        $model->id='62';
        //$model->id='62,126,23';
        $result = $model->delete();
        dump($result);  //返回结果，返回被影响的行数
    }

    //AR模式可以不指定主键信息
    public function test20(){
        $model = M('Dept');
        $re = $model->find('13');
        dump($re);
        $model->pid = 1;
        $re = $model->save();
        dump($re);
    }

    //where方法
    public function test21(){
        $model = M('Dept');
        $model->where('id>3');  //条件where id>3
        $re = $model->select();
        dump($re);
    }

    //limit方法
    public function test22(){
        //实例化模型
        $model = M('Dept');
        //限制记录 查询
        $re = $model->where('id>=1')->limit(1,2)->select();
        dump($re);
    }

    //field方法
    public function test23(){
        $model = M('Dept');
        $re = $model->field('id,name as 部门名称')->where('id>1')->limit(1,3)->select();
        dump($re);
    }

    //order方法
    public function test24(){
        $model = M('Dept');
        $re = $model->field('id,name as 部门名称')->where('id>=2')->order('id desc')->limit(0,10)->select();  //desc 降序
        dump($re);
    }

    //group方法
    public function test25(){
        $model = M('Dept');
        $re = $model->field('name as 部门名称,count(*) as 出现次数')->group('name')->select();
        dump($re);
    }

    //count方法 查询出部门表中总的记录数
    public function test26(){
        $model = M('Dept');
        $count = $model->count();
        dump($count);
    }

    //max 查询部门表中id最大的部门的id
    public function test27(){
        $model = M('Dept');
        $max = $model->max('id');
        dump($max);
    }

    //min  查询部门表中id最小的部门的id
    public function test28(){
        $model = M('Dept');
        $min = $model->min('id');
        dump($min);
    }

    //avg 查询部门表中id平均值
    public function test29(){
        $model = M('Dept');
        $avg = $model->avg('id');
        dump($avg);
    }

    //sum 查询部门表id总和
    public function test30(){
        $model = M('Dept');
        $sum = $model->sum('id');
        dump($sum);
    }

    //fetchSql
    public function test31(){
        $model = M('Dept');
        $re = $model->field('id,name as 部门名称')->where('id>=2')->order('id desc')->fetchSql(true)->limit(0,10)->select();  //desc 降序
        dump($re);
    }

    public function index(){
        echo 'Admin分组 Test控制器 index方法';
    }













































}

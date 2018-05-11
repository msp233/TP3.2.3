<?php
/**
 * Created by PhpStorm.
 * User: msp
 * Date: 2018/5/6
 * Time: 22:40
 */
namespace Admin\Controller;
use Think\Controller;
use Admin\Model as Model;
class DeptController extends Controller{//展示实例化的结果
    public function shilihua(){
        //普通实例化方法
        //$model = new Model\DeptModel();

        //实例化自定义模型 D
        $model = D('Dept');//其实实例化结果和使用普通new方法是一样的
        //$model = D();//实例了父类模型，不关联表
        //$model = M('Dept'); //实例化父类，关联数据表
        //$model = M();//实例化父类，不关联表
        dump($model);
    }
    //add方法使用
    public function tianjia(){
        $model = M('Dept');//直接使用基本的增删改查可以使用父类模型
        //声明数组（关联数组）
        /*$data = array(
          'name' => '人事部',
            'pid' => '0',
            'sort' => '1',
            'remark' => '这是人事部门'
        );
        $result = $model->add($data);*/

        //批量添加
        $data = array(
            array(
                'name' => '公关部',
                'pid' => 0,
                'sort' => 3,
                'remark' => '公共关系维护'
            ),
            array(
                'name' => '总裁办',
                'pid' => 0,
                'sort' => 4,
                'remark' => '权力最高的部门'
            )
        );
        $result = $model->addAll($data);
        dump($result);
    }

    //save方法的使用
    public function xiugai(){
        //实例化父类模型
        $model = M('Dept');
        //修改操作
        $data = array(
            'id' => '2',
            'sort' => '22',
            'remark' => '我们是财神^_^'
        );
        $result = $model->save($data);
        dump($result);
    }

    //查询
    public function chaxun(){
        //实例化模型
        $model = M('Dept');
        //select部门
        //$result = $model->select(); //查询全部  返回二维数组
        //$result = $model->select(1);  //指定id  返回二维数组
        $result = $model->select('1,2');  //指定id集合  返回二维数组

        //find部分
        //$result = $model->find();     //limit 1  返回一维数组
        //$result = $model->find('11');     //指定id  返回一维数组
        $sql = $model->getLastSql();
        dump($sql);
        dump($result);
    }

    //删除操作
    public function shanchu(){
        //实例化模型
        $model = M('Dept');
        //删除操作
        //$result = $model->delete();  //false

        $result = $model->delete(12);  //返回受影响的行数
        //$result = $model->delete(11,12);  //删除多个id记录 返回受影响的行数
        //打印$result
        dump($result);
    }
    public function login(){
        //展示模板
        $this->display();
        //获取模板内容
        //$re = $this->fetch();
        //echo '<hr/><hr/>';
        //dump打印
        //dump($re);
    }

}
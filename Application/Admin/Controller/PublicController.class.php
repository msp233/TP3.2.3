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
    //登录页面展示
    public function login(){
        //展示模板
        $this->display();
        //获取模板内容
        //$re = $this->fetch();
        //echo '<hr/><hr/>';
        //dump打印
        //dump($re);

    }

    //captcha方法
    public function captcha(){
        ob_end_clean();
        //配置
        $cfg = array(
            'UserImgBg' =>  false,          //使用背景图片
            'fontSize'  =>  10,              // 验证码字体大小(px)
            'useCurve'  =>  false,            // 是否画混淆曲线
            'useNoise'  =>  false,            // 是否添加杂点
            'imageH'    =>  36,               // 验证码图片高度
            'imageW'    =>  75,               // 验证码图片宽度
            'length'    =>  4,               // 验证码位数
        );
        //实例化验证码类
        $verify = new \Think\Verify($cfg);
        //输出验证码
        $verify->entry();
    }


    public function home(){
        $this->display();
    }
    public function index(){
        $this->display();
    }
}
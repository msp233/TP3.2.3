<?php
/**
 * Created by PhpStorm.
 * User: msp
 * Date: 2018/5/8
 * Time: 14:57
 */
/*
 * 将取出的数据数组组装成有父子结构的数组
 * */
function getTree($data, $fid)
{
    $tree = array();
    foreach($data as $k => $v)
    {
        if($v['fid'] == $fid)
        {        //父亲找到儿子
            $v['fid'] = getTree($data, $v['id']); //这行报错
            $tree[] = $v;
            //unset($data[$k]);
        }
    }
    return $tree;
}
/*
 * 将有父子结构的数组拼接html标签 用来显示
 * */
function procHtml($tree)
{
    $html = '';
    foreach($tree as $t)
    {
        if($t['fid'] == '')
        {
            $html .= "<li>{$t['catename']}</li>";
        }
        else
        {
            $html .= "<li>".$t['catename'];
            $html .= procHtml($t['fid']);
            $html = $html."</li>";
        }
    }
    return $html ? '<ul>'.$html.'</ul>' : $html ;
}
<?php
namespace app\index\controller;
use think\Controller; 
use think\View;
use think\Db;

 
class Index extends Controller 
{
    public function index()
    {
        $list = Db::table('info')->order('firsteditime desc')->paginate(10);
        // 把分页数据赋值给模板变量list
        $this->assign('list', $list);
        // 渲染模板输出
        if(request()->isAjax()) {
           return view("list");
        }else{
           return $this->fetch();
        }
    }
}

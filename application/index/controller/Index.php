<?php
namespace app\index\controller;
use think\Controller; 
use think\View;
use think\Db;

 
class Index extends Controller 
{
    public function index()
    {
        $sql = "1=1";
        if (isset($_POST['keyword'])){
           $sql.= " and title like '%" . $_POST["keyword"] . "%'";
        }
        $list = Db::table('info')->where($sql)->order('firsteditime desc')->paginate(10);
        // 把分页数据赋值给模板变量list
        $this->assign('list', $list);
        // 渲染模板输出
        if(request()->isAjax()) {
           return view("list");
           //return $this->display($sql);
        }else{
           return $this->fetch();
        }
    }
}

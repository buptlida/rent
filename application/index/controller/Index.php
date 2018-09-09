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
        $region = Db::table('region')->where($sql)->select();
        $this->assign('region', $region); 
        $sql = "1=1";
        $subline = Db::table('subline')->where($sql)->select();
        $this->assign('subline', $subline);

        $sql = "1=1";
        if (isset($_POST['subline'])){
           if (isset($_POST['subway'])){
              $sql = "1=1";
           }else{
              $sql.= " and title like '%" . $_POST["title"] . "%'";
              if($_POST['area']!='0') $sql.= " and regioncode =" . $_POST['area'];
              if($_POST['subline']!='0') $sql.= " and sublinecode =" . $_POST['subline'];
              if($_POST['housetype']!='0') $sql.= " and housetype =" . $_POST['housetype'];
              if ($_POST["price"]!='0'){
                $price = (1 << (intval($_POST["price"]) - 1));
                $sql.= " and (price & " . strval($price) . " )!=0";
              } 
              if($_POST['renttype']=='1') $sql.= " and renttype =" . $_POST['renttype'];
              if($_POST['renttype']!='1') $sql.= " and renttype !=1";
              if($_POST['classify']=='1') $sql.= " and classify =" . $_POST['classify'];
              if($_POST['classify']!='1') $sql.= " and classify !=1";
              if($_POST['bedroom']!='0') $sql.= " and bedroom =" . $_POST['bedroom'];
              if($_POST['gender']!='0') $sql.= " and gender =" . $_POST['gender'];
              if($_POST['publish']=='1') {
                $mytime=mktime(0, 0, 0, date('m'), date('d')-1, date('Y'));
                $sql.= " and firsteditime >" .strval($mytime) ;
              }
              if($_POST['publish']=='2') {
                $mytime=mktime(0, 0, 0, date('m'), date('d')-7, date('Y'));
                $sql.= " and firsteditime >" .strval($mytime) ;
              }
           }
        }
        if (isset($_POST['keyword'])){
           $sql.= " and title like '%" . $_POST["keyword"] . "%'";
        }
        $list = Db::table('info')->where($sql)->order('firsteditime desc')->paginate(10);
        // 把分页数据赋值给模板变量list
        $this->assign('list', $list);
        // 渲染模板输出
        if(request()->isAjax()) {
           return view("topic");
           //return $this->display($sql);
        }else{
           return $this->fetch();
        }
    }

    public function getarea()
    {
        $sql = "1=1";
        $code = $_POST['code'];
        $sql = "1=1 and pcode=".$code;
        $subregion = Db::table('street')->where($sql)->select();
        $this->assign('subregion', $subregion);
        return View("subarea");
        
    }
    
    public function getstation()
    {
        $sql = "1=1";
        $code = $_POST['code'];
        $sql = "1=1 and pcode=".$code;
        $subway = Db::table('subway')->where($sql)->select();
        $this->assign('subway', $subway);
        return View("subway");
        
    }
}

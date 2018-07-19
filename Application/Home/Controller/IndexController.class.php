<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends CommonController {
    public function index(){
		parent::index();
		$ban = M('banner') -> select();
		$this -> assign('ban',$ban);
		$this -> display('index');
	}
	
	public function pbl(){
		
		$num = $_POST['num'];
		$id = $_POST['id'];
		$works = M('works') -> order("createtime desc") -> limit($num,8) -> select();
		$users = M('user') -> field('id,name,thum') -> select();
		$work = [];
		foreach($works as $k => $v){
			$work[$k] = $v;
			
			$da['imgid'] = $v['id'];
			$data3 = M('likework') -> where($da) -> field('userid') -> select();
			$data3len = M('likework') -> where($da) -> count();
			$work[$k]['liklen'] = $data3len;
			if($data3[0]['userid'] == $id){
				$work[$k]['likess'] = 1;
			}
			$lab = explode(',',$v['label']);
			$labs = '';
			for($i=0; $i<sizeof($lab); $i++){
				$work[$k]['lab'] .= '<span>'.$lab[$i].'</span>';
			}
			for($j=0; $j<sizeof($users); $j++){
				if($works[$k]['author'] == $users[$j]['id']){
					$work[$k]['zz'] = $users[$j]['name'];
					$work[$k]['tx'] = $users[$j]['thum'];
				}
			}
		}
		//var_dump($work);
		$this->ajaxReturn($work);
		
	}
	
	public function sousuo(){
		parent::index();
		
		
		$title = $_POST["title"];
		
		if($title!=""){
			$_SESSION["title"] = $title;
		}
		
		$data["title"] = array("like", "%".$_SESSION["title"].'%');
		$data['type'] = '1';
		
		
		$user = M('fenlei'); // 实例化User对象
		
		$count      = $user->where($data)->count();// 查询满足要求的总记录数
		$Page       = new \Think\Page($count,5);// 实例化分页类 传入总记录数和每页显示的记录数(25)
		$Page -> setConfig('prev', '上一页');
		$Page -> setConfig('next', '下一页');
		
		$show       = $Page->show();// 分页显示输出
		// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
		
		$list = $user->where($data)->limit($Page->firstRow.','.$Page->listRows)->order("id asc")->select();
		
		//var_dump($Page);
		
		$this->assign('list',$list);// 赋值数据集
		$this->assign('page',$show);// 赋值分页输出
		$this->assign('title',$title);
		
		$this->display('sousuo');
		
	}
}
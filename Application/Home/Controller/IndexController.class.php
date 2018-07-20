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
		$label = $_POST['label'];
		$this -> assign('label',$label);
		$this -> display('sousuo');
		
	}
	
	public function sousuopbl(){
		
		$num = $_POST['num'];
		$id = $_POST['id'];
		$val = $_POST['label'];
		$data['label'] = array('like','%'.$val.'%');
		$works = M('works') -> where($data) -> order("createtime desc") -> limit($num,8) -> select();
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
}
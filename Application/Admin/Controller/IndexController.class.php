<?php
namespace Admin\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
		
		$nav = M("nav")->where("p_id like '0,2,%'")->select();
		$this->assign("list",$nav);
		
		$linpai = $_GET['lingpai'];
		$username = $_SESSION['username'];
		if(empty($username)){
			$this->error('请您先登录后台',__APP__.'/Admin/Index/login',2);
		}
		$this->assign('username',$username);
		$this->display();
	}
	
	public function del_cache() { 
		header("Content-type: text/html; charset=utf-8");
		//清文件缓存
		$dirs = array('Application/Runtime');
		//@mkdir('Application/Runtime',0777,true);
		//清理缓存
		foreach($dirs as $value) {
			$this->rmdirr($value);
		}
		
		//$this->assign("jumpUrl","__ROOT__/");
		$this->success('系统缓存清除成功！');
		echo '<div style="color:red;">系统缓存清除成功！</div>';
	}
	
	public function rmdirr($dirname){
		if(!file_exists($dirname)){
			return false;
		}
		if (is_file($dirname) || is_link($dirname)) {
			return unlink($dirname);
		}
		$dir = dir($dirname);
		if($dir){
			while (false !== $entry = $dir->read()) {
				if ($entry == '.' || $entry == '..') {
					continue;
				}
				//递归
				$this->rmdirr($dirname.DIRECTORY_SEPARATOR.$entry);
			}
		}
		$dir->close();
		return rmdir($dirname);
	}
	
	public function login(){
		
		$this->display();
	}
	
	public function loginFun(){
		$lingpai = time();
		$_SESSION['lingpai'] = time();
		
		$verify = I('param.verify','1');

		if(!check_verify($verify)){  
			$this->error("亲，验证码输错了哦！",$this->site_url,2);
		}else{
			$data['username'] = $_POST['username'];
			$data['password'] = $_POST['password'];
			$admin = M('admin')->where($data)->find();
			if(empty($admin)){
				$this->error("帐号密码错误",$this->site_url,2);
			}else{
				
				$_SESSION['username'] = $admin['username'];
				$this->success("登陆成功",__APP__.'/Admin/Index/index/lingpai/'.$lingpai,2);
				
			}
		}
	}
	
	public function logout(){
		$_SESSION['lingpai'] = array();
		$_SESSION['username'] = array();
		$this->success("退出成功",__APP__.'/Admin/Index/login/',2);
				
		
	}
	
	
	//会员管理的 增删改查 搜索分页
	public function userList(){
		
		$username = empty($_POST["username"])?"":$_POST["username"];
		$data["username"] = $username;
		$numPerPage = empty($_REQUEST["numPerPage"])?"10":$_REQUEST["numPerPage"];
		
		$user = M('user'); // 实例化User对象
		
		if(!empty($username)){
			$count      = $user->where($data)->count();// 查询满足要求的总记录数
		}else{
			$count      = $user->count();// 查询满足要求的总记录数
		}
		$Page       = new \Think\Page($count,$numPerPage);// 实例化分页类 传入总记录数和每页显示的记录数(25)
		$show       = $Page->show();// 分页显示输出
		// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
		if(!empty($username)){
			$list = $user->where($data)->limit($Page->firstRow.','.$Page->listRows)->order("id asc")->select();
		}else{
			$list = $user->limit($Page->firstRow.','.$Page->listRows)->order("id asc")->select();
		}
		$this->assign('list',$list);// 赋值数据集
		$this->assign('page',$show);// 赋值分页输出
		$this->assign('username',$username);
		
		$this->assign('totalCount',$count);             //总条数
		$this->assign('numPerPage',$Page->listRows);      //每页显示多少条
		$this->assign('page',$Page);
		$this->assign('pageNumShown',10);    //行显示多少页码
		$currentPage = empty($_REQUEST["pageNum"])?1:$_REQUEST["pageNum"];
		
		$this->assign('currentPage',$currentPage);      //当前是第几页
		
		$this->display();
	}
	public function userAdd(){ 
		$this->display();
	}
	public function userAddEdit(){
		
		$data["username"] = $_POST["username"];
		$data["password"] = $_POST["password"];
		$data["email"] = $_POST["email"];
		$time1 = time();
		$time = date("Y年m月d日",$time1);
		$data["time"] = $time;
		$user = M("user")->add($data);
		if($user){
			$this->success("添加成功");
		}else{
			$this->error("添加失败");
		}
		
	}
		
	public function userDelete(){
		
		$data["id"] = $_GET["uid"];
		$user = M("user")->where($data)->delete();
		if($user){
			$this->success("删除成功");
		}else{
			$this->error("删除失败");
		}
		
		
	}
	
	public function userEdit(){
		
		$data["id"] = $_GET["uid"];
		$user = M("user")->where($data)->select();
		$this->assign('list',$user);
		$this->display();
	}
	
	public function userEditEdit(){
		$id = $_POST["id"];
		$data["username"] = $_POST["username"];
		$data["password"] = $_POST["password"];
		$data["email"] = $_POST["email"];
		
		$user = M("user")->where("id=$id")->save($data);
		
		if($user){
			$this->success("修改成功");
		}else{
			$this->error("修改失败");
		}
		
	}
	
	public function verify_c(){
		$Verify = new \Think\Verify();  
		$Verify->fontSize = 20;  
		$Verify->length   = 4;  
		$Verify->useNoise = false;  
		$Verify->codeSet = '0123456789';  
		$Verify->imageW = 130;  
		$Verify->imageH = 50;  
		//$Verify->expire = 600;  
		$Verify->entry();
	}

	
		
}
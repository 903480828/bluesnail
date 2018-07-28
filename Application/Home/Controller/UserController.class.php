<?php
namespace Home\Controller;
use Think\Controller;
class UserController extends CommonController {
    public function index(){
		parent::index();
		if(empty($_COOKIE['username'])){
			$this -> display('login');
		}else{
			echo'<script language="javascript">window.history.back(-1);</script>';
		}
		
	}
	
	public function register(){
		parent::index();
		
		//var_dump($_SESSION);
		$this -> display('register');
		
	}
	
	public function login(){
		header("Content-Type: text/html;charset=utf-8");
		$data['username'] = $_POST['email'];
		$data['password'] = $_POST['password'];
		$data['stat'] = 1;
		$list = M('user') -> where($data) ->select();
		$username = $list[0]['name'];
		$thum = $list[0]['thum'];
		$id = $list[0]['id'];
		if(!empty($id)){
			cookie('username',$username);
			cookie('thum',$thum);
			cookie('id',$id);
			$urls = cookie('url_current');
			$url = empty($urls)?'{:U("Home/Index/index")}':$urls;
			//echo '<script language="javascript">window.location.href="'.$url.'";</script>';
			$this->success("登陆成功",U("Home/Index/index"),1);
			
		}else{
			$this->error("账号或密码错误",U('Home/User/index'),2);
		}
	}
	
	public function logout(){
		cookie('username' , null);
		cookie('thum' , null);
		cookie('id' , null);
		// setcookie("username");
		// setcookie("thum");
		// setcookie("id");
		echo '<script language="javascript">window.location.href="'.U("Home/Index/index").'";</script>';
	}
	
	/* public function zhuceadd(){
		
		$name = $_POST['name'];
		$email = $_POST['email'];
		$password = $_POST['password'];
		$times=date('Y-m-d h:i:s',time());
		$code = time();
		
		$data['username'] = $email;
		$data['name'] = $name;
		$data['password'] = $password;
		$data['code'] = $code;
		$data['createtime'] = $times;
		$data['stat'] = 0;
		$data['thum'] = '/bluesnail/images/upload/img02.jpg';
		
		$user = M('user') -> add($data);
			
		if($user){
			$emailcontent.='<html><head></head><body><div style="font-family:黑体;min-height:300px; background:#57bfaa;min-width:300px;max-width: 1000px;border: 0px solid #ccc; margin: auto;">';
			$emailcontent.='<div style="width: 100%;font-size:20px;text-align: center;background: #4484c5; height: 50px;color: #FFF;line-height: 50px">邮箱激活</div>';
			$emailcontent.='<div style="padding: 20px;color: #fff">';
			$emailcontent.='<h3>尊敬的【'.$name.'】你好：</h3>';
			$emailcontent.='<p style="line-height: 30px">您的账号需要激活，请点击以下链接完成邮箱验证：</p>';
			$emailcontent.='<p style="line-height: 30px"><a href="http://lansewoniu.com/'.U("Home/User/codestat").'&users='.$user.'&username='.$email.'&code='.$code.'">http://lansewoniu.com/'.U("Home/User/codestat").'&users='.$user.'&username='.$email.'&code='.$code.'</a></p>';
			$emailcontent.='<p style="line-height: 30px">如果以上链接无法打开，请把上面网页地址复制到浏览器地址栏中打开（该链接在48小时内有效）</p>';
			$emailcontent.='<p style="line-height: 30px">本邮件由蓝色蜗牛系统自动发出，请勿直接回复哦。</p>';
			$emailcontent.='<p style="line-height: 30px">如果您有任何疑问或建议，可以通过邮箱 lansewoniuteam@163.com 联系我们</p>';
			$emailcontent.='<p style="text-align: right;">蓝色蜗牛官方团队</p>';
			$emailcontent.='<p style="text-align: right;">'.$times.'</p>';
			$emailcontent.='</div>';
			$emailcontent.='</div></body></html>';
			if($emailcontent){
				
				if (sendmail($email,'蓝色蜗牛官方团队',$emailcontent)) {
				
					$this->success('发送成功！');
				} else {
					$this->error('发送失败');
				}
			}
		}else{
			$this->error('系统错误，清稍后再试');
		}
		
		
	}
	*/
	
	public function zhuceadd(){
		session_start();
		$verify = I('param.verify');
		//var_dump($_SESSION);
		//var_dump(strtoupper($verify));
		if(!check_verify($verify,'1')){  
			$this->error("亲，验证码输错了哦！",$this->site_url,1);
		}else{
			$name = $_POST['name'];
			$email = $_POST['email'];
			$password = $_POST['password'];
			$times=date('Y-m-d h:i:s',time());
			$code = time();
			
			$data['username'] = $email;
			$data['name'] = $name;
			$data['password'] = $password;
			$data['code'] = $code;
			$data['createtime'] = $times;
			$data['stat'] = 1;
			$data['thum'] = '/bluesnail/images/upload/img02.jpg';
			$user = M('user') -> add($data);
			if($user){
				echo '<script type="text/javascript">window.location.href = "'.U("Home/User/codestat").'&users='.$user.'&username='.$email.'&codes='.$code.'"</script>';
				//echo '<script type="text/javascript">window.location.href = "http://lansewoniu.com/'.U("Home/User/codestat").'&users='.$user.'&username='.$email.'&codes='.$code.'"</script>';
				
			}else{
				$this->error("系统错误，清稍后再试",$this->site_url,1);
			}
		}
		
	}
	
	public function verify_c(){
		session_start();
		$Verify = new \Think\Verify();  
		$Verify->fontSize = 16;  
		$Verify->length   = 4;  
		$Verify->useNoise = false;  
		$Verify->codeSet = '0123456789';  
		$Verify->imageW = 130;  
		$Verify->imageH = 30;  
		$Verify->expire = 600;
		$Verify->entry(1);
	}
	
	public function jiancename(){
		
		$data['name'] = $_POST['name'];
		$user = M('user') -> where($data) -> select();
		if($user){
			$this->ajaxReturn(0);
		}else{
			$this->ajaxReturn(1);
		}
		
		
		
	}
	
	public function jianceemail(){
		
		$data['username'] = $_POST['email'];
		$user = M('user') -> where($data) -> select();
		if($user){
			$this->ajaxReturn(0);
		}else{
			$this->ajaxReturn(1);
		}
		
	}
	
	public function codestat(){
		//session_start();
		$id = $_GET['users'];
		$code = $_GET['codes'];
		$email = $_GET['username'];
		$user = $_GET['users'];
		$users = M('user');
		$time = time() - $code;
		
		$data['id'] = $id;
		$datas = false;
		//$datas = $users -> where(array('username'=>$email,'stat'=>1)) -> select();
		if($datas){
            $this->success('你的账号已经激活，不需要再次激活!',U('Home/User/labels')); 
			session('usersid',$id);
        }else if($time > 172800000){
			$users -> where($data) -> delete();
			$this->error('您的链接已经失效，清重新申请!',U('Home/User/register')); 
			
		}else{
			
			$users -> where($data) -> save(array('stat'=>1));
			if($users){
				//session
				$this->success('激活成功!请填写您的个人标签吧',U('Home/User/labels'));
				session_start();
				session('usersid',$id);
			}else{
				$this->error('激活失败，请重新打开连接',U('Home/User/register'));
			}
		}
		
	}
	
	public function labels(){
		
		session_start();
		//var_dump($_SESSION);
		$id = $_SESSION['usersid'];
		if(!empty($id)){
			
			$data = M('label') -> select();
			
			
			$this -> assign('data',$data);
			$this -> display('label');
		}else{
			
			//$this->error('链接失效，请重新打开连接',U('Home/User/register'),1);
			
		}
	}
	
	public function labeladd(){
		$id = $_POST['id'];
		$data['sflabel'] = $_POST['sf'];
		$data['oldlabel'] = $_POST['old'];
		$data['gxlabel'] = $_POST['gx'];
		$users = M('user') -> where("id = $id") -> save($data);
		if($users){
			$this->ajaxReturn(1);
		}else{
			$this->ajaxReturn(0);
		}
	}

}
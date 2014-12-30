<?php
// 本类由系统自动生成，仅供测试用途
class PublicAction extends Action {
	public function index()
	{
		//如果通过认证跳转到首页
		redirect(__APP__);
	}
	public function login(){
		if($_SESSION[C('USER_AUTH_KEY')]!==NULL){
			$this->redirect('appoint/index');
		}
		else{
			$this->display();
		}
	}

	// 登录检测
	public function checkLogin() {
		if(empty($_POST['account'])) {
			$this->error('请输入用户名');
		}elseif (empty($_POST['password'])){
			$this->error('请输入密码');
		}
		if (empty($_POST['verify'])){
			$this->error('请输入验证码！');
		}
		if($_SESSION['verify'] != md5($_POST['verify'])) {
			$this->error('验证码错误！');
		}
		//生成认证条件
        $map            =   array();
		// 支持使用绑定帐号登录
		$map['account']	= $_POST['account'];
        $map["status"]	=	array("eq",1);
		
		import ( '@.ORG.Util.RBAC' );
        $authInfo = RBAC::authenticate($map);
        //使用用户名、密码和状态的方式进行认证
        if(false === $authInfo) {
            $this->error('用户名不存在或已禁用！');
        }else {
            if($authInfo['password'] != md5($_POST['password'])) {
            	$this->error("密码错误");
            }
			
			$_SESSION[C('USER_AUTH_KEY')]	=	$authInfo['id'];
			$_SESSION["account"]=$authInfo['account'];
		
			$_SESSION["type_id"]=$authInfo['type_id'];
            $_SESSION['administrator']		=	true;

			// 缓存访问权限
            RBAC::saveAccessList();
			$this->success('登录成功！',U('admin/appoint/index/'));

		}
	}
	// 用户登出
    public function logout()
    {
        if(isset($_SESSION[C('USER_AUTH_KEY')])) {
			unset($_SESSION[C('USER_AUTH_KEY')]);
			unset($_SESSION);
			session_destroy();
            $this->success('登出成功！',U('admin/public/login/'));
        }else {
            $this->error('已经登出！');
        }
    }
	public function verify()
    {
		$type	 =	 isset($_GET['type'])?$_GET['type']:'gif';
        import("@.ORG.Util.Image");
        Image::buildImageVerify(4,1,$type);
    }
}
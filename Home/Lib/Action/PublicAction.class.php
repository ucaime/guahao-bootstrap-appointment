<?php
// 本类由系统自动生成，仅供测试用途
class PublicAction extends Action {
	function _initialize() {
		//系统设置
		$model=D("setting");
		$vo=$model->select();
		foreach($vo as $val){
			$map[$val["skey"]]=$val["svalue"];
		}
		$this->assign("vo",$map);
	}
	public function login(){
		$this->display();
	}

	public function save(){
		$model = D("User");
		if (empty($_POST['verify'])){
			$this->error('verify:请输入验证码！');
		}
		if($_SESSION['verify'] != md5($_POST['verify'])) {
			$this->error('verify:验证码错误！');
		}
        if ($vo = $model->create()) {
            $list = $model->add(); 
            if ($list !== false) {
                $this->success('success:注册成功！',U('home/public/login/'));
            } else {
                $this->error('error:数据写入错误！');
            }
        } else {
            $this->error($model->getError());
        }
	}
	public function reg(){
		if(isset($_POST["submit"])){
			//https://jihua.in/
//http://www.bootpi.com/theme/category/4
		}
		$this->display();
	}

	// 登录检测
	public function checkLogin() {
		
		if(empty($_POST['username'])) {
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
		$map['username']	= $_POST['username'];
        $map["status"]	=	array("eq",0);
		
		import ( '@.ORG.Util.RBAC' );
        $authInfo = RBAC::authenticate($map);
        //使用用户名、密码和状态的方式进行认证
        if(NULL === $authInfo) {
            $this->error('用户名不存在或已经列入黑名单，请联系管理员！');
        }else {
            if($authInfo['password'] != md5($_POST['password'])) {
            	$this->error("密码错误");
            }
			$_SESSION[C('USER_AUTH_KEY')]	=	$authInfo['uid'];
			$_SESSION["username"]=$authInfo['username'];
			$_SESSION["mobile"]=$authInfo['mobile'];
			$_SESSION["truename"]=$authInfo['truename'];
            $_SESSION['administrator']		=	true;

			// 缓存访问权限
            RBAC::saveAccessList();
			$this->success('登录成功！',U('home/room/index/'));

		}
	}
	// 用户登出
    public function logout()
    {
        if(isset($_SESSION[C('USER_AUTH_KEY')])) {
			unset($_SESSION[C('USER_AUTH_KEY')]);
			unset($_SESSION);
			session_destroy();
            $this->success('登出成功！',U('home/public/login/'));
        }else {
            $this->error('已经登出！');
        }
    }
	public function verify()
    {
		$type	 =	 isset($_GET['type'])?$_GET['type']:'gif';
		ob_end_clean();
        import("@.ORG.Util.Image");
        Image::buildImageVerify(4,1,$type);
    }
}
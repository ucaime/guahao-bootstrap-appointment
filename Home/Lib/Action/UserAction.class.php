<?php
// 本类由系统自动生成，仅供测试用途
class UserAction extends BaseAction {
	function edit() {
		$name=$this->getActionName();
		$model = D ( $name );
		$vo = $model->where ( 'uid='.$_GET["uid"])->find();

		$this->assign ( 'model', $vo );
		$this->display ();
	}
	public function dosave(){
		$model = D("User");
		if (empty($_POST['verify'])){
			$this->error('请输入验证码！');
		}
		if($_SESSION['verify'] != md5($_POST['verify'])) {
			$this->error('验证码错误！');
		}
        if ($vo = $model->create($_POST,2)) {
			$map["type"]=$_POST["type"];
			$map["truename"]=$_POST["truename"];
			$map["id"]=$_POST["id"];
			$map["cardid"]=$_POST["cardid"];
			$map["mobile"]=$_POST["mobile"];
			$map["address"]=$_POST["address"];
			$map["type"]=$_POST["type"];
			$map["uid"]=$_POST["uid"];
            $list = $model->save($map); 
            if ($list !== false) {
                $this->success('数据保存成功！',U('home/user/edit/'));
            } else {
				dump($model);
                $this->error('数据写入错误！');
            }
        } else {
            $this->error($model->getError());
        }
	}
	
	// 检查用户是否登录
	protected function checkUser() {
		if(!isset($_SESSION[C('USER_AUTH_KEY')])) {
			$this->assign('jumpUrl','Public/login');
			$this->error('没有登录');
		}
	}
	// 更换密码
    public function changePwd()
    {
		$this->checkUser();
        //对表单提交处理进行处理或者增加非表单数据
		if(empty($_POST["oldpassword"])){
            $this->error('旧密码不能为空');
		}
		$newpassword=$_POST["newpassword"];
		if(empty($newpassword)){
            $this->error('新密码不能为空');
		}
		$length  =  mb_strlen($newpassword,'utf-8');
		if($length<6 || $length>16){
            $this->error('新密码长度应为6~16位字符');
		}
		if($_POST['newpassword']!=$_POST['renewpassword']){
            $this->error('确认密码不正确');
		}
		$map	=	array();

        if(isset($_SESSION[C('USER_AUTH_KEY')])) {
            $map['uid']		=	$_SESSION[C('USER_AUTH_KEY')];
        }
        //检查用户
        $User    =   M("User");
        if(!$User->where($map)->field('uid')->find()) {
            $this->error('旧密码不符或者用户名错误！');
        }else {
			
			$User->password	=	md5($newpassword);
			$User->save();
			$this->success('密码修改成功！');
         }
    }
}
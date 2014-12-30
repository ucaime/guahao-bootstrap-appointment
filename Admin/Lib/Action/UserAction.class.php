<?php
// 本类由系统自动生成，仅供测试用途
class UserAction extends BaseAction {
	public function update(){
		$status=$_POST["status"];
		//删除指定记录
		$name=$this->getActionName();
		$model = M ($name);
		if (! empty ( $model )) {
			$pk = $model->getPk ();
			$id = $_REQUEST [$pk];
			if (isset ( $id )) {
				$condition = array ($pk => array ('in', explode ( ',', $id ) ) );
				$list=$model->where ( $condition )->setField ( 'status', $status );	
			
				if ($list!==false) {
					$this->ajaxReturn("","操作成功",1);
				} else {
					$this->ajaxReturn("","操作失败",0);
				}
			} else {
					$this->ajaxReturn("","参数非法",0);
			}
		}
	}

	public function adminlist(){
		$admin = D("Admin");
		$list=$admin->where(array("type_id"=>"1"))->select();
		$this->assign("list",$list);
		$this->display();
	}
	public function create(){

		$admin = D("Admin");
        if ($admin->create($_POST)) {
			$result="";
			if($_POST['id']!=""){
				$data["id"]=$_POST["id"];
				$data["info"]=$_POST["info"];
				$list=$admin->save($data);
				$result="修改用户成功";
			}
			else{				
				$list=$admin->add();
				$result="添加用户成功";
			}
            //如果你的主键是自动增长类型，并且如果插入数据成功的话，add方法的返回值就是最新插入的主键值，可以直接获取。
			
            if ($list !== false) {
				$this->success($result);  
            } else {
				$this->error($admin->getError());
            }
        } else { 
			$this->error($admin->getError());
        }

	}
	/**
     +----------------------------------------------------------
	 * 默认删除操作
     +----------------------------------------------------------
	 * @access public
     +----------------------------------------------------------
	 * @return string
     +----------------------------------------------------------
	 * @throws ThinkExecption
     +----------------------------------------------------------
	 */
	public function delete() {
		//删除指定记录
		$name=$this->getActionName();
		$model = M ($name);
		if (! empty ( $model )) {
			$pk = $model->getPk ();
			$id = $_REQUEST [$pk];
			if (isset ( $id )) {
				$condition = array ($pk => array ('in', explode ( ',', $id ) ) );
				$list=$model->where ( $condition )->delete();	
				
				$appoint=M("appoint");
				$appoint->where($condition)->delete();
			
				if ($list!==false) {
					$this->ajaxReturn("","删除成功",1);
				} else {
					$this->ajaxReturn("","删除失败",0);
				}
			} else {
					$this->ajaxReturn("","参数非法",0);
			}
		}
	}	
	public function deleteadmin() {
		//删除指定记录
		$model = M ("admin");
		if (! empty ( $model )) {
			$pk = $model->getPk ();
			$id = $_REQUEST [$pk];
			if (isset ( $id )) {
				$condition = array ($pk => array ('in', explode ( ',', $id ) ) );
				$list=$model->where ( $condition )->delete();	
			
				if ($list!==false) {
					$this->success("删除成功");
				} else {
					$this->error("删除失败");
				}
			} else {
					$this->error("参数非法");
			}
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
            $map['id']		=	$_SESSION[C('USER_AUTH_KEY')];
        }
        //检查用户
        $User    =   M("admin");
        if(!$User->where($map)->field('id')->find()) {
            $this->error('旧密码不符或者用户名错误！');
        }else {
			
			$User->password	=	md5($newpassword);
			$User->save();
			$this->success('密码修改成功！');
         }
    }
}
<?php
// 本类由系统自动生成，仅供测试用途
class DoctorAction extends BaseAction {
	
	//赋值文章可用分类
	public function _before_index() {
		$model=M("room");
		//显示列表分类并且状态正常的
		$list = $model->order('rid desc')->select();
		$this->assign('room',$list);
	}
	public function add(){
		$this->display();
	}
	public function save() {
		$doctor = D("Doctor");
        if ($doctor->create($_POST)) {
			$did=$_POST['did'];
			$result="修改医生成功";
			if($did=="0"){
				$did = $doctor->add();
				$result="添加医生成功";
			}
			else
				$doctor->save();
            //如果你的主键是自动增长类型，并且如果插入数据成功的话，add方法的返回值就是最新插入的主键值，可以直接获取。
			
			//处理schedule
			$model=D("schedule");
			$rid=$_POST['rid'];
			$array = $_POST['s'];
			foreach($array as $key=>$val){
				$s=explode("_", $key);
				$map=array();
				$map['rid']=$rid;
				$map['did']=$did;
				$map['week']=$s[0];
				$map['noon']=$s[1];
				if($model->where($map)->count()==0){//插入
					if($val!="" && $val!==0){
						$map['limit']=$val;
						$model->add($map);
					}
				}
				else{//修改		
							
					if($val=="" || $val=="0")	{
						$model->where($map)->delete();
					}
					else{
						$model->where($map)->setField('limit',$val);
					}
				}
			}

            if ($did !== false) {
				$this->success($result);  
            } else {
				$this->error($doctor->getError());
            }
        } else {
			//$this->ajaxReturn("",$_POST["intro"],0);   
			$this->error($doctor->getError());
        }
	}
	public function edit() {
		$model = M ( "schedule" );
		$map['did']=$_GET['did'];
		$vo = $model->where ($map)->select();
		//var_dump($this->ajaxReturn($vo,"ok",1,"JSON"));
		$this->ajaxReturn($vo,"ok",1,"JSON");
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
				$appoint=M("schedule");
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

}
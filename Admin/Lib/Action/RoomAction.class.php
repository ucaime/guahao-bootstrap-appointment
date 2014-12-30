<?php
// 本类由系统自动生成，仅供测试用途
class RoomAction extends BaseAction {

	public function add(){
		$model=M("room");
		$map["rid"]=$_POST['rid'];
		$map["name"]=$_POST['name'];
		$map["state"]=$_POST['state'];
		$map["delayed"]=$_POST['delayed'];
		$map["intro"]=$_POST['intro'];
		if(!empty($_FILES['img']['name'])){
			//如果有文件上传 上传附件 
            import("@.ORG.Util.UploadFile"); 
			//导入上传类 
			$upload = new UploadFile(); 
			//设置上传文件大小 
			$upload->maxSize = 3292200; 
			//设置上传文件类型 
			$upload->allowExts = explode(',', 'jpg,gif,png,jpeg'); 
			//设置附件上传目录 
			$upload->savePath = './Public/Uploads/'; 
			//设置上传文件规则 
			$upload->saveRule = uniqid;  
			$imgpath="";
			if (!$upload->upload()) { 
				//捕获上传异常 
				$this->ajaxReturn("",$upload->getErrorMsg(),0); 
			} else { 
				//取得成功上传的文件信息 
				$uploadList = $upload->getUploadFileInfo(); 
				//$uploadList[0]['savepath']
				$map["img"]='Uploads/'.$uploadList[0]['savename'];
			} 
		}
		if($map['rid']!=""){
			$flag=$model->save($map);
			if ($flag) { 
				$this->success("修改科室成功"); 
			} else { 
				$this->error($model->getError()); 
			}
		}
		else{
			//保存当前数据对象 
			if ($model->add($map)) { 
				$this->success("添加科室成功"); 
			} else { 
				$this->error($model->getError()); 
			} 
		}
	}

	
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
				if ($list!==false) {			
					$appoint=M("appoint");
					$appoint->where($condition)->delete();
					$schedule=M("schedule");
					$schedule->where($condition)->delete();
					$doctor=M("doctor");
					$doctor->where($condition)->delete();
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
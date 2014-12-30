<?php
// 本类由系统自动生成，仅供测试用途
class AppointAction extends BaseAction {
	function save() {
		$model = M("appoint");
		 // 要修改的数据对象属性赋值
		$data['aid'] = $_GET['aid'];
		$data['state'] = $_GET['state'];
		if ($model->save($data)) { 
            $this->ajaxReturn("","success",1); 
        } else { 
            $this->ajaxReturn("","error",0); 
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
<?php
// 本类由系统自动生成，仅供测试用途
class SettingAction extends BaseAction {
	public function index(){
		
		$this->display();
	}

	public function save(){
		$model=D("setting");
		foreach($_POST as $k => $v){
			if($k == 'submit')continue;
			$map["skey"]=$k;
			//var_dump($k.'|'.$v);
			$model->where($map)->setField('svalue',$v);
		}
		$this->success("保存成功");
	}
}
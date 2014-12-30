<?php
//公共模块
class BaseAction extends Action {

	function _initialize() {
		if($_SESSION[C('USER_AUTH_KEY')]==NULL) {
            $this->redirect('Public/login');
		}
		$this->assign("username",$_SESSION["account"]);
		$this->assign("type_id",$_SESSION["type_id"]);
		$this->assign("controllers", $this->getActionName());
		$doctortype = array('普通','主治','专家','特殊专家');
		$this->assign("doctortype",$doctortype);
		//系统设置
		$setting=D("setting");
		if(isset($_POST['submit'])){
			
		}
		else{
			$vo=$setting->select();
			foreach($vo as $val){
				$map[$val["skey"]]=$val["svalue"];
			}
			$this->assign("setting",$map);
		}
    }
	public function index() {
		//列表过滤器，生成查询Map对象
		$name=$this->getActionName();
		$name=strtolower($name);
		
		if($name=="appoint"){
			$name="AppointView";
			$sortBy="addtime desc";
		}
		else if($name==("doctor")){
			$name="DoctorView";
			$sortBy="did desc";
		}
		
		$map = $this->_search ($name);
		$model = D ($name);
		if (! empty ( $model )) {
			$this->_list ( $model, $map,$sortBy );
		}
		
		$this->display ();
		return;
	}
	protected function _list($model, $map, $sortBy = '', $asc = false) {
		
		//自定义
        import("@.ORG.Util.Page");       //导入分页类
        $count = $model->where($map)->count();    //计算总数
        $p = new Page($count, '');
        $list = $model->where($map)->order($sortBy)->limit($p->firstRow . ',' . $p->listRows)->select();
		
		//var_dump($model);
        /* 
          默认值为$config = array('header'=>'条记录','prev'=>'上一页','next'=>'下一页','first'=>'第一页','last'=>'最后一页', 
          'theme'=>' %totalRow% %header% %nowPage%/%totalPage% 页 %upPage% %downPage% %first%  %prePage%  %linkPage%  %nextPage% %end%'); 
          修改显示的元素的话设置theme就行了，可对其元素加class 
         */ 

        $p->setConfig('theme', ' %upPage%  %first%  %prePage%  %linkPage%  %nextPage%  %downPage% %end%'); 

        $page = $p->show();            //分页的导航条的输出变量
        $this->assign("page", $page);
        $this->assign("list", $list); //数据循环变量
        return;
	}
	
	/**
     +----------------------------------------------------------
	 * 根据表单生成查询条件
	 * 进行列表过滤
     +----------------------------------------------------------
	 * @access protected
     +----------------------------------------------------------
	 * @param string $name 数据对象名称
     +----------------------------------------------------------
	 * @return HashMap
     +----------------------------------------------------------
	 * @throws ThinkExecption
     +----------------------------------------------------------
	 */
	protected function _search($name = '') {		
		
		if($name==("DoctorView")){
			$name="doctor";
		}
		$name=strtolower($name);
		$model = D ( $name );
		$map = array ();
		foreach ( $model->getDbFields () as $key => $val ) {
			if (isset ( $_REQUEST [$val] ) && $_REQUEST [$val] != '') {
				
				if($val=='state'){
					if($_REQUEST['state']!=0)$map['state']=$_REQUEST['state'];
				}else{
					if($name=="user" || $name=="appointview"){
						$map[$val] = array('like','%'.$_REQUEST [$val].'%');
					}
					else{
						$map [$val] = $_REQUEST [$val];
					}
				}
			}
		}
		if($name=="appointview"){
			$map['day'] = array('like','%'.$_REQUEST ['day'].'%');
			$map['id'] = array('like','%'.$_REQUEST ['id'].'%');
			$map['truename'] = array('like','%'.$_REQUEST ['truename'].'%');
			if($_REQUEST['state']!=0)$map['state']=$_REQUEST['state'];
		}
		return $map;
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
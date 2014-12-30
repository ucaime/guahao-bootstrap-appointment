<?php
// 本类由系统自动生成，仅供测试用途
class BaseAction extends Action {	
	function _initialize() {	
		if($_SESSION[C('USER_AUTH_KEY')]!==NULL) {
			//$this->display();
			$this->assign("uid",$_SESSION[C('USER_AUTH_KEY')]);
			$this->assign("username",$_SESSION["username"]);
			define("uid",$_SESSION[C('USER_AUTH_KEY')]);
			define("username",$_SESSION["username"]);
			define("mobile",$_SESSION["mobile"]);
			define("truename",$_SESSION["truename"]);
		}else{
			redirect(U('home/public/login/'));
		}
		$this->assign("controllers", $this->getActionName());
		//系统设置
		$model=D("setting");
		if(isset($_POST['submit'])){
			
		}
		else{
			$vo=$model->select();
			foreach($vo as $val){
				$map[$val["skey"]]=$val["svalue"];
			}
			define("appointday",$map["appointDay"]);
			define("smstpl",$map["smstpl"]);
			define("sitename","【".$map["sitename"]."】");
			$this->assign("vo",$map);
		}
    }

	
	public function index() {
		//列表过滤器，生成查询Map对象
		$name=$this->getActionName();
		$name=strtolower($name);
		
		if($name==("appoint")){			
			$map['uid']=uid;
			$name="AppointView";
			$sortBy="day desc";
		}
		else if($name==("doctor")){
			$name="DoctorView";
			$sortBy="did desc";
		}
		
		$map = $this->_search ($name);
		
		if (method_exists ( $this, '_filter' )) {
			$this->_filter ( $map );
		}
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
		$map = array ();
		if($name==("AppointView")){
			$name="Appoint";
			$map['uid']=uid;
		}
		else if($name==("DoctorView")){
			$name="doctor";
		}
		$model = D ( $name );
		foreach ( $model->getDbFields () as $key => $val ) {
			if (isset ( $_REQUEST [$val] ) && $_REQUEST [$val] != '') {
				
				if($val=='state'){
					if($_REQUEST['state']!=0)$map['state']=$_REQUEST['state'];
				}else{
					$map [$val] = $_REQUEST [$val];
				}
			}
		}
		return $map;
	}
	
	
}
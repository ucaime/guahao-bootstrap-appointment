<?php
// 本类由系统自动生成，仅供测试用途
class RoomAction extends BaseAction {

	public function detail(){
		$appdata['uid']=uid;
		$appdata['addtime']=array('EGT',strtotime(date ("Y-m-d")));

		$app=M("appoint");
		$appoint=$app->where($appdata)->count('aid');
		
		$this->assign("appoint",$appoint);
		$this->assign("name",$_GET["name"]);
		$this->assign("rid",$_GET["rid"]);
		$this->display();
	}

	public function json(){
		$data["rid"]=$_GET["rid"];
		$sc["rid"]=$_GET["rid"];
		$schedule=M("schedule");
		$appoint=M("appoint");
		$room=M("room")->where(array('rid'=>$_GET['rid']))->find();
		//$list=M("schedule")->group('week')->where($data)->field('did,sum(`limit`) limits,week')->select();
		$delayed=0;
		if(isset($room)){
			$delayed=$room['delayed'];
		}
		
		for($i = $delayed;$i < appointday+$delayed;$i++){
			$day=date('Y-m-d',strtotime('+'.$i.' day'));
			$week=$this->getWeek($day);
			$sc["week"]=$week;
			//按周几 获取对应 科室的总预约数
			$count=$schedule->where($sc)->sum("`limit`");
			if($count!==NULL){
				$data["day"]=$day;
				$data['state']  = array('neq',3);
				$counted=$appoint->where($data)->count('aid');
				if($count>$counted){
					$map[]= array(
						'id'=>$week,
						'title' => '预约',
						'start' => $day,
						'end' => $day,
						'backgroundColor'=>'#428bca'
						
					);
				}else{
					$map[]= array(
						'title' => '已满',
						'start' => $day,
						'end' => $day,
						'backgroundColor'=>'red',
					);
				}
			}
		}
		$this->ajaxReturn($map,'JSON');
	} 

	public function getappoint(){
		header("Content-type: text/html; charset=utf-8"); 
		$day=$_GET["day"];
		$week=$_GET["week"];
		$rid=$_GET["rid"];
		$data['j_schedule.rid']=$rid;
		$data['week']=$week;
		//$list=M("schedule")->where($data)->select();
		$model=M("schedule");
		$list=$model->join('LEFT JOIN j_doctor ON j_schedule.did = j_doctor.did')->where($data)->order(" week asc")->select();
//dump($list);
		$app=M("appoint");
		$a["day"]=$day;
		$a["rid"]=$rid;
		$a['state']  = array('neq',3);
		foreach($list as $k=>$v){
			$a["noon"]=$list[$k]["noon"];
			$a["did"]=$list[$k]["did"];
			$count=$app->where($a)->count("aid");
			//var_dump($app);
			$list[$k]['shengyu']=$list[$k]['limit']-$count;
		}
		$data["day"]=$day;
		$appoint_list=M("appoint")->where($data)->select();
		$this->ajaxReturn($list,'JSON');
		
		/*SELECT s . * , d.name
FROM  `j_schedule` AS s
LEFT JOIN  `j_doctor` AS d ON s.did = d.did
WHERE 1 
LIMIT 0 , 30*/
	}

	public function getWeek($day){
	  $days = array('周日','周一','周二','周三','周四','周五','周六');
	  $day = explode('-',$day);
	  return $days[date('w',mktime(0,0,0,$day[1],$day[2],$day[0]))];
	}
}
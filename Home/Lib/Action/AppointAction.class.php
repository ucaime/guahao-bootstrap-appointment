<?php
// 本类由系统自动生成，仅供测试用途
class AppointAction extends BaseAction {

	public function ajaxsave(){
		$model=D("Appoint");
		$data["uid"]=$_GET['uid'];
		$data["rid"]=$_GET['rid'];
		$data["did"]=$_GET['did'];
		$data["day"]=$_GET['day'];
		$data["noon"]=$_GET['noon'];
		$data["time"]=$_GET['time'];
		$data["addtime"]=strtotime(date ("Y-m-d H:i:s"));
		$data["state"]=1;
		$roomname=$_GET['roomname'];
		$name=$_GET['name'];
		$datatime=$data["day"];
		if($model->create($data)){

			$vo=$model->add($data);
			if($vo){
				//挂号成功发送短信到用户手机号
				//尊敬的客户您好，您注册帐号是[%用户帐号%],您预约了[%科室%][%医生%]，就诊时间是[%就诊时间%]，请您携带有效证件按时就诊！[%医院%]
				$setting=M("setting")->where(array("skey"=>"smstpl"))->find();
				$authinfo=M("user")->where(array("uid"=>uid))->find();				
				$msg=$setting['svalue'];
				if($authinfo!==NULL){					
					$msg=str_replace("[%用户帐号%]", $authinfo['username'], $msg);
					$msg=str_replace("[%科室%]", $roomname, $msg);
					$msg=str_replace("[%医生%]", $name, $msg);
					$msg=str_replace("[%就诊时间%]", $datatime, $msg);
					$msg=str_replace("[%医院%]", "【绍兴瑞金医院】", $msg);
					$msg=str_replace("[%患者名字%]", $authinfo['truename'], $msg);
					$map['mobile']= $authinfo['mobile'];

					//print $msg;
					$map['content']=$msg;
					$result=$this->sendMsg($map['mobile'],$msg);
					//var_dump($result);
					if($result === false){
						$map["state"]=1;
					}else{	
						$map["state"]=0;
					}
					M("sms")->add($map);
				}
				$this->success("挂号成功");
			}else{
				$this->error("挂号失败");
			}
		}
		else{
			$this->error($model->getError());
		}	
	}
	public function sendMsg($mobile,$msg){
		//%B2%E2%CA%D4%A1%BE%C9%DC%D0%CB%C8%F0%BD%F0%D2%BD%D4%BA%A1%BF
		
		$url="http://202.85.222.10:8686/SMSPortal/send?spid=bjyt&spno=0069&pwd=bjyt0069&dt=".$mobile."&msg=".urlencode(mb_convert_encoding($msg, 'gb2312', 'utf-8'));
		$msg = file_get_contents($url);
		return strpos($msg,'result="0"');
	}
	public function save() {
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
}
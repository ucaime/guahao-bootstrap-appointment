<?php
class DoctorViewModel extends ViewModel {
	public $viewFields = array(
     'doctor'=>array('did','name'=>'name','intro','type','_type'=>'LEFT'),
     'room'=>array('rid','name'=>'rname','_on'=>'doctor.rid=room.rid'),
   );
	// �Զ���֤����
    protected $_validate = array(
        array('name', 'require', '������룡', 1),//1Ϊ������֤
        array('rid', 'require', '���ұ��룡', 1),//2Ϊ��Ϊ��ʱ��֤
        array('type', 'require', '������룡', 1),//2Ϊ��Ϊ��ʱ��֤
    );
}

?>
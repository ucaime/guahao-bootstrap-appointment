<?php
class AppointViewModel extends ViewModel {

    public $viewFields = array(
     'appoint'=>array('aid','day','time','state','_type'=>'LEFT','addtime'),
     'user'=>array('uid','truename','id','mobile','tel','birthday','type'=>'sex','address','_on'=>'appoint.uid=user.uid','_type'=>'LEFT'),
     'room'=>array('rid','name','img','intro','_on'=>'appoint.rid=room.rid','_type'=>'LEFT'),
     'doctor'=>array('did','name'=>'dname','intro'=>'dintro','type'=>'dtype','_on'=>'appoint.did=doctor.did','_type'=>'LEFT'),
   );
}

?>
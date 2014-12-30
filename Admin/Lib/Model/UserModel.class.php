<?php
class UserModel extends CommonModel {
	public $_validate	=	array(
		array('account','/^[a-z]\w{3,}$/i','�ʺŸ�ʽ����'),
		array('password','require','�������'),
		array('nickname','require','�ǳƱ���'),
		array('repassword','require','ȷ���������'),
		array('repassword','password','ȷ�����벻һ��',self::EXISTS_VALIDATE,'confirm'),
		array('account','','�ʺ��Ѿ�����',self::EXISTS_VALIDATE,'unique',self::MODEL_INSERT),
		);
	public $_auto		=	array(
		array('password','pwdHash',self::MODEL_BOTH,'callback'),
		array('create_time','time',self::MODEL_INSERT,'function'),
		array('update_time','time',self::MODEL_UPDATE,'function'),
		);

	protected function pwdHash() {
		if(isset($_POST['password'])) {
			return pwdHash($_POST['password']);
		}else{
			return false;
		}
	}
}

?>
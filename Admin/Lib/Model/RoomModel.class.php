<?php
class RoomModel extends CommonModel {
	// �Զ���֤����
    protected $_validate = array(
        array('name', 'require', '������룡', 1),//1Ϊ������֤
        array('name', '', '�����Ѿ�����', 0, 'unique', self::MODEL_INSERT),
    );
}

?>
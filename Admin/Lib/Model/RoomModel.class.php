<?php
class RoomModel extends CommonModel {
	// 自动验证设置
    protected $_validate = array(
        array('name', 'require', '标题必须！', 1),//1为必须验证
        array('name', '', '科室已经存在', 0, 'unique', self::MODEL_INSERT),
    );
}

?>
<?php
class DoctorModel extends Model {
	// 自动验证设置
    protected $_validate = array(
        array('name', 'require', '标题必须！', 1),//1为必须验证
        array('rid', 'require', '科室必须！', 1),//2为不为空时验证
        array('type', 'require', '级别必须！', 1),//2为不为空时验证
        array('name', '', '医生已经存在', 0, 'unique', self::MODEL_INSERT),
    );
}

?>
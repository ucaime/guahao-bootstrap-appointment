<?php

class UserModel extends Model {
	public $_validate	=	array(
		array('username','require', 'username:用户名不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
        array('username', '', 'username:用户名已经存在', self::MUST_VALIDATE, 'unique', self::MODEL_INSERT),
		array('username', '2,16', "username:用户名不合法", self::EXISTS_VALIDATE, 'length'), //用户名长度不合法
		array('password', '6,16', "password:密码长度不合法", self::MUST_VALIDATE, 'length',self::MODEL_INSERT), //密码长度不合法		
		array('repassword','require','repassword:确认密码不能为空'),
		array('password','repassword','password:确认密码不一致',self::MUST_VALIDATE,'confirm'),
		array('truename','require','truename:真实姓名不能为空'),
		array('id','require','id:请输入身份证',self::MUST_VALIDATE,'regex',self::MODEL_INSERT),/* 验证手机号码 */
		array('id', '', 'id:身份证已经存在了', self::MUST_VALIDATE, 'unique', self::MODEL_INSERT),		
		array('id','/(^\d{15}$)|(^\d{17}([0-9]|X|x)$)/','id:输入的身份证号长度不对,15位号码应全为数字，18位号码末位可以为数字或X。',self::MUST_VALIDATE),/* 验证手机号码 */
		array('mobile', '#^13[\d]{9}$|14^[0-9]\d{8}|^15[0-9]\d{8}$|^18[0-9]\d{8}$#', "mobile:手机格式不正确", self::MUST_VALIDATE), //手机格式不正确 TODO:
		//array('phone','11','电话长度不符！',3,'length')
		//#^[\d]{15}$|^[\d]{18}$#
		//array('mobile', '', "手机号码被占用", self::EXISTS_VALIDATE, 'unique'), //手机号被占用
	);

	public $_auto		=	array(
		array('password','md5',3,'function'),
		array('addtime', NOW_TIME, self::MODEL_INSERT),
		array('regIp', 'get_client_ip', self::MODEL_INSERT, 'function', 1),
	);

	/**
     * 用正则表达式验证手机号码(中国大陆区)
     * @param integer $num    所要验证的手机号
     * @return boolean
     */
    public static function isMobile($num) {
        if (!$num) {
            return false;
        }
        return preg_match('#^13[\d]{9}$|14^[0-9]\d{8}|^15[0-9]\d{8}$|^18[0-9]\d{8}$#', $num) ? true : false;
    }
	/**
     * 正则表达式验证身份证号码
     *
     * @param integer $num    所要验证的身份证号码
     * @return boolean
     */
    public static function isPersonalCard($num) {
        if (!$num) {
            return false;
        }
        return preg_match('#^[\d]{15}$|^[\d]{18}$#', $num) ? true : false;
    }
}

?>
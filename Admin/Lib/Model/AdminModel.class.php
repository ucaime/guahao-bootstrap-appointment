<?php

class AdminModel extends Model {
	public $_validate	=	array(
		array('account','require', '用户名不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_INSERT),
        array('account', '', '用户名已经存在', self::EXISTS_VALIDATE, 'unique', self::MODEL_INSERT),
		array('account', '3,16', "用户名长度超出", self::EXISTS_VALIDATE, 'length'), //用户名长度不合法
		array('password', '6,16', "密码长度不合法", self::EXISTS_VALIDATE, 'length',self::MODEL_INSERT), //密码长度不合法		
		array('repassword','require','确认密码不能为空',self::MUST_VALIDATE, 'regex', self::MODEL_INSERT),
		array('password','repassword','确认密码不一致',self::MUST_VALIDATE,'confirm'),
	);

	public $_auto		=	array(
		array('password','md5',3,'function'),
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
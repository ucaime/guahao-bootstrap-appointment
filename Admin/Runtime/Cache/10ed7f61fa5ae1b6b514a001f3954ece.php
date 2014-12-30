<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">

<title>预约挂号系统管理中心</title>
<link rel="stylesheet" href="http://cdn.bootcss.com/twitter-bootstrap/3.0.2/css/bootstrap.min.css">
<style>
body {
  background-color: #eee;
}
html,
body {
  height: 100%;
  /* The html and body elements cannot have any padding or margin. */
}
/* Wrapper for page content to push down footer */
#wrap {
  min-height: 100%;
  height: auto;
  /* Negative indent footer by its height */
  margin: 0 auto -60px;
  /* Pad bottom by footer height */
  padding: 0 0 60px;
}


.container .text-muted {
	text-align:center;
	margin: 20px 0;
}
#footer > .container {
  padding-left: 15px;
  padding-right: 15px;
}

/* Set the fixed height of the footer here */
#footer {
  height: 60px;
  background-color: #f5f5f5;
}

.form-signin {
  max-width: 330px;
  padding: 15px;
  margin: 0 auto;
}
.form-signin .form-signin-heading,
.form-signin .checkbox {
  margin-bottom: 10px;
}
.form-signin .checkbox {
  font-weight: normal;
}
.form-signin .form-control {
  position: relative;
  font-size: 16px;
  height: auto;
  padding: 10px;
  -webkit-box-sizing: border-box;
     -moz-box-sizing: border-box;
          box-sizing: border-box;
}
.form-signin .form-control:focus {
  z-index: 2;
}
.form-signin input[type="text"] {
  margin-bottom: -1px;
  border-bottom-left-radius: 0;
  border-bottom-right-radius: 0;
}
.form-signin input[type="password"] {
  margin-bottom: 10px;
  border-top-left-radius: 0;
  border-top-right-radius: 0;
}
</style>
<!-- jQuery文件。务必在bootstrap.min.js 之前引入 -->
<script src="http://cdn.bootcss.com/jquery/1.10.2/jquery.min.js"></script>
<!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
<script src="http://cdn.bootcss.com/twitter-bootstrap/3.0.2/js/bootstrap.min.js"></script>
<script>
$(function(){
	$("#loadimg").on("click",function(){
		var img=$("#verifyImg");	
		img.attr("src",img.attr("src")+"&rand="+Math.random());
	})
	$("form").submit(function(){

		$("[type='submit']").val("正在登录");
		$(".info").html("");
		var self = $(this);
		$.post(self.attr("action"), self.serialize(), success, "json");
		return false;

		function success(data){
			if(data.status){
				$(".info").html("登录成功！").css("color","green");
				window.location.href = data.url;
			} else {
				//self.find(".check-tips").text(data.info);
				$(".info").html(data.info).css("color","red");
				//刷新验证码
				$("#verifyImg").click();
				$("[type='submit']").val("登录");
			}
		}

	})
})
</script>
</head>
<body>
<div id="wrap">
<div><img src="__PUBLIC__/images/bg.jpg"/></div>
<div class="container">
<div class="row" style="margin-top:50px;">
  <div id="box" class="col-xs-3" style="float:none; margin-left:auto; margin-right:auto;">
	<div class="row" style="margin-top:50px;">
		<form name="loginForm" method="post" action="<?php echo U('admin/public/checkLogin/');?>">
			  <div class="input-group input-group-lg">
				<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
				<input type="text" class="form-control" name="account" placeholder="用户名">
			  </div>
			  <br>
			  <div class="input-group input-group-lg">
				<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
				<input type="password" class="form-control" name="password" placeholder="密	码">
			  </div>
			  <br>
			  
			  <div class="form-group">
				 <div class="row">
				 <div class="col-xs-5">
				 <input type="text" name="verify" class="form-control input-lg"
				 placeholder="验证码" />
				 </div>
				 <div class="col-xs-7"><img class="code" id="verifyImg" style="height:42px;" src="<?php echo U('admin/public/verify/');?>" onclick="this.src+='&rand=' + Math.random();" alt="点击刷新验证码" /> <a href="#" id="loadimg">看不清?</a>
				 </div>
				 </div>
			  </div>
			  <div class="form-group">
			  <input type="submit" class="btn btn-primary btn-block btn-lg" value="登录"/>		  
			  <p class="info"></p>
			  </div>
		</form>
	</div>
</div>


</div>
</div> <!-- /container -->
</div>
<div id="footer">
  <div class="container">
	<p class="text-muted">&copy; 2013. Created by <a href="http://ichuan.net/">yc</a> | <a href="#" title="">Help</a> | <a title="" href="#">Changelog</a></p>
  </div>
</div>
</body>
</html>
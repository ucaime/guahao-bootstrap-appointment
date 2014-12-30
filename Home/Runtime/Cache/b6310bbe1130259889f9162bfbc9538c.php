<?php if (!defined('THINK_PATH')) exit();?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">

<title><?php echo ($vo["sitename"]); ?>预约系统</title>
<link rel="stylesheet" href="http://cdn.bootcss.com/twitter-bootstrap/3.0.2/css/bootstrap.min.css">
<link rel="stylesheet" href="__PUBLIC__/style/fullcalendar.css">
<style>
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
/* Wrapper for page content to push down footer */
#wrap {
  min-height: 100%;
  height: auto;
  /* Negative indent footer by its height */
  margin: 0 auto -60px;
  /* Pad bottom by footer height */
  padding: 0 0 60px;
}
.alert {
	display: none;
	border-radius: 0;
}
.bs-docs-nav {
	text-shadow: 0 -1px 0 rgba(0,0,0,.15);
	background-color: #563d7c;
	border-color: #463265;
	box-shadow: 0 1px 0 rgba(255,255,255,.1);
}
/* Custom page CSS
-------------------------------------------------- */
/* Not required for template or sticky footer method. */


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

</style>
<!-- jQuery文件。务必在bootstrap.min.js 之前引入 -->
<script src="http://cdn.bootcss.com/jquery/1.10.2/jquery.min.js"></script>
<script src="http://libs.baidu.com/jqueryui/1.10.2/jquery-ui.min.js "></script>
<!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
<script src="http://cdn.bootcss.com/twitter-bootstrap/3.0.2/js/bootstrap.min.js"></script>
<script src="http://cdn.bootcss.com/holder/2.0/holder.min.js"></script>
<script src="__PUBLIC__/scripts/ajaxfileupload.js"></script>
<script src="__PUBLIC__/scripts/insertsome.js"></script>
<script src="__PUBLIC__/scripts/fullcalendar.js"></script>
<script>
$(function(){
	var controller = "<?php echo ($controllers); ?>";
	$("#nav li").each(function (i) {
		if ($(this).attr("controllers") == controller.toLocaleLowerCase())
			$(this).addClass("active");
		else
			$(this).removeClass("active");
	})
	$("#changepwd").click(function(){
		$("#pwdDialog").modal("show");	
	})
	$("#closepwd").click(function(){
		$("#pwdDialog").modal("hide");
		return false;
	})
})
</script>

</head>
<body>
<div id="wrap">
<div><img src="__PUBLIC__/images/bg.jpg"/></div>
<!-- Fixed navbar -->
<div class="navbar navbar-default" role="navigation">
  <div class="container">
	<div class="navbar-header">
	  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
		<span class="sr-only">Toggle navigation</span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
	  </button>
	  <a class="navbar-brand" href="#"><?php echo ($vo["sitename"]); ?>预约系统</a>
	</div>
	<div class="navbar-collapse collapse">
	  <ul class="nav navbar-nav" id="nav">
		<li class="active" controllers="room">
		  <a href="<?php echo U('home/room/index/');?>"><i class="glyphicon glyphicon-home"></i> 我要挂号</a>
		</li>
		<li class="active dropdown" controllers="appoint">
		  <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-list"></i> 预约记录 <b class="caret"></b></a>
		  <ul class="dropdown-menu" controllers="index">
			<li><a href="<?php echo U('admin/appoint/index/',array('state'=>0));?>">全部预约</a></li>
			<li><a href="<?php echo U('admin/appoint/index/',array('state'=>1));?>">已挂号</a></li>
			<li><a href="<?php echo U('admin/appoint/index/',array('state'=>2));?>">已就诊</a></li>
			<li><a href="<?php echo U('admin/appoint/index/',array('state'=>3));?>">已取消</a></li>
			<li><a href="<?php echo U('admin/appoint/index/',array('state'=>4));?>">失约</a></li>
		  </ul>
		</li>
		<li controllers="user"><a href="<?php echo U('admin/user/edit/',array('uid'=>$uid));?>"><i class="glyphicon glyphicon-user"></i> 个人信息</a></li>
	  </ul>
	  <ul class="nav navbar-nav navbar-right">
		<li class="dropdown">
		  <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-user"></i> <?php echo ($username); ?> <b class="caret"></b></a>
		  <ul class="dropdown-menu">
			<li><a href="#" data-url="<?php echo U('admin/user/changepwd/');?>" id="changepwd"><i class="glyphicon glyphicon-lock"></i>  修改密码</a></li>
			<li><a href="<?php echo U('admin/public/logout/');?>"><i class="glyphicon glyphicon-off"></i>  注销</a></li>
		  </ul>
		</li>
	  </ul>
	</div><!--/.nav-collapse -->
  </div>
</div>
<!-- channelResDialog start -->
<div id="pwdDialog" class="modal" tabindex="-1">
	<div class="modal-dialog" style="width: 300px;">
		<div class="modal-content">
			<form role="form" action="<?php echo U('home/user/changePwd/');?>" method="post">
			<div class="modal-body">
				  <div class="form-group">
					<label for="oldpassword">旧密码</label>
					<input type="text" class="form-control" id="oldpassword" name="oldpassword" placeholder="旧密码">
				  </div>
				  <div class="form-group">
					<label for="newpassword">新密码</label>
					<input type="password" class="form-control"  name="newpassword" placeholder="新密码">
				  </div>
				  <div class="form-group">
					<label for="exampleInputPassword1">确认新密码</label>
					<input type="password" class="form-control" name="renewpassword" placeholder="确认新密码">
				  </div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-default" id="closepwd">
					取消
				</button>
				<button type="submit" class="btn btn-primary">保存</button>
			</div>			
			</form>
		</div>
	</div>
</div>
<!-- channelResDialog end -->
<script>
$(function(){
	$("#loadimg").on("click",function(){
		var img=$("#verifyImg");	
		img.attr("src",img.attr("src")+"&rand="+Math.random());
	})
	$("form").submit(function(){
		$(".fade").find("h4").html("");
		$("[type='submit']").val("正在保存");
		var self = $(this);
		$.post(self.attr("action"), self.serialize(), success, "json");
		return false;

		function success(data){
			if(data.status){
				$(".fade").find("h4").html("修改成功！").css("color","green");
				$("[type='submit']").val("马上保存");
				//window.location.href = data.url;
			} else {
				$(".fade").find("h4").html(data.info).css("color","red");
				//刷新验证码
				$("#verifyImg").click();
				$("[type='submit']").val("立即保存");
			}
		}

	})
})
</script>
<div class="container">
<div class="panel panel-primary">
		<div class="panel-heading"><strong>修改个人信息</strong></div>
		<div class="panel-body">
		<div class="row">
		<form class="form-horizontal" method="post" action="<?php echo U('home/user/dosave/');?>">
		<input type="hidden" value="<?php echo ($model["uid"]); ?>" name="uid"/>
		  <div class="form-group row">
			<label for="username" class="col-sm-2 control-label">用户名</label>
			<div class="row">
				<div class="col-xs-3">
				<input type="text" name="username" class="form-control"
				 placeholder="用户名" value="<?php echo ($model["username"]); ?>" />
				 </div>
				 <div class="col-xs-4"><span class="help-block" id="username">中英文均可，4~16位</span>
				 </div>
			</div>
		  </div>
		  
		  <div class="form-group">
			<label for="pwd" class="col-sm-2 control-label">性别</label>
			<div class="col-sm-4">
				<label class="checkbox-inline">
				  <input type="radio" id="type0" name="type" value="0" <?php if(($model["type"]) == "0"): ?>checked<?php endif; ?>> 男
				</label>
				<label class="checkbox-inline">
				  <input type="radio" id="type1" name="type" value="1" <?php if(($model["type"]) == "1"): ?>checked<?php endif; ?>> 女
				</label>
			</div>
		  </div>
		  <div class="form-group">
			<label for="truename" class="col-sm-2 control-label" >真实姓名</label>
			<div class="row">
				<div class="col-xs-3">
				<input type="text" name="truename" class="form-control"
				 placeholder="真实姓名"  value="<?php echo ($model["truename"]); ?>"/>
				 </div>
				 <div class="col-xs-4"><span class="help-block">请填写真实姓名</span>
				 </div>
			</div>
		  </div>
		  <div class="form-group">
			<label for="id" class="col-sm-2 control-label">身份证</label>
			<div class="row">
				<div class="col-xs-3">
				<input type="text" name="id" class="form-control"
				 placeholder="身份证" value="<?php echo ($model["id"]); ?>"/>
				 </div>
				 <div class="col-xs-4"><span class="help-block">请填写身份证</span>
				 </div>
			</div>
		  </div>
		  
		  <div class="form-group">
			<label for="cardid" class="col-sm-2 control-label">医保号</label>
			<div class="row">
				<div class="col-xs-3">
				<input type="text" name="cardid" class="form-control"
				 placeholder="医保号" value="<?php echo ($model["cardid"]); ?>" />
				 </div>
				 <div class="col-xs-4"></div>
			</div>
		  </div>
		  
		  <div class="form-group">
			<label for="mobile" class="col-sm-2 control-label">手机号</label>
			<div class="row">
				<div class="col-xs-3">
				<input type="text" name="mobile" class="form-control"
				 placeholder="手机号" value="<?php echo ($model["mobile"]); ?>"/>
				 </div>
				 <div class="col-xs-4"><span class="help-block">请填写手机号</span></div>
			</div>
		  </div>
		  
		  <div class="form-group">
			<label for="address" class="col-sm-2 control-label">地址</label>
			
			<div class="row">
				<div class="col-xs-6">
				<textarea class="form-control" row="4" name="address"><?php echo ($model["address"]); ?></textarea>
				</div>
			</div>
		  </div>
		  <div class="form-group">
			<label for="verify" class="col-sm-2 control-label">验证码</label>
			<div class="row">
				<div class="col-xs-2">
				<input type="text" name="verify" class="form-control"
				 placeholder="验证码" />
				 </div>
				 <div class="col-xs-2"><img class="code" id="verifyImg" style="height:32px;" src="<?php echo U('home/public/verify');?>" onclick="this.src+='&rand='+Math.random();" alt="点击刷新验证码" /> <a href="#" id="loadimg">看不清?</a>
				 </div>
			</div>
		  </div>
		  <div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
			  <div class="row">			  
				  <div class="col-xs-2">
				  <input class="btn btn-primary" type="submit" value=" 马上保存 "/>
				  </div>				  
				  <div class="col-xs-4" id="tip">
					  <div class="fade in">					  
						<h4></h4>
					  </div>
				  </div>
			  </div>
			</div>
		  </div>
		</form>
		</div>
    </div>
	</div>
</div>

</div> <!-- /container -->

<!-- 主页面结束 -->


<br/><br/>
</div>
<div id="footer">
      <div class="container">
        <p class="text-muted">&copy; 2013. Created by <a href="http://ichuan.net/">yc</a> | <a href="#" title="����">Help</a> | <a title="" href="#">Changelog</a></p>
      </div>
    </div>
</body>
</html>
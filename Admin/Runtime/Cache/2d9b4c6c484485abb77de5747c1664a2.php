<?php if (!defined('THINK_PATH')) exit();?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">

<title><?php echo ($setting["sitename"]); ?>预约系统</title>
<link rel="stylesheet" href="http://cdn.bootcss.com/twitter-bootstrap/3.0.2/css/bootstrap.min.css">
<style>
html,
body {
  height: 100%;
  /* The html and body elements cannot have any padding or margin. */
}

.alert {
	display: none;
	border-radius: 0;
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


</style>
<!-- jQuery文件。务必在bootstrap.min.js 之前引入 -->
<script src="http://cdn.bootcss.com/jquery/1.10.2/jquery.min.js"></script>
<!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
<script src="http://cdn.bootcss.com/twitter-bootstrap/3.0.2/js/bootstrap.min.js"></script>
<script src="__PUBLIC__/scripts/ajaxfileupload.js"></script>
<script src="__PUBLIC__/scripts/insertsome.js"></script>
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
	$(".createadmin").click(function(){
		$("#createDialog").modal("show");	
		if($(this).attr("data-id")!="0"){
			$("#createDialog").find("[type='password']").parent().hide();
			$("[name='account']").val($(this).attr("data-account")).attr("disabled",true);
			$("[name='info']").val($(this).attr("data-info"));
			$("[name='id']").val($(this).attr("data-id"));
		}
		else{
			$("#createDialog").find("[type='password']").parent().show();
			$("[name='account']").attr("disabled",false);
			$("[name='info']").val("");
			$("[name='id']").val("");
		}
	})
	$("#closecreate").click(function(){
		$("#createDialog").modal("hide");
		return false;
	})
	if("<?php echo ($type_id); ?>"=="1"){
		$(".createadmin,#adminlist,#start,.userdelete,#add,.roomedit,.roomdelete,.doctordelete,.doctoredit").attr("disabled","disabled");
		$("#setting,.createadmin,#adminlist").hide();
	}
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
	  <a class="navbar-brand" href="<?php echo U('admin/appoint/index/');?>"><i class="glyphicon glyphicon-home"></i> <?php echo ($setting["sitename"]); ?>预约系统</a>
	</div>
	<div class="navbar-collapse collapse">
	  <ul class="nav navbar-nav" id="nav">
		<li class="active dropdown" controllers="appoint">
		  <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-th-large"></i> 挂号管理 <b class="caret"></b></a>
		  <ul class="dropdown-menu" controllers="index">
			<li><a href="<?php echo U('admin/appoint/index/',array('state'=>0));?>">全部预约</a></li>
			<li><a href="<?php echo U('admin/appoint/index/',array('state'=>1));?>">已挂号</a></li>
			<li><a href="<?php echo U('admin/appoint/index/',array('state'=>2));?>">已就诊</a></li>
			<li><a href="<?php echo U('admin/appoint/index/',array('state'=>3));?>">已取消</a></li>
			<li><a href="<?php echo U('admin/appoint/index/',array('state'=>4));?>">失约</a></li>
		  </ul>
		</li>
		<li class="dropdown" controllers="user">
		  <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-user"></i> 用户管理 <b class="caret"></b></a>
		  <ul class="dropdown-menu">
			<li><a href="<?php echo U('admin/user/index/');?>">所有用户</a></li>
			<li id="createadminlist"><a href="#" class="createadmin" data-id="0">创建浏览用户</a></li>
			<li id="adminlistlist"><a href="<?php echo U('admin/user/adminlist/');?>" id="adminlist">管理员</a></li>
		  </ul>
		</li>
		<li controllers="room"><a href="<?php echo U('admin/room/index/');?>"><i class="glyphicon glyphicon-exclamation-sign"></i> 科室管理</a></li>
		<li controllers="doctor"><a href="<?php echo U('admin/doctor/index/',array('state'=>0));?>"><i class="glyphicon glyphicon-heart"></i>  医生管理</a></li>
		<li controllers="setting">
		  <a href="<?php echo U('admin/setting/index/');?>" id="setting"><i class="glyphicon glyphicon-cog"></i> 系统设置</a>
		</li>
	  </ul>
	  <ul class="nav navbar-nav navbar-right">
		<li class="dropdown">
		  <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-user"></i> <?php echo ($username); ?> <b class="caret"></b></a>
		  <ul class="dropdown-menu">
			<li><a href="#" data-url="<?php echo U('admin/user/changepwd/');?>" id="changepwd"><i class="glyphicon glyphicon-lock"></i>  修改密码</a></li>
			<li><a href="<?php echo U('admin/public/logout/');?>"><i class="glyphicon glyphicon-off"></i> 注销</a></li>
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
			<form role="form" action="<?php echo U('admin/user/changePwd/');?>" method="post">
			<div class="modal-body">
				  <div class="form-group">
					<label for="oldpassword">旧密码</label>
					<input type="password" class="form-control" id="oldpassword" name="oldpassword" placeholder="旧密码">
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

<!-- channelResDialog start -->
<div id="createDialog" class="modal" tabindex="-1">
	<div class="modal-dialog" style="width: 300px;">
		<div class="modal-content">
			<form role="form" action="<?php echo U('admin/user/create/');?>" method="post">
			<input type="hidden" value="1" name="status"/>
			<input type="hidden" value="1" name="type_id"/>
			<input type="hidden" value="" name="id"/>
			<div class="modal-body">

				  <div class="form-group">
					<label for="account">用户名</label>
					<input type="text" class="form-control" id="account" name="account" placeholder="用户名">
				  </div>
				  <div class="form-group">
					<label for="password">密码</label>
					<input type="password" class="form-control"  name="password" placeholder="密码">
				  </div>
				  <div class="form-group">
					<label for="repassword">确认密码</label>
					<input type="password" class="form-control" name="repassword" placeholder="确认密码">
				  </div>
				  <div class="form-group">
					<label for="repassword">备注</label>
					<textarea class="form-control" id="info" name="info" rows="3"></textarea>
				  </div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-default" id="closecreate">
					取消
				</button>
				<button type="submit" class="btn btn-primary">保存</button>
			</div>			
			</form>
		</div>
	</div>
</div>
<script>
$(function(){
	$("#chkall").bind("click", function () {
		var chk=this.checked;
		$("[name = chkid]:checkbox").each(function () {
			if ($(this).attr("disabled") != "disabled") {
				$(this).prop('checked', chk);
			}
		});
	});
	$(".userdelete").on("click",function(){
		if(confirm("确定要删除这个用户吗？预约记录将被一并删除！")){
			$.ajax({
				url:$(this).attr("data-url"),type:"get",dataType:"json",cache:false
			}).done(function(data){
				if(data.status==1){
					location.reload();
				}else{
					alert(data.info);
					return false;
				}
			})
		}
	})	
	$("#search").on("click",function(){
		var url="<?php echo U('admin/user/index/');?>";
		var query  = $('#formuser').find('input').serialize();
		location.href=url+"&"+query;
	})
	$("#start,#stop").on("click",function(){
		 var idsvalue = "";
		$("[name='chkid']").each(function (i) {
			if ($(this).is(':checked')) {
				if (idsvalue != "") idsvalue += ",";
				idsvalue += $(this).attr("value");
			}
		});
		if(idsvalue!=""){
			if(confirm("确定操作选中项吗？")){
				$.ajax({
					url:"<?php echo U('admin/user/update/');?>",type:"post",dataType:"json",cache:false,data:{uid:idsvalue,status:$(this).val()}
				}).done(function(data){
					if(data.status){
						location.reload();
					}
				});

			}
		}
	})
})
</script>
<div class="container">
	<form class="form-inline" role="form" action="<?php echo U('admin/user/index/');?>" method="get" id="formuser">
	  <div class="form-group">
		<label class="sr-only" for="username">用户名</label>
		<input type="text" class="form-control" id="username" name="username" placeholder="用户名" style="width:120px;">
	  </div>
	  <div class="form-group">
		<label class="sr-only" for="id">身份证号</label>
		<input type="text" class="form-control" id="id" name="id" placeholder="身份证号" style="width:120px;">
	  </div>
	  <div class="form-group">
		<label class="sr-only" for="truename">真实姓名</label>
		<input type="text" class="form-control" id="truename" name="truename" placeholder="真实姓名" style="width:120px;">
	  </div>

	  <button type="button" class="btn btn-primary" id="search">搜索</button>&nbsp;
	  <button type="button" class="btn btn-primary navbar-btn" id="start" value="0">启用</button>&nbsp;
	  <button type="button" class="btn btn-danger navbar-btn" id="stop" value="1">拉黑</button>
	 
	</form>
	<br>

	<table class="table table-striped">
		<tr>
			<th><input type="checkbox" id="chkall"></th><th>用户名</th><th>真实姓名</th><th>身份证</th><th>性别</th><th>手机</th><th>注册日期</th><th>状态</th><th>操作</th>
		</tr>
		<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
			<th><input type="checkbox" name="chkid" value="<?php echo ($vo["uid"]); ?>"></th>
			<td><?php echo ($vo["username"]); ?></td>
			<td id="truename_<?php echo ($vo["uid"]); ?>"><?php echo ($vo["truename"]); ?></td>
			<td id="id_<?php echo ($vo["uid"]); ?>"><?php echo ($vo["id"]); ?></td>	
			<td id="sex_<?php echo ($vo["uid"]); ?>"><?php echo (getsex($vo['type'])); ?></td>
			<td id="mobile_<?php echo ($vo["uid"]); ?>"><?php echo ($vo["mobile"]); ?></td>
			<td id="addtime_<?php echo ($vo["uid"]); ?>"><?php echo (todate($vo['addtime'])); ?></td>
			<td><?php echo (getuserstate($vo['status'])); ?></td>
			<td><a href="<?php echo U('admin/appoint/index/',array('uid'=>$vo['uid']));?>" class="btn btn-primary btn-xs">挂号记录</a>&nbsp;
			<a href="#" class="btn btn-danger btn-xs userdelete" data-url="<?php echo U('admin/user/delete/',array('uid'=>$vo['uid']));?>">删除</a></td>
		</tr><?php endforeach; endif; else: echo "" ;endif; ?>
	</table>
	
	<ul class="pagination"><?php echo ($page); ?></ul>
</div> <!-- /container -->
<!-- channelResDialog start -->
<div id="userDialog" class="modal" tabindex="-1">

	<form class="form-horizontal" action="<?php echo U('admin/user/save/');?>" method="post">
	<div class="modal-dialog" style="width: 600px;">
		<div class="modal-content">
			<div class="modal-header">
				<h4>添加用户</h4>
			</div>
			<div class="modal-body">
			<input type="hidden" value="0" name="did" id="did"/>
			  <div class="form-group">
				<label  class="col-sm-3 control-label" for="truename">真实姓名</label>
				<div class="col-sm-9">
				<input type="text" class="form-control input-sm" id="truename" name="name" placeholder="真实姓名">
				</div>
			  </div>
			  <div class="form-group">
				<label  class="col-sm-3 control-label" for="id">身份证</label>
				<div class="col-sm-9">
				<input type="text" class="form-control input-sm" id="id" name="id" placeholder="身份证">
				</div>
			  </div>		  
			  
			  <div class="form-group">
				<label  class="col-sm-3 control-label" for="type">性别</label>
				<div class="col-sm-9">
				<label class="radio-inline">
				  <input type="radio" id="typ0" name="type" value="0" checked> 男
				</label>
				<label class="radio-inline">
				  <input type="radio" id="type1" name="type" value="1"> 女
				</label>
				</div>
			  </div>

			  <div class="form-group">
				<label  class="col-sm-3 control-label" for="id">医保号</label>
				<div class="col-sm-9">
				<input type="text" class="form-control input-sm" id="id" name="id" placeholder="医保号">
				</div>
			  </div>
			  
			  <div class="form-group">
				<label  class="col-sm-3 control-label" for="mobile">手机号</label>
				<div class="col-sm-9">
				<input type="text" class="form-control input-sm" id="id" name="mobile" placeholder="mobile">
				</div>
			  </div>
			  <div class="form-group">
				<label  class="col-sm-3 control-label" for="address">地址</label>
				<div class="col-sm-9">
				<textarea class="form-control input-sm" rows="2" id="address" name="address"></textarea>
				</div>
			  </div>
			  <div class="form-group">
				<label  class="col-sm-3 control-label" for="mobile">验证码</label>
				<div class="col-sm-9">
				<input type="text" class="form-control input-sm" id="id" name="mobile" placeholder="mobile">
				</div>
			  </div>
			</div>
			<div class="modal-footer">
				<input class="btn btn-default" value="取消" id="close" type="button">
				<input class="btn btn-primary" type="submit" value="确认">
			</div>
			
		</div>
	</div>
	</form>	
</div>

<!-- 主页面结束 -->

</div>
<div id="footer">
  <div class="container">
	<p class="text-muted">&copy; 2013. Created by <a href="http://ichuan.net/">yc</a> | <a href="#" title="">Help</a> | <a title="" href="#">Changelog</a></p>
  </div>
</div>

</body>
</html>
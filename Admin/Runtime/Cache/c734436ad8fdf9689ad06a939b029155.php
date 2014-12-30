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
	var roomdialog=$("#roomDialog");
	$("#add").on("click",function(){
		roomdialog.modal("show");	
	})
	$("#close").on("click",function(){
		$("[type='text'],[type='hidden'],textarea,[type='file']").val("");
		roomdialog.modal("hide");	
	})
	$(".roomedit").on("click",function(){
		var $rid=$(this).attr("data-rid");
		var $intro=$(this).attr("data-intro");
		var $name=$(this).attr("data-name");
		var $img=$(this).attr("data-img");
		var $state=$(this).attr("data-state");
		var $delayed=$(this).attr("data-delayed");
		$("#rid").val($rid);
		$("#name").val($name);
		$("#intro").val($intro);
		$("#state").val($state);
		$("#delayed").val($delayed);
		roomdialog.find("h4").text("编辑科室");
		$("#src").empty();
		if($img!=""){
			//$("#src").empty().append($("<a/>").attr("href","__PUBLIC__/"+$img).text($img)).append("<a href=\"#\" class=\"btn btn-primary btn-xs \"><i class=\"glyphicon glyphicon-trash\"></i></a>");
			$("#src").empty().append($("<a/>").attr("href","__PUBLIC__/"+$img).text($img));
		}
		roomdialog.modal("show").find(".help-inline").html("");
	});	
	$(".roomdelete").on("click",function(){
		if(confirm("确定要删除这个科室吗？该科室下的所有医生和预约记录将被一并删除！")){
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
})
</script>
<div class="container">
	<button type="button" class="btn btn-primary navbar-btn" id="add">新增</button>

	<table class="table table-striped">
		<tr>
			<th>科室名称</th><th>预约</th><th>医生</th><th>状态</th><th>操作</th>
		</tr>
		<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
			<td><?php echo ($vo["name"]); ?></td>
			<td><a href="<?php echo U('admin/appoint/index/',array('rid'=>$vo['rid']));?>">查看</a></td>
			<td><a href="<?php echo U('admin/doctor/index/',array('rid'=>$vo['rid']));?>">查看</a></td>	
			<td><?php echo (getroomstate($vo['state'])); ?></td>
			<td><a href="#" data-rid="<?php echo ($vo["rid"]); ?>" data-intro="<?php echo ($vo["intro"]); ?>" data-img="<?php echo ($vo["img"]); ?>" data-state="<?php echo ($vo["state"]); ?>" data-name="<?php echo ($vo["name"]); ?>" data-delayed="<?php echo ($vo["delayed"]); ?>"  class="btn btn-primary btn-xs roomedit">编辑</a>&nbsp; <a href="#" data-url="<?php echo U('admin/room/delete/',array('rid'=>$vo['rid']));?>" class="btn btn-danger btn-xs roomdelete">删除</a></td>
		</tr><?php endforeach; endif; else: echo "" ;endif; ?>
	</table>
	
	<ul class="pagination"><?php echo ($page); ?></ul>
</div> <!-- /container -->

<!-- channelResDialog start -->
<div id="roomDialog" class="modal" tabindex="-1">
	<div class="modal-dialog" style="width: 500px;">
		<div class="modal-content">
			<div class="modal-header">
				<h4>新增科室</h4>
			</div>
			<form class="form-horizontal" role="form" action="<?php echo U('admin/room/add/');?>" method="post" enctype="multipart/form-data">
			<div class="modal-body">
				<input type="hidden" value="" id="rid" name="rid">
					<div class="form-group">
						<label class="col-xs-3 control-label">科室名称</label>
						<div class="col-xs-9">
							<input id="name" name="name" type="text" class="form-control" required autofocus>
							<span class="help-inline"></span>
						</div>
					</div>
					<div class="form-group">
						<label class="col-xs-3 control-label">延后预约</label>
						<div class="col-xs-9">
							<input id="delayed" name="delayed" type="text" class="form-control" value="0" required autofocus>
							<span class="help-inline"></span>
						</div>
					</div>
					<div class="form-group">
						<label class="col-xs-3 control-label">状态</label>
						<div class="col-xs-9">
							<select id="state" name="state">
								<option value="0">正常</option>
								<option value="1">停用</option>
							</select> 
							<span class="help-inline"></span>
						</div>
					</div>
					<div class="form-group">
						<label class="col-xs-3 control-label">科室图片</label>
						<div class="col-xs-9">
							<input id="img" name="img" type="file" class="form-control">
							<div id="src"></div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-xs-3 control-label">科室介绍</label>
						<div class="col-xs-9">
							<textarea class="form-control" id="intro" name="intro" rows="3"></textarea>
						</div>
					</div>
			</div>
			<div class="modal-footer">
				<a class="btn btn-default" href="#" id="close">取消</a>
				<input class="btn btn-primary" type="submit" value="确认"/>
			</div>
			</form>
		</div>
	</div>
</div>
<!-- channelResDialog end -->

<!-- 主页面结束 -->

</div>
<div id="footer">
  <div class="container">
	<p class="text-muted">&copy; 2013. Created by <a href="http://ichuan.net/">yc</a> | <a href="#" title="">Help</a> | <a title="" href="#">Changelog</a></p>
  </div>
</div>

</body>
</html>
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
	var appdialog=$("#appDialog");
	$(".appedit").on("click",function(){
		var $id=$(this).attr("id");
		var $tel=$(this).attr("data-tel");
		var $birthday=$(this).attr("data-birthday");
		var $address=$(this).attr("data-address");
		var $uid=$(this).attr("data-uid");
		appdialog.modal("show").find("table td:even").css("background","#f9f9f9").css("boder-color","#ddd").css("color","#000");
		$("#aid").val($id);
		$("#name").html($("#name_"+$id).html());
		$("#dname").html($("#dname_"+$id).html());
		$("#tel").html($tel);
		
		$("#birthday").html($birthday);
		$("#address").html($address);
		$("#sex").html($("#sex_"+$id).html());
		$("#truenameinfo").html($("#truename_"+$id).html());
		$("#state").val($(this).attr("data-state"));
		$("#dayinfo").html($("#day_"+$id).html());
		$("#mobile").html($("#mobile_"+$id).html());
		$("#uid").html($uid);

	});	

	$("#close").on("click",function(){
		appdialog.modal("hide");	
	})
	$("#edit").on("click",function(){
		$.ajax({
			url:"<?php echo U('admin/appoint/save/');?>",type:"get",dataType:"json",cache:false,data:{
				aid:$("#aid").val(),state:$("#state").val()
			}
		}).done(function(data){	
			appdialog.modal("hide");
			if(data.info=="success"){
				location.reload();
			}
			showTip(data.info,"edit");
		})	
	})
	$(".appointdelete").on("click",function(){
		if(confirm("确定要删除选中项吗？")){
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
		var url="<?php echo U('admin/appoint/index/');?>";
		var query  = $('#formuser').find('input').serialize();
		
		location.href=url+"&"+query;
	})
	function showTip(result, mode) {
		if (result == "success") {
			if (mode == "edit") {
				$("#successAlert").html('编辑成功！');
			}
			$("#successAlert").slideDown();
			window.setTimeout(function(){$("#successAlert").slideUp();}, 3000);
		} else {
			if (mode == "edit") {
				$("#errorAlert").html('编辑失败！');
			}
			$("#errorAlert").slideDown();
			window.setTimeout(function(){$("#errorAlert").slideUp();}, 3000);
		}
	}

})
</script>
<div class="container">
	<div id="successAlert" class="alert alert-success fade in"></div>
	<div id="errorAlert" class="alert alert-danger fade in"></div>
	<form class="form-inline" role="form" action="<?php echo U('admin/appoint/index/');?>" method="get" id="formuser">
	  <div class="form-group">
		<label class="sr-only" for="day">预约日期</label>
		<input type="text" class="form-control" id="day" name="day" placeholder="预约日期" style="width:120px;">
	  </div>
	  <div class="form-group">
		<label class="sr-only" for="id">身份证号</label>
		<input type="text" class="form-control" id="id" name="id" placeholder="身份证号" style="width:120px;">
	  </div>
	  <div class="form-group">
		<label class="sr-only" for="truename">真实姓名</label>
		<input type="text" class="form-control" id="truename" name="truename" placeholder="真实姓名" style="width:120px;">
	  </div>
	  <button type="button" class="btn btn-primary" id="search">搜索</button>	&nbsp; 
	</form><br>
	<table class="table table-striped">
		<tr>
			<th>预约日期</th><th>发布时间</th><th>预约者</th><th>身份证</th><th>性别</th><th>预约科室</th><th>预约医生</th><th>预约状态</th><th>联系方式</th><th>操作</th>
		</tr>
		<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
			<td id="day_<?php echo ($vo["aid"]); ?>"><?php echo ($vo["day"]); ?></td>
			<td id="time_<?php echo ($vo["aid"]); ?>"><?php echo (todate($vo['addtime'])); ?></td>
			<td id="truename_<?php echo ($vo["aid"]); ?>"><?php echo ($vo["truename"]); ?></td>	
			<td id="truename_<?php echo ($vo["aid"]); ?>"><?php echo ($vo["id"]); ?></td>
			<td id="sex_<?php echo ($vo["aid"]); ?>"><?php echo (getsex($vo['sex'])); ?></td>	
			<td id="name_<?php echo ($vo["aid"]); ?>"><?php echo ($vo["name"]); ?></td>				
			<td id="dname_<?php echo ($vo["aid"]); ?>"><?php echo ($vo["dname"]); ?></td>	
			<td id="state_<?php echo ($vo["aid"]); ?>"><?php echo (getstate($vo['state'])); ?></td>	
			<td id="mobile_<?php echo ($vo["aid"]); ?>"><?php echo ($vo["mobile"]); ?></td>	
			<td><a href="#" id="<?php echo ($vo["aid"]); ?>" data-uid="<?php echo ($vo["uid"]); ?>" data-tel="<?php echo ($vo["tel"]); ?>" data-birthday="<?php echo ($vo["birthday"]); ?>" data-address="<?php echo ($vo["address"]); ?>" data-state="<?php echo ($vo["state"]); ?>" class="btn btn-primary btn-xs appedit">编辑</a>
				<a href="#" data-url="<?php echo U('admin/appoint/delete/',array('aid'=>$vo['aid']));?>" id="<?php echo ($vo["aid"]); ?>" class="btn btn-primary btn-xs appointdelete">删除</a></td>
		</tr><?php endforeach; endif; else: echo "" ;endif; ?>
	</table>
	
	<ul class="pagination"><?php echo ($page); ?></ul>
</div> <!-- /container -->
<!-- channelResDialog start -->
<div id="appDialog" class="modal" tabindex="-1">
	<div class="modal-dialog" style="width: 550px;">
		<div class="modal-content">
			<div class="modal-header">
				<h4>编辑预约记录</h4>
			</div>
			<div class="modal-body">
				<input type="hidden" value="" id="aid"/>
				<table class="table table-hover">
					<tr><td style="width:90px">预约科室：</td><td id="name"></td><td style="width:90px">预约医生：</td><td id="dname"></td></tr>
					<tr>
						<td>预约日期：</td><td id="dayinfo"></td>
						<td>预约状态：</td><td><select id="state">
						<option value="1">已挂号</option>
						<option value="2">已就诊</option>
						<option value="3">已取消</option>
						<option value="4">失约</option>
						</select></td>
					</tr>
					<tr><td>预约者：</td><td id="truenameinfo"></td><td>卡号：</td><td id="uid"></td></tr>
					<tr><td>性别：</td><td id="sex"></td><td>出生年月：</td><td id="birthday"></td></tr>
					<tr><td>联系手机：</td><td id="mobile"></td><td>联系电话：</td><td id="tel"></td></tr>
					<tr><td>联系地址：</td><td id="address" colspan="3"></td></tr>
				</table>
			</div>
			<div class="modal-footer">
				<button class="btn btn-default" id="close">
					取消
				</button>
				<button class="btn btn-primary" id="edit">
					确认
				</button>
			</div>
		</div>
	</div>
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
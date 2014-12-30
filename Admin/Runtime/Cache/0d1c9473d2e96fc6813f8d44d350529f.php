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
function DoctorAction(mod){
	var dialog=$("#doctorDialog");
	if(mod=="add"){
		var $limit="";
		$(".limit").each(function(){
			var $num=$(this).val();
			if($num=="")$num=0;
			if (/\D/.test($num)) {
				alert("放号量请输入数字");
				$(this).focus();
                return false;
            } 
		})
		alert($("form").serialize());
		$.ajax({
			url:"<?php echo U('admin/doctor/save/');?>",type:"post",dataType:"json",cache:false,data:$("form").serialize()
		}).done(function(data){	
			alert(data.info);
			return false;
			location.reload();
		})
	}
	else if(mod=="edit"){

	}

	else{	
		;	
	}
}
$(function(){
	var dialog=$("#doctorDialog");
	dialog.find("table td:even").css("background","#f9f9f9").css("boder-color","#ddd").css("color","#000");
	$("#add").on("click",function(){
		dialog.modal("show");	
	})
	$("#close").on("click",function(){
		$("[type='text'],[type='hidden'],textarea").val("");
		dialog.modal("hide");	
	})
	$(".doctordelete").on("click",function(){
		if(confirm("确定要删除这个医生吗？预约记录将被一并删除！")){
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
	$(".doctoredit").on("click",function(){
		$("[name='name']").val($(this).attr("data-name"));
		$("[name='intro']").val($(this).attr("data-intro"));
		$("[name='rid']").val($(this).attr("data-rid"));
		$("[name='type']").val($(this).attr("data-type"));
		$("[name='did']").val($(this).attr("data-did"));
		//alert($(this).attr("data-url"));
		$.ajax({
			url:$(this).attr("data-url"),type:"get",dataType:"json",cache:false
		}).fail(function(){
			
		}).done(function(data){
			if(data.data!=null){
				$.each(data.data, function (i, item) {
					var dom=item.week+"_"+item.noon;
					$("[name='s["+dom+"]']").val(item.limit);
				});
			}
		});	
		dialog.modal("show");
	})
})
</script>
<div class="container">
	
	<button type="button" class="btn btn-primary navbar-btn" id="add">新增</button>
	<table class="table table-striped">
		<tr>
			<th>编号</th><th>医生姓名</th><th>所属科室</th><th>操作</th>
		</tr>
		<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
			<td id="did_<?php echo ($vo["did"]); ?>"><?php echo ($vo["did"]); ?></td>
			<td id="name_<?php echo ($vo["did"]); ?>"><?php echo ($vo["name"]); ?></td>
			<td id="rname_<?php echo ($vo["did"]); ?>"><?php echo ($vo["rname"]); ?></td>		
			<td><a href="<?php echo U('admin/appoint/index/',array('did'=>$vo['did']));?>" class="btn btn-primary btn-xs">挂号记录</a>&nbsp; <a href="#" id="<?php echo ($vo["did"]); ?>" data-did="<?php echo ($vo["did"]); ?>" data-rid="<?php echo ($vo["rid"]); ?>" data-name="<?php echo ($vo["name"]); ?>" data-type="<?php echo ($vo["type"]); ?>" data-intro="<?php echo ($vo["intro"]); ?>" data-url="<?php echo U('admin/doctor/edit/',array('did'=>$vo['did']));?>" class="btn btn-primary btn-xs doctoredit">编辑</a> &nbsp;
			<a href="#" class="btn btn-danger btn-xs doctordelete" data-url="<?php echo U('admin/doctor/delete/',array('did'=>$vo['did']));?>">删除</a></td>
		</tr><?php endforeach; endif; else: echo "" ;endif; ?>
	</table>
	
	<ul class="pagination"><?php echo ($page); ?></ul>
</div> <!-- /container -->
<!-- channelResDialog start -->
<div id="doctorDialog" class="modal" tabindex="-1">

	<div class="modal-dialog" style="width: 600px;">
		<div class="modal-content">
			<div class="modal-header">
				<h4>添加医生</h4>
			</div>
			<form class="form-horizontal" action="<?php echo U('admin/doctor/save/');?>" method="post">
			<div class="modal-body">
			<input type="hidden" value="0" name="did" id="did"/>
			<div class="form-group">
				<label  class="col-sm-3 control-label" for="name">医生名称</label>
				<div class="col-sm-9">
				<input type="text" class="form-control input-sm" id="name" name="name" placeholder="医生名称">
				</div>
			  </div>
			  <div class="form-group">
				<label  class="col-sm-3 control-label" for="rid">所属科室</label>
				<div class="col-sm-9">
				<select class="form-control input-sm" id="rid" name="rid">
					<?php if(is_array($room)): $i = 0; $__LIST__ = $room;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["rid"]); ?>"><?php echo ($vo["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
				</select>
				</div>
			  </div>
			  <div class="form-group">
				<label  class="col-sm-3 control-label" for="type">级别</label>
				<div class="col-sm-9">
				<select class="form-control input-sm" id="type" name="type">
					<?php if(is_array($doctortype)): $i = 0; $__LIST__ = $doctortype;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($i); ?>"><?php echo ($vo); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
				</select>
				</div>
			  </div>
			  <div class="form-group">
				<label  class="col-sm-3 control-label" for="intro">擅长治疗</label>
				<div class="col-sm-9">
				<textarea class="form-control input-sm" rows="2" id="intro" name="intro"></textarea>
				</div>
			  </div>
			  <div class="form-group">
				<label  class="col-sm-3 control-label" for="exampleInputFile">房号量</label>
				<div class="col-sm-9">
				<div class="row">
				  <table class="table table-condensed">
					<tr>
						<td style="width:80px;">周日上午</td><td><input type="text" class="form-control input-sm limit" data-week="周日" data-noon="上午" id="sun_a" name="s[周日_上午]" placeholder="0"></td>
						<td style="width:80px;">周日下午</td><td><input type="text" class="form-control input-sm limit" data-week="周日" data-noon="下午" id="sun_p" name="s[周日_下午]" placeholder="0"></td>
					</tr>					
					<tr>
						<td style="width:80px;">周一上午</td><td><input type="text" class="form-control input-sm limit" data-week="周一" data-noon="上午"  id="mon_a" name="s[周一_上午]" placeholder="0"></td>
						<td style="width:80px;">周一下午</td><td><input type="text" class="form-control input-sm limit" data-week="周一" data-noon="下午"  id="mon_p" name="s[周一_下午]" placeholder="0"></td>
					</tr>					
					<tr>
						<td style="width:80px;">周二上午</td><td><input type="text" class="form-control input-sm limit" data-week="周二" data-noon="上午"  id="tue_a" name="s[周二_上午]" placeholder="0"></td>
						<td style="width:80px;">周二下午</td><td><input type="text" class="form-control input-sm limit" data-week="周二" data-noon="下午"  id="tue_p" name="s[周二_下午]" placeholder="0"></td>
					</tr>
					<tr>
						<td style="width:80px;">周三上午</td><td><input type="text" class="form-control input-sm limit" data-week="周三" data-noon="上午"  id="wed_a" name="s[周三_上午]" placeholder="0"></td>
						<td style="width:80px;">周三下午</td><td><input type="text" class="form-control input-sm limit" data-week="周三" data-noon="下午"  id="wed_p" name="s[周三_下午]" placeholder="0"></td>
					</tr>
					<tr>
						<td style="width:80px;">周四上午</td><td><input type="text" class="form-control input-sm limit" data-week="周四" data-noon="上午"  id="thu_a" name="s[周四_上午]" placeholder="0"></td>
						<td style="width:80px;">周四下午</td><td><input type="text" class="form-control input-sm limit" data-week="周四" data-noon="下午"  id="thu_p" name="s[周四_下午]" placeholder="0"></td>
					</tr>
					<tr>
						<td style="width:80px;">周五上午</td><td><input type="text" class="form-control input-sm limit" data-week="周五" data-noon="上午"  id="fri_a" name="s[周五_上午]" placeholder="0"></td>
						<td style="width:80px;">周五下午</td><td><input type="text" class="form-control input-sm limit" data-week="周六" data-noon="下午"  id="fri_p" name="s[周五_下午]" placeholder="0"></td>
					</tr>
					<tr>
						<td style="width:80px;">周六上午</td><td><input type="text" class="form-control input-sm limit" data-week="" data-noon=""  id="sat_a" name="s[周六_上午]" placeholder="0"></td>
						<td style="width:80px;">周六下午</td><td><input type="text" class="form-control input-sm limit" data-week="周六" data-noon="下午"  id="sat_p" name="s[周六_下午]" placeholder="0"></td>
					</tr>
				  </table>
				</div>
				</div>
			  </div>
			</div>
			<div class="modal-footer">
				<input class="btn btn-default" value="取消" id="close" type="button">
				<input class="btn btn-primary" type="submit" value="确认">
			</div>
			</form>	
			
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
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
<style>

</style>
<script>

	$(document).ready(function() {
		/*
		$.ajax({
			url:"<?php echo U('home/room/json/',array('rid'=>$rid));?>",type:"get",dataType:"json",cache:false
		}).fail(function(){
			
		}).done(function(data){
			$.each(data,function(i,item){
				alert(item.title+","+item.start+","+item.end+","+item.backgroundColor);
			});	
		})*/
		var date = new Date();
		var d = date.getDate();
		var m = date.getMonth();
		var y = date.getFullYear();
		$("body").on("click",".guahao",function(){
			$(this).text("正在提交...").attr("disabled","disabled");
			var $url="<?php echo U('home/appoint/ajaxsave/');?>";
			var $uid=$(this).attr("data-uid");
			var $rid=$(this).attr("data-rid");
			var $did=$(this).attr("data-did");
			var $day=$(this).attr("data-day");
			var $noon=$(this).attr("data-noon");
			var $roomname=$(this).attr("data-roomname");
			var $name=$(this).attr("data-name");
			/*
			$.ajax({
				url:$url,type:"post",dataType:"json",cache:false,data:{
					uid:$uid,rid:$rid,did:$did,day:$day,noon:$noon,time:"09:00"
				}
			}).done(function(data){
				alert(data.info);
			})*/
			var time="09:00";
			if($noon=="下午"){
				time="14:00";
			}

			location.href=$url+"&uid="+$uid+"&rid="+$rid+"&did="+$did+"&day="+$day+"&noon="+$noon+"&time="+time+"&name="+$name+"&roomname="+$roomname;
		})
		$("#close").click(function(){
			$("#roomDialog").modal("hide");
		})
		if("<?php echo ($vo["maxAppointTimes"]); ?>"!="<?php echo ($appoint); ?>"){
			$('#calendar').fullCalendar({
				header: {
					left: 'title',
					center: '',
					right: 'prev,next today'
				},
				titleFormat:{month:"yyyy年MMMM月",week:"yyyy年MMMM月d{'&#8212;'d日}",day:"yyyy年MMMM月d日 dddd"},
				buttonText:{
					prev:"上月",
					next:"下月",
					today:"今天",month:"月",week:"周",day:"日"
				},
				firstDay:1,monthNames:['01','02','03','04','05','06','07','08','09','10','11','12'],
				monthNamesShort:['01','02','03','04','05','06','07','08','09','10','11','12'],
				dayNames:['周日','周一','周二','周三','周四','周五','周六'],
				dayNamesShort:['日','一','二','三','四','五','六'],
				contentHeight:560,
				events: "<?php echo U('home/room/json/',array('rid'=>$rid));?>",
				dayClick: function(date, allDay, jsEvent, view) {
					/*var selDate =$.fullCalendar.formatDate(date,"yyyy-MM-dd");
					var dt = new Date(selDate);  
					
					if(dt.getDay()==2){
					alert(dt.getDay());  //0代表周日
					}*/
				},
				eventClick: function(calEvent, jsEvent, view) {
					var selDate =$.fullCalendar.formatDate(calEvent.start,"yyyy-MM-dd");
					if(calEvent.title=="已满"){
						return false;
					}
					var tbody=$(".modal-body").find("tbody").empty();
					$("#roomDialog").modal("show");
					$.ajax({
						url:"<?php echo U('home/room/getappoint/',array('rid'=>$rid));?>",type:"get",dataType:"json",cache:true,
						data:{day:selDate,week:calEvent.id,rid:$("#rid").val()},
						beforeSend:function(){
							tbody.html("<td colspan='7'>数据正在加载...</td>"); 
						}
					}).done(function(data){
						if(data!=null)tbody.empty();
						$.each(data,function(i,item){
							//alert(item.week);
							var td_day=$("<td/>").html(selDate);
							var td_week=$("<td/>").html(item.week+" "+item.noon);
							var td_roomname=$("<td/>").html("<?php echo ($name); ?>");
							var td_name=$("<td/>").html(item.name);
							var td_limit=$("<td/>").html(item.limit);
							var td_shengyu=$("<td/>").html(item.shengyu);
							var a=$("<a class=\"btn btn-primary btn-xs guahao\"/>").attr("data-uid","<?php echo ($uid); ?>")
									.attr("data-rid",item.rid)
									.attr("data-did",item.did)
									.attr("data-day",selDate)
									.attr("data-roomname","<?php echo ($name); ?>")
									.attr("data-name",item.name)
									.attr("data-noon",item.noon).text("挂号");
							if(item.shengyu=="0")a.removeClass("btn-primary").addClass("btn-danger").text("停挂").attr("disabled","disabled");
							
							var td_edit=$("<td/>").html(a);
							tr=$("<tr/>");
							tr.append(td_day).append(td_week).append(td_roomname)
							.append(td_name).append(td_shengyu).append(td_edit);
							tbody.append(tr);
						})
					});
				}
			});
			$(".alert").hide();
			$("body").find('.fc-day-content>div').each(function(i){
				//alert($(this).html());	
			})
		}
		else{
			$(".alert").show();
		}
	});
</script>
<div class="container">
	<div class="alert alert-danger">每日只能挂一次号，请明天挂号</div>
	<input type="hidden" value="<?php echo ($rid); ?>" id="rid"/>
	<div id="calendar"></div>
</div> <!-- /container -->
<!-- channelResDialog start -->
<div id="roomDialog" class="modal" tabindex="-1">
	<div class="modal-dialog" style="width: 650px;">
		<div class="modal-content">
			<div class="modal-body">
				<table class="table table-bordered">
					<thead>
					<tr><th>日期</th><th>时段</th><th>科室</th><th>医生</th><th>剩余号</th><th>操作</th></tr>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>
			<div class="modal-footer">
				<button class="btn btn-default" id="close">
					取消
				</button>
			</div>
		</div>
	</div>
</div>
<!-- channelResDialog end -->
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
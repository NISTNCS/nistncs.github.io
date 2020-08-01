<?php
	session_start();
	if(isset($_SESSION['ncs']) and $_SESSION['ncs']==true)
	{
		$id=$_SESSION['id'];
		$name=$_SESSION['name'];
		$phone=$_SESSION['phone'];
		$email=$_SESSION['email'];
		$curyear=$_SESSION['year'];
		if($_SESSION['role']!='Admin')
		{
			$batch=$_SESSION['batch'];
			$branch=$_SESSION['branch'];
			$fac=$_SESSION['fac'];
		}
		
	}
	else
		header('location: ../login.php');
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="shortcut icon" href="../favicon.ico">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>NCS - Events</title>
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/font-awesome.min.css" rel="stylesheet">
	<link href="css/datepicker3.css" rel="stylesheet">
	<link href="css/styles.css" rel="stylesheet">
	<link rel="shortcut icon" href="../favicon.ico">
	
	<!--Custom Font-->
	<link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
	<!--[if lt IE 9]>
	<script src="js/html5shiv.js"></script>
	<script src="js/respond.min.js"></script>
	<![endif]-->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  
           <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>  
           <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>            
           <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />  
           <link href="css/bootstrap-datetimepicker.min.css" rel="stylesheet">
<script src="js/bootstrap-datetimepicker.min.js"></script>
	<script type="text/javascript">
	$(document).ready(function() {
      	$("#datetime").datetimepicker({
		    format: 'yyyy-mm-dd hh:ii',
		    autoclose: true,
		    todayBtn:true
		});
      });
	</script>
	</head>
<body>
	<nav class="navbar navbar-custom navbar-fixed-top" role="navigation">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#sidebar-collapse"><span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span></button>
				<a class="navbar-brand" href="#"><span style="padding-right:20px;">NCS</span><?php echo '('.$curyear.'-'.($curyear+1).')';?></a>
				<ul class="nav navbar-top-links navbar-right">
					
				</ul>
			</div>
		</div><!-- /.container-fluid -->
	</nav>
	<div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
		<div class="profile-sidebar">
			<div class="profile-userpic" align="center">
				<img src="../upload/<?php echo $id ?>.jpg" style="object-fit: cover;" class="img-responsive" alt="" onerror=this.src="../img/avatar.jpg">
			</div>
			<div class="profile-usertitle">
				<div class="profile-usertitle-name"><?php echo $name?></div>
				<small><?php echo $id?></small>
			</div>
			<div class="clear"></div>
		</div>
		<div class="divider"></div>
		
		<ul class="nav menu">
			<li><a href="index.php"><em class="fa fa-address-card">&nbsp;</em> Profile</a></li>
			<li><a href="meetings.php"><em class="fa fa-calendar">&nbsp;</em> Meetings</a></li>
			<li><a href="student_details.php"><em class="fa fa-search">&nbsp;</em> Student Details</a></li>
			<li><a href="addstudent.php"><em class="fa fa-user-plus">&nbsp;</em> Add Students</a></li>
			<?php if($_SESSION['role']!='Admin') echo '<li><a href="attendance.php"><em class="fa fa-bars">&nbsp;</em> Attendance</a></li>';?>
			<li><a href="update.php"><em class="fa fa-edit">&nbsp;</em> Update Profile</a></li>
			<li class="active"><a href=""><em class="fa fa-trophy">&nbsp;</em> Events</a></li>
		</ul>
		<div class="divider"></div>
		<ul class="nav menu">	
			<li><a href="../login.php"><em class="fa fa-power-off">&nbsp;</em> Logout</a></li>
		</ul>
	</div><!--/.sidebar-->
		
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">

		<div class="row">
			<ol class="breadcrumb">
				<li><a href="index.php">
					<em class="fa fa-home"></em>
				</a></li>
				<li class="active">Events</li>
			</ol>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Add New Event</h1>
			</div>
		</div><!--/.row-->
		<!--/.row-->
		<div class="row">
			
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="container-fluid">
						<div class="row">
					      <!-- left column -->
					      <!-- edit form column -->
					      <div class="col-md-12 personal-info">
					        <div id="error" style="display: none;" class="alert alert-info alert-dismissable">
					          <a class="panel-close close" data-dismiss="alert">×</a> 
					        </div>
					        <h3>Event details</h3>
					        
					        <form class="form-horizontal" role="form" >
					        <div class="row" style="margin-bottom: 10px;">
					        	<div class="form-group col-lg-6" >
					        		<div class="col-lg-12" style="border-right: 1px solid rgb(220,220,220); ">
								        <div class="text-center">
								          <img id="setpic"  src="../eventpic/nofilefound.jpg" style="object-fit: cover;" height="250px" width="80%"  alt="avatar">
								          
								          <div class="input-group">
								                <label class="input-group-btn">
								                    <span class="btn btn-info">
								                        Browse&hellip; <input type="file" value="-" id="propic" accept="image/*" style="display: none;" onchange="document.getElementById('setpic').src = window.URL.createObjectURL(this.files[0]);document.getElementById('pictext').value=this.files.item(0).name" class="form-control">
								                    </span>
								                </label>
								                <input type="text" id="pictext" class="form-control" readonly>
								            </div>
								          
								        </div>
								      </div>
								      <hr>
					        	</div>
					          <div class="col-lg-6">
					          <div class="form-group col-lg-12">
					            <label class="col-lg-2 control-label">Title:</label>
					            <div class="col-lg-10">
					              <input class="form-control" type="text" id="title" value="" name="name" placeholder="Event Title">
					            </div>
					          </div>
					          <div class="form-group col-lg-12">
						        <label class="col-lg-2 control-label">Date:</label>
						        <div class="col-lg-10" >
						        	<input type="text" class="form-control" name="date" id="datetime" placeholder="click here">
						                    
						        </div>
						     </div>
					          
					          <div class="form-group col-lg-12">
					            <label class="col-lg-2 control-label">Place:</label>
					            <div class="col-lg-10">
					              <input class="form-control" type="text" value="" id="place" name="place" placeholder="Place">
					            </div>
					          </div>
					          <div class="form-group col-lg-12">
					            <label class="col-lg-2 control-label">About:</label>
					            <div class="col-lg-10">
					              <textarea class="form-control" rows=5 value="" id="about" placeholder="Write about event"></textarea>
					            </div>
					          </div>

					          </div>
					          </div>
					          
					          <div class="form-group">
					            <div class="col-md-12" align="center">
					              <input type="submit" id="update_button" class="btn btn-primary" value="Add Event">
					              <span></span>
					              <input type="reset" class="btn btn-default" value="Cancel">
					            </div>
					          </div>
					        </form>
					      </div>
					  </div>
					</div>

				</div>
			</div>
		</div>
			<center><div class="container-fluid">
			<div class="row">
				<p class="tm-copyright-text">Copyright &copy; 2018 NIST Counseling Service | Maintained by <a rel="nofollow" href="http://nist.edu/" target="_blank">N.I.S.T.</a> | Designed by <span style="color: #C51162">N.C.S. Web Design Team</span></p>
			</div>
		</div>		
	  
	</center>

	</div>	<!--/.main-->
	  

	<script src="js/bootstrap.min.js"></script>
	<script src="js/chart.min.js"></script>
	<script src="js/chart-data.js"></script>
	<script src="js/easypiechart.js"></script>
	<script src="js/easypiechart-data.js"></script>
	<script src="js/bootstrap-datepicker.js"></script>
	<script src="js/custom.js"></script>
		
</body>
</html>
<script>
	function preview_images() 
	{
	$('#image_preview').html('');
	 var total_file=document.getElementById("images").files.length;
	 for(var i=0;i<total_file;i++)
	 {
	  $('#image_preview').append("<div class='col-md-3'><img class='img-responsive' src='"+URL.createObjectURL(event.target.files[i])+"'></div>");
	 }
	}
	$('#update_button').click(function(event){
			
			event.preventDefault();
			if(!($('#title').val()==""|| $('#datetime').val()=="" || $('#place').val()=="" || $('#about').val()==""))
			{

				var filedata=document.getElementById('propic').files[0];
				var data=new FormData($('form')[0]);
				data.append('photo',filedata);
				data.append('event',true);
				data.append('id',<?php echo $id; ?>)
				data.append('about',$("#about").val());
				$.ajax({
					type : 'POST',
					url : 'login.php',
					data : data,
					processData: false,
	    			contentType: false,
					beforeSend: function(){
						$("#error").fadeOut();
						$("#update_button").val('sending ...');

					},
					success : function(response){
						if(response=="success"){
							$("#update_button").val('Saving ...');
							$("#error").html('<a class="panel-close close" data-dismiss="alert">×</a><i class="fa fa-coffee"></i> Successfully added Event!!');
							$("#error").fadeIn(500,function(){
							});
							setTimeout('window.location.href = "event.php"; ',3000);
						} 
						else {
							$("#update_button").val('Add Event');
							$("#error").html('<a class="panel-close close" data-dismiss="alert">×</a><i class="fa fa-coffee"></i>'+response);
							$("#error").fadeIn(500, function(){
								
							});
						}
					}
				});
			}
			else
			{
				$("#error").html('<a class="panel-close close" data-dismiss="alert">×</a><i class="fa fa-coffee"></i>'+"  Please fill all the details......");
							$("#error").fadeIn(500, function(){
								
							});
			}
			return false;
		});  
 $(document).ready(function(){  
      $('#student_data').DataTable();  

 });  
 </script>  
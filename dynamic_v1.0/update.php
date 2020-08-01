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
	<title>NCS - Update</title>
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/font-awesome.min.css" rel="stylesheet">
	<link href="css/styles.css" rel="stylesheet">
	
	<!--Custom Font-->
	<link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/custom.js"></script>

	<!--[if lt IE 9]>
	<script src="js/html5shiv.js"></script>
	<script src="js/respond.min.js"></script>
	<![endif]-->
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
			<li class="active"><a href="update.php"><em class="fa fa-edit">&nbsp;</em> Update Profile</a></li>
			<li><a href="event.php"><em class="fa fa-trophy">&nbsp;</em> Events</a></li>
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
				<li class="active">Update Profile</li>
			</ol>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Update Profile</h1>
			</div>
		</div><!--/.row-->

		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					
					<div class="container-fluid" style="padding-top: 20px; padding-bottom: 20px;">
					    
						<div class="row">
					      <!-- left column -->
					      
					      
					      <!-- edit form column -->
					      <div class="col-md-12 personal-info">
					        
					        <div id="error" style="display: none;" class="alert alert-info alert-dismissable">
					          <a class="panel-close close" data-dismiss="alert">×</a> 
					          
					        </div>
					        
					        
					        <form class="form-horizontal" role="form" method="post" id="update-form">
					        <?php
					        	if($_SESSION['role']!='Admin')
					        	{
					        		echo '<div class="row">	
					        	
								<div class="form-group col-lg-6" >
					        		<div class="col-lg-12" style="border-right: 1px solid rgb(220,220,220); ">
								        <div class="text-center">
								          <img id="setpic"  src="http://www.zimphysio.org.zw/wp-content/uploads/2018/01/default-avatar-2.jpg" style="object-fit: cover;" height="100px" width="100px" class="avatar img-rounded" alt="avatar">
								          <h6>Upload a different photo...</h6>
								          <div class="input-group">
								                <label class="input-group-btn">
								                    <span class="btn btn-info">
								                        Browse&hellip; <input type="file" value="-" id="propic" accept="image/*" style="display: none;" onchange="document.getElementById(\'setpic\').src = window.URL.createObjectURL(this.files[0]);document.getElementById(\'pictext\').value=this.files.item(0).name" class="form-control">
								                    </span>
								                </label>
								                <input type="text" id="pictext" class="form-control" readonly>
								            </div>
								        </div>
								      </div>
								      <hr>
					        	</div>
						        <div class="form-group col-lg-6">
						            <label class="col-lg-2 control-label">Name:</label>
						            <div class="col-lg-10">
						              <input class="form-control" name="name" type="text" value="" placeholder="Someone">
						            </div>
						        </div>

						        <div class="form-group col-lg-6">
						            <label class="col-lg-2 control-label">Batch:</label>
						            <div class="col-lg-10">
						              <input class="form-control" name="batch" type="text" value="" placeholder="student batch">
						            </div>
					            </div>
					            
					            <div class="form-group col-lg-6">
						            <label class="col-lg-2 control-label">Branch:</label>
						            <div class="col-lg-10">
						              <input class="form-control" type="text" name="branch" value="" placeholder="Your Branch">
						            </div>
					          	</div>
					        </div>
					        <hr>
					        <div class="row">
					          <div class="form-group col-lg-6">
					            <label class="col-lg-2 control-label">Phone:</label>
					            <div class="col-lg-10">
					              <input class="form-control" type="text" name="phone" value="" placeholder="0000000000">
					            </div>
					          </div>
					          <div class="form-group col-lg-6">
					            <label class="col-lg-2 control-label">Email:</label>
					            <div class="col-lg-10">
					              <input class="form-control" type="text" name="email" value="" placeholder="someone@example.com">
					            </div>
					          </div>
					        </div> 
					       <hr>
					        <div class="row">
					          <div class="form-group col-lg-6">
					            <label class="col-lg-2 control-label">Password:</label>
					            <div class="col-lg-10">
					              <input class="form-control" type="password" id="p1" name="password" value="" placeholder="New Password">
					            </div>
					          </div>
					          <div class="form-group col-lg-6">
					            <label class="col-lg-2 control-label">Confirm Password:</label>
					            <div class="col-lg-10">
					              <input class="form-control" type="password" id="p2" name="confpassword" value="" placeholder="Confirm Password">
					            </div>
					          </div>
					        </div>';
					        	}
					        	else
					        	{
					        		echo '<div class="row">	
					        	<div class="form-group col-lg-6" >
					        		<div class="col-lg-12" style="border-right: 1px solid rgb(220,220,220); ">
								        <div class="text-center">
								          <img id="setpic"  src="http://www.zimphysio.org.zw/wp-content/uploads/2018/01/default-avatar-2.jpg" style="object-fit: cover;" height="100px" width="100px" class="avatar img-rounded" alt="avatar">
								          <h6>Upload a different photo...</h6>
								          
								          <div class="input-group">
								                <label class="input-group-btn">
								                    <span class="btn btn-info">
								                        Browse&hellip; <input type="file" value="-" id="propic" accept="image/*" style="display: none;" onchange="document.getElementById(\'setpic\').src = window.URL.createObjectURL(this.files[0]);document.getElementById(\'pictext\').value=this.files.item(0).name" class="form-control">
								                    </span>
								                </label>
								                <input type="text" id="pictext" class="form-control" readonly>
								            </div>
								        </div>
								      </div>
								      <hr>
					        	</div>

						        <div class="form-group col-lg-6">
						            <label class="col-lg-2 control-label">Name:</label>
						            <div class="col-lg-10">
						              <input class="form-control" name="name" type="text" value="" placeholder="Someone">
						            </div>
						        </div>

						        <div class="form-group col-lg-6">
					            <label class="col-lg-2 control-label">Phone:</label>
					            <div class="col-lg-10">
					              <input class="form-control" type="text" name="phone" value="" placeholder="0000000000">
					            </div>
					          </div>
					          <div class="form-group col-lg-6">
					            <label class="col-lg-2 control-label">Email:</label>
					            <div class="col-lg-10">
					              <input class="form-control" type="text" name="email" value="" placeholder="someone@example.com">
					            </div>
					          </div>
					        </div>
					       
					       <hr>
					        <div class="row">
					          <div class="form-group col-lg-6">
					            <label class="col-lg-2 control-label">Password:</label>
					            <div class="col-lg-10">
					              <input class="form-control" type="password" id="p1" name="password" value="" placeholder="New Password">
					            </div>
					          </div>
					          <div class="form-group col-lg-6">
					            <label class="col-lg-2 control-label">Confirm Password:</label>
					            <div class="col-lg-10">
					              <input class="form-control" type="password" id="p2" name="confpassword" value="" placeholder="Confirm Password">
					            </div>
					          </div>
					        </div>';
					        	}
					        ?>
								
					          <hr>
					          <div class="row">
					          <div class="col-lg-6 col-lg-offset-4">
					          <div class="form-group">
					            
					            <div class="col-md-12">
					              <input type="submit" id="update_button"  class="btn btn-primary" value="Save Changes">
					              <span></span>
					              <input type="reset" class="btn btn-default" value="Cancel">
					            </div>
					          </div>
					      </div>
					      </div>
					        </form>
					      </div>
					  </div>
					</div>

				</div>
			</div>
				
		
	<center><div class="container-fluid">
			<div class="row">
				<p class="tm-copyright-text">Copyright &copy; 2018 NIST Counseling Service | Maintained by <a rel="nofollow" href="http://nist.edu/" target="_blank">N.I.S.T.</a> | Designed by <span style="color: #C51162">N.C.S. Web Design Team</span></p>
			</div>
		</div></center>		
	 
	</div>

	
	<script type="text/javascript">
		$('#update_button').click(function(event){
			if($('#p1').val()=="" || ($('#p1').val()==$('#p2').val()))
			{
			event.preventDefault();
			var filedata=document.getElementById('propic').files[0];
			var data=new FormData($('form')[0]);
			data.append('photo',filedata);
			data.append('update',true);
			data.append('id',<?php echo $id; ?>)
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
					console.log(response);
					if(response=="success"){
						$("#update_button").val('Saving ...');
						$("#error").fadeIn(500,function(){
							$("#error").html('<a class="panel-close close" data-dismiss="alert">×</a><i class="fa fa-coffee"></i> You information hasbeen updated successfully!!');
						});
						setTimeout(' window.location.href = "update.php"; ',3000);
					} 
					else {
						$("#update_button").val('Save Changes');
						$("#error").fadeIn(500, function(){
							$("#error").html('<a class="panel-close close" data-dismiss="alert">×</a><i class="fa fa-coffee"></i>'+response);
							$("#login_button").html('<span class="glyphicon glyphicon-log-in"></span>   Sign In');
						});
					}
				}
			});
		}
		else
		{

			$("#error").fadeIn(500, function(){
							$("#error").html('<a class="panel-close close" data-dismiss="alert">×</a><i class="fa fa-coffee"></i>'+"  Password Doesn't Match!! Please Confirm Password....");
							$("#login_button").html('<span class="glyphicon glyphicon-log-in"></span>   Sign In');
						});
		}
		return false;
		});
	</script>
	
</body>
</html>


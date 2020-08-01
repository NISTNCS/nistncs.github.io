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
	<title>NCS - Student Details</title>
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/font-awesome.min.css" rel="stylesheet">
	<link href="css/styles.css" rel="stylesheet">
	
	<!--Custom Font-->
	<link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
	<!--[if lt IE 9]>
	<script src="js/html5shiv.js"></script>
	<script src="js/respond.min.js"></script>
	<![endif]-->
	<script src="js/jquery.min.js"></script>  
    <script src="js/jquery.dataTables.min.js"></script>  
    <script src="js/dataTables.bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/dataTables.bootstrap.min.css" />
	
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
			<?php if($_SESSION['role']!='Admin') echo '<li class="active"><a href="attendance.php"><em class="fa fa-bars">&nbsp;</em> Attendance</a></li>';?>
			<li><a href="update.php"><em class="fa fa-edit">&nbsp;</em> Update Profile</a></li>
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
				<li class="active">Student Details</li>
			</ol>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Student Search</h1>
			</div>
		</div><!--/.row-->
		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default" style="padding:20px 20px 20px 20px;">
						
						<div id="error" style="display: none;" class="alert alert-info alert-dismissable">
					          <a class="panel-close close" data-dismiss="alert">×</a> 
					          
					        </div>

						<div class="container-fluid">
						<div class="form-group">
						  <label for="sel1">Select Meeting Date:</label>
						  <select class="form-control" id="sel1" name="sel1" style="width: 40%;">
						    <?php
						    	require($_SERVER['DOCUMENT_ROOT']."/dynamic_v1.0/class/clsSearchTransaction.php");
						    	$objclsSearchTransaction=new clsSearchTransaction();
						    	$res= $objclsSearchTransaction->MeetingDates($_SESSION['id']);
						    	if($res!=null)
						    	{
						    		while($row=pg_fetch_array($res))
						    		{
						    			echo '<option value="'.$row['miid'].'">'.$row['midate'].'</option>';
						    		}
						    	}
						    ?>
						  </select>
						</div>
						<div class="table-responsive">
							<table id="student_data" class="table table-striped table-bordered">
								<thead>
									<tr>
										<td>Roll No.</td>
										<td>Name</td>
										<td>Attendance</td>
									</tr>
								</thead>
								<?php
									require_once($_SERVER['DOCUMENT_ROOT']."/dynamic_v1.0/class/clsSearchTransaction.php");
									$clsSearchTransaction=new clsSearchTransaction();
									$result=$clsSearchTransaction->displayStudentAttendance2($_SESSION['year'],$_SESSION['id']);
									if($result!=null)
									{
										while($row=pg_fetch_array($result))
										{
											echo '
												<tr>
													<td>'.$row["studroll"].'</td>
													<td>'.$row["studname"].'</td>
													<td><input type="checkbox" name="student_id[]" value="'.$row["studroll"].'"/></td>
												</tr>
											';
										}
									}
								?>
							</table>
							<div align="center">
								<button class="btn btn-primary" id="add_atten">
								Submit
								</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!--/.row-->
			<center><div class="container-fluid">
			<div class="row">
				<p class="tm-copyright-text">Copyright &copy; 2018 NIST Counseling Service | Maintained by <a rel="nofollow" href="http://nist.edu/" target="_blank">N.I.S.T.</a> | Designed by <span style="color: #C51162">N.C.S. Web Design Team</span></p>
			</div>
		</div>		
	  
	</center>

	</div>	<!--/.main-->
	  

	<script src="js/bootstrap.min.js"></script>
	<script src="js/custom.js"></script>
		
</body>
</html>
<script>  
 $(document).ready(function(){  
      var table=$('#student_data').DataTable();
	
      $('#add_atten').on('click',function(){
      		if(confirm("Are you sure you want to submit?"))
      		{
      			var id=[];
      			var miid=$('#sel1 option:selected').val();
      			$(':checkbox:checked').each(function(i){
      				id[i]=$(this).val();
      			});

      			if(id.length===0)
      			{
      				return false;
      			}
      			else
      			{
      				var data=new FormData();
      				var json_arr = JSON.stringify(id);
      				data.append('studattenid',json_arr);
      				data.append('miid',miid);
      				data.append('attendance',true);
      				$.ajax({
      					url:'login.php',
      					method:'POST',
      					data : data,
						processData: false,
		    			contentType: false,
		    			beforeSend: function(){
							$("#error").fadeOut();
							$("#add_atten").html('Submitting ...');

						},
						success : function(response){
							console.log(response);
							if(response=="success")
							{
								$("#error").fadeIn(500,function(){
								$("#error").html('<a class="panel-close close" data-dismiss="alert">×</a><i class="fa fa-coffee"></i> Attendance has been updated successfully!!');
								});
								$("#add_atten").html('Submit');
								setTimeout(' window.location.href = "attendance.php"; ',3000);
							}	
							else
							{
								$("#error").fadeIn(500,function(){
								$("#error").html('<a class="panel-close close" data-dismiss="alert">×</a><i class="fa fa-coffee"></i> Can\'t Process your reqeust right now!! Please Try again later.....');
								});
								$("#add_atten").html('Submit');
							}				
						}
      				});
      			}
      		}
      		else
      		{
      			return false
      		}
      });
  
 }); 
 </script>  
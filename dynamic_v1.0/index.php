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
	<title>NCS - Profile</title>
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/font-awesome.min.css" rel="stylesheet">
	<link href="css/datepicker3.css" rel="stylesheet">
	<link href="css/styles.css" rel="stylesheet">
	<link href="css/mystyles.css" rel="stylesheet">	
	<link href="https://fonts.googleapis.com/css?family=Lora" rel="stylesheet"> 
	
	<!--Custom Font-->
	<link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
	
		
	
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
			<li class="active"><a href="index.php"><em class="fa fa-address-card">&nbsp;</em> Profile</a></li>
			<li><a href="meetings.php"><em class="fa fa-calendar">&nbsp;</em> Meetings</a></li>
			<li><a href="student_details.php"><em class="fa fa-search">&nbsp;</em> Student Details</a></li>
			<li><a href="addstudent.php"><em class="fa fa-user-plus">&nbsp;</em> Add Students</a></li>
			<?php if($_SESSION['role']!='Admin') echo '<li><a href="attendance.php"><em class="fa fa-bars">&nbsp;</em> Attendance</a></li>';?>
			<li><a href="update.php"><em class="fa fa-edit">&nbsp;</em> Update Profile</a></li>
			<li><a href="event.php"><em class="fa fa-trophy">&nbsp;</em> Events</a></li>
		</ul>	
		<div class="divider"></div>
		<ul class="nav menu">	
			<li><a href="../login.php"><em class="fa fa-power-off">&nbsp;</em> Logout</a></li>
		</ul>
	</div><!--/.sidebar--><!--/.sidebar-->
		
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="index.php">
					<em class="fa fa-home"></em>
				</a></li>
				<li class="active">Profile</li>
			</ol>
		</div><!--/.row-->
		
		

		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<!--<center><img height="200px" width="200px" style="padding:10px 10px 10px 10px;" src="http://www.rafgsa.org/wp-content/uploads/2016/09/noprofile.png" class="img-circle img-responsive"></img></center>-->
					
					    <div class="row user-menu-container">
					        <div class="col-md-12 user-details">
					            <div class="row coralbg white">
					                <div class="col-md-3 no-pad">
					                    <div class="user-image" >
					                        <center><img src="../upload/<?php echo $id ?>.jpg" style="object-fit: contain; border-color: #fff;border-radius: 12px;" height="198px" onerror=this.src="../img/avatar.jpg"></center>
					                    </div>
					                </div>
					                <div class="col-md-9 no-pad">
					                    <div class="user-pad">
					                        <h2 style="margin-bottom: 0px;">Welcome back, <strong style="color:rgb(100,100,200);"><?php echo $name;?></strong></h2>
					                        <small><h4 class="red"><?php echo $_SESSION['role']?></h4></small>
					                        <h5 class="white">
											<div class="container-fluid">
												
													<div class="col-lg-6 col-md-6 col-sm-12" style="padding-top: 5px;">
													<strong>Roll</strong>
													: <?php echo $id; ?>
													</div>
													
												
													
													<?php if($_SESSION['role']!='Admin'){ echo '<div class="col-lg-6 col-md-6 col-sm-12" style="padding-top: 5px;">
													<strong>Faculty Guide</strong>
													: '.$fac.'
													</div>
													<div class="col-lg-6 col-md-6 col-sm-12" style="padding-top: 5px;">
														<strong>Batch</strong> : '.$batch.'
													</div>
													<div class="col-lg-6 col-md-6 col-sm-12" style="padding-top: 5px;">
														<strong>Branch</strong> : '.$branch.'
													</div>';
													}
													
													?>
													<div class="col-lg-6 col-md-6 col-sm-12" style="padding-top: 5px;">
														<strong>Phone</strong> : <?php echo $phone ; ?>	
													</div>
													<div class="col-lg-6 col-md-6 col-sm-12" style="padding-top: 5px;">
														<strong>Email</strong> : <?php echo $email ; ?>
													</div>
												
											</div>
					                        </h5>
					                        
					                    </div>
					                </div>
					            </div>
					            
					        </div>
					
						</div>
					</div>
			</div>

		</div>
		
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						Recent Events
						<span class="pull-right clickable panel-toggle panel-button-tab-left"><em class="fa fa-toggle-up"></em></span></div>
					<div class="panel-body timeline-container" style="background-color: #B0BEC5">
						<ul class="timeline">
							<?php
							require_once($_SERVER['DOCUMENT_ROOT']."/dynamic_v1.0/class/clsNCSEventInfoManager.php");
							$query="SELECT * from ncseventinfo order by eidate desc limit 5";
							$objclsNCSEventInfoManager= new clsNCSEventInfoManager();
							$result=$objclsNCSEventInfoManager->retrieveNCSEventInfo($query);
							while($row=pg_fetch_array($result))
							{
								echo '<li>
								<div class="timeline-badge"><em class="glyphicon glyphicon-thumbs-up"></em></div>
								<div class="timeline-panel" style="background-color: #fff;box-shadow: 5px 5px 4px rgba(0, 0, 0, .5);-moz-box-shadow: 5px 5px 4px rgba(0, 0, 0,0.5);-webkit-box-shadow: 5px 5px 4px rgba(0, 0, 0, .5);">
									<div class="timeline-heading">
										<strong><h2 class="timeline-title" style="margin-bottom: 8px;">'.$row['etitle'].'</h2></strong>
										<h6 style="padding-left: 10px; margin-top: 0px; margin-bottom:10px; color:#aaa;"><span style="padding-right:20px;object-fit:cover;">'.date("l, jS-F y",strtotime($row['eidate'])).'</span>'.$row['eiplace'].'</h6>
										
									</div>
									<div class="timeline-body">
										<div class="row">
											<div class="col-lg-5">
												<img src="../eventpic/'.$row['eno'].'.jpg" height="200px" width="100%" style="object-fit:cover;">
											</div>
											<div class="col-lg-7">
											<p style="font-size:18px;font-family: \'Lora\', serif; align="justify">'.$row['eipurpose'].'</p>
											</div>
										</div>
									</div>
								</div>
							</li>';
							}

							?>							
						</ul>
					</div>
				</div>
			</div>
			
		</div>
		<div class="panel panel-container">
			<div class="row">
				<?php
					require_once($_SERVER['DOCUMENT_ROOT']."/dynamic_v1.0/class/clsSearchTransaction.php");
					$objclsSearchTransaction=new clsSearchTransaction();
					$Count=$objclsSearchTransaction->retieveCounts();
				?>
				<div class="col-xs-4 col-md-4 col-lg-4 no-padding">
					<div class="panel panel-teal panel-widget border-right">
						<div class="row no-padding"><img height="30px" width="30px" src="../img/teacher_icon.png">
							<div class="large"><?php echo $Count['counsellorNumber'];?></div>
							<div class="text-muted">Counsellors</div>
						</div>
					</div>
				</div>
				<div class="col-xs-4 col-md-4 col-lg-4 no-padding">
					<div class="panel panel-blue panel-widget border-right">
						<div class="row no-padding"><img height="30px" width="30px" src="../img/student_guide_icon.png">
							<div class="large"><?php echo $Count['studentGuideNumber'];?></div>
							<div class="text-muted">Student Guides</div>
						</div>
					</div>
				</div>
				<div class="col-xs-4 col-md-4 col-lg-4 no-padding">
					<div class="panel panel-orange panel-widget border-right">
						<div class="row no-padding"><em class="fa fa-xl fa-users color-red"></em>
							<div class="large"><?php echo $Count['studentNumber'];?></div>
							<div class="text-muted">New Students</div>
						</div>
					</div>
				</div>
				
			</div><!--/.row-->
		</div>
		<?php if($_SESSION['role']=="Admin")

			echo '<div class="row coralbg white" style="margin-bottom: 20px;">
			<div id="error" style="display: none;" class="alert alert-info alert-dismissable">
					          <a class="panel-close close" data-dismiss="alert">×</a> 
					          
					        </div>
					            	<center><input type="number" name="setyear" min="2017" value="'.date("Y").'" id="yearval" max="'.date("Y").'" class="form-control" style="width: 200px;"><button id="setyearval" class="btn btn-warning">SET CURRENT YEAR!!</button></center>
					            </div>';
		?>
		<center><div class="container-fluid">
			<div class="row">
				<p class="tm-copyright-text">Copyright &copy; 2018 NIST Counseling Service | Maintained by <a rel="nofollow" href="http://nist.edu/" target="_blank">N.I.S.T.</a> | Designed by <span style="color: #C51162">N.C.S. Web Design Team</span></p>
			</div>
		</div>		
	  
	</center>

			<!--/.row-->
	</div>	<!--/.main-->
	
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/custom.js"></script>
	<script type="text/javascript">
	$(document).ready(function(){  
		$('#setyearval').on('click',function(){
			var year=$('#yearval').val();
			if(confirm("Are you sure want to change the current calendar year?"))
			{
				var data=new FormData();
      			data.append('changeyear',year);
      			data.append('currentcalendaryear',true);
      			$.ajax({
      				url:'login.php',
      				method:'POST',
      				data : data,
					processData: false,
		    		contentType: false,
		    		beforeSend: function(){
						$("#error").fadeOut();
						$("#setyearval").html('SETTING...');
					},
					success : function(response){
						console.log(response);
						if(response=="success")
						{
							$("#error").html('<a class="panel-close close" data-dismiss="alert">×</a><i class="fa fa-coffee"></i> Current calendar year has been updated successfully!!');
							$("#error").fadeIn(500,function(){
								
							});
							$("#setyearval").html('SET CURRENT YEAR!!');
							setTimeout(' window.location.href = "index.php"; ',3000);
						}	
						else
						{
							$("#error").html('<a class="panel-close close" data-dismiss="alert">×</a><i class="fa fa-coffee"></i> Can\'t Process your reqeust right now!! Please Try again later.....'+response);
							$("#error").fadeIn(500,function(){
								
							});
							$("#setyearval").html('SET CURRENT YEAR!!');
						}				
					}
				});
			}
			else
			{
				return false;
			}
		});
	});
	</script>
	
	
</body>
</html>